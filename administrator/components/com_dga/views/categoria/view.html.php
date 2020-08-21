<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('DGAHelper', JPATH_COMPONENT . '/helpers/dga.php');

class DGAViewCategoria extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form     = $this->get('Form');
		$this->item     = $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
                
		JHtml::_('jquery.framework');
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
            JFactory::getApplication()->input->set('hidemainmenu', true);

            $user		= JFactory::getUser();
            $userId		= $user->get('id');
            $isNew		= ($this->item->id_cat == 0);

            // Since we don't track these assets at the item level, use the category id.
            $canDo = JHelperContent::getActions(0, 0, 'com_dga');

            JToolbarHelper::title($isNew ? 'Cadastra nova Categoria' : 'Editar Categoria', 'bookmark categorias');

            if ($canDo->get('core.edit'))
            {
                JToolbarHelper::apply('categoria.apply');
                JToolbarHelper::save('categoria.save');
            }

            JToolbarHelper::cancel('categoria.cancel');
	}
}

