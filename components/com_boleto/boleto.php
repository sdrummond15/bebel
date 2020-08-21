<?php

defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('Boleto');
$controller->execute(JRequest::getVar('task', 'click'));
$controller->redirect();
