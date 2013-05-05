<?php
class LM2generalProblem {
   public function getProblemList($page = 1) {
      global $_urole;
      global $konek;
      global $base_url;
      $start = ($page-1) * 50;
      $end = $page * 50;
      
      $per = "SELECT * FROM pcdb_prob ORDER BY id DESC";
      $qry = mysqli_query($konek, $per);
      $num_row = mysqli_num_rows($qry);
      $num_page = ceil($num_row / 50);

      $per = "SELECT * FROM pcdb_prob ORDER BY id DESC LIMIT $start, $end";
      $qry = mysqli_query($konek, $per);
      
      ob_start();
      include "problist.php";
      
      return ob_get_clean();
   }

}
class LM2prob {
   function __construct($name) {
      $this->name = $name;
   }
   
   public function getPath($type) {
      $ext = ".txt";
      if ($type == "prob") {
         $ext = ".txt";
      } else if ($type == "sol") {
         $ext = ".sol";
      } else if ($type == "in") {
         $ext = ".in";
      } else if ($type == "out") {
         $ext = ".out";
      }
      return tempatnya($this->name, "prob").$ext;
   }

   public function problemExists() {
      if (file_exists( $this->getProblemPath() )) {
         return True;
      } else {
         return False;
      }
   }
   public function getProblemPath() {
      return $this->getPath("prob");
   }
   public function getProblemContent() {
      if ( $this->problemExists() ) {
         return file_get_contents($this->getProblemPath());
      } else {
         return "File not found";
      }
   }
   
   public function solutionExists() {
      if (file_exists( $this->getSolutionPath() )) {
         return True;
      } else {
         return False;
      }
   }
   public function getSolutionPath() {
      return $this->getPath("sol");
   }
   public function getSolutionContent() {
      if ( $this->solutionExists() ) {
         return file_get_contents($this->getSolutionPath());
      } else {
         return "File not found";
      }
   }
   
   public function TCInExists() {
      if (file_exists( $this->getTCInPath() )) {
         return True;
      } else {
         return False;
      }
   }
   public function getTCInPath() {
      return $this->getPath("in");
   }
   public function getTCIn() {
      if ( $this->TCInExists() ) {
         return file_get_contents($this->getTCInPath());
      } else {
         return "File not found";
      }
   }
   
   public function TCOutExists() {
      if (file_exists( $this->getTCOutPath() )) {
         return True;
      } else {
         return False;
      }
   }
   public function getTCOutPath() {
      return $this->getPath("out");
   }
   public function getTCOut() {
      if ( $this->TCOutExists() ) {
         return file_get_contents($this->getTCOutPath());
      } else {
         return "File not found";
      }
   }

   public function getDetails() {
      global $konek;
      global $base_url;
      $pid = $this->name;
      if ($this->problemExists()) {
         $probContent = $this->getProblemContent();
      } else {
         $probContent = "<h2>Problem did not exist</h2>";
      }
      if ($this->solutionExists()) {
         $solContent = $this->getSolutionContent();
      } else {
         $solContent = "<h2>Solution did not exist</h2>";
      }
      if ($this->TCInExists()) {
         $tcin = $this->getTCIn();
      } else {
         $tcin = "";
      }
      if ($this->TCOutExists()) {
         $tcout = $this->getTCOut();
      } else {
         $tcout = "";
      }
      
      if (file_exists( $this->getProblemPath() )) {
         $perintah = "SELECT * FROM pcdb_prob WHERE pid='$pid'";
         $hasil = mysqli_query($konek, $perintah);
         $data = mysqli_fetch_array($hasil);
      } else {
         $data['pid']      = $pid;
         $data['ptitle']   = $pid;
         $data['ptim']     = "";
         $data['pmem']     = "";
         $data['psubmit']  = 0;
         $data['pac']      = 0;
         $data['pnac']     = 0;
         $data['plicense'] = "";
         $data['pattr']    = "";
         $data['pauthor']  = "";
         $data['plastedit']= "";
         $data['pnotrun']  = 0;
         $data['pce']      = 0;
         $data['prte']     = 0;
         $data['ptle']     = 0;
         $data['pmle']     = 0;
         $data['pisc']     = 0;  //Illegal system call
         $data['pir']      = 0;  //Internal error
         $data['pacall']   = 0;  // Accepted, not discrete
         $data['pwa']      = 0;
      }
      $data['probContent'] = $probContent;
      $data['solContent'] = $solContent;
      $data['tcin'] = $tcin;
      $data['tcout'] = $tcout;
      
      return $data;
      
   }

