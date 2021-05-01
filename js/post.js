var html = "";
var jtml = "";
function fetchTimeline(){
	$.ajax({
		type:'GET',
		url:'pros.php?request=fetchTimeline',
		success:function(res){
			var json = JSON.parse(res);
			// console.log(json.fetchTimeline[1].gambarPostingan);
			console.log(json.fetchTimeline[1].gambarPostingan);
			for(var i = 0; i < json.fetchTimeline.length; i++){
				var obj = json.fetchTimeline[i];
				h("<div class='card shadow border-0'>"); //div1
				h("<div class='card-body'>");//div2
				h("<p class='font-weight-bold p-2'>"+obj.nama_warga+"</p>");
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
				}
				h("<hr>");
				h("<p>"+obj.isi_postingan+"</p>");
				h("<hr>");
				h("<center><div class='row'><div class='col'><b><span class='fa fa-heart' style='color:red;'></span> "+obj.jumlahsuka_postingan+"</b></div><div class='col'><b><span class='fa fa-comment'></span> "+obj.jumlahkomentar_postingan+"</div></div></center>");
				h("</div>"); //div 2
				h("</div>"); //div1
			}
			// console.log(html);
			$("#timeline").html(html);
		}
	});
}
function h(value){
	html += value;
}
function j(value){
	jtml += value;
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

async function posting(){
	//pertama kita kirim isi postingan terlebih dahulu
	var isi_postingan = $("#isi").val();
	var file_data = $("#customFile").prop("files");
	var form_data = new Array();
	
	for(var i = 0; i < file_data.length; i++){
		form_data.push(file_data[i]);
	}	
	console.log(form_data);
	var dat = new FormData();
	dat.append("file", form_data);
	console.log(dat);
	$.ajax({
		type:'POST',
		data:dat,
		cache:false,
		contentType:false,
		processData:false,
		dataType:'script',
		url:'pros.php',
		success:function(res){
			alert(res);
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