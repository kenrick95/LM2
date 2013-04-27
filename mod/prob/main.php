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
         $probContent = "";
      }
      if ($this->solutionExists()) {
         $solContent = $this->getSolutionContent();
      } else {
         $solContent = "";
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
         $hasil = mysql_query($perintah, $konek);
         $data = mysql_fetch_array($hasil);
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
      if (($type == "prob") || ($type == "newprob")) {
         $content = $data['probContent'];
      } else {
         $content = $data['solContent'];
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
      $pid = mysql_escape_string($this->name);

      $content = $data['content'];
      if ($type == "prob") {
         $ptitle = $data['ptitle'];
         $pmem = $data['pmem'];
         $ptim = $data['ptim'];
         $tcin = $data['tcin'];
         $tcout = $data['tcout'];
         
         $pqry = mysql_query("SELECT pid FROM pcdb_prob WHERE pid='$pid'", $konek);
         $pcek = mysql_num_rows($pqry);
         if ($pcek==0){
            $per= "INSERT INTO pcdb_prob(pid, ptitle, ptim, pmem, psubmit, pac, pnac)
               VALUES('$pid', '$ptitle', '$ptim', '$pmem', '0', '0', '0')";
         } else {
            $per= "UPDATE pcdb_prob SET name='$ptitle', ptim='$ptim', pmem='$pmem' WHERE pid='$pid'";
         }
         $pqry = mysql_query($per);
         if (isset($pqry)){
            $tcinpx= $data['tcin'];
            $tcoutx= $data['tcout'];
            file_put_contents($this->getProblemPath(), stripslashes($content));
            file_put_contents($this->getTCInPath(), $tcinpx);
            file_put_contents($this->getTCOutPath(), $tcoutx);
            return $content;
         } else {
            return "Saving failed: ".mysql_error();
         }
         
      } else if ($type == "sol") {
         file_put_contents($this->getSolutionPath(), stripslashes($content));
         return $content;
      }
   }

   
   public function createMenuItem($action = "view", $text = "Problem", $type = "problem", $right = false) {
      global $base_url;
      if ($type == "sol") {
         $type = "solution";
      } else if ($type == "prob") {
         $type = "problem";
      }
      if ($right) {
         return "<div class=\"menu-item right-item\"><a href=\"". $base_url . $type. ".". $action . "." . $this->name . "\">" . $text . "</a></div>";
      } else {
         return "<div class=\"menu-item\"><a href=\"". $base_url . $type. ".". $action . "." . $this->name . "\">" . $text . "</a></div>";
      }
   }
   public function getHeader($action = "view", $type = "prob") {
      $content = "";
      if ($type == "prob") {
         if ($action=="view") {
            $content = $this->createMenuItem("view","Problem");
            if ($this->problemExists()) {
               $content .= $this->createMenuItem("edit","Edit");
               $content .= $this->createMenuItem("delete","Delete");

            } else {
               $content .= $this->createMenuItem("new","New");

            }
            $content .= $this->createMenuItem("view","Solution","solution", true);
            
         } else if ($action=="new") {
            $content = $this->createMenuItem("view","Problem");
            $content .= $this->createMenuItem("new","New");
            
         } else if ($action=="edit") {
            $content = $this->createMenuItem("view","Problem");
            $content .= $this->createMenuItem("edit","Edit");
            $content .= $this->createMenuItem("delete","Delete");
            $content .= $this->createMenuItem("view","Solution","solution", true);
            
         } else if ($action=="save") {
            $content = $this->createMenuItem("view","Problem");
            $content .= $this->createMenuItem("edit","Edit");
            $content .= $this->createMenuItem("delete","Delete");
            $content .= $this->createMenuItem("view","Solution","solution", true);
            
         } else if ($action=="delete") {
            $content = $this->createMenuItem("view","Problem");
            $content .= $this->createMenuItem("edit","Edit");
            $content .= $this->createMenuItem("delete","Delete");
            $content .= $this->createMenuItem("view","Solution","solution", true);
            
         } else if ($action=="confirmdelete") {
            $content = $this->createMenuItem("view","Problem");
            $content .= $this->createMenuItem("edit","Edit");
            $content .= $this->createMenuItem("delete","Delete");
            $content .= $this->createMenuItem("view","Solution","solution", true);
            
         } else {
            $content = $this->createMenuItem("view","Problem");
            $content .= $this->createMenuItem("edit","Edit");
            $content .= $this->createMenuItem("delete","Delete");
            $content .= $this->createMenuItem("view","Solution","solution", true);
            
         }
      } else if ($type == "sol") {
         if ($action=="view") {
            $content = $this->createMenuItem("view","Solution","solution");
            if ($this->solutionExists()) {
               $content .= $this->createMenuItem("edit","Edit","solution");
               $content .= $this->createMenuItem("delete","Delete","solution");

            } else {
               $content .= $this->createMenuItem("new","New","solution");

            }
            $content .= $this->createMenuItem("view","Problem", "problem", true);
            
         } else if ($action=="new") {
            $content = $this->createMenuItem("view","Solution","solution");
            $content .= $this->createMenuItem("new","New","solution");
            $content .= $this->createMenuItem("view","Problem", "problem", true);
            
         } else if ($action=="edit") {
            $content = $this->createMenuItem("view","Solution","solution");
            $content .= $this->createMenuItem("edit","Edit","solution");
            $content .= $this->createMenuItem("delete","Delete","solution");
            $content .= $this->createMenuItem("view","Problem", "problem", true);
            
         } else if ($action=="save") {
            $content = $this->createMenuItem("view","Solution","solution");
            $content .= $this->createMenuItem("edit","Edit","solution");
            $content .= $this->createMenuItem("delete","Delete","solution");
            $content .= $this->createMenuItem("view","Problem", "problem", true);
            
         } else if ($action=="delete") {
            $content = $this->createMenuItem("view","Solution","solution");
            $content .= $this->createMenuItem("edit","Edit","solution");
            $content .= $this->createMenuItem("delete","Delete","solution");
            $content .= $this->createMenuItem("view","Problem", "problem", true);
            
         } else if ($action=="confirmdelete") {
            $content = $this->createMenuItem("view","Solution","solution");
            $content .= $this->createMenuItem("edit","Edit","solution");
            $content .= $this->createMenuItem("delete","Delete","solution");
            $content .= $this->createMenuItem("view","Problem", "problem", true);
            
         } else {
            $content = $this->createMenuItem("view","Solution","solution");
            $content .= $this->createMenuItem("edit","Edit","solution");
            $content .= $this->createMenuItem("delete","Delete","solution");
            $content .= $this->createMenuItem("view","Problem", "problem", true);
            
         }
      }
      return $content;
   }
}
?>
