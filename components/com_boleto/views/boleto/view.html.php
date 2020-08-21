<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
JPluginHelper::importPlugin('content.joomplu');

class BoletoViewBoleto extends JViewLegacy {

    function display($tpl = null) {
        
        $doc = JFactory::getDocument();
        $doc->addStyleSheet('components/com_boleto/css/styleboleto.css');
        parent::display($tpl);
    }
}
