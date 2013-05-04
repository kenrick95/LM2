<?php
/* Lihat Masalah
 * Version : 1.1
 * Codename: LM2
 * 
 * License:
 * - Content (documentation): Creative Commons Attribution 3.0 (attribution: Kenrick)
 * - Content: chosen by user (default: Creative Commons Attribution 3.0)
 * - Code: MIT License (C) Copyright 2013 Kenrick
 *
 */
   session_start();
   $content = "";
   include_once "assets/resc/header.php";
   ##########          START           ##########
   ##########   EARLY MODULE PROCESS   ##########
   //something to do here
   
   ##########      MODULE:PROBLEM      ##########
   if ($_pxtion=="solution"){
      if ($_paction=="new") {
         $content = $problem->getEditForm("newsol");
      } else if ($_paction=="edit") {
         $content = $problem->getEditForm("sol");
      } else if ($_paction=="save") {
         if (isset($_POST['edtr']) ){
            $data = array(
               "content"   => $_POST["edtr"]
            );
            $content = $problem->saveForm("sol", $data);
         } else {
            $content = "Not done";
         }
      } else if ($_paction=="delete") {
         $content = $problem->delete("sol");
      } else if ($_paction=="confirmdelete") {
         $content = $problem->confirmDelete("sol");
      } else if ($_paction=="view") {
         $content = $data['solContent'];
      }
   } else { #### problem
      if (isset($_GET['paction'])) {
         $_paction = $_GET['paction'];
      }
      if ($_paction=="new") {
         $content = $problem->getEditForm("newprob");
      } else if ($_paction=="edit") {
         $content = $problem->getEditForm("prob");
      } else if ($_paction=="save") {
         if (isset($_POST['edtr'], $_POST['ptitle']) ){
            if (!isset($_POST["pattr"])) {
               $_POST["pattr"] = $urealname;
            } else {
               if ($_POST["pattr"] == "") {
                  $_POST["pattr"] = $_urealname;
               }
            }
            $data = array(
               "ptitle"    => $_POST["ptitle"],
               "pmem"      => $_POST["pmem"],
               "ptim"      => $_POST["ptim"],
               "content"   => $_POST["edtr"],
               "tcin"      => $_POST["tcin"],
               "tcout"     => $_POST["tcout"],
               "plicense"  => $_POST["plicense"],
               "pattr"     => $_POST["pattr"]
            );
            $content = $problem->saveForm("prob", $data);
         } else {
            $content = "Not done";
         }
      } else if ($_paction=="delete") {
         $content = $problem->delete("prob");
      } else if ($_paction=="confirmdelete") {
         $content = $problem->confirmDelete("prob");
      } else if ($_paction=="submitans") {
         $content = $problem->getSubmitAnsForm();
      } else if ($_paction=="saveans") {
         if (isset($_POST['asourcecode'], $_POST["alang"]) ){
            $data = array(
               "code"   => $_POST["asourcecode"],
               "lang"   => $_POST["alang"]
            );
            $content = $problem->grade($data);
         } else {
            $content = "Not done";
         }
      } else if ($_paction=="view") {
         $content = $problem->viewProblem();
      } else if ($_paction=="list") {
         require_once "mod/prob/main.php";
         $gen_prob = new LM2generalProblem();
         $content = $gen_prob->getProblemList($_REQUEST["page"]);
      }
   }
   ##########   END: MODULE:PROBLEM    ##########

   
   ##########       MODULE:USER        ##########
   if (isset($_uaction)) {
      if ($_uaction == "view") {
         $content = $user->view();
      
      } else if ($_uaction == "edit") {
         $content = $user->getEditForm();
         
      } else if ($_uaction == "delete") {
         $content = "Feature not available yet.";
         
      } else if ($_uaction == "save") {
         $user = new LM2user($_POST['uid']);
         $content = $user->saveForm();
         
      } else if ($_uaction == "register") {
         $content = $cur_user->getRegisterForm();
      } else if ($_uaction == "login") {
         $content = "Feature not available yet.";
      
      } else if ($_uaction == "reset") {
         $content = "Feature not available yet.";
      
      } else if ($_uaction == "manage") {
         $content = $cur_user->manageUser($_REQUEST["page"]);
      
      } else if ($_uaction == "etc") {
         $content = "Feature not available yet.";
      
      } else {
         $content = "Feature not available yet.";
      
      }
   }
   ##########     END: MODULE:USER     ##########


   
   ##########   EARLY MODULE PROCESS   ##########
   ##########           END            ##########
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="keywords" content="LM2" />
      <meta name="description" content="LM2." />
      <meta http-equiv="Content-Language" content="en-US" />
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/img/favicon.ico" />
      <title><?php echo $_pagetitle; ?></title>
      <style type="text/css">
         <!--
         @import "<?php echo $base_url; ?>assets/css/default.css";
         @import "<?php echo $base_url; ?>assets/css/news.css";
         @import "<?php echo $base_url; ?>assets/css/user.css";
         <?php
         ##########          START           ##########
         ##########    IMPORT MODULE CSS     ##########
         //something to do here
         ##########    IMPORT MODULE CSS     ##########
         ##########           END            ##########
         ?>
         -->
      </style>
   </head>
   <script type="text/javascript" src="<?php echo $base_url; ?>assets/js/jquery-1.5.min.js">
   </script>
   <?php
      ##########             START              ##########
      ##########    EARLY MODULE JAVASCRIPT     ##########
      //something to do here
      ?>
      <script type="text/javascript">
         base_url = "<?php echo $base_url; ?>";
      </script>
      <?php
      ##########    EARLY MODULE JAVASCRIPT     ##########
      ##########              END               ##########
   ?>
   <body>
      <div id="top">
         <div id="menu">
            <div id="menu-list">
               <!--<a href="<?php echo $base_url; ?>home">-->
                  <div class="menu-item logo">
                     <b>Li</b>hat <b>ma</b>salah
                  </div>
               <!--</a>-->
               
               <div class="menu-item" id="pidform-cont">
                  <form id="pidform" name="pidform" action="javascript:void(0);">
                     <input type="text" id="pform-pid" name="pform-pid" value="<?php
                  if (isset($_GET['pid'])) {
                     echo $_GET['pid'];
                  }
                  ?>" title="Problem ID" autocomplete="off" />
                  </form>
               </div>
               
               <a href="<?php echo $base_url; ?>home"><div class="menu-item">Home</div></a>
               <div class="menu-item">News</div>
               <a href="<?php echo $base_url; ?>about"><div class="menu-item">About</div></a>
               
               <div class="menu-item right-item" id="sign-trigger">
                  <?php
                     if (loggedin()){
                        if (trim($_urealname)=="") {
                           echo $_username;
                        } else {
                           echo $_urealname;
                        }
                     } else {
                        echo "Log in";
                     }
                  ?>
               </div>
               <?php
                  if (isset($_GET['pid'])) {
                     ?>
               <a href="<?php echo $base_url; ?>problem.submitans.<?php echo $_GET['pid']; ?>"><div class="menu-item right-item">Submit answer</div></a>
               <?php
                  }
                  ?>
               
            </div>
         </div>
      </div>
      <div id="main">
         <div id="main-wrapper">
            <div id="header">
               <?php include_once "assets/resc/loginbox.php" ?>
                  
               <?php
                  if (isset($_GET['pid'])) {
               ?>
                  <div id="menu">
                     <div id="menu-list">
                        <?php
                           if ($_pxtion=="solution"){
                              echo $problem->getHeader($_paction, "sol");
                           } else {
                              echo $problem->getHeader($_paction, "prob");
                           }
                        ?>
                     </div>
                  </div>
               <?php
                  } else {
               ?>
                  <script type="text/javascript">
                     $(document).ready(function() {
                        $("#main-wrapper #content").css("border-width","1px");
                     });
                  </script>
               <?php
                  }
               ?>
               <div style="clear:both;"></div>
               </div>
            <div id="content">
               <div id="content-main">
                  <!--     Content    -->
                  <?php
                     ##########          START            ##########
                     ##########    MODULE MAIN CONTENT    ##########
                     //something to do here
                     //require_once("mod/prob/main.php");
                     
                     echo $content;
                     //echo $problem->getProblemContent();
                     ##########    MODULE MAIN CONTENT    ##########
                     ##########           END             ##########
                  ?>
               </div>
            </div>
            <div id="footer">
               <div id="footer-cc">
                  <!--<a rel="license" href="http://creativecommons.org/licenses/by/3.0/" target="_blank">
                     <img alt="Creative Commons" title="Lisensi Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by/3.0/80x15.png" />
                  </a>
                  <br />-->
                  <?php
                     if (stripos($_SERVER['HTTP_USER_AGENT'], 'Firefox')==0) {
                  ?>
                  <a href='https://affiliates.mozilla.org/link/banner/10397/3/190'>
                     <img src='http://affiliates-cdn.mozilla.org/media/uploads/banners/download-small-blue-EN.png' alt='Download Firefox' title='Download Firefox' width='80' style='border-width:0' />
                  </a>
                  <?php
                     }
                  ?>
               </div>
               <div id="footer-version">
                  <a href='about'>
                  <img src="assets/img/favicon.ico" id="pc-footer-version-img" />&nbsp;
                  <span id="pc-footer-logo">
                     <b>Li</b>hat <b>ma</b>salah
                  </span>
                  </a>
                  <?php echo $_version; ?>
               </div>
            </div>
         </div>
      </div>
      <div id="bottom">
      <?php
         #nothing to do here
      ?>
      </div>
   </body>
   <script type="text/javascript" src="assets/js/default.js">
   </script>
   <?php
      ##########            START              ##########
      ##########    LATE MODULE JAVASCRIPT     ##########
      //something to do here
      ##########    LATE MODULE JAVASCRIPT     ##########
      ##########             END               ##########
   ?>
</html>
<?php
$thread_id = mysqli_thread_id($konek);
mysqli_kill($konek, $thread_id);
mysqli_close($konek);
?>
