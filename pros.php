<?php
	
	ob_start();
	session_start();

	include 'lib/sql.php';
	include 'lib/auth.php';
	include "lib/post.php";
	// include 'lib/image.php';
	$sql = A::getInstance();
	$auth = Auth::getInstance($sql);
	$post = Post::getInstance($sql);
	// $image = Image::getInstance();


	if(isset($_POST)){
		if(isset($_POST["login"])){
			$res = $auth->login($_POST["namapengguna_warga"], $_POST["katasandi_warga"]);
			if($res["status"] == true){
				$_SESSION["loged_in"] = true;
				$_SESSION["namapengguna_warga"] = $res["namapengguna_warga"];
				$_SESSION["nama_warga"] = $res["nama_warga"];
				echo $res["msg"];
			}else{
				echo $res["msg"];
			}
		}else if(isset($_POST["logout"])){
			unset($_SESSION["loged_in"]);
			unset($_SESSION["namapengguna_warga"]);
			unset($_SESSION["nama_warga"]);
			session_destroy();
			echo "logout berhasil";
		}else if(isset($_POST["signup"])){
			$res = $auth->signup($_POST["nama_warga"], $_POST["namapengguna_warga"],$_POST["nohp_warga"], $_POST["katasandi_warga"]);
			if($res["status"] == true){
				echo $res["msg"];
			}else{
				echo $res["msg"];
			}
		}else if(isset($_POST["request"])){
			if($_POST["request"] == "newPost"){
				$post->newPost($_POST, $_FILES);
			}
		}
	}
	if(isset($_GET)){
		if(isset($_GET["request"])){
			if($_GET["request"] == "fetchTimeline"){
				$post->fetchTimeline();
			}
		}
	}
	


	ob_end_flush();
?>