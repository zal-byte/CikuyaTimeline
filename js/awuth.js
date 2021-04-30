function logen(){
	var namapengguna_warga = $("#l_username").val();
	var katasandi_warga = $("#l_password").val();

	if(namapengguna_warga.length <= 0){
		alert("Silahkan isi nama pengguna dengan benar");
	}else{
		if(katasandi_warga.length <= 0){
			alert("Silahkan isi kata sandi dengan benar");
		}else{
			$.ajax({
				type:'POST',
				url:'pros.php',
				data:'katasandi_warga='+katasandi_warga+'&namapengguna_warga='+namapengguna_warga+'&login=1',
				success:function(res){
					if( res == "login berhasil"){
						window.location.href = 'index.php';
					}else{
						//error
						console.log(res);
					}
				}
			});
		}
	}
}
function registor(){
	var nama_warga = $("#s_fullname").val();
	var namapengguna_warga = $("#s_username").val();
	var katasandi_warga = $("#s_password").val();
	var nohp_warga = $("#s_phonenumber").val();
	if( nama_warga.length <= 0 ){
								$("#response").attr("class","text-center font-weight-bold p-2 mt-1 bg-warning rounded")
								$("#response").html("Nama lengkap tidak boleh dikosongkan");
	}else{
		$("#s_fullname").attr("class","form-control is-valid");
		if(namapengguna_warga.length <= 0){
								$("#response").attr("class","text-center font-weight-bold p-2 mt-1 bg-warning rounded")
								$("#response").html("Nama pengguna tidak boleh dikosongkan");
		}else{
			$("#s_username").attr("class","form-control is-valid");
			if(nohp_warga.length <= 10){
								$("#response").attr("class","text-center font-weight-bold p-2 mt-1 bg-warning rounded")
								$("#response").html("No HP harus lebih dari 10 digit");
			}else{
				$("#s_phonenumber").attr("class", "form-control is-valid");
				if(katasandi_warga.length <= 2){
								$("#response").attr("class","text-center font-weight-bold p-2 mt-1 bg-warning rounded")
								$("#response").html("Kata sandi harus lebih dari 2 karakter");
				}else{
					$("#s_password").attr("class","form-control is-valid");
					$.ajax({
						type:'POST',
						url:'pros.php',
						data:'signup=1&nama_warga='+nama_warga+'&namapengguna_warga='+namapengguna_warga+'&nohp_warga='+nohp_warga+'&katasandi_warga='+katasandi_warga,
						success:function(res){
							if(res == "Nama pengguna ini telah digunakan oleh orang lain"){
								$("#s_username").attr("class","form-control is-invalid");
								$("#response").attr("class","text-center font-weight-bold p-2 mt-1 bg-danger rounded")
								$("#response").html(res);	
							}else if(res == "Daftar berhasil"){
								$("#s_username").val("");
								$("#s_password").val("");
								$("#s_phonenumber").val("");
								$("#s_fullname").val("");
								$("#response").attr("class","text-center font-weight-bold p-2 mt-1 bg-success rounded")
								$("#response").html("Daftar Berhasil");
							}else if(res == "Daftar gagal"){
								$("#response").attr("class","text-center font-weight-bold p-2 mt-1 bg-danger rounded")
								$("#response").html("Daftar Gagal");								
							}
						}
					});
				}
			}
		}
	}
}
function logeout(){
	$.ajax({
		type:'POST',
		url:'pros.php',
		data:'logout=1',
		success:function(res){
			if( res == "logout berhasil"){
				window.location.href="index.php";
			}else{
				//Huh ?
			}
		}
	});
}