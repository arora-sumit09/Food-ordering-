<?php

function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}
define('SERVER_DISH_IMAGE',$_SERVER['DOCUMENT_ROOT'].'\\media\dish\\');
define('SITE_IMAGE',"http://localhost:3000/");
define('SITE_DISH_IMAGE',SITE_IMAGE."media/dish/")
?>