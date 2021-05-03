var html = "";
var jtml = "";
var vtml = "";

function fetchTimeline(){
	$.ajax({
		type:'GET',
		url:'pros.php?request=fetchTimeline',
		success:function(res){
			if( res.length <= 0){
				//ga ada postingan
				v("<div class='card border-0 shadow mt-2 text-center' style='background-color:lightblue;'>");
					v("<div class='card-body'>");
						v("<h4> Belum ada postingan </h4>");
					v("</div>");
				v("</div>");
				$("#timeline").html(vtml);
			}else{

			var json = JSON.parse(res);
			// console.log(json.fetchTimeline[1].gambarPostingan);
			// console.log(json.fetchTimeline[1].gambarPostingan);
				// console.log(json);
			var ids = Array();
			for(var i = 0; i < json.fetchTimeline.length; i++){
				var obj = json.fetchTimeline[i];
				ids.push(obj.id_postingan);
				h("<div class='card shadow-sm border-0 mb-0 mt-2'>"); //div1
				h("<div class='card-body'>");//div2
				h("<div class='row'>");
					h("<div class='col-1'>");
						h("<img src='"+obj.profile_warga+"' class='img-responsive rounded-circle' style='width:5em; height:5em;'>");
					h("</div>");
					h("<div class='col-lg'>");
						h("<p class='font-weight-bold'>"+obj.nama_warga+"</p>");
						h("<div class='row'>");
							h("<div class='col'>");
								h("<b>2020-02-02</b>");
							h("</div>");
						h("</div>");
					h("</div>");
				h("</div>");
				h("<hr>");
				if( json.fetchTimeline[i].gambarPostingan.length > 0){
					h("<div class='carousel slide' id='postSlide' data-ride='carousel'>"); //div3
						h("<ul class='carousel-indicators'>"); //ul1
							for(var asu = 0; asu < json.fetchTimeline[i].gambarPostingan.length; asu++){
								h("<li data-target='#postSlide' data-slide-to='"+asu+"'></li>"); //li1 //li1
							}
						h("</ul>"); //ul1

						h("<div class='carousel-inner'>"); //div 4
							for(var tempik = 0; tempik < json.fetchTimeline[i].gambarPostingan.length; tempik++){
								if( tempik == 0 ){
									h("<div class='carousel-item active'>") //div 5
										h("<img src='"+json.fetchTimeline[i].gambarPostingan[tempik].src+"' class='img-responsive device'></img>"); //img1
									h("</div>"); //div 5									
								}
								h("<div class='carousel-item'>") //div 5
									h("<img src='"+json.fetchTimeline[i].gambarPostingan[tempik].src+"' class='img-responsive device'></img>"); //img1
								h("</div>"); //div 5
							}
						h("</div>"); //div 4
						h("<a class='carousel-control-prev' href='#postSlide' data-slide='prev'><span class='carousel-control-prev-icon'></span></a>"); //a1 //a1 //span1 //span1
						h("<a class='carousel-control-next' href='#postSlide' data-slide='next'><span class='carousel-control-next-icon'></span></a>"); //a1 //a1 //span1 //span1

					h("</div>"); //div3
				h("<hr>");

				}
				h("<p>"+obj.isi_postingan+"</p>");
				h("<hr>");
				// console.log(isLiked(json.fetchTimeline[i].id_postingan, $("#namapengguna_warga").val()));
				// var fin = true;
				// if( fin == true ){
				// 	h("<center><div class='row'><div class='col p-2 btn-hov cursor-link' onclick='likeSystem(`"+json.fetchTimeline[i].id_postingan+"`,`"+$("#namapengguna_warga").val()+"`)'><b id='like-count'><span class='fa fa-heart' style='color:red;'></span> "+obj.jumlahsuka_postingan+"</b></div><div class='col p-2 btn-hov'><b><span class='fa fa-comment'></span> "+obj.jumlahkomentar_postingan+"</b></div></div></center>");
				// }else{
				// 	h("<center><div class='row'><div class='col p-2 btn-hov cursor-link' onclick='likeSystem(`"+json.fetchTimeline[i].id_postingan+"`,`"+$("#namapengguna_warga").val()+"`)'><b id='like-count'><span class='fa fa-heart' style='color:black;'></span> "+obj.jumlahsuka_postingan+"</b></div><div class='col p-2 btn-hov'><b><span class='fa fa-comment'></span> "+obj.jumlahkomentar_postingan+"</b></div></div></center>");
				// }
				h("<center><div class='row'><div class='col p-2 btn-hov cursor-link' onclick='likeSystem(`"+json.fetchTimeline[i].id_postingan+"`,`"+$("#namapengguna_warga").val()+"`)'><b id='like-count-"+json.fetchTimeline[i].id_postingan+"'><span class='fa fa-heart' id='like-span' style='color:red;'></span> "+obj.jumlahsuka_postingan+"</b></div><div class='col p-2 btn-hov cursor-link' data-toggle='collapse' data-target='#com-col-"+json.fetchTimeline[i].id_postingan+"' aria-expanded='false'><b id='comment-count-"+json.fetchTimeline[i].id_postingan+"'><span class='fa fa-comment'></span> "+obj.jumlahkomentar_postingan+"</b></div></div></center>");
				h("</div>"); //div 2
				h("</div>"); //div1
											// isLiked(json.fetchTimeline[i].id_postingan, $("#namapengguna_warga").val());

				h("<div class='container collapse mt-2' id='com-col-"+json.fetchTimeline[i].id_postingan+"' >");
					h("<div class='card border-0 ' style='border-top-right-radius:0px; border-top-left-radius:0x;'>");
						h("<div class='card-body'>");
						console.log($("#namapengguna_warga"));
							if($("#namapengguna_warga").val() == "null") {

							}else{
								h("<div class='form-group'>");
									h("<label for='comment-value-"+json.fetchTimeline[i].id_postingan+"'>Komentar</label>");
									h("<input type='text' id='comment-value-"+json.fetchTimeline[i].id_postingan+"' class='form-control '>");
									h("<button role='button' type='button' class='btn cursor-link shadow mt-1 btn-hov' onclick='sendComment(`"+json.fetchTimeline[i].id_postingan+"`)'>Kirim</button>");
								h("</div>");
								h("<hr>");
							}
							h("<div style='overflow-y:scroll;'>");
								h("<div id='comment-"+json.fetchTimeline[i].id_postingan+"' style='max-height:30em;'>");
									h("<p> Testing </p>");
								h("</div>");
							h("</div>");
							h("<hr>");
							h("<button class='btn cursor-link btn-hov shadow' data-target='#com-col-"+json.fetchTimeline[i].id_postingan+"' data-toggle='collapse'>Hide</button>");
						h("</div>");	
					h("</div>");
				h("</div>");


			}
				// console.log(html);
				$("#timeline").html(html);
				for(i = 0; i < ids.length; i++){
					fetchComment(ids[i]);
				}
			}
		}
	});
}
function h(value){
	html += value;
}
function j(value){
	jtml += value;
}
var comment = "";
function c(val){
	comment += val;
}
function sendComment(id_postingan){
	var namapengguna_warga = $("#namapengguna_warga").val();
	var isi_komentar = $("#comment-value-"+id_postingan).val();
	if( isi_komentar.length <= 0){
		alert("Komentar tidak boleh kosong");
	}else{
		$.ajax({
			type:'POST',
			url:'pros.php',
			data:'request=sendComment&id_postingan='+id_postingan+'&namapengguna_warga='+namapengguna_warga+'&isi_komentar='+isi_komentar,
			success:function(res){
				var obj = JSON.parse(res);
				if( obj.status ==true ){
					$("#comment-section-"+id_postingan).html("");
					$("#comment-count-"+id_postingan).html("<span class='fa fa-comment'></span> "+obj.count);
					$("#comment-value-"+id_postingan).html(" ");
					setTimeout(function() {fetchComment(id_postingan);}, 1000);
					// fetchComment(id_postingan);
				}else{
					alert(obj.msg);
				}
			}
		});
	}
	// console.log(isi_komentar);
}
 function fetchComment(id_postingan){
	$.ajax({
		type:'GET',
		url:'pros.php?request=fetchComment&id_postingan='+id_postingan,
		success:function(res){
			var json = JSON.parse(res);
			if( json.fetchComment.length <= 0){
				$("#comment-"+id_postingan).html("<b class='text-center'>Belum ada komentar</b>");
			}else{
				for( var i = 0; i < json.fetchComment.length; i++){
					var obj = json.fetchComment[i];
					// console.log(id_postingan);
					// $("#comment-section-"+id_postingan).html("<div class='container card border-0'><div class='card-body'><b><p>"+obj.nama_warga+"</p></b><p>"+obj.isi_komentar+"</p></b></div></div>");
					// $("#comment-section-"+(id_postingan+1)).html(" ");
					c("<div class='container-fluid'>");
						c("<div class='card shadow mt-1 mb-1 border-0'>");
							c("<div class='card-body'>");
								c("<div class='row'>");
									c("<div class='col-1'>");
										c("<img src='"+obj.profile_warga+"' class='device-low-comment img-responsive rounded-circle'>");
									c("</div>");
									c("<div class='col-md'>");
										c("<b class='m-auto'><p>"+obj.nama_warga+"</p></b>");
									c("</div>");
								c("</div>");
								c("<hr>");
								c("<p>"+obj.isi_komentar+"</p>");
							c("</div>");
						c("</div>");
					c("</div>");
					$("#comment-"+obj.id_postingan).html(comment);
				}
				comment = "";
			}
			// $("#comment-section-"+id_postingan).html(comment);
			// comment = " ";
		}
	});
}
function image_preview(){
	// $(document).ready(function(){

	// });

	var total_file = document.getElementById("customFile").files.length;
	if( total_file > 5 ){
		$("#sendto").attr("disabled","disabled");
		$("#postPreview").html("<p class='font-weight-bold p-3 bg-warning rounded m-2'>Gambar hanya bisa 5</p>");
	}else{
		$("#sendto").removeAttr("disabled");
		var last = 1;
		for(var i = 0; i < total_file; i++){
			if( last == 1){
				j("<div class='row'>");
			}
			j("<div class='col'><img src='"+URL.createObjectURL(event.target.files[i])+"' class='img-responsive img-thumbnail device-low'></div>");
			if( last > 1 ){
				j("</div>");
				last = 0;
			}
			last++;
		}
		$("#postPreview").html(jtml);
	}
}
function reset(){
	$("#postPreview").html("");
}
function v(value){
	vtml += value;
}