   public function viewProblem($show_stat = false) {
      $data = $this->getDetails();
      ob_start();
      include "view.php";
      return ob_get_clean();
   }
   
   
   public function getEditForm($type = "prob") {
      global $_urole;
      global $base_url;
      $data = $this->getDetails();
      if ($type == "prob") {
         if ($_urole <= 0) {
            return "<h2>Editing problem</h2>"."You do not have the right to do this action.";
         }
         $content = $data['probContent'];
      } else if ($type == "newprob") {
         if ($_urole <= 0) {
            return "<h2>New problem</h2>"."You do not have the right to do this action.";
         }
         $content = "";
      } else if ($type == "sol") {
         if ($_urole <= 0) {
            return "<h2>Editing solution</h2>"."You do not have the right to do this action.";
         }
         $content = $data['solContent'];
      } else if ($type == "newsol") {
         if ($_urole <= 0) {
            return "<h2>New problem</h2>"."You do not have the right to do this action.";
         }
         $content = "";
      }
      $tcin = $data['tcin'];
      $tcout = $data['tcout'];
      $ptitle = $data['ptitle'];
      $pid = $data['pid'];
      //var_dump($data);
      ob_start();
      include "form.php";
      return ob_get_clean();
   }

   public function saveForm($type = "prob", $data) {
      global $konek;
      $pid = mysqli_escape_string($konek, $this->name);

      if ($type == "prob") {
         $content = $data['content'];
         $ptitle = mysqli_escape_string($konek, $data['ptitle']);
         $pmem = mysqli_escape_string($konek, $data['pmem']);
         $ptim = mysqli_escape_string($konek, $data['ptim']);
         
         /*
          * Prevent hacking
          * If not in the option given, then license = Public Domain
          * */
         if ($data['plicense'] == "0"){
            $data['plicense'] = "Public Domain";
         } else if (!(($data['plicense'] == "Creative Commons Attribution 3.0") || ($data['plicense'] == "Creative Commons Attribution ShareAlike 3.0") || ($data['plicense'] == "GNU Free Documentation License 1.3") || ($data['plicense'] == "Creative Commons Zero"))) {
            $data['plicense'] = "Public Domain";
         }
         $plicense = mysqli_escape_string($konek, $data['plicense']);
         $pattr = mysqli_escape_string($konek, $data['pattr']);
         
         $tcin = $data['tcin'];
         $tcin=str_ireplace("\r","",$tcin);// delete \r in textfile
         
         $tcout = $data['tcout'];
         $tcout=str_ireplace("\r","",$tcout);// delete \r in textfile
         
         $pqry = mysqli_query($konek, "SELECT pid FROM pcdb_prob WHERE pid='$pid'");
         $pcek = mysqli_num_rows($pqry);
         
         if ($pcek==0){
            $per= "INSERT INTO pcdb_prob(pid, ptitle, ptim, pmem, psubmit, pac, pnac, plicense, pattr)
               VALUES('$pid', '$ptitle', '$ptim', '$pmem', '0', '0', '0', '$plicense', '$pattr')";
         } else {
            $per= "UPDATE pcdb_prob SET ptitle='$ptitle', ptim='$ptim', pmem='$pmem', plicense='$plicense', pattr='$pattr' WHERE pid='$pid'";
         }
         $pqry = mysqli_query($konek, $per);
         if (isset($pqry)){
            $tcinpx= $data['tcin'];
            $tcoutx= $data['tcout'];
            file_put_contents($this->getProblemPath(), stripslashes($content));
            file_put_contents($this->getTCInPath(), $tcinpx);
            file_put_contents($this->getTCOutPath(), $tcoutx);
            return "<h2>Problem saved</h2>\n".$content;
         } else {
            return "<h2>Saving failed</h2>\n".mysqli_error($konek);
         }
         
      } else if ($type == "sol") {
         
         $content = $data['content'];
         file_put_contents($this->getSolutionPath(), stripslashes($content));
         return "<h2>Solution saved</h2>\n".$content;
      }
   }

