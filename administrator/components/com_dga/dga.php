<?php
    defined('_JEXEC') or die('Acesso restrito!');
    JHtml::_('behavior.tabstate');
    
    // Access check.
    if (!JFactory::getUser()->authorise('core.manage', 'com_dga')) 
    {
        return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
    }
    
    require(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'Utils.php');
    require(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'JHtmlPlus.php');
    require(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'dga.php');
    
    // Execute the task.
    $controller	= JControllerLegacy::getInstance('DGA');
    $controller->execute(JFactory::getApplication()->input->get('task'));
    $controller->redirect();
?>
