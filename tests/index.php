<?php

// Turn on error reporting
error_reporting(E_ALL);

function debug($var) {
	echo '<pre>'. print_r($var, true) .'</pre>';
}

// Require the class
include_once '../gears/Gears.php';

$tplPath = dirname(__FILE__) .'/templates';

// Set up engine and display
$temp = new Gears($tplPath);
//$temp->setLayout('layouts/default');
$temp->bind(array(
	'className'		=> 'Gears - Template Engine',
	'version'		=> '2.0',
	'extraInfo'		=> 'Gears is a play on words for: Engine + Gears + Structure.',
	'description'	=> 'A PHP class that loads template files, binds variables, allows for parent-child hierarchy all the while rendering the template structure.',
	1 => 'number check',
	'asd as8dm  0sadmsd asda)*#&$' => 'as'
));

echo $temp->display('index');

debug($temp);