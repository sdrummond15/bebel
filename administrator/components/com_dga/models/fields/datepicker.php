<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 *
 * Provides a pop up date picker linked to a button.
 * Optionally may be filtered to use user's or server's time zone.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldDatepicker extends JFormField
{
	protected $type = 'Datepicker';
		
		protected $dateFormat;
		protected $mask;
		protected $minDate;

		public function __get($name)
	{
		switch ($name)
		{
			case 'dateFormat':
			case 'mask':
						case 'minDate':
							return $this->$name;
		}

		return parent::__get($name);
	}
		
		public function __set($name, $value)
	{
		switch ($name)
		{
			case 'dateFormat':
			case 'mask':
						case 'minDate':
							$this->$name = (string)$value;
							break;
			default:
							parent::__set($name, $value);
		}
	}
		
		public function setup(SimpleXMLElement $element, $value, $group = null)
	{
			$return = parent::setup($element, $value, $group);

			if ($return)
			{
				$this->dateFormat   = (string)$this->element['dateFormat'] ? (string)$this->element['dateFormat'] : 'dd/mm/yy';
				$this->mask         = (string)$this->element['mask'] ? (string)$this->element['mask'] : '99/99/9999';
				$this->minDate      = (string)$this->element['minDate'] ? (string)$this->element['minDate'] : 'null';
			}

			return $return;
	}
		
	public function getInput()
	{                
				$document = JFactory::getDocument();
				$document->addScriptDeclaration(
					'window.addEvent(\'domready\', function() {'. 
										'jQuery("#'.$this->id.'").datepicker('.
										'{'.
										  'minDate: '.$this->minDate.','.
										  'firstDay: 1,'.
										  'showOn: "button",'.
										  'dateFormat: "'.$this->dateFormat.'",'.
										  'onSelect: function(dateText, inst)'. 
										  '{'.
											'jQuery("#'.$this->id.'").val(dateText);'.
										  '},'.
										  'showOptions: { direction: "up" }'.
										'});'.

										'jQuery("#'.$this->id.'").mask("'.$this->mask.'");'.
										'});'
				);
				
				$PATH_ADMIN_CSS = 'administrator/components/com_dga/assets/css/';
				$PATH_ADMIN_JS = 'administrator/components/com_dga/assets/js/';
				
				JHTML::stylesheet($PATH_ADMIN_CSS . 'smoothness/jquery-ui-1.9.2.custom.min.css');

				/* -------- JS -------- */
				JHTML::script($PATH_ADMIN_JS . 'jquery-ui-1.9.2.min.js');
				JHTML::script($PATH_ADMIN_JS . 'jquery.ui.datepicker-pt-BR.js');
				JHTML::script($PATH_ADMIN_JS . 'jquery.maskedinput-1.3.1.min.js');

				$value = '';
				
                if($value != '01/01/1970' 
                && $value != '31/12/1969')
                {
                    if(strpos($this->value, '-'))
                    {
                        $value = date('d/m/Y', strtotime($this->value)); 
                    }
                    else
                    {
                        $value = $this->value; 
                    }
                }

				
		return '<div class="input-append"><input style="position: relative; z-index: 2;" type="text" title="" name="'.$this->name.'" id="'.$this->id.'" value="'.$value.'" maxlength="45" class="input-medium hasTooltip" data-original-title="" ></div>';
	}
    
    public function CheckValidDate($sDate) 
    {
        $sDate = str_replace(' ', '-', $sDate);
        $sDate = str_replace('/', '-', $sDate);
        $sDate = str_replace('--', '-', $sDate);
        
        preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $sDate, $xadBits);
        
        return checkdate($xadBits[2], $xadBits[3], $xadBits[1]);
    }
}
