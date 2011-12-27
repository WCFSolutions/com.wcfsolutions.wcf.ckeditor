<?php
/**
 * Provides functions to use the ckeditor.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wcf.ckeditor
 * @subpackage	data.ckeditor
 * @category	Community Framework
 */
class CKEditor {
	/**
	 * html id of ckeditor
	 * 
	 * @var	string
	 */
	protected $htmlID = '';
	
	/**
	 * config options of ckeditor
	 * 
	 * @var	array
	 */
	protected $configOptions = array();
	
	/**
	 * list of toolbar items
	 * 
	 * @var	array
	 */
	protected $toolbarItems = array(
		'document' => array('Source', '-', 'Templates'),
		'clipboard' => array('PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
		'editing' => array('Find', 'Replace', '-', 'SelectAll'),
		'/',
		'basicstyles' => array('Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
		'paragraph' => array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
		'links' => array('Link', 'Unlink', 'Anchor'),
		'insert' => array('Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'Iframe'),
		'/',
		'styles' => array('Styles', 'Format', 'Font', 'FontSize'),
		'colors' => array('TextColor', 'BGColor'),
		'tools' => array('Maximize', 'ShowBlocks')
	);
	
	/**
	 * Creates a new CKEditor object.
	 * 
	 * @param	string		$htmlID	 	 
	 */
	public function __construct($htmlID) {
		$this->htmlID = $htmlID;
		
		// set config options
		$this->setConfigOptions(array(
			'baseHref' => "'".$this->encodeJS(RELATIVE_WCF_DIR)."'",
			'language' => "'".Language::fixLanguageCode(WCF::getLanguage()->getLanguageCode())."'",
			'contentsCss' => "'".$this->encodeJS(FileUtil::addTrailingSlash(FileUtil::unifyDirSeperator(dirname(WCF::getSession()->requestURI))).RELATIVE_WCF_DIR.'style/extra/ckeditor.css')."'",
			'customConfig' => "''",
			'toolbar' => "'custom'",
			'toolbar_custom' => $this->getToolbarJS($this->toolbarItems)
		));
	}
	
	/**
	 * Sets the given config options.
	 * 
	 * @param	array		$options
	 */
	public function setConfigOptions($options) {
		foreach ($options as $key => $value) {
			$this->configOptions[$key] = $value;
		}
	}
	
	/**
	 * Returns the toolbar js code of the given toolbar items.
	 * 
	 * @param	array		$toolbarItems
	 * @return	array
	 */
	public function getToolbarJS($toolbarItems) {
		$toolbarJS = '[';
		$i = 1;
		$numberOfToolbarItems = count($toolbarItems);
		foreach ($toolbarItems as $identifier => $toolbarItem) {
			if (is_array($toolbarItem)) {
				$toolbarJS .= "{ name: '".$identifier."', items: ['".implode("','", $toolbarItem)."'] }";
			}
			else {
				$toolbarJS .= "'".$toolbarItem."'";
			}
			if ($i < $numberOfToolbarItems) $toolbarJS .= ',';
			$i++;
		}
		$toolbarJS .= ']';
		return $toolbarJS;		
	}
	
	/**
	 * Returns the configuration html code.
	 * 
	 * @return	string
	 */
	public function getConfigurationHTML() {
		WCF::getTPL()->assign(array(
			'htmlID' => $this->htmlID,
			'configOptions' => $this->configOptions
		));
		return WCF::getTPL()->fetch('ckeditor');
	}
	
	/**
	 * Encodes javascript in the given string.
	 * 
	 * @return	string
	 */
	public function encodeJS($string) {
		// escape backslash
		$string = StringUtil::replace("\\", "\\\\", $string);
		
		// escape singe quote
		$string = StringUtil::replace("'", "\'", $string);
		
		// escape new lines
		$string = StringUtil::replace("\n", '\n', $string);
		
		// escape slashes
		$string = StringUtil::replace("/", '\/', $string);
		
		return $string;
	}
}
?>