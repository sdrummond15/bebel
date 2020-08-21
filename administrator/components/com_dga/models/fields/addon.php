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
class JFormFieldAddon extends JFormField
{
	protected $type = 'Addon';
        
        protected $text_left;
        protected $text_right;
        protected $image_left;
        protected $image_right;
        protected $style;
        

        public function __get($name)
	{
		switch ($name)
		{
			case 'text_left':
			case 'text_right':
                        case 'image_left':
                        case 'image_right':
                        case 'style':
                            return $this->$name;
		}

		return parent::__get($name);
	}
        
        public function __set($name, $value)
	{
		switch ($name)
		{
			case 'text_left':
			case 'text_right':
                        case 'image_left':
                        case 'image_right':
                        case 'style':
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
                $this->text_left   = (string)$this->element['text_left'] ? (string)$this->element['text_left'] : '';
                $this->text_right  = (string)$this->element['text_right'] ? (string)$this->element['text_right'] : '';
                $this->image_left  = (string)$this->element['image_left'] ? (string)$this->element['image_left'] : '';
                $this->image_right  = (string)$this->element['image_right'] ? (string)$this->element['image_right'] : '';
                $this->style  = (string)$this->element['style'] ? (string)$this->element['style'] : '';
            }

            return $return;
	}
        
	public function getInput()
	{                
                $PATH_ADMIN_CSS = 'administrator/components/com_joomob/assets/css/';
                
                JHTML::stylesheet($PATH_ADMIN_CSS . 'bootstrap-panel.css');

                $html = '<div class="input-group" style="display: inline-table;width:1px;">';
                
                if(!empty($this->text_left))
                {
                    $html .= '<span class="input-group-addon">'.$this->text_left.'</span>'; 
                }

                $style = empty($this->style) ? '' : 'style="'.$this->style.'"'; 
                
                $html .= '<input type="text" '.$style.' name="'.$this->name.'" id="'.$this->id.'" class="form-control hasTooltip '.$this->class.'" value="'.$this->value.'">'; 
                
                if(!empty($this->text_right))
                {
                    $html .= '<span class="input-group-addon">'.$this->text_right.'</span>'; 
                }
                
                $html .= '</div>'; 
                
		return '<div class="input-append">'.$html.'</div>';
	}
}