   public function getSubmitAnsForm() {
      global $_urole;
      if ($_urole <= -1) {
         return "<h2>Submitting answer</h2>"."You do not have the right to do this action.";
      }
      global $base_url;
      global $konek;
      $data = $this->getDetails();
      ob_start();
      include "submitans.php";
      return ob_get_clean();
   }
   public function grade($data) {
   
      global $base_url;
      global $konek;
      
      global $_uname;
      global $_usubmit;
      global $_uac;
      global $_unac;
      global $_uid;
      global $_uwa;
      global $_uacall;
      global $_unotrun;
      global $_uce;
      global $_umle;
      global $_utle;
      global $_urte;
      global $_uisc;
      global $_uir;
      $uname      = $_uname;
      $usubmit    = $_usubmit;
      $uac        = $_uac;
      $unac       = $_unac;
      $uid        = $_uid;
      $uwa        = $_uwa;
      $uacall     = $_uacall;
      $unotrun    = $_unotrun;
      $uce        = $_uce;
      $umle       = $_umle;
      $utle       = $_utle;
      $urte       = $_urte;
      $uisc       = $_uisc;
      $uir        = $_uir;
      
      
      
      $temp = $data;
      $data = $this->getDetails();
      $data['lang'] = $temp['lang'];
      $data['code'] = $temp['code'];
      
      ob_start();
      
      $time=gmdate("YmdHis");
      $apiuser = 'lima';
      $apipass = 'lipsum';
      $lang = $data['lang'];
      $code = $data['code'];

      $pid     = $data['pid'];
      $ptitle  = $data['ptitle'];
      $psubmit = $data['psubmit'];
      $pac     = $data['pac'];      // Accepted, discrete
      $pacall  = $data['pacall'];   //  Accepted, not discrete
      $pwa     = $data['pwa'];      //  Wrong answer
      $pnac    = $data['pnac'];
      $pnotrun = $data['pnotrun'];  // Not running
      $pce     = $data['pce'];      // Compilation error
      $pmle    = $data['pmle'];     // Memory limit exceeded
      $ptle    = $data['ptle'];     // Time limit exceeded
      $pisc    = $data['pisc'];     //  Illegal system call
      $pir     = $data['pir'];      //  Internal error

      $tcin    = $data['tcin'];
      $tcout   = $data['tcout'];
      
      $tcout   = str_ireplace("\r","",$tcout);// delete \r in textfile

      $tcin  = trim($tcin);
      $tcout = trim($tcout);
      if ($tcin[strlen($tcin)-1] != "\n") {
         $tcin .= "\n";
      }
      if ($tcout[strlen($tcout)-1] != "\n") {
         $tcout .= "\n";
      }

      $ptim = $data['ptim'];
      $pmem = $data['pmem'];

      $input   = $tcin;
      $run     = true;
      $private = true;

      $client = new SoapClient( "http://ideone.com/api/1/service.wsdl" ); //create new SoapClient
      $result = $client->createSubmission( $apiuser, $apipass, $code, $lang, $input, $run, $private );
      //create new submission
      
      if ( $result['error'] == 'OK' ) {
      //if submission is OK, get the status
         sleep(1);
         $status = $client->getSubmissionStatus( $apiuser, $apipass, $result['link'] );
         
         if ( $status['error'] == 'OK' ) { 
            while ( $status['status'] != 0 ) {
               //check if the status is 0, otherwise getSubmissionStatus again
               sleep(1); //sleep 1 seconds
               $status = $client->getSubmissionStatus( $apiuser, $apipass, $result['link'] );
            }
            
            $details = $client->getSubmissionDetails( $apiuser, $apipass, $result['link'], true, true, true, true, true );
            //finally get the submission results
            
            if ( $details['error'] == 'OK' ) { //ok
               switch ($details['result']) {
                  case 0:
                     $verdict="Not running";
                     $pnotrun++;
                     $unotrun++;
                     break;
                  case 11:
                     $verdict="Compilation error";
                     $pce++;
                     $uce++;
                     break;
                  case 12:
                     $verdict="Runtime error";
                     $prte++;
                     $urte++;
                     break;
                  case 13:
                     $verdict="Time limit exceeded";
                     $ptle++;
                     $utle++;
                     break;
                  case 15:
                     $verdict="Success";
                     break;
                  case 17:
                     $verdict="Memory limit exceeded";
                     $pmle++;
                     $umle++;
                     break;
                  case 19:
                     $verdict="Illegal system call";
                     $pisc++;
                     $uisc++;
                     break;
                  case 20:
                     $verdict="Internal error";
                     $pir++;
                     $uir++;
                     break;
               }
               $output = $details['output'];
               
               if ($verdict == "Success") {
                  if ($details['time']>$ptim) {
                     $verdict = "Time limit exceeded";
                     $ptle++;
                     $utle++;
                  } else if ($details['memory']>$pmem) {
                     $verdict = "Memory limit exceeded";
                     $pmle++;
                     $umle++;
                  } else {
                     if (strcmp($details['output'],$tcout)==0) {
                        $verdict = "Accepted";
                        $pacall++;
                        $uacall++;
                     } else {
                        $verdict = "Wrong Answer";
                        $pwa++;
                        $uwa++;
                     }
                  }
               } else if ($verdict == "Not running") {
                  if ($lang == 62) {   //Text
                     $compcode = trim($code);
                     if ($compcode[strlen($compcode)-1] != "\n") {
                        $compcode .= "\n";
                     }
                     if (strcmp($compcode, $tcout)==0) {
                        $verdict = "Accepted";
                        $pacall++;
                        $uacall++;
                     } else {
                        $verdict = "Wrong Answer";
                        $pwa++;
                        $uwa++;
                     }
                  }
               }
               
               $ideonelink = $result['link'];
               $per = "INSERT INTO pcdb_ans(pid, ptitle, uid, uname, time, link, verdict)
                     VALUES('$pid', '$ptitle', '$uid', '$uname', '$time', '$ideonelink', '$verdict')";
               $pqry = mysqli_query($konek, $per);
               
               //Process verdict
               $psubmit++;
               $usubmit++;
               if ($verdict=="Accepted") {
                  $fn   = $uname.".user";
                  $fs   = tempatnya($fn,"user");
                  if (file_exists($fs)) {
                     $cont = file_get_contents($fs);
                     $cont = str_ireplace("\r","",$cont);
                     if (strripos($cont, $ptitle)===false) {
                        $cont=$cont."\n".$ptitle;
                        file_put_contents($fs, stripslashes($cont));
                        $pac++;
                        $uac++;
                     }
                  } else {
                     $cont = $ptitle;
                     file_put_contents($fs, stripslashes($cont));
                     $pac++;
                     $uac++;
                  }
                  
               } else {
                  $pnac++;
                  $unac++;
               }
               $per2 = "UPDATE pcdb_prob SET
               psubmit  = '$psubmit',
               pac      = '$pac',
               pnac     = '$pnac',
               pwa      = '$pwa',
               pacall   = '$pacall',
               pnotrun  = '$pnotrun',
               pce      = '$pce',
               prte     = '$prte',
               ptle     = '$ptle',
               pmle     = '$pmle',
               pisc     = '$pisc',
               pir      = '$pir'
               WHERE pid='$pid'";
               $pqry2 = mysqli_query($konek, $per2);
               
               $per3= "UPDATE pcdb_user SET
               usubmit  = '$usubmit',
               uac      = '$uac',
               unac     = '$unac',
               uwa      = '$uwa',
               uacall   = '$uacall',
               unotrun  = '$unotrun',
               uce      = '$uce',
               urte     = '$urte',
               utle     = '$utle',
               umle     = '$umle',
               uisc     = '$uisc',
               uir      = '$uir'
               WHERE uname = '$uname'";
               $pqry3 = mysqli_query($konek, $per3);
               
               if (isset($pqry,$pqry2,$pqry3)){
                  echo "<h2>Answer submitted.</h2>";
                  echo "<p>Details:";
                  echo "<br />&emsp;Language: ".$details['langName']." ".$details['langVersion'];
                  echo "<br />&emsp;Memory used: ".$details['memory']." kB";
                  echo "<br />&emsp;Time used: ".$details['time']." s";
                  echo "<br />&emsp;Verdict: <b><code>".$verdict."</code></b>";
                  echo "<br />Your code:<br /><pre>".$details['source']."</pre></p>";
               } else {
                  echo "<h2>Failed to submit</h2><h3>".mysqli_error($konek)."</h3>"."<br />&emsp;Answer ID: " . $id;
               }
            } else { //we got some error
               echo "<h2>Failed to submit</h2><h3>".$details['result']."</h3>";
               var_dump( $details );
            }
         } else { //we got some error
            echo "<h2>Failed to submit</h2><h3>".$status['result']."</h3>";
            var_dump( $status );
         }
      } else { //we got some error
         echo "<h2>Failed to submit</h2><h3>".$result['error']."</h3>";
         var_dump( $result );
      }
      include "grade.php";
      return ob_get_clean();
   }
   
