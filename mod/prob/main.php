<?php
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
         $data['pid'] = $pid;
         $data['ptitle'] = $pid;
         $data['ptim'] = "";
         $data['pmem'] = "";
         $data['psubmit'] = 0;
         $data['pac'] = 0;
         $data['pnac'] = 0;
      }
      $data['probContent'] = $probContent;
      $data['solContent'] = $solContent;
      $data['tcin'] = $tcin;
      $data['tcout'] = $tcout;
      
      return $data;
      
   }
   
   public function getEditForm($type = "prob") {
      global $base_url;
      $data = $this->getDetails();
      if ($type == "prob") {
         $content = $data['probContent'];
      } else if ($type == "newprob") {
         $content = "";
      } else if ($type == "sol") {
         $content = $data['solContent'];
      } else if ($type == "newsol") {
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
         $ptitle = $data['ptitle'];
         $pmem = $data['pmem'];
         $ptim = $data['ptim'];
         $tcin = $data['tcin'];
         $tcin=str_ireplace("\r","",$tcin);// delete \r in textfile
         
         $tcout = $data['tcout'];
         $tcout=str_ireplace("\r","",$tcout);// delete \r in textfile
         
         $pqry = mysqli_query($konek, "SELECT pid FROM pcdb_prob WHERE pid='$pid'");
         $pcek = mysqli_num_rows($pqry);
         if ($pcek==0){
            $per= "INSERT INTO pcdb_prob(pid, ptitle, ptim, pmem, psubmit, pac, pnac)
               VALUES('$pid', '$ptitle', '$ptim', '$pmem', '0', '0', '0')";
         } else {
            $per= "UPDATE pcdb_prob SET name='$ptitle', ptim='$ptim', pmem='$pmem' WHERE pid='$pid'";
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
            return "<h2>Saving failed</h2>\n".mysqli_error();
         }
         
      } else if ($type == "sol") {
         $content = $data['content'];
         file_put_contents($this->getSolutionPath(), stripslashes($content));
         return "<h2>Solution saved</h2>\n".$content;
      }
   }

   public function getSubmitAnsForm() {
      global $base_url;
      global $konek;
      $data = $this->getDetails();
      ob_start();
      include "submitans.php";
      return ob_get_clean();
   }
   public function grade($data) {
/*      global $base_url;
      global $konek;
      
      $data = $this->getDetails();
      
      $time=gmdate("YmdHis");
      $apiuser = 'lima';
      $apipass = 'extras1.';
      $lang = $data['lang'];
      $code = $data['code'];

      $psubmit=$data['psubmit'];
      $pac=$data['pac'];
      $pnac=$data['pnac'];

      $tcin = $data['tcin'];
      $tcout = $data['tcout'];
      $tcout=str_ireplace("\r","",$tcout);// delete \r in textfile

      $input = $tcinp;
      $run = true;
      $private = true;

      $client = new SoapClient( "http://ideone.com/api/1/service.wsdl" ); //create new SoapClient
      $result = $client->createSubmission( $apiuser, $apipass, $code, $lang, $input, $run, $private ); //create new submission
       if ( $result['error'] == 'OK' ) { //if submission is OK, get the status
         sleep(1);
         $status = $client->getSubmissionStatus( $apiuser, $apipass, $result['link'] );
         if ( $status['error'] == 'OK' ) { 
            while ( $status['status'] != 0 ) { //check if the status is 0, otherwise getSubmissionStatus again
               sleep(1); //sleep 1 seconds
               $status = $client->getSubmissionStatus( $apiuser, $apipass, $result['link'] );
            }
            $details = $client->getSubmissionDetails( $apiuser, $apipass, $result['link'], true, true, true, true, true );
            //finally get the submission results
            if ( $details['error'] == 'OK' ) { //ok
               switch ($details['result']) {
                  case 0:  $verdict="Not running"; break;
                  case 11: $verdict="Compilation error"; break;
                  case 12: $verdict="Runtime error"; break;
                  case 13: $verdict="Time limit error"; break;
                  case 15: $verdict="Success"; break;
                  case 17: $verdict="Memory limit error"; break;
                  case 19: $verdict="Illegal system call"; break;
                  case 20: $verdict="Internal error"; break;
               }
               $output=$details['output'];
               if ($verdict=="Success") {
                  if ($details['time']>$ptim) {
                     $verdict="Time limit exceeded";
                  } else if ($details['memory']>$pmem) {
                     $verdict="Memory limit exceeded";
                  } else {
                     if (strcmp($details['output'],$tcout)==0) {
                        $verdict="Accepted";
                     } else {
                        $verdict="Wrong Answer";
                     }
                  }
               }
               $ideonelink=$result['link'];
               $per="INSERT INTO pcdb_ans(pid, ptitle, uid, uname, time, link, verdict)
                     VALUES('$pid', '$ptitle', '$userid', '$username', '$time', '$ideonelink', '$verdict')";
               $pqry = mysqli_query($konek, $per);
/* DO MODULE USER FIRST!
										//Process verdict
										$psubmit++;
										$usubmit++;
										if ($verdict=="Accepted") {
											$fn=$username.".user";
											$fs=tempatnya($fn,"u");
											$cont=file_get_contents($fs);
											$cont=str_ireplace("\r","",$cont);
											if (strripos($ptitle, $cont)===false) {
												$cont=$cont."\n".$ptitle;
												file_put_contents($fs, stripslashes($cont));
												$pac++;
												$uac++;
											}
										} else {
											$pnac++;
											$unac++;
										}
										$per2= "UPDATE pcdb_prob SET submit='$psubmit', ac='$pac', nac='$pnac' WHERE pid='$pid'";
										$pqry2 = mysql_query($per2,$konek);
										
										$per3= "UPDATE pcdb_user SET submit='$usubmit', ac='$uac', nac='$unac' WHERE name='$username'";
										$pqry3 = mysql_query($per3,$konek);
										if (isset($pqry,$pqry2,$pqry3)){
											echo "<h2>Pengiriman jawaban " . $id . " berhasil!</h2>";
											echo "<p>Detail jawaban:";
											echo "<br />&emsp;Bahasa pemrograman: ".$details['langName']." ".$details['langVersion'];
											echo "<br />&emsp;Memori: ".$details['memory']." kB";
											echo "<br />&emsp;Waktu: ".$details['time']." s";
											echo "<br />&emsp;Verdict: <b><code>".$verdict."</code></b>";
											echo "<br />Berikut adalah kode Anda:<br /><code>".nl2br($details['source'])."</code></p>";
										} else {
											echo "<h2>Pengiriman jawaban " . $id . " gagal.</h2><h3>".mysql_error()."</h3>";
										}
									} else { //we got some error
										echo "<h2>Pengiriman jawaban " . $id . " gagal.</h2><h3>".$details['result']."</h3>";
										var_dump( $details );
									}
								} else { //we got some error
									echo "<h2>Pengiriman jawaban " . $id . " gagal.</h2><h3>".$status['result']."</h3>";
									var_dump( $status );
								}
							} else { //we got some error
								echo "<h2>Pengiriman jawaban " . $id . " gagal.</h2><h3>".$result['error']."</h3>";
								var_dump( $result );
							}
							$content = "<p><b>Li</b>hat <b>ma</b>salah menggunakan <a href='http://ideone.com'>Ideone API</a> &copy;
oleh <a href='http://sphere-research.com'>Sphere Research Labs</a></p>";

            }*/
      ob_start();
      include "grade.php";
      return ob_get_clean();
   }
   
   public function delete($type = "prob"){
      global $base_url;
      $data = $this->getDetails();
      if ($type == "prob") {
         $content = $data['probContent'];
      } else {
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
      global $base_url;
      global $konek;
      if ($this->problemExists()) {
         $content = "<h2>Deletion result</h2>";
         $pid = $this->name;
         
         if ($type == "prob") {
            
            $per = "DELETE FROM pcdb_prob WHERE pid='$pid'";
            $pqry = mysqli_query($konek, $per);
            if ( !isset($pqry) ) {
               $content .= mysql_error()."<br />";
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
      $content = "";
      if ($type == "prob") {
         if ($action=="view") {
            $content = $this->createMenuItem("view","Problem", "problem", "current");
            if ($this->problemExists()) {
               $content .= $this->createMenuItem("edit","Edit");
               $content .= $this->createMenuItem("delete","Delete");
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
            $content .= $this->createMenuItem("delete", "Delete");
            $content .= $this->createMenuItem("view", "Solution","solution", "right");
            
         } else if ($action=="save") {
            $content = $this->createMenuItem("view","Problem", "problem", "current");
            $content .= $this->createMenuItem("edit","Edit");
            $content .= $this->createMenuItem("delete","Delete");
            $content .= $this->createMenuItem("view","Solution","solution", "right");
            
         } else if ($action=="delete") {
            $content = $this->createMenuItem("view","Problem");
            $content .= $this->createMenuItem("edit","Edit");
            $content .= $this->createMenuItem("delete","Delete", "problem", "current");
            $content .= $this->createMenuItem("view","Solution","solution", "right");
            
         } else if ($action=="confirmdelete") {
            $content = $this->createMenuItem("view","Problem", "problem", "current");
            $content .= $this->createMenuItem("new","New");
            
         } else {
            $content = $this->createMenuItem("view","Problem", "problem", "current");
            $content .= $this->createMenuItem("edit","Edit");
            $content .= $this->createMenuItem("delete","Delete");
            $content .= $this->createMenuItem("view","Solution","solution", "right");
            
         }
      } else if ($type == "sol") {
         if ($action=="view") {
            $content = $this->createMenuItem("view","Solution","solution", "current");
            if ($this->solutionExists()) {
               $content .= $this->createMenuItem("edit","Edit","solution");
               $content .= $this->createMenuItem("delete","Delete","solution");

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
            $content .= $this->createMenuItem("delete","Delete","solution");
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         } else if ($action=="save") {
            $content = $this->createMenuItem("view","Solution","solution", "current");
            $content .= $this->createMenuItem("edit","Edit","solution");
            $content .= $this->createMenuItem("delete","Delete","solution");
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         } else if ($action=="delete") {
            $content = $this->createMenuItem("view","Solution","solution");
            $content .= $this->createMenuItem("edit","Edit","solution");
            $content .= $this->createMenuItem("delete","Delete","solution", "current");
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         } else if ($action=="confirmdelete") {
            $content = $this->createMenuItem("view","Solution","solution", "current");
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         } else {
            $content = $this->createMenuItem("view","Solution","solution", "current");
            $content .= $this->createMenuItem("edit","Edit","solution");
            $content .= $this->createMenuItem("delete","Delete","solution");
            $content .= $this->createMenuItem("view","Problem", "problem", "right");
            
         }
      }
      return $content;
   }
}
?>
