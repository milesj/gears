<?php

// Turn on error reporting
error_reporting(E_ALL);

// Include the class
include_once '../gears/Gears.php';

function debug($var) {
	echo '<pre>'. print_r($var, true) .'</pre>';
}

$directory = dirname(__FILE__) .'/templates/';

// Instantiate engine and set template directory
$temp = new Gears($directory);

// Set the layout
$temp->setLayout('layouts/default');

$temp->setCaching($directory .'_cache');

// Bind template variables
$temp->bind(array(
	'className'		=> 'Gears - Template Engine',
	'version'		=> $temp->version,
	'extraInfo'		=> 'Gears is a play on words for: Engine + Gears + Structure.',
	'description'	=> 'A PHP class that loads template files, binds variables, allows for parent-child hierarchy all the while rendering the template structure.',
	'methods'		=> get_class_methods($temp)
));

// Render
echo $temp->display('index', 'wtf.index');

debug($temp);