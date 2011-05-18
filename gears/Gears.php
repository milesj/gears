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

class Gears {

	/**
	 * Current version.
	 *
	 * @access public
	 * @var string
	 */
	public $version = '2.0';
	
	/**
	 * Settings required for the template engine.
	 *
	 * @access protected
	 * @var array
	 */
	protected $_config = array(
		'ext' => 'tpl',
		'path' => '/',
		'layout' => null
	);

	/**
	 * The rendered inner content to be used in the layout.
	 *
	 * @access protected
	 * @var string
	 */
	protected $_content;
	
	/**
	 * Array of binded template variables.
	 *
	 * @access protected
	 * @var array
	 */
	protected $_variables = array();

	/**
	 * Configure the templates path and file extension.
	 *
	 * @access public
	 * @param string $path
	 * @param string $ext
	 * @return void
	 */
	public function __construct($path, $ext = 'tpl') {
		$path = str_replace('\\', '/', $path);

		if (substr($path, -1) != '/') {
			$path .= '/';
		}
		
		$this->_config = array(
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
				if (is_numeric($var)) {
					$var = '_'. $var;
				}

				$var = preg_replace('/[^_a-zA-Z0-9]/i', '', $var);

				$this->_variables[$var] = $value;
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
		if (substr($tpl, -(strlen($this->_config['ext']) + 1)) != '.'. $this->_config['ext']) {
			$tpl .= '.'. $this->_config['ext'];
		}

		$path = str_replace($this->_config['path'], '', trim($tpl, '/'));

		if (!file_exists($this->_config['path'] . $path)) {
			trigger_error(sprintf('%s(): The template "%s" does not exist', __METHOD__, $tpl), E_USER_ERROR);
		}

		return $path;
	}

	/**
	 * Displays the chosen template and its layout.
	 *
	 * @access public
	 * @param string $tpl
	 * @return mixed
	 */
	public function display($tpl) {
		// Render inner layout
		$this->_content = $this->_render($this->_config['path'] . $this->checkPath($tpl));

		// Render outer layout
		$rendered = $this->_render($this->_config['path'] . $this->_config['layout']);

		return $rendered;
	}

	/**
	 * Return the rendered content.
	 *
	 * @access public
	 * @return string
	 */
	public function getContent() {
		return $this->_content;
	}

	/**
	 * Include a template within another template. Can pass variables into its own protected scope.
	 *
	 * @access public
	 * @param string $tpl
	 * @param array $variables
	 * @return string
	 */
	public function open($tpl, array $variables = array()) {
		return $this->_render($this->_config['path'] . $this->checkPath($tpl), $variables);
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
			$this->_config['layout'] = $path;
		}
	}

	/**
	 * Render the template and extract the variables using output buffering.
	 *
	 * @access protected
	 * @param string $path
	 * @param array $variables
	 * @return string
	 */
	protected function _render($path, array $variables = array()) {
		$variables = array_merge($this->_variables, $variables);
		extract($variables, EXTR_SKIP);

		ob_start();
		include $path;
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
	
}