   public function delete($type = "prob"){
      global $_urole;
      global $base_url;
      $data = $this->getDetails();
      if ($type == "prob") {
         
         if ($_urole <= 1) {
            return "<h2>Deleting problem</h2>"."You do not have the right to do this action.";
         }
         $content = $data['probContent'];
      } else {
         
         if ($_urole <= 1) {
            return "<h2>Deleting solution</h2>"."You do not have the right to do this action.";
         }
         $content = $data['solContent'];
      }
      $tcin = $data['tcin'];
      $tcout = $data['tcout'];
      $ptitle = $data['ptitle'];
      $pid = $data['pid'];
      ob_start();
      include "delete.php";
      return ob_get_clean();
      
   }
   public function confirmDelete( $type = "prob") {
      global $_urole;
      if ($_urole <= 1) {
         return "You do not have the right to do this action.";
      }
      global $base_url;
      global $konek;
      if ($this->problemExists()) {
         $content = "<h2>Deletion result</h2>";
         $pid = $this->name;
         
         if ($type == "prob") {
            
            $per = "DELETE FROM pcdb_prob WHERE pid='$pid'";
            $pqry = mysqli_query($konek, $per);
            if ( !isset($pqry) ) {
               $content .= mysqli_error($konek)."<br />";
            } else {
               $content .= "Database entry deleted. <br />";
               
               $probPath = $this->getProblemPath();
               unlink($probPath);
               $content .= "Problem deleted. <br />";
                     
               $solPath = $this->getSolutionPath();
               unlink($solPath);
               $content .= "Solution deleted. <br />";
         
               $tcinPath = $this->getTCInPath();
               unlink($tcinPath);
               $content .= "Input testcase deleted. <br />";
               
               $tcoutPath = $this->getTCOutPath();
               unlink($tcoutPath);
               $content .= "Output testcase deleted. <br />";
            }
         } else if ($type == "sol") {
            $solPath = $this->getSolutionPath();
            unlink($solPath);
            $content .= "Solution deleted. <br />";
         }
      } else {
         $content = "Problem did not exists.";
      }
      return $content;
   }
   
   public function createMenuItem($action = "view", $text = "Problem", $type = "problem", $behav = "left") {
      global $base_url;
      if ($type == "sol") {
         $type = "solution";
      } else if ($type == "prob") {
         $type = "problem";
      }
      if ($behav == "right") {
         return "<a href=\"". $base_url . $type. ".". $action . "." . $this->name . "\"><div class=\"menu-item right-item\">" . $text . "</div></a>";
      } else if ($behav == "current") {
         return "<a href=\"". $base_url . $type. ".". $action . "." . $this->name . "\"><div class=\"menu-item current-item\">" . $text . "</div></a>";
      } else {
         return "<a href=\"". $base_url . $type. ".". $action . "." . $this->name . "\"><div class=\"menu-item\">" . $text . "</div></a>";
      }
   }
   public function getHeader($action = "view", $type = "prob") {
      global $_urole;
      $content = "";
      if ($type == "prob") {
         if ($action=="view") {
            $content = $this->createMenuItem("view","Problem", "problem", "current");
            if ($this->problemExists()) {
               $content .= $this->createMenuItem("edit","Edit");
               if ($_urole >= 2) {
                  $content .= $this->createMenuItem("delete","Delete");
               }
               $content .= $this->createMenuItem("view","Solution","solution", "right");

            } else {
               $content .= $this->createMenuItem("new","New");

            }
            
         } else if ($action=="new") {
            $content = $this->createMenuItem("view","Problem");
            $content .= $this->createMenuItem("new","New", "problem", "current");
            
         } else if ($action=="edit") {
            $content = $this->createMenuItem("view", "Problem");
            $content .= $this->createMenuItem("edit", "Edit", "problem", "current");
            if ($_urole >= 2) {
               $content .= $this->createMenuItem("delete", "Delete");
            }
            $content .= $this->createMenuItem("view", "Solution","solution", "right");
            
         } else if ($action=="save") {
            $content = $this->createMenuItem("view","Problem", "problem", "current");
            $content .= $this->createMenuItem("edit","Edit");
            if ($_urole >= 2) {
               $content .= $this->createMenuItem("delete","Delete");
            }
            $content .= $this->createMenuItem("view","Solution","solution", "right");
            
         } else if ($action=="delete") {
            $content = $this->createMenuItem("view","Problem");
            $content .= $this->createMenuItem("edit","Edit");
            if ($_urole >= 2) {
               $content .= $this->createMenuItem("delete","Delete", "problem", "current");
            }
            $content .= $this->createMenuItem("view","Solution","solution", "right");
            
         } else if ($action=="confirmdelete") {
            $content = $this->createMenuItem("view","Problem", "problem", "current");
            $content .= $this->createMenuItem("new","New");
            
         } else {
            $content = $this->createMenuItem("view","Problem", "problem", "current");
            $content .= $this->createMenuItem("edit","Edit");
            if ($_urole >= 2) {
               $content .= $this->createMenuItem("delete","Delete");
            }
            $content .= $this->createMenuItem("view","Solution","solution", "right");
            
         }
      } else if ($type == "sol") {
         if ($action=="view") {
            $content = $this->createMenuItem("view","Solution","solution", "current");
            if ($this->solutionExists()) {
               $content .= $this->createMenuItem("edit","Edit","solution");
               if ($_urole >= 2) {
                  $content .= $this->createMenuItem("delete","Delete","solution");
               }

            } else {
               $content .= $this->createMenuItem("new","New","solution");

            }
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         } else if ($action=="new") {
            $content = $this->createMenuItem("view","Solution","solution");
            $content .= $this->createMenuItem("new","New","solution", "current");
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         } else if ($action=="edit") {
            $content = $this->createMenuItem("view","Solution","solution");
            $content .= $this->createMenuItem("edit","Edit","solution", "current");
            if ($_urole >= 2) {
               $content .= $this->createMenuItem("delete","Delete","solution");
            }
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         } else if ($action=="save") {
            $content = $this->createMenuItem("view","Solution","solution", "current");
            $content .= $this->createMenuItem("edit","Edit","solution");
            if ($_urole >= 2) {
               $content .= $this->createMenuItem("delete","Delete","solution");
            }
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         } else if ($action=="delete") {
            $content = $this->createMenuItem("view","Solution","solution");
            $content .= $this->createMenuItem("edit","Edit","solution");
            if ($_urole >= 2) {
               $content .= $this->createMenuItem("delete","Delete","solution", "current");
            }
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         } else if ($action=="confirmdelete") {
            $content = $this->createMenuItem("view","Solution","solution", "current");
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         } else {
            $content = $this->createMenuItem("view","Solution","solution", "current");
            $content .= $this->createMenuItem("edit","Edit","solution");
            if ($_urole >= 2) {
               $content .= $this->createMenuItem("delete","Delete","solution");
            }
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         }
      }
      return $content;
   }
}
?>
