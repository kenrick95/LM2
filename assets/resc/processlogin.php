<?php
if (isset($_POST['sign-uid'])&&isset($_POST['sign-pass'])) {
	include_once "connect.php";
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
	$user = $_POST['sign-uid'];
	$pass = $_POST['sign-pass'];
	$pass =hash('sha512',hash('whirlpool', $pass));
	if ((trim($user) != "") && (trim($pass) != "")) {
		$checkSQL = "SELECT * FROM pcdb_user WHERE uname='$user' AND upassword='$pass'";
		$qrycheck = mysqli_query($konek, $checkSQL);
		$checkresult = mysqli_num_rows($qrycheck);
		if ($checkresult >= 1) {
			if (!session_start()) {
				session_start();
			}
			$_SESSION['loginsession'] = hash('sha512',hash('whirlpool', $user)); 
			#setcookie("loginsessioncookie", $_SESSION['loginsession'], time()+3600, );
			
			#setcookie("usrcookie", $user, time()+3600, );
			
			if ($base_url == "http://localhost/lm2/") {
				setcookie("loginsessioncookie", $_SESSION['loginsession'], time()+3600, "/lm2/");
				setcookie("usrcookie", $user, time()+3600, "/lm2/");
			} else {
				setcookie("loginsessioncookie", $_SESSION['loginsession'], time()+3600, "/");
				setcookie("usrcookie", $user, time()+3600, "/");
			}
				echo '{"status":"OK","message":"Login successful"}';
			//header( "refresh:5;url=index.php" ); 
  			//echo "<h3 style='cursor:wait'>Anda telah berhasil masuk log.</h3>";
			//echo "<p style='cursor:wait'>Anda akan dialihkan ke Beranda dalam 5 detik. Jika tidak, <a href='index.php'>klik di sini</a>.</p>";
			//exit();
		} else {
			echo '{"status":"ERROR","message":"Wrong username or password"}';
			//echo "<div class='err'>Nama Pengguna atau Kata Sandi tidak cocok. Silakan coba lagi.</div>";
		}
	} else {
		echo '{"status":"ERROR","message":"Please fill username or password"}';
		//echo "<div class='err'>Mohon isi Nama Pengguna dan Kata Sandi. Silakan coba lagi.</div>";
	}
} else {
	echo '{"status":"ERROR","message":"Invalid request"}';
}
mysqli_close($konek);
?>