async function posting(){
	//pertama kita kirim isi postingan terlebih dahulu
	var isi_postingan = $("#isi").val();
	var file_data = $("#customFile").prop("files");
	var data = new FormData();
	if( file_data.length  <= 0 ){

	}else{
		data.append("file", file_data[0]);
	}
	data.append("request","newPost");
	data.append("isi_postingan", isi_postingan);
	data.append("namapengguna_warga",$("#namapengguna_warga").val());
	$.ajax({
		type:'POST',
		data:data,
		cache:false,
		contentType:false,
		processData:false,
		// dataType:'script',
		url:'pros.php',
		success:function(res){
			// alert(res);
			var jo = JSON.parse(res);
			if ( jo.status == true ){
				html = "";
				$("#timeline").html(" ");
				setTimeout(function() {fetchTimeline();$("#isi").val("");$("#postPreview").html("");}, 1000);
				// fetchTimeline();
			}else{
				alert(jso.msg);
			}
		}
	});
}


function isLiked(id_postingan, namapengguna_warga){
	var ss = "";
	 $.ajax({
		type:'GET',
		url:'pros.php?request=checkLike&id_postingan='+id_postingan+'&namapengguna_warga='+namapengguna_warga,
		success:function(res){
			ss += res;
		}
	});
}
function xhr(){
	var xhr = new XMLHttpRequest();
	xhr.open("GET","pros.php?request=fetchTimeline",1);
	xhr.setRequestHeader("Content-Type","text/html");
	xhr.setRequestHeader("User-Agent","");
	xhr.onload = function(){
		console.log("onLoad");
	}

	xhr.send();
	// console.log(xhr);
}

function likeSystem(id_postingan, namapengguna_warga){
	$.ajax({
		type:'GET',
		url:'pros.php?request=doLike&id_postingan='+id_postingan+'&namapengguna_warga='+namapengguna_warga,
		success:function(res){
			var json = JSON.parse(res);

			if( json.status == true ){
				setTimeout(function() {	$("#like-count-"+json.id_postingan).html("<span class='fa fa-heart' style='color:red;'></span> "+json.count);},100);

			}else{
				alert(json.msg);
			}
			
		}
	});
}

function test(){
	var visibility = $("#postPost");
	if(visibility.css("display") == "none"){
		visibility.css("display","block");
	}else if(visibility.css("display") == "block"){
		visibility.css("display","none");
	}

}
