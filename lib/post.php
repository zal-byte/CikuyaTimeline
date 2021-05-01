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
			$response = $this->sql->query("select * from postingan left join warga on warga.namapengguna_warga = postingan.namapengguna_warga order by postingan.id_postingan desc");
			$arr["fetchTimeline"] = array();
			while($row = $this->sql->assoc($response)){
				$re["id_postingan"] = $row["id_postingan"];
				$re["isi_postingan"] = $row["isi_postingan"];
				$re["jumlahsuka_postingan"] = $row["jumlahsuka_postingan"];
				$re["jumlahkomentar_postingan"] = $row["jumlahkomentar_postingan"];
				$re["namapengguna_warga"] = $row["namapengguna_warga"];
				$re["nama_warga"] = $row["nama_warga"];
				$re["gambarPostingan"] = $this->getGambarPostingan($row["id_postingan"]);
				// array_push($arru["gambarPostingan"], $this->getGambarPostingan($row["id_postingan"]));
				array_push($arr["fetchTimeline"], $re);
			}
			// array_push($arr["fetchTimeline"], $re);
			$this->print($arr);
		}
		public function getGambarPostingan($id_postingan){
			$response = $this->sql->query("select * from gambar_postingan where id_postingan='".$id_postingan."' order by id_gambarpostingan desc");
			$arr = array();
			while($row = $this->sql->assoc($response)){
				array_push($arr, array("src"=>$row["gambar_postingan"]));
			}
			return $arr;
		}
		public function newPost($postData, $fileData){
			print_r($postData);
			print_r($fileData);
			//pertama kita eksekusi isi postingan terlebih dahulu
			$default_like = "0";
			$default_comment = "0";
			$namapengguna_warga = $_SESSION["namapengguna_warga"];
			$isiPostingan = $postData["isi_postingan"];
			// $respon1 = $this->sql->query("insert into postingan (`isi_postingan`,`jumlahsuka_postingan`,`jumlahkomentar_postingan`,`namapengguna_warga`) values ('".$isiPostingan."','".$default_like."','".$default_comment."','".$namapengguna_warga."')");
			// if($respon1){
			// 	if($fileData["type"] == "image/gif" || $fileData["type"] == "image/png"){
			// 		//return null
			// 	}
			// }else{
			// 	return array("status"=>false, "msg"=>"Gagal memposting");
			// }
		}
		public function uploadImgPost($fileData){

		}
		public function print($string){
			echo json_encode($string);
		}
	}

?>