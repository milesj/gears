<?php 
/**
 * template.php
 *
 * A template engine that can will display a specific template within the templates directory.
 * The template can be bound with variables that are passed into the template from PHP,
 * as well the template can have a wrapping layout template.
 * 
 * @author 		Miles Johnson - www.milesj.me
 * @copyright	Copyright 2006-2009, Miles Johnson, Inc.
 * @license 	http://www.opensource.org/licenses/mit-license.php - Licensed under The MIT License
 * @package 	Gears - Template Engine
 * @version 	2.0
 * @link		www.milesj.me/resources/script/template-engine
 */

class Gears {

	/**
	 * Current version: www.milesj.me/resources/script/template-engine
	 *
	 * @access public
	 * @var string
	 */
	public $version = '2.0';
	
	/**
	 * Settings required for the template engine.
	 *
	 * @access private
	 * @var array
	 */
	private $__config = array(
		'ext' => 'tpl',
		'path' => '/',
		'layout' => null
	);

	/**
	 * The rendered inner content to be used in the layout.
	 *
	 * @access private
	 * @var string
	 */
	private $__content;
	
	/**
	 * Array of binded template variables.
	 *
	 * @access private
	 * @var array
	 */
	private $__variables = array();

	/**
	 * Configure the templates path and file extension.
	 *
	 * @access public
	 * @param string $path
	 * @param string $ext
	 * @return void
	 */
	public function __construct($path = '', $ext = 'tpl') {
		if (substr($path, -1) != DIRECTORY_SEPARATOR) {
			$path .= DIRECTORY_SEPARATOR;
		}
		
		$this->__config = array(
			'ext' => trim($ext, '.'),
			'path' => $path,
			'layout' => 'default.tpl'
		);
	}

	/**
	 * Binds variables to all the templates.
	 *
	 * @access public
	 * @param array $vars
	 * @return void
	 */
	public function bind(array $vars = array()) {
		if (!empty($vars)) {
			foreach ($vars as $var => $value) {
				$this->__variables[$var] = $value;
			}
		}
	}

	/**
	 * Checks for a valid template extension and that the file exists.
	 *
	 * @access public
	 * @param string $tpl
	 * @return string
	 */
	public function checkPath($tpl) {
		if (substr($tpl, -(strlen($this->__config['ext']) + 1)) != '.'. $this->__config['ext']) {
			$tpl .= '.'. $this->__config['ext'];
		}

		$tpl = str_replace($this->__config['path'], '', $tpl);

		if (!file_exists($this->__config['path'] . $tpl)) {
			trigger_error('Gears::checkPath(): The template "'. $tpl .'" does not exist', E_USER_ERROR);
		}

		return $tpl;
	}

	/**
	 * Displays the chosen template and its layout.
	 *
	 * @access public
	 * @param string $tpl
	 * @param boolean $return
	 * @return mixed
	 */
	public function display($tpl, $return = false) {
		// Render inner layout
		$this->__content = $this->render($this->__config['path'] . $this->checkPath($tpl));

		// Render outer layout
		$rendered = $this->render($this->__config['path'] . $this->__config['layout']);

		if ($return === true) {
			return $rendered;
		} else {
			echo $rendered;
		}
	}

	/**
	 * Return the rendered content.
	 *
	 * @access public
	 * @return string
	 */
	public function getContent() {
		return $this->__content;
	}

	/**
	 * Include a template within another template. Can pass variables into its own private scope.
	 *
	 * @access public
	 * @param string $tpl
	 * @param array $variables
	 * @return string
	 */
	public function open($tpl, array $variables = array()) {
		return $this->render($this->__config['path'] . $this->checkPath($tpl), $variables);
	}

	/**
	 * Render the template and extract the variables using output buffering.
	 *
	 * @access public
	 * @param string $tpl
	 * @param array $variables
	 * @return string
	 */
	public function render($tpl, array $variables = array()) {
		$variables = array_merge($this->__variables, $variables);
		extract($variables, EXTR_SKIP);

		ob_start();
		require $tpl;
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * Reset the class back to its defaults. Can save the previous path if necessary.
	 *
	 * @access public
	 * @param boolean $savePath
	 * @return void
	 */
	public function reset($savePath = true) {
		$path = $this->__config['path'];

		$this->__config = array();
		$this->__content = null;
		$this->__variables = array();

		if ($savePath === true) {
			$this->__config['path'] = $path;
		}
	}

	/**
	 * Set the current layout to be used.
	 *
	 * @access public
	 * @param string $tpl
	 * @return void
	 */
	public function setLayout($tpl) {
		if ($path = $this->checkPath($tpl)) {
			$this->__config['layout'] = $path;
		}
	}
	
}
