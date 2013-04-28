<?php
############   GLOBAL INCLUDES   ############
include_once("connect.php");
//session_start();
############   GLOBAL FUNCTIONS   ###########
function curPageURL() {
   #current page URL; e.g. http://pc.t15.org/problems.lipsum
   $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
   if ($_SERVER["SERVER_PORT"] != "80"){
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
   } else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
   }
   return $pageURL;
}
function tempatnya($tempat,$tempato="news") {
   if (strpos(curPageURL(),"pc.t15.org") === false) {
      $tempat_dia = "E:\\wamp\\www\\lm2\\data\\".$tempato."\\" . $tempat;
   } else {
      $tempat_dia="//home//u613458361//public_html//data//".$tempato."//".$tempat;
   }
    #$tempat_dia = "E:\\wamp\\www\\ant\\data\\".$tempato."\\" . $tempat;
    return $tempat_dia;
}
if (strpos(curPageURL(),"ant.t15.org") === false) {
   $base_url = "http://localhost/lm2/";
} else {
   $base_url = "http://pc.t15.org/";
}
function curPageName() {
   #Current page name; e.g. register.php
   $pageName=$_SERVER["REQUEST_URI"];
   $pieces = explode("/", $pageName);
   $i=0;
   while (isset($pieces[$i])) {
      $i++;
   }
   $i--;
   $pageName=$pieces[$i];
   return $pageName;
}
function logged_in($top = false){
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
            if ($base_url == "http://localhost/ant/") {
               setcookie("loginsessioncookie", $_SESSION['loginsession'], time()+3600, "/ant/");
               setcookie("usrcookie", $_COOKIE['usrcookie'], time()+3600, "/ant/");
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

$_loggedin = false;
$_loggedin = logged_in(true);
function loggedin() {
   global $_loggedin;
   return $_loggedin;
}
############   GLOBAL CODES  AND VARIABLES   ###########
##      GLOBAL VARIABLE RULES
##
##      NO PREFIX
##       ONLY for SITE THINGS
##
##      USE PREFIX:
##         "$_u" - user module
##         "$_p" - problem module
##         "$_n" - news module
##
##    USER MODULE
##      $_username             = User name
##      $_urole                = User's role id   (role id)
##      $_userrole             = User's role id   (role id)
##      $_userrolename         = User's role name (role name)
##      $_urealname            = User's real name
##      $_uschool              = User's school
##      $_userid               = User's id
##      $_usubmit              = User's number of submission
##      $_uac                  = User's number of Accepted submission
##      $_unac                 = User's number of Not Accepted (RTE/TLE/WA/CE/etc) submission
##  
##      SITE THINGS
##    $_pagetitle              = Page title
##    $_loggedin               = Determine if user is logged in or not
##    $base_url                = Base URL of the website
##    $_version                = Site version
##
##  
##
##  
##
##########################################################


if ($_loggedin){
   #Declare variables for user data
   $_username  = $_COOKIE['usrcookie'];
   $_uname     = $_username;
   $_checkSQL  = "SELECT * FROM pcdb_user WHERE uname='$_username'";
   $_qrycheck  = mysqli_query($konek, $_checkSQL);
   $_data      = mysqli_fetch_array($_qrycheck);
   $_urole     = $_data['urole'];
   $_userrole  = $_urole;
   $_urealname = $_data['urealname'];
   $_uschool   = $_data['uschool'];   
   $_userid    = $_data['uid'];
   $_uid       = $_userid;
   $_usubmit   = $_data['usubmit'];
   $_uac       = $_data['uac'];
   $_unac      = $_data['unac'];
   
   switch ($_urole) {
      case 0: $_userrolename = "User"; break;
      case 1: $_userrolename = "Editor"; break;
      case 2: $_userrolename = "Judge"; break;
      case 3: $_userrolename = "Supervisor"; break;
      case 4: $_userrolename = "Administrator"; break;
   }
   
} else {
   $_username     = "";
   $_urole        = -1;
   $_userrole     = -1;
   $_urealname    = "";
   $_uschool      = "";
   $_userid       = -1;
   $_userrolename = "Anonymous";
}
switch (curPageName()) {
   case "register":      $_pagetitle="Lihat masalah - Create account"; break;
   #case "login":       $_pagetitle="Lihat masalah - Log in"; break;
   #case "problist":      $_pagetitle="Lihat masalah - Problem list"; break;
   case "news":          $_pagetitle="Lihat masalah - News"; break;
   case "home":          $_pagetitle="Lihat masalah - Home"; break;
   case "about":          $_pagetitle="Lihat masalah - About us"; break;
   #case "role":          $_pagetitle="Lihat masalah - User role"; break;
   case "answer":       $_pagetitle="Lihat masalah - Answer"; break;
   #case "":             $_pagetitle="Lihat masalah - "; break;
   default:             $_pagetitle="Lihat masalah"; break;
}
$_version = "20130428";

$_paction="";
$_pxtion="";
if ((isset($_REQUEST['pid'])) && ($_REQUEST['pid'] != "")){
   #Get problem details
	require_once("mod/prob/main.php");
	$problem = new LM2prob($_REQUEST['pid']);
	$data = $problem->getDetails();
	
   $_pid = $_REQUEST['pid'];
   $_tid = $_REQUEST['pid'] . ".txt";
	
	$_tcin = $data['tcin'];
   $_tcout = $data['tcout'];
   $_ptitle = $data['ptitle'];
   $_pid = $data['pid'];
	/*
   $fs   = tempatnya($_tid, "prob");
   if (file_exists($fs)){
      $perintah = "SELECT * FROM pcdb_prob WHERE pid='$_pid'";
      $hasil=mysqli_query($konek, $perintah);
      $data=mysqli_fetch_array($hasil);
      $_ptitle=$data['ptitle'];
   } else {
      $_ptitle=$_pid;
   }*/
	
	
   if ((isset($_REQUEST['pxtion'])) && ($_REQUEST['pxtion'] != "")){
      $_pxtion=$_REQUEST['pxtion'];
      if ($_pxtion=="solution"){
         if (isset($_REQUEST['paction'])){
            $_paction=$_REQUEST['paction'];
         } else {
            $_paction="";
         }
         if ($_paction=="new") {
            $_pagetitle="Lihat masalah - Solution - New: ".$_ptitle;
         } else if ($_paction=="edit") {
            $_pagetitle="Lihat masalah - Solution - Edit: ".$_ptitle;
         } else if ($_paction=="save") {
            $_pagetitle="Lihat masalah - Solution - Save: ".$_ptitle;
         } else if ($_paction=="delete") {
            $_pagetitle="Lihat masalah - Solution - Delete: ".$_ptitle;
         } else if ($_paction=="confirmdelete") {
            $_pagetitle="Lihat masalah - Solution - Confirm deletion: ".$_ptitle;
         } else {
            $_pagetitle="Lihat masalah - Solution: ".$_ptitle;
         }
      }
   } else {
      if ((isset($_REQUEST['paction'])) && ($_REQUEST['paction'] != "")){
         $_paction=$_REQUEST['paction'];
         if ($_paction=="new") {
            $_pagetitle="Lihat masalah - New: ".$_ptitle;
         } else if ($_paction=="edit") {
            $_pagetitle="Lihat masalah - Edit: ".$_ptitle;
         } else if ($_paction=="save") {
            $_pagetitle="Lihat masalah - Save: ".$_ptitle;
         } else if ($_paction=="delete") {
            $_pagetitle="Lihat masalah -  Delete: ".$_ptitle;
         } else if ($_paction=="confirmdelete") {
            $_pagetitle="Lihat masalah - Confirm deletion: ".$_ptitle;
         } else if ($_paction=="submitans") {
            $_pagetitle="Lihat masalah - Submit answer: ".$_ptitle;
         }
      } else {
         $_pagetitle="Lihat masalah: ".$_ptitle;
      }
   }
} else {
   if (curPageName()=="") {
      header("location: home");
   } else if (curPageName()=="home") {
		$data['probContent'] = "";
	}
}
?>
