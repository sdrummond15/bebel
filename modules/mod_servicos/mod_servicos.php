<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_servicos
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base(true) . '/modules/mod_servicos/assets/css/styleservicos.css');

$categoria = $params->get('catid');
$titulo = $params->get('titulo');

$servicos = modServicosHelper::getServicos($categoria);

require JModuleHelper::getLayoutPath('mod_servicos', $params->get('layout', 'default'));

