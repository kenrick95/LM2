<?php
if (isset($_POST['sign-uid'])&&isset($_POST['sign-pass'])) {
	include_once "connect.php";
	$user = $_POST['sign-uid'];
	$pass = $_POST['sign-pass'];
	$pass =hash('sha512',hash('whirlpool', $pass));
	if ((trim($user) != "") && (trim($pass) != "")) {
		$checkSQL = "SELECT * FROM antdb_user WHERE name='$user' AND password='$pass'";
		$qrycheck = mysql_query($checkSQL,$konek);
		$checkresult = mysql_num_rows($qrycheck);
		if ($checkresult >= 1) {
			if (!session_start()) {
				session_start();
			}
			$_SESSION['loginsession'] = hash('sha512',hash('whirlpool', $user)); 
			#setcookie("loginsessioncookie", $_SESSION['loginsession'], time()+3600, );
			
			#setcookie("usrcookie", $user, time()+3600, );
			
			if ($base_url == "http://localhost/lm2/") {
				setcookie("loginsessioncookie", $_SESSION['loginsession'], time()+3600, "/ant/");
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
?>