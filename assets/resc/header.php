<?php
############   GLOBAL INCLUDES   ############
include_once("connect.php");
//session_start();
############   GLOBAL FUNCTIONS   ###########
function tempatnya($tempat,$tempato="news") {
   if (strpos(curPageURL(),"pc.t15.org") === false) {
      $tempat_dia = "E:\\wamp\\www\\lm2\\data\\".$tempato."\\" . $tempat;
   } else {
      $tempat_dia="//home//u613458361//public_html//data//".$tempato."//".$tempat;
   }
    #$tempat_dia = "E:\\wamp\\www\\ant\\data\\".$tempato."\\" . $tempat;
    return $tempat_dia;
}
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
if (strpos(curPageURL(),"pc.t15.org") === false) {
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

require_once("mod/user/main.php");
$cur_user = new LM2generalUser();

function logged_in($top = false){
   #Determine if someone is logged in
   global $cur_user;
	return $cur_user->logged_in($top);
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
$user_details = $cur_user->getDetails();

$_username  = $user_details['uname'];
$_uname     = $_username;
$_urole     = $user_details['urole'];
$_userrole  = $_urole;
$_urolename = $user_details['urolename'];
$_userrolename = $user_details['urolename'];
$_urealname = $user_details['urealname'];
$_uschool   = $user_details['uschool'];   
$_userid    = $user_details['uid'];
$_uid       = $_userid;
$_usubmit   = $user_details['usubmit'];
$_uac       = $user_details['uac'];
$_unac      = $user_details['unac'];

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
$_version = "1.1a1";

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
} else if ((isset($_REQUEST['uaction'])) && ($_REQUEST['uaction'] != "")){
	$_uaction = $_REQUEST['uaction'];
	/**************************************************************
	*
	*  NOTICE!!!!
	*  "xid" here is for Module:User
	*          This is due to "uid" being used already as
	*          the current logged in user ID
	*/
	if (isset($_REQUEST['xid'])) {
		$_xid = $_REQUEST['xid'];
		$user = new LM2uid($_xid);
	} else {
		$_xid = -1;
	}
	if ($_uaction == "view") {
		$_pagetitle="Lihat masalah - View user";
	} else if ($_uaction == "edit") {
		$_pagetitle="Lihat masalah - Edit user";
	
	} else if ($_uaction == "delete") {
		$_pagetitle="Lihat masalah - Delete user";
	
	} else if ($_uaction == "save") {
		$_pagetitle="Lihat masalah - Save user";
	
	} else if ($_uaction == "register") {
		$_pagetitle="Lihat masalah - Create account";
		
	} else if ($_uaction == "login") {
		$_pagetitle="Lihat masalah - Log in";
	
	} else if ($_uaction == "reset") {
		$_pagetitle="Lihat masalah - Reset user";
	
	} else if ($_uaction == "manage") {
		$_pagetitle="Lihat masalah - Manage user";
	
	} else if ($_uaction == "etc") {
		$_pagetitle="Lihat masalah - etc";
	
	} else {
	
	}
} else {
   if (curPageName()=="") {
      header("location: home");
   } else if (curPageName()=="home") {
		require_once("mod/prob/main.php");
		$problem = new LM2prob("home");
		$data = $problem->getDetails();
		$content = $data['probContent'];
	} else if (curPageName()=="about") {
		require_once("mod/prob/main.php");
		$problem = new LM2prob("about");
		$data = $problem->getDetails();
		$content = $data['probContent'];
	} else if (curPageName()=="tos") {
		require_once("mod/prob/main.php");
		$problem = new LM2prob("tos");
		$data = $problem->getDetails();
		$content = $data['probContent'];
	}
}

?>
