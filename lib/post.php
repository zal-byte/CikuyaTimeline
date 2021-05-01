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
			$res["timeline"] = array();
			$arr["fetchTimeline"] = array();
			$arru["gambarPostingan"] = array();
			while($row = $this->sql->assoc($response)){
				$re["id_postingan"] = $row["id_postingan"];
				$re["isi_postingan"] = $row["isi_postingan"];
				$re["jumlahsuka_postingan"] = $row["jumlahsuka_postingan"];
				$re["jumlahkomentar_postingan"] = $row["jumlahkomentar_postingan"];
				$re["namapengguna_warga"] = $row["namapengguna_warga"];
				$re["nama_warga"] = $row["nama_warga"];
				array_push($arru["gambarPostingan"], $this->getGambarPostingan($row["id_postingan"]));
				array_push($arr["fetchTimeline"], $re);
			}
			array_push($res["timeline"], $arr);
			array_push($res["timeline"], $arru);
			$this->print($res);
		}
		public function getGambarPostingan($id_postingan){
			$response = $this->sql->query("select * from gambar_postingan where id_postingan='".$id_postingan."' order by id_gambarpostingan desc");
			$arr = array();
			while($row = $this->sql->assoc($response)){
				array_push($arr, array("src"=>$row["gambar_postingan"]));
			}
			return $arr;
		}
		public function print($string){
			echo json_encode($string);
		}
	}

?>