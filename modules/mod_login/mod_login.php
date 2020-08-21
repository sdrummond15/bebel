<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the login functions only once
require_once __DIR__ . '/helper.php';

$document = JFactory::getDocument();
$document->addScript(JURI::base().'modules'.DIRECTORY_SEPARATOR.$module->module.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'buttonlogin.js');
$document->addStyleSheet(JURI::base().'modules'.DIRECTORY_SEPARATOR.$module->module.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'loginstyle.css');

$params->def('greeting', 1);

$type	          = ModLoginHelper::getType();
$return	          = ModLoginHelper::getReturnUrl($params, $type);
$twofactormethods = ModLoginHelper::getTwoFactorMethods();
$user	          = JFactory::getUser();
$layout           = $params->get('layout', 'default');

// Logged users must load the logout sublayout
if (!$user->guest)
{
	$layout .= '_logout';
}

require JModuleHelper::getLayoutPath('mod_login', $layout);
