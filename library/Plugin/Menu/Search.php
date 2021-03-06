<?php
/**
 * ZRECommerce e-commerce web application.
 * 
 * @author ZRECommerce
 * 
 * @package Plugin
 * @category Plugin
 * 
 * @version $Id$
 * @copyright Copyrights 2008 ZRECommerce. See README file.
 * @license GPL v3 or higher. See README file.
 */
/**
 * Plugin_Menu_Search - Outputs a search bar.
 */
class Plugin_Menu_Search implements Plugin_Abstract {
	private $_options = null;
	
	public function __construct($options=null) {
		
	}
	
	public function setOptions($options)
	{
		$this->_options = $options;
		return true;
	}
	
	public function getOptions()
	{
		return $this->_options;
	}
	
	public function __toString() {
		return $this->getHtml();
	}
	public function getHtml() {
		$cssTemplatePath = Zre_Template::baseCssTemplateUrl();
		
		$output = <<<EOD
		<div id="searchBarMain">
			<form action="/search/" method="POST">
				<input type="text" id="searchTextBox" name="searchTextBox" />
				<input type="image" id="searchButtonSubmit" src="$cssTemplatePath/components/searchbar.button.png" />
			</form>
		</div>
EOD;
		return $output;
	}
	
	public function getScript() {
		
	}
	
	/**
	 * Outputs the configuration form
	 *
	 * @return Zend_Form
	 */
	public function getForm() {
		
	}
	
	/**
	 * Validate submitted values.
	 *
	 * @param array $params
	 */
	public function validateForm( $params ) {
		
	}
	
	/**
	 * Process the form values.
	 *
	 * @param array $params
	 */
	public function processForm( $params ) {
		
	}
	/**
	 * Install the plugin
	 *
	 */
	public function install() {
		
	}
	/**
	 * Uninstall the plugin
	 *
	 */
	public function uninstall() {
		
	}
}
?>