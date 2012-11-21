<?php
/**
 * @copyright	Copyright 2006-2012, Miles Johnson - http://milesj.me
 * @license		http://opensource.org/licenses/mit-license.php - Licensed under the MIT License
 * @link		http://milesj.me/code/php/gears
 */

// Turn on error reporting
error_reporting(E_ALL);

// Include the class
include_once '../Gears.php';

$directory = dirname(__FILE__);

// Instantiate engine and set template directory
$temp = new \mjohnson\gears\Gears($directory . '/templates/');

// Set the layout
$temp->setLayout('layouts/default');

// Turn on caching and set the cache directory
$temp->setCaching($directory . '/cache/');

// Check to see if the cache already exists (if not, display() will do so)
// We can do this to exit early and not hit the database (or other logic)
if ($cache = $temp->isCached('index')) {
	echo $cache;
	return;
}

// Bind template variables
$temp->bind(array(
	'className' => 'Gears - Template Engine',
	'extraInfo' => 'Gears is a play on words for: Engine + Gears + Structure.',
	'description' => 'A PHP class that loads template files, binds variables, allows for parent-child hierarchy all the while rendering the template structure.',
	'methods' => get_class_methods($temp)
));

// Render and save cached version to "index"
echo $temp->display('index', 'index');
