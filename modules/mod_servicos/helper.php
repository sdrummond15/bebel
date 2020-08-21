<?php
/**
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Site
 * @subpackage	mod_qualification
 * @since		1.5
 */
class modServicosHelper
{
    public function getServicos($categoria){
        
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__content As c');
        $query->where('c.state = 1 AND c.catid = '.$categoria);
        
        $db->setQuery($query);
	$rows = (array) $db->loadObjectList();
        shuffle($rows);
        
        return $rows;
    }
    
}