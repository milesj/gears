<?php
/**
 * Gears
 *
 * A template engine that will display a specific template within the templates directory.
 * The template can be bound with variables that are passed into the engine from PHP,
 * wrap itself with layout templates, and open templates within templates.
 *
 * @author 		Miles Johnson - http://milesj.me
 * @copyright	Copyright 2006-2011, Miles Johnson, Inc.
 * @license 	http://opensource.org/licenses/mit-license.php - Licensed under The MIT License
 * @link		http://milesj.me/code/php/gears
 */

// Turn on error reporting
error_reporting(E_ALL);

// Include the class
include_once '../gears/Gears.php';

$directory = dirname(__FILE__);

// Instantiate engine and set template directory
$temp = new Gears($directory .'/templates/');

// Set the layout
$temp->setLayout('layouts/default');

// Turn on caching and set the cache directory
$temp->setCaching($directory .'/cache/');

// Bind template variables
$temp->bind(array(
	'className'		=> 'Gears - Template Engine',
	'version'		=> $temp->version,
	'extraInfo'		=> 'Gears is a play on words for: Engine + Gears + Structure.',
	'description'	=> 'A PHP class that loads template files, binds variables, allows for parent-child hierarchy all the while rendering the template structure.',
	'methods'		=> get_class_methods($temp)
));

// Render
echo $temp->display('index', 'index');
