var html = "";
function fetchTimeline(){
	$.ajax({
		type:'GET',
		url:'pros.php?request=fetchTimeline',
		success:function(res){
			var json = JSON.parse(res);
			for(var i = 0; i < json.timeline[0].fetchTimeline.length; i++){
				var obj = json.timeline[0].fetchTimeline[i];
				h("<div class='card shadow border-0'>"); //div1
				h("<div class='card-body'>");//div2
				h("<p class='font-weight-bold p-2'>"+obj.nama_warga+"</p>");
				h("<hr>");
				if( json.timeline[1].gambarPostingan[0].length > 0){
					h("<div class='carousel slide' id='postSlide' data-ride='carousel'>"); //div3
						h("<ul class='carousel-indicators'>"); //ul1
							for(var asu = 0; asu < json.timeline[1].gambarPostingan[0].length; asu++){
								h("<li data-target='#postSlide' data-slide-to='"+asu+"'></li>"); //li1 //li1
							}
						h("</ul>"); //ul1

						h("<div class='carousel-inner'>"); //div 4
							for(var tempik = 0; tempik < json.timeline[1].gambarPostingan[0].length; tempik++){
								if( tempik == 0 ){
									h("<div class='carousel-item active'>") //div 5
										h("<img src='"+json.timeline[1].gambarPostingan[0][tempik].src+"' class='img-responsive device'></img>"); //img1
									h("</div>"); //div 5									
								}
								h("<div class='carousel-item'>") //div 5
									h("<img src='"+json.timeline[1].gambarPostingan[0][tempik].src+"' class='img-responsive device'></img>"); //img1
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
			console.log(html);
			$("#timeline").html(html);
		}
	});
}
function h(value){
	html += value;
}
function image_preview(){
	// $(document).ready(function(){

	// });

	var total_file = document.getElementById("customFile").files.length;
	var file
	if( total_file > 10 ){

	}
}

function test(){
	var visibility = $("#postPost");
	if(visibility.css("display") == "none"){
		visibility.css("display","block");
	}else if(visibility.css("display") == "block"){
		visibility.css("display","none");
	}

}