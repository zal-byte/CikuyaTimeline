<?php
	ob_start();
	session_start();

	if(isset($_SESSION)){
		if(isset($_SESSION["namapengguna_warga"])){
			if(isset($_GET[md5($_SESSION["namapengguna_warga"])])){
				if(isset($_SESSION["loged_in"])){
					profile("pengguna");
				}else{
					profile("pengunjung");
				}
			}else{
				if(isset($_SESSION["loged_in"])){
					view("pengguna");
				}else{
					view("pengunjung");
				}
			}
		}else{
			if(isset($_SESSION["loged_in"])){
				view("pengguna");
			}else{
				view("pengunjung");
			}
		}
	}


	// if(isset($_SESSION["loged_in"])){
	// 	view("pengguna");
	// }else{
	// 	view("pengunjung");
	// }

	// if(isset($_GET[md5($_SESSION["namapengguna_warga"])])){
	// 	if(isset($_SESSION["loged_in"])){
	// 		profile("pengguna");
	// 	}else{
	// 		profile("pengunjung");
	// 	}
	// }
	function profile_img_upload(){
		?>
		<div class="modal fade" id="profileUpload" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">
							Unggah Profile
						</h4>
						<button type="button" role="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Tutup
							</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="card border-0">
							<div class="card-body p-2">
								<div class="form-group custom-input">
									<input type="file" onchange="profileImgPreview()" name="imageprofile" class="custom-file-input" id="files">
									<label class="custom-file-label" for="files">Pilih gambar</label>
									<div id="preview">

									</div>
									<button role="button" type="button" class="btn shadow mt-2" id="upload" style="background-color: lightblue;" onclick="uploads()">Unggah</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	function dashboard(){
		echo $_SESSION["namapengguna_warga"];
		?>

		<?php
	}

	function profile($who = "pengunjung"){
		?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Linimasa cikuya lebak">
		<meta name="keyword" content="Cikuya lebak timeline">
		<meta name="author" content="Rizal">
		<link rel="stylesheet" type="text/css" href="style/bootstrap4.3.1.css">
		<link rel="stylesheet" type="text/css" href="style/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="style/font-awesome.min.css">
		<title>Cikuya Timeline</title>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/popper.min.js"></script>
		<script type="text/javascript" src="js/kit.js"></script>
		<script type="text/javascript" src="js/lazyload.js"></script>
		<style type="text/css">
			body{
				margin:0;
				padding: 0;
				background-color: #f5f5f5;
				font-family: google-sans;
			}
			@font-face{
				font-family: google-sans;
				src:url("font/google_sans.ttf");
			}
		@media (max-width: 480px){
			.views{
				display: none;
			}
			.view-nav{
				display: block;
			}
			.postView{
				display: none;
			}
			.device{
				width: 100%;
				height: 15em;
			}
		}
		@media (min-width: 1025px){
			.view-nav{
				display: none;
			}
			.views{
				display: block;
			}
			.device{
				width: 100%;
				height: 35em;
			}
			.postView{
				display: block;
			}
		}
		</style>
		</head>
		<body>
			<div class="jumbotron pl-1 pr-1 pt-2 pb-2 text-center">
				<a href="?upload" data-toggle="modal" data-target="#profileUpload"><img src="png/gg_men.png" class="img-responsive rounded-circle upimg " style="height: 15em; border-style: solid;border-width: 1px; border-color: black;" id="upimg"></a>
				<p class="font-weight-bold mt-2"><?=$_SESSION["nama_warga"];?></p>
			</div>
			<section class="section">
				<div class="container">

				</div>
			</section>
			<?php profile_img_upload();?>
		</body>
				<script type="text/javascript">
			function profileImgPreview(){
				$("#preview").html("<center><img src='"+URL.createObjectURL(event.target.files[0])+"' class='img-responsive' style='height=10em; width:10em;'></center>");
			}	
			function uploads(){
				var file_data = $("#files").prop("files")[0];
				var form_data = new FormData();
				form_data.append("file",file_data);
				$.ajax({
					type:'POST',
					url:'pros.php',
					dataType:'script',
					cache:false,
					contentType:false,
					processData:false,
					data:form_data,
					success:function(res){
						console.log(res);
					}
					//error
				});
				console.log(form_data.get("file"));
			}
		</script>
					<script type="text/javascript">
		$("img").lazyload({

	    effect : "fadeIn"

	});</script>
		</html>
		<?php
	}

	function view($who = "pengunjung"){



?>

	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Linimasa cikuya lebak">
		<meta name="keyword" content="Cikuya lebak timeline">
		<meta name="author" content="Rizal">
		<link rel="stylesheet" type="text/css" href="style/bootstrap4.3.1.css">
		<link rel="stylesheet" type="text/css" href="style/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="style/font-awesome.min.css">
		<title>Cikuya Timeline</title>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/popper.min.js"></script>
		<script type="text/javascript" src="js/kit.js"></script>
		<script type="text/javascript" src="js/lazyload.js"></script>
		<style type="text/css">
			body{
				margin:0;
				padding: 0;
				background-color: #f5f5f5;
				font-family: google-sans;
			}
			.bimg1{
				background-image:url("png/gg_men.png");
				background-repeat: no-repeat;
				background-position: right;
				background-size: contain;
			}
			@font-face{
				font-family: google-sans;
				src:url("font/google_sans.ttf");
			}
		@media (max-width: 480px){
			.views{
				display: none;
			}
			.view-nav{
				display: block;
			}
			.postView{
				display: none;
			}
			.device{
				width: 100%;
				height: 15em;
			}
		}
		@media (min-width: 1025px){
			.view-nav{
				display: none;
			}
			.views{
				display: block;
			}
			.device{
				width: 100%;
				height: 35em;
			}
			.postView{
				display: block;
			}
		}
		</style>
	</head>
	<body>
		<?php if(isset($_SESSION["loged_in"])){

			?>
		<header>
			<div class="view-nav navbar navbar-inverse-lg container text-center m-0 pb-2" style="background-color: lightblue;">
				<img src="png/gg_men.png" class="mb-1 img-responsive rounded-circle" style="height: 5em;">
				<p><?=$_SESSION["nama_warga"];?></p>
				<hr>
				<div class="row">
					<div class="col">
						<a href="#" onclick="test()" data-target="#postPost" data-toggle="collapse" aria-expanded="false" aria-controls="postPost">
							<button role="button" type="button" class="btn shadow">Posting</button>
						</a>
					</div>
					<div class="col">
						<a href="?<?=md5($_SESSION["namapengguna_warga"]);?>">
							<button role="button" type="button" class="btn shadow">Profile</button>
						</a>
					</div>
					<div class="col">
						<a href="#">
							<button role="button" type="button" class="btn shadow" onclick="logeout()">Keluar</button>
						</a>
					</div>
				</div>
			</div>
		</header>
			<?php

		}?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4 m-1">
					<div class="card border-0 shadow">
						<?php if( $who == "pengunjung" ){
							?>
						<div class="card-header">
							<h3> Masuk / Daftar untuk memposting </h3>
						</div>
						<div class="card-body" style="visibility: visible;" aria-hashup="false" aria-hidden="false" id="form">
							<center><b>Masuk</b></center>
							<div class="form-group">
								<label>Nama Pengguna</label>
								<input type="text" id="l_username" placeholder="Nama Pengguna" class="form-control" required="true">
								<lable>Kata Sandi</lable>
								<input type="password" id="l_password" placeholder="Kata sandi" class="form-control" required="true">
								<br/>
								<button role="button" type="button" class="btn btn-info" onclick="logen()">Masuk</button>
							</div>
							<hr>
							<center><b>Daftar</b></center>
							<div class="form-group">
								<label>Nama Pengguna</label>
								<input type="text" id="s_username" placeholder="Nama pengguna" class="form-control" required="true">
								<label>Nama Lengkap</label>
								<input type="text" id="s_fullname" placeholder="Nama lengkap" class="form-control" required="true">
								<label>No HP</label>
								<input type="number" id="s_phonenumber" placeholder="08xxxx" class="form-control" required="true">
								<label>Kata Sandi</label>
								<input type="password" id="s_password" placeholder="Kata sandi baru" class="form-control" required="true">
								<br/>
								<button type="button" role="button" class="btn btn-info" onclick="registor()">Daftar</button>
								<p class="text-center font-weight-bold" id="response"></p>
							</div>
						</div>
							<?php
						}else if($who == "pengguna"){
							?>
						<div class="card-header views " style="background-color: lightblue;">
							<h3> Selamat datang, <?=$_SESSION["nama_warga"];?>. </h3>
						</div>
						<div class="card-body postView" aria-hidden="false" id="postPost">
							<div class="postView container text-center mb-2">
								<div class="row">
									<div class="col">
										<a href="?<?=md5($_SESSION["namapengguna_warga"]);?>">
											<button role="button" type="button" class="btn shadow">Profile</button>
										</a>
									</div>
									<div class="col">
										<a href="#">
											<button role="button" type="button" class="btn shadow" onclick="logeout()">Keluar</button>
										</a>
									</div>
								</div>								
							</div>
							<p class="text-center">
								Buat postingan baru
							</p>
<!-- 							<label for="judul">Judul Postingan</label>
							<input type="text" class="form-control" id="judul" placeholder="Judul Postingan" required="true"> -->
							<label for="isi">Isi Postingan</label>
							<textarea class="form-control bimg1" rows="5" placeholder="Hari ini cerah sekali !"></textarea>
							<label for="gambar">Tambah gambar <span style="color:darkred;">Max 10 Gambar</span></label>
							<div class="custom-file">
								<input type="file" name="upload[]" class="custom-file-input" id="customFile" onchange="image_preview()"  required="true"   multiple="multiple">
								<label class="custom-file-label" for="customFile">Choose File</label>
							</div>

							<div id="postPreview">

							</div>

							<button class="btn shadow mt-2" style="background-color: lightblue;text-shadow: 1px 1px 1px white;">Unggah</button>
						</div>
							<?php
						} ?>
					</div>
				</div>
				<div class="col-md">
					<p class="text-center font-weight-bold">Postingan Terbaru</p>
					<div style="overflow-y: scroll;">
<!-- 						<div class="card shadow border-0 m-1">
							<div class="card-body">
								<p class="font-weight-bold">Rizal Solehudin</p>
								<center>
									<img src="png/gg_men.png" class="img-responsive img-thumbnail mb-2 device">
									<hr>
								</center>
								<p>Hari ini sungguh cerah sekali.</p>
								<hr>
								<center>
									<div class="row">
										<div class="col">
											<b><span class="fa fa-heart" style="color: red;"></span> 10</b>
										</div>
										<div class="col">
											<b><span class="fa fa-comment" style="color: black;"></span> 10</b>
										</div>
										<div class="col">
											<b><span class="fa fa-share" style="color: black;"></span> 10</b>
										</div>
									</div>									
								</center>

							</div>
						</div>
						<div class="card border-0 shadow m-1">
							<div class="card-body">
								<p class="font-weight-bold">Rizal Solehudin</p>
								<p> ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
								quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
								consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
								cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							</div>
						</div> -->
						<div id="timeline">

						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="js/post.js"></script>
		<script type="text/javascript" src="js/awuth.js"></script>
		<script type="text/javascript">
			$("#img").lazyload({
				efect:"fadeIn"
			});
		</script>
		<script type="text/javascript">fetchTimeline();</script>

	</body>
	</html>
	<?php 
	}

	ob_end_flush();

?>