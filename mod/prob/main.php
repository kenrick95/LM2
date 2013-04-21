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
   
   public function getProblemPath() {
      return $this->getPath("prob");
   }
   
   public function getProblemContent() {
      if (file_exists( $this->getProblemPath() )) {
         return file_get_contents($this->getProblemPath());
      } else {
         return "File not found";
      }
   }
   
   public function getSolutionPath() {
      return $this->getPath("sol");
   }
   
   public function getSolutionContent() {
      if (file_exists( $this->getSolutionPath() )) {
         return file_get_contents($this->getSolutionPath());
      } else {
         return "File not found";
      }
   }
   public function getTCInPath() {
      return $this->getPath("in");
   }
   public function getTCIn() {
      if (file_exists( $this->getTCInPath() )) {
         return file_get_contents($this->getTCInPath());
      } else {
         return "File not found";
      }
   }
   public function getTCOutPath() {
      return $this->getPath("out");
   }
   public function getTCOut() {
      if (file_exists( $this->getTCOutPath() )) {
         return file_get_contents($this->getTCOutPath());
      } else {
         return "File not found";
      }
   }
   public function getDetails() {
      global $konek;
      global $base_url;
      $pid = $this->name;
      $probContent = $this->getProblemContent();
      $solContent = $this->getSolutionContent();
      $tcin = $this->getTCIn();
      $tcout = $this->getTCOut();
      
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
}
?>
