<?php
	
	class Auth{
		public $sql;
		public $connect;
		private static $instance = null;
		public static function getInstance($sql){
			if(self::$instance == null){
				self::$instance = new Auth($sql);
			}
			return self::$instance;
		}
		public function __construct($sql){
			$this->sql = $sql;
			$this->sql->con($sql::CONNECT_PREPARE, "localhost","database","root","cikuy");
		}
		public function login($namapengguna_warga, $katasandi_warga){
			$ss = $this->sql->query("select * from warga where namapengguna_warga='".$namapengguna_warga."'");
			$row = $this->sql->assoc($ss);
			if($this->sql->num($ss) > 0){
				if(md5($katasandi_warga) == $row["katasandi_warga"]){
					return array("status"=>true, "msg"=>"login berhasil","namapengguna_warga"=>$row["namapengguna_warga"],"nama_warga"=>$row["nama_warga"]);
				}else{
					return array("status"=>false,"msg"=>"Kata sandi salah");
				}
			}else{
				return array("status"=>false,"msg"=>"Pengguna tidak ditemukan");
			}
		}
		public function signup($nama_warga, $namapengguna_warga, $nohp_warga, $katasandi_warga){
			if($this->checkUser($namapengguna_warga) == true){
				return array("status"=>false, "msg"=>"Nama pengguna ini telah digunakan oleh orang lain");
			}else{

				$response = $this->sql->query("insert into warga (`nama_warga`,`nohp_warga`,`namapengguna_warga`,`katasandi_warga`,`profile_warga`) values ('".$nama_warga."','".$nohp_warga."','".$namapengguna_warga."','".md5($katasandi_warga)."','profile/default.jpg')");
				if($response){
					return array("status"=>true, "msg"=>"Daftar berhasil");
				}else{
					return array("status"=>false,"msg"=>"Daftar gagal");
				}
			}
		}
		public function checkUser($namapengguna_warga){
			$row = $this->sql->assoc($this->sql->query("select * from warga where namapengguna_warga='".$namapengguna_warga."'"));
			if($row["namapengguna_warga"]){
				//ada
				return true;
			}else{
				return false;
			}
		}
	}

?>