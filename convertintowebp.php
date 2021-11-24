<?php

//print_r($_REQUEST);

$file = $_REQUEST['image'];
$ext = pathinfo($file, PATHINFO_EXTENSION);
$type = array("jpg", "jpeg", "png");
//echo 'in_array '.in_array($ext, $type);
if (in_array($ext, $type))
{
	echo $output = str_replace(array($ext,'/img'),array('webp','/w3webp/img'),$file);
	$image = imagecreatefromstring(file_get_contents($file));
	imagewebp($image,$output,80);
	imagedestroy($image);
	echo '<h4>Output Image Saved as '.$output.'</h4>';
}