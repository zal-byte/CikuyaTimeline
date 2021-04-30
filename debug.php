<?php

	$path = __DIR__."/png/gg_men.png";
	// echo $path;

	if(isset($_GET["load"])){
		loadimg($path);
		?>
		<img src="debug.php">
		<?php
	}
	function loadimg($path){
		// header("Content-Type: image/png");

		return imagepng(imagecreatefrompng($path));
	}

?>