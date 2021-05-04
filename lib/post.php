<?php

	class Post{
		private static $instance = null;
		public static function getInstance($sql){
			if(self::$instance == null){
				self::$instance = new Post($sql);
			}
			return self::$instance;
		}
		public $sql;
		public function __construct($sql){
			$this->sql = $sql;
			$this->sql->con($this->sql::CONNECT_PREPARE, "localhost","database","root","cikuy");
		}
		public function fetchTimeline(){
			$response = $this->sql->query("select * from postingan left join warga on warga.namapengguna_warga = postingan.namapengguna_warga order by postingan.id_postingan desc limit 0,5");
			$arr["fetchTimeline"] = array();
			while($row = $this->sql->assoc($response)){
				$re["id_postingan"] = $row["id_postingan"];
				$re["isi_postingan"] = $row["isi_postingan"];
				$re["jumlahsuka_postingan"] = $row["jumlahsuka_postingan"];
				$re["jumlahkomentar_postingan"] = $row["jumlahkomentar_postingan"];
				$re["namapengguna_warga"] = $row["namapengguna_warga"];
				$re["nama_warga"] = $row["nama_warga"];
				$re["profile_warga"] = $row["profile_warga"];
				$re["gambarPostingan"] = $this->getGambarPostingan($row["iden"]);
				// array_push($arru["gambarPostingan"], $this->getGambarPostingan($row["id_postingan"]));
				array_push($arr["fetchTimeline"], $re);
			}
			// array_push($arr["fetchTimeline"], $re);
			$this->print($arr);
		}
		public function getGambarPostingan($iden){
			$response = $this->sql->query("select * from gambar_postingan where iden='".$iden."' order by id_gambarpostingan desc");
			$arr = array();
			while($row = $this->sql->assoc($response)){
				array_push($arr, array("src"=>$row["gambar_postingan"]));
			}
			return $arr;
		}
		public function newPost($postData, $fileData){
			// print_r($postData);
			// print_r($fileData);
			//pertama kita eksekusi isi postingan terlebih dahulu
			$default_like = "0";
			$default_comment = "0";
			$namapengguna_warga = $_SESSION["namapengguna_warga"];
			$isiPostingan = isset($postData["isi_postingan"]) ? $postData["isi_postingan"] : " ";
			$iden = base64_encode(uniqid());
			$respon1 = $this->sql->query("insert into postingan (`isi_postingan`,`jumlahsuka_postingan`,`jumlahkomentar_postingan`,`namapengguna_warga`,`iden`) values ('".$isiPostingan."','".$default_like."','".$default_comment."','".$namapengguna_warga."','".$iden."')");
			if($respon1){
				if(isset($fileData["file"])){
					$path = "posts/img/";
					$ex = explode(".", $fileData["file"]["name"]);
					$ext = $ex[count($ex)-1];
					$respon2 = $this->sql->query("insert into gambar_postingan (`gambar_postingan`,`iden`) values ('".$path.$namapengguna_warga."_".$iden.".".$ext."','".$iden."')");
				$this->uploadImgPost($fileData, $iden, $namapengguna_warga);
				}else{
					$this->print(array("status"=>true,"msg"=>"Postingan terkirim"));
				}

			}else{
				$this->print(array("status"=>false, "msg"=>"Gagal memposting"));
			}
		}
		public function uploadImgPost($fileData, $iden, $namapengguna_warga){
			$ex = explode(".", $fileData["file"]["name"]);
			$ext = $ex[count($ex)-1];
			$path = "posts/img/";
			$filename = $namapengguna_warga."_".$iden.".".$ext;
			if(move_uploaded_file($fileData["file"]["tmp_name"], $path.$filename)){
				$this->print(array("status"=>true, "msg"=>"Postingan berhasil di unggah"));
			}else{
				$this->print(array("status"=>false, "msg"=>"Postingan gagal di unggah"));
			}
		}

		public function uploadImgProfile($postData, $fileData){
			$namapengguna_warga = $postData["namapengguna_warga"];
			$path = "profile/";
			$fil = explode(".", $fileData["file"]["name"]);
			$filename = $namapengguna_warga.".".$fil[count($fil)-1];
			if(file_exists($path.$filename)){
				unlink($path.$filename);
			}
			if(move_uploaded_file($fileData["file"]["tmp_name"], $path.$filename)){
				$this->updateProfileQuery($postData["namapengguna_warga"], $fil[count($fil)-1]);
			}else{
				$this->print(array("status"=>false,"msg"=>"Profile gagal diperbarui"));
			}
		}
		public function updateProfileQuery($namapengguna_warga, $ext){
			$reso = $this->sql->query("update warga set profile_warga='profile/".$namapengguna_warga.".".$ext."' where namapengguna_warga='".$namapengguna_warga."'");
			if($reso){
				$this->print(array("status"=>true,"msg"=>"Profile berhasil diperbarui","src"=>"profile/".$namapengguna_warga.".".$ext));
			}else{
				$this->print(array("status"=>false,"msg"=>"Profile tidak bisa diperbarui"));
			}
		}


		public function fetchProfileData($namapengguna_warga){
			$res = $this->sql->query("select * from warga where namapengguna_warga='".$namapengguna_warga."'");
			$row = $this->sql->assoc($res);
			$this->print(array("nama_warga"=>$row["nama_warga"], "namapengguna_warga"=>$row["namapengguna_warga"],"profile_warga"=>$row["profile_warga"],"nohp_warga"=>$row["nohp_warga"]));
		}
		public function doLike($id_postingan, $namapengguna_warga){
			$re = $this->sql->query("select * from suka where id_postingan='".$id_postingan."' and namapengguna_warga='".$namapengguna_warga."'");
			if($this->sql->num($re) > 0){
				$this->doUnlike($id_postingan, $namapengguna_warga);
			}else{
				$response = $this->sql->query("insert into suka (`jumlah`,`id_postingan`,`namapengguna_warga`) values ('1','".$id_postingan."','".$namapengguna_warga."')");
				if($response){
					$jumlahsuka_postingan = $this->sql->assoc($this->sql->query("select jumlahsuka_postingan from postingan where id_postingan='".$id_postingan."'"))["jumlahsuka_postingan"];
					$rus = $this->sql->query("update postingan set jumlahsuka_postingan='".($jumlahsuka_postingan + 1)."' where id_postingan='".$id_postingan."'");
					if($rus){
						$this->print(array("status"=>true, "msg"=>"Liked","count"=>$jumlahsuka_postingan+1,"id_postingan"=>$id_postingan));
					}else{
						$this->print(array("status"=>false, "msg"=>"Like error ( update "));
					}
				}else{
					$this->print(array("status"=>true, "msg"=>"Like error"));
				}
			}
		}
		public function doUnlike($id_postingan, $namapengguna_warga){
			$re = $this->sql->query("delete from suka where id_postingan='".$id_postingan."' and namapengguna_warga='".$namapengguna_warga."'");
			if($re){
				$ri = $this->sql->query("select jumlahsuka_postingan from postingan where id_postingan='".$id_postingan."'");
				if($ri){
					$row = $this->sql->assoc($ri);
					$jumlahsuka_postingan = (int) $row["jumlahsuka_postingan"];
					$na = $this->sql->query("update postingan set jumlahsuka_postingan='".($jumlahsuka_postingan -1 )."' where id_postingan='".$id_postingan."'");
					if($na){
						$this->print(array("status"=>true,"msg"=>"Unliked","count"=>$jumlahsuka_postingan-1,"id_postingan"=>$id_postingan));
					}else{
						$this->print(array("status"=>false, "msg"=>"Unlike error ( update )"));
					}
				}else{
					$this->print(array("status"=>false, "msg"=>"Couldn't fetch jumlahsuka_postingan"));
				}
			}else{
				$this->print(array("status"=>false, "msg"=>"Unlike error"));
			}
		}
		public function checkLiked($id_postingan, $namapengguna_warga){
			if($this->sql->num($this->sql->query("select * from suka where id_postingan='".$id_postingan."' and namapengguna_warga='".$namapengguna_warga."'")) > 0 ){
				$this->print(array("status"=>true,"msg"=>"Ada"));
			}else{
				// echo "Tidak ada";
				$this->print(array("status"=>false, "msg"=>"Tidak ada"));
			}
		}
		public function fetchComment($id_postingan){
			//relasi tabel komentar dengan warga
			$aa["fetchComment"] = array();
			$reso = $this->sql->query("select * from komentar inner join warga using (namapengguna_warga) where id_postingan='".$id_postingan."' order by komentar.id_komentar desc");
			while($row = $this->sql->assoc($reso)){
				$re["id_komentar"] = $row["id_komentar"];
				$re["nama_warga"] = $row["nama_warga"];
				$re["profile_warga"] = $row["profile_warga"];
				$re["isi_komentar"] = $row["isi_komentar"];
				$re["namapengguna_warga"] = $row["namapengguna_warga"];
				$re["id_postingan"] = $id_postingan;
				array_push($aa["fetchComment"], $re);
			}
			$this->print($aa);
		}
		public function sendComment($id_postingan, $namapengguna_warga, $isi_komentar){
			$reso = $this->sql->query("insert into komentar (`id_postingan`,`isi_komentar`,`namapengguna_warga`) values ('".$id_postingan."','".$isi_komentar."','".$namapengguna_warga."')");
			if($reso){
				$count = $this->sql->assoc($this->sql->query("select jumlahkomentar_postingan from postingan where id_postingan='".$id_postingan."'"))["jumlahkomentar_postingan"];
				$oo = $this->sql->query("update postingan set jumlahkomentar_postingan = '".($count + 1)."' where id_postingan='".$id_postingan."'");
				if($oo){
					$this->print(array("status"=>true, "msg"=>"Komentar berhasil ditambahkan","count"=>$count + 1));
				}else{
					$this->print(array("status"=>false, "msg"=>"Komentar gagal ditambahkan (update)"));
				}
			}else{
				$this->print(array("status"=>false, "msg"=>"Komentar gagal ditambahkan"));
			}
		}





		////////////////////////P{rofile}
		public function updateProfile($array){
			$nama_warga = $array["nama_warga"];
			$nohp_warga = $array["nohp_warga"];

			$result = $this->sql->query("update warga set nama_warga='".$nama_warga."', nohp_warga='".$nohp_warga."' where namapengguna_warga='".$array["namapengguna_warga"]."'");
			if($result){
				$this->print(array("status"=>true, "msg"=>"Profile berhasil diperbarui"));
			}else{
				$this->print(array("status"=>false, "msg"=>"Profile gagal diperbarui"));
			}
		}

		public function changePassword($array){
			$pass = $this->fetchPass($array["namapengguna_warga"]);
			if($)
		}
		function fetchPass($namapengguna_warga){
			return $this->sql->assoc($this->sql->query("select katasandi_warga from warga where namapengguna_warga='".$namapengguna_warga."'"))["katasandi_warga"];
		}


		public function print($string){
			echo json_encode($string);
		}
	}

?>