<?php
    defined('_JEXEC') or die('Acesso restrito!');
    
    JHtml::_('behavior.tabstate');
     
    $pathAdmin = JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_dga'.DIRECTORY_SEPARATOR;
    
    require($pathAdmin.'Utils.php');
    require($pathAdmin.'JHtmlPlus.php');
    
    // Execute the task.
    $controller	= JControllerLegacy::getInstance('DGA');
    $controller->execute(JFactory::getApplication()->input->get('task'));
    $controller->redirect();
?>
