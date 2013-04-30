<?php
class LM2generalUser {
   public function logged_in($top = false){
      global $base_url;
      #Determine if someone is logged in
      if (
         ( isset($_SESSION['loginsession'],$_COOKIE['usrcookie'])
          && ($_SESSION['loginsession'] ==hash('sha512',hash('whirlpool', $_COOKIE['usrcookie']))  )
          )
       &&
          ( isset($_COOKIE['loginsessioncookie'],$_COOKIE['usrcookie'])
          && ($_COOKIE['loginsessioncookie'] ==hash('sha512',hash('whirlpool', $_COOKIE['usrcookie']))  )
          )
       ) {
            $_SESSION['loginsession'] = hash('sha512',hash('whirlpool', $_COOKIE['usrcookie'])); 
            if ($top === true) {
               if ($base_url == "http://localhost/lm2/") {
                  setcookie("loginsessioncookie", $_SESSION['loginsession'], time()+3600, "/lm2/");
                  setcookie("usrcookie", $_COOKIE['usrcookie'], time()+3600, "/lm2/");
               } else {
                  setcookie("loginsessioncookie", $_SESSION['loginsession'], time()+3600, "/");
                  setcookie("usrcookie", $_COOKIE['usrcookie'], time()+3600, "/");
               }
            }
         return true;
      } else {
         return false;
      }
   }
   public function loggedin() {
      return logged_in(true);
   }
   public function getDetails() {
      global $konek;
      if (logged_in(true)) {
         $uname = $_COOKIE['usrcookie'];
         $user = new LM2user($uname);
         $data = $user->getDetails();
      } else {
         $data['uname']       = "";
         $data['urole']       = -1;
         $data['urealname']   = "";
         $data['uschool']     = "";
         $data['uid']         = -1;
         $data['urolename']   = "Anonymous";
         $data['uac']         = -1;
         $data['unac']        = -1;
         $data['usubmit']     = -1;
      }
      return $data;
   }

   public function getEditForm() {
      $cur_user = new LM2user($_COOKIE['usrcookie']);
      $content = $cur_user->getEditForm();
      return $content;
   }

   
   public function getRegisterForm() {
      global $konek;
      global $base_url;
      include "recaptchalib.php";
      $publickey =  "6LcXf8sSAAAAAAmi1kgd4Re-EVFniv4w1vbEJ9AT";
      $privatekey = "6LcXf8sSAAAAAM6x9vNioMJeXWW066xUdTR4jLB_ ";
      # the response from reCAPTCHA
      $resp = null;
      # the error code from reCAPTCHA, if any
      $error = null;
      $regfield=true;
      
      ob_start();
      
      if (isset($_POST["recaptcha_response_field"])) {
         $resp = recaptcha_check_answer ($privatekey,
                  $_SERVER["REMOTE_ADDR"],
                  $_POST["recaptcha_challenge_field"],
                  $_POST["recaptcha_response_field"]);
         if ($resp->is_valid) {
               //echo "You got it!";
               $error_msg = "";
               if  (trim($_POST['reguname'])=="") {
                  $error_msg .= "You must pick a username.";
               } else if (strlen($_POST['reguname'])<3) {
                  $error_msg .= "Your username must be more than 3 characters.";
               } else if (strlen($_POST['reguname'])>32) {
                  $error_msg .= "Your username must be less than 32 characters.";
               }
               
               if (trim($_POST['regpswd'])=="") {
                  $error_msg .= "You must pick a password.";
               } else if (strlen($_POST['regpswd'])<6) {
                  $error_msg .= "Your password must be more than 6 characters.";
               } else if (strlen($_POST['regpswd'])>32) {
                  $error_msg .= "Your password must be less than 32 characters.";
               }
               
               if (trim($_POST['regemail'])=="") {
                  $error_msg .= "You must enter your email address.";
               }
               if (trim($_POST['regschool'])=="") {
                  $error_msg .= "You must enter your institution.";
               }
               if (trim($_POST['regrealname'])=="") {
                  $error_msg .= "You must enter your real name.";
               }
               if (!isset($_POST['regterm'])) {
                  $error_msg .= "You must agree with our term and conditions.";
               } else if (trim($_POST['regterm'])=="") {
                  $error_msg .= "You must agree with our term and conditions.";
               }
               
               if (empty($error_msg)) {
                     $nama = mysqli_escape_string($konek, $_POST['reguname']);
                     $pass = mysqli_escape_string($konek, $_POST['regpswd']);
                     $pass = hash('sha512',hash('whirlpool', $pass));
                     $email= mysqli_escape_string($konek, $_POST['regemail']);
                     if ((isset($_POST['regschool']))&&($_POST['regschool']!="")) {
                        $school=mysqli_escape_string($konek, $_POST['regschool']);
                     } else {
                        $school="Unspecified";
                     }
                     if ((isset($_POST['regrealname']))&&($_POST['regrealname']!="")) {
                        $realname=$_POST['regrealname'];
                     } else {
                        $realname=$_POST['reguname'];
                     }
                     $mem_userid = mysqli_escape_string($konek, $nama);
                     $per = "SELECT uname FROM pcdb_user WHERE uname='$mem_userid'";
                     $qry = mysqli_query($konek, $per);
                     $cek_data = mysqli_num_rows($qry);
                     if ($cek_data!=0){
                        echo "<div class='err'>Username have been taken, use other username please.</div>";
                     } else {
                        $per= "INSERT INTO pcdb_user(uname, upassword, uemail, urole, urealname, uschool)
                              VALUES('$nama', '$pass', '$email', '0', '$realname', '$school')";
                        $qry = mysqli_query($konek, $per);
                        if (isset($qry)){
                           $content = "<h2>Registration successful</h2>";
                           $content .= "<br />User account created.";
                           $content .= "<br />Username: ".$nama;
                           $arry = str_split($pass, 32);
                           $content .= "<br />Password (encrypted): ";
                           for ($i=0; $i<count($arry); $i++) {
                              $content .= "<br />".$arry[$i];
                           }
                           $content .= "<br />E-mail: ".$email;
                           $content .= "<br />Real name: ".$realname;
                           $content .= "<br />Institution: ".$school;
                           $content .= "<br />Role: User";
                           $regfield= false;
                        } else {
                           $content = "<div class='err'> MySQL Error</div> <br /> ".mysql_error();
                        }
                        echo $content;
                     }
               } else {
                  echo "<div class='err'>".str_replace(".",".<br />",$error_msg)."</div><br />";
               }
         } else {
               # set the error code so that we can display it
               $error = $resp->error;
               echo "<div class='err'>Captcha Error</div><br />";
         }
      }
      
      if ($regfield===true) {
         include "registerForm.php";
      }
      return ob_get_clean();
   }
}
class LM2user {
   function __construct($name) {
      $this->name = $name;
   }
   public function getDetails() {
      global $konek;
      $uname   = $this->name;
      
      $per     = "SELECT * FROM pcdb_user WHERE uname='$uname'";
      $qry     = mysqli_query($konek, $per);
      $data    = mysqli_fetch_array($qry);
      $urole   = $data['urole'];
      switch ($urole) {
         case 0: $urolename = "User"; break;
         case 1: $urolename = "Editor"; break;
         case 2: $urolename = "Judge"; break;
         case 3: $urolename = "Supervisor"; break;
         case 4: $urolename = "Administrator"; break;
      }
      $data['urolename'] = $urolename;
      
      return $data;
   }

   public function getEditForm() {
      global $base_url;
      global $konek;
      $data = $this->getDetails();
      
      ob_start();
      include "editForm.php";
      return ob_get_clean();
   }
}
?>
