<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Banner model.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 * @since       1.6
 */
class DGAModelCategoria extends JModelAdmin
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_DGACATEGORIA';

	/**
	 * The type alias for this content type.
	 *
	 * @var      string
	 * @since    3.2
	 */
	public $typeAlias = 'com_dga.categoria';

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
	 *
	 * @since   1.6
	 */
	protected function canDelete($record)
	{
            $user = JFactory::getUser();
            
            if (!empty($record->id_cat))
            {
                return $user->authorise('core.delete', 'com_dga.categoria.' . (int)$record->id_cat);
            }
            else
            {
                return parent::canDelete($record);
            }
	}

	/**
	 * Method to test whether a record can have its state changed.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
	 *
	 * @since   1.6
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		// Check against the category.
		if (!empty($record->id_cat))
		{
			return $user->authorise('core.edit.state', 'com_dga.categoria.' . (int) $record->id_cat);
		}
		// Default to component settings if category not known.
		else
		{
			return parent::canEditState($record);
		}
	}

	/**
	 * Returns a JTable object, always creating it.
	 *
	 * @param   string  $type    The table type to instantiate. [optional]
	 * @param   string  $prefix  A prefix for the table class name. [optional]
	 * @param   array   $config  Configuration array for model. [optional]
	 *
	 * @return  JTable  A database object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Categoria', $prefix = 'DGATable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form. [optional]
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not. [optional]
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_dga.categoria', 'categoria', array('control' => 'jform', 'load_data' => $loadData));
		
                if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$app  = JFactory::getApplication();
		$data = $app->getUserState('com_dga.edit.categoria.data', array());

		if (empty($data))
		{
                    $data = $this->getItem();

                    // Prime some default values.
                    if ($this->getState('categoria.id_cat') == 0)
                    {
                        $data->set('id_cat', $app->input->getInt('catid', $app->getUserState('com_dga.categoria.filter.id_cat')));
                    }
		}

		$this->preprocessData('com_dga.categoria', $data);

		return $data;
	}

	/**
	 * Method to stick records.
	 *
	 * @param   array    &$pks   The ids of the items to publish.
	 * @param   integer  $value  The value of the published state
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.6
	 */
	public function stick(&$pks, $value = 1)
	{
		$user = JFactory::getUser();
		$table = $this->getTable();
		$pks = (array) $pks;

		// Access checks.
		foreach ($pks as $i => $pk)
		{
			if ($table->load($pk))
			{
				if (!$this->canEditState($table))
				{
					// Prune items that you can't change.
					unset($pks[$i]);
					JError::raiseWarning(403, JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'));
				}
			}
		}

		// Attempt to change the state of the records.
		if (!$table->stick($pks, $value, $user->get('id')))
		{
			$this->setError($table->getError());
			return false;
		}

		return true;
	}

	/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param   JTable  $table  A record object.
	 *
	 * @return  array  An array of conditions to add to add to ordering queries.
	 *
	 * @since   1.6
	 */
	protected function getReorderConditions($table)
	{
		$condition = array();
		$condition[] = 'id_cat = '. (int) $table->id_cat;
		$condition[] = 'state >= 0';
		return $condition;
	}

	/**
	 * @since  3.0
	 */
	protected function prepareTable($table)
	{
		
	}
	
	public function save($data)
	{
		$app = JFactory::getApplication();

		// Alter the name for save as copy
		if ($app->input->get('task') == 'save2copy')
		{
			list($name, $alias) = $this->generateNewTitle($data['id_cat'], $data['alias'], $data['name']);
			$data['name']	= $name;
			$data['alias']	= $alias;
			$data['state']	= 0;
		}

		if (parent::save($data))
		{
                    return true;
		}

		return false;
	}   
}

