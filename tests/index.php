<?php

// Turn on error reporting
error_reporting(E_ALL);

// Require the class
include_once '../gears/Gears.php';

$tplPath = dirname(__FILE__) .'/templates/';

// Set up engine and display
$temp = new Gears($tplPath);
$temp->bind(array(
	'className'		=> 'Gears - Template Engine',
	'version'		=> '2.0',
	'extraInfo'		=> 'Gears is a play on words for: Engine + Gears + Structure.',
	'description'	=> 'A PHP class that loads template files, binds variables, allows for parent-child hierarchy all the while rendering the template structure.'
));
$temp->setLayout('layout');
echo $temp->display('index');
