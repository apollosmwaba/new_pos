<?php 

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/database.php";
require_once __DIR__ . "/model.php";

spl_autoload_register('my_function');

function my_function($classname)
{
	$filename = "../app/models/".ucfirst($classname) . ".php";
	if(file_exists($filename)){
		require $filename;
	}
}