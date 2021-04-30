function fetchTimeline(){
	$.ajax({
		type:'GET',
		url:'row.php',
		success:function(res){
			$("#timeline").html(res);
		}
	});
}
function image_preview(){
	// $(document).ready(function(){

	// });

	var total_file = document.getElementById("customFile").files.length;
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