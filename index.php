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
   include_once "assets/resc/header.php";
   ##########          START           ##########
   ##########   EARLY MODULE PROCESS   ##########
   //something to do here
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
      ##########    EARLY MODULE JAVASCRIPT     ##########
      ##########              END               ##########
   ?>
   <body>
      <div id="top">
         <div id="menu">
            <div id="menu-list">
               <a href="<?php echo $base_url; ?>home">
                  <div class="menu-item logo">
                     <b>Li</b>hat <b>ma</b>salah
                  </div>
               </a>
               <!--
               <div class="menu-item" id="pidform-cont">
                  <form id="pidform" name="pidform" action="javascript:void(0);">
                     <input type="text" id="pform-pid" name="pform-pid" value="<?php
                  if (isset($_GET['pid'])) {
                     echo $_GET['pid'];
                  }
                  ?>" title="ID Masalah"/>
                  </form>
               </div>
               
               <?php
                  if (isset($_GET['pid'])) {
                     ?>
               <div class="menu-item"><a href="problems.submitans.<?php echo $_GET['pid']; ?>">Kumpul jawaban</a></div>
               <?php
                  }
                  ?>
                  <div class="menu-item">Beranda</div>
                  <div class="menu-item">News</div>
                  <div class="menu-item">About</div>
               <div class="menu-item right-item" id="sign-trigger">
                  <?php
                     if (loggedin()){
                        if (trim($_urealname)=="") {
                           echo $_username;
                        } else {
                           echo $_urealname;
                        }
                     } else {
                        echo "Masuk log";
                     }
                  ?>
               </div>
               -->
            </div>
         </div>
      </div>
      <div id="main">
         <div id="main-wrapper">
            <div id="header">
               <?php include_once "assets/resc/loginbox.php" ?>
               <div style="clear:both;"></div>
               </div>
            <div id="content">
               <div id="content-main">
                  <!--     Content    -->
                  <?php
                     ##########          START            ##########
                     ##########    MODULE MAIN CONTENT    ##########
                     //something to do here
                     require_once("mod/prob/main.php");
                     $problem = new LM2prob("ywd");
                     echo $problem->getEditForm("sol");
                     echo $problem->getProblemContent();
                     ##########    MODULE MAIN CONTENT    ##########
                     ##########           END             ##########
                  ?>
               </div>
            </div>
            <div id="footer">
               <div id="footer-cc">
                  <a rel="license" href="http://creativecommons.org/licenses/by/3.0/" target="_blank">
                     <img alt="Lisensi Creative Commons" title="Lisensi Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by/3.0/80x15.png" />
                  </a>
                  <br />
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
