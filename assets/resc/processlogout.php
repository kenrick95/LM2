<?php
/*
session_start();
unset($_SESSION['administrator']);
session_destroy();
*/

// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name('loginsession'), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
setcookie("loginsessioncookie", "", time()-360000);
setcookie("usrcookie", "", time()-360000);

if ($base_url == "http://localhost/lm2/") {
	setcookie("loginsessioncookie", "", time()-360000, "/lm2/");
	setcookie("usrcookie", "", time()-360000, "/lm2/");
} else {
	setcookie("loginsessioncookie", "", time()-360000, "/");
	setcookie("usrcookie", "", time()-360000, "/");
}
// Finally, destroy the session.
session_destroy();
//header( "refresh:5;url=index.php" ); 
//echo "<h3 style='cursor:wait'>Anda telah berhasil keluar log.</h3>";
//echo "<p style='cursor:wait'>Anda akan dialihkan ke Beranda dalam 5 detik. Jika tidak, <a href='index.php'>klik di sini</a>.</p>";
//exit();
echo '{"status":"OK","message":"You\'ve been logged out"}';
?>