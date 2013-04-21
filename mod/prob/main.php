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
   
   public function getEditForm($type = "prob") {
      global $base_url;
      $pid = $this->name;
      if ($type == "prob") {
         $content = $this->getProblemContent();
         $tcin = $this->getTCIn();
         $tcout = $this->getTCOut();

      } else if ($type == "newprob") {
         $content = "";
         $tcin = "";
         $tcout = "";

      } else if ($type == "sol") {
         $content = $this->getSolutionContent();
         $tcin = "";
         $tcout = "";

      } else if ($type == "newsol") {
         $content = "";
         $tcin = "";
         $tcout = "";

      }
      ob_start();
      include "form.php";
      return ob_get_clean();
   }
}
?>
