<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

//import joomlas filesystem functions, we will do all the filewriting with joomlas functions,
//so if the ftp layer is on, joomla will write with that, not the apache user, which might
//not have the correct permissions
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Banner model.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 * @since       1.6
 */
class DGAModelArquivo extends JModelAdmin
{

	/**
	 * @var    string  The prefix to use with controller messages.
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_JOOMOB_DOCUMENT';

	/**
	 * The type alias for this content type.
	 *
	 * @var      string
	 * @since    3.2
	 */
	public $typeAlias = 'com_dga.arquivo';

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

		if (!empty($record->id_doc))
		{
			return $user->authorise('core.delete', 'com_dga.arquivo.' . (int) $record->id_doc);
		} else
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
		if (!empty($record->id_doc))
		{
			return $user->authorise('core.edit.state', 'com_dga.arquivo.' . (int) $record->id_doc);
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
	public function getTable($type = 'Arquivo', $prefix = 'DGATable', $config = array())
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
		$form = $this->loadForm('com_dga.arquivo', 'arquivo', array('control' => 'jform', 'load_data' => $loadData));

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
		$app = JFactory::getApplication();
		$data = $app->getUserState('com_dga.edit.arquivo.data', array());

		if (empty($data))
		{
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('arquivo.id_doc') == 0)
			{
				$data->set('id_doc', $app->input->getInt('catid', $app->getUserState('com_dga.arquivo.filter.id_doc')));
			}
		}
		else
		{
			
			$data["uploadFile"] = '';//
		}
		
		$this->preprocessData('com_dga.arquivo', $data);

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
		$condition[] = 'id_doc = ' . (int) $table->id_doc;
		$condition[] = 'state >= 0';
		return $condition;
	}

	/**
	 * @since  3.0
	 */
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();
		
		if (empty($table->id_doc)) 
		{
			$table->create_user_doc = $user->id;
			$table->create_date_doc = $date->toSql(); 
		}
		else
		{
			$table->update_user_doc = $user->id;
			$table->update_date_doc = $date->toSql(); 
		}

		$this->convertDateRow($table);
	}
	
	private function convertDateRow(&$table)
	{

		$table->data_inicio_publicacao_doc = date(implode("-", array_reverse(explode("/", $table->data_inicio_publicacao_doc))));
		$table->data_fim_publicacao_doc = date(implode("-", array_reverse(explode("/", $table->data_fim_publicacao_doc))));
	}

	public function getGrupos()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$id_doc = JRequest::getVar('id_doc', 0);

		$query->select(
				'a.id AS id, ' .
				'a.title AS title, ' .
				'(SELECT dcg.id_grupo FROM #__dga_documentos_grupos_dcg AS dcg WHERE dcg.id_grupo=a.id AND dcg.id_doc='.$id_doc.') AS id_grupo');

		$query->from('#__usergroups AS a');

		// Add the level in the tree.
		$query->select('COUNT(DISTINCT c2.id) AS level')
			->join('LEFT OUTER', $db->quoteName('#__usergroups') . ' AS c2 ON a.lft > c2.lft AND a.rgt < c2.rgt')
			->group('a.id, a.lft, a.rgt, a.parent_id, a.title');
		
		$query->order('a.lft ASC');
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		return $rows;
	}

	public function getUsuarios()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$id_doc = JRequest::getVar('id_doc', 0);

		$query->select(
				'a.id AS id, ' .
				'a.name AS name, ' .
				'(SELECT dcu.id_user FROM #__dga_documentos_usuarios_dcu AS dcu WHERE dcu.id_user=a.id AND dcu.id_doc='.$id_doc.') AS id_user');

		$query->from('#__users AS a');

		$query->order('a.name ASC');
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		return $rows;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param   array  The form data.
	 *
	 * @return  boolean  True on success.
	 * @since   1.6
	 */
	public function save($data)
	{
		$app = JFactory::getApplication();
		$user = JFactory::getUser();

		// Alter the name for save as copy
		/* if ($app->input->get('task') == 'save2copy') {
		  list($name, $alias) = $this->generateNewTitle($data['id_doc'], $data['alias'], $data['name']);
		  $data['name'] = $name;
		  $data['alias'] = $alias;
		  $data['state'] = 0;
		  } */

		$fieldName = 'jform_filename_doc';

		$fileError = $_FILES[$fieldName]['error'];

		/* if ($fileError > 0) 
		  {
		  switch ($fileError)
		  {
		  case 1:
		  echo JText::_('FILE TO LARGE THAN PHP INI ALLOWS');
		  return;

		  case 2:
		  echo JText::_('FILE TO LARGE THAN HTML FORM ALLOWS');
		  return;

		  case 3:
		  echo JText::_('ERROR PARTIAL UPLOAD');
		  return;

		  case 4:
		  echo JText::_('ERROR NO FILE');
		  return;
		  }
		  } */

		if ($fileError <= 0)
		{
			$fileName = $_FILES[$fieldName]["name"]; //file name
			$extensao = array_reverse(explode(".", $fileName));
			$newFileName = md5(uniqid(rand(), true)) . '.' . $extensao[0];
			$tmp_name = $_FILES[$fieldName]["tmp_name"];
			$pathFolder = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'dga' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR;
			$newPath = $pathFolder . $newFileName;

			$data['extension_doc'] = $extensao[0];
			$data['filename_doc'] = $newFileName;

			if (!file_exists($pathFolder))
			{
				mkdir($pathFolder, 0777, true);
			}

			if (move_uploaded_file($tmp_name, $newPath))
			{
				//$msg .= "     Arquivo " . $fileName . " copiado com sucesso!Path: $path<br/>";
			}

			$table = $this->getTable();

			//$pk = (int) $this->getState($this->getName() . '.id');
			$pk = (int) $data['id_doc'];

			if ($pk > 0)
			{
				$table->load($pk);

				$filename = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'dga' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $table->filename_doc;

				//apaga o arquivo do servidor
				unlink($filename);
			}
		}

		if (parent::save($data))
		{
			$this->saveUsuarios();
			$this->saveGrupos();
			return true;
		}

		return false;
	}

	private function saveUsuarios()
	{
		$db = $this->getDbo();
		$id_doc = $this->getState($this->getName() . '.id');
		$usuarios = JRequest::getVar('jform_usuarios', '', 'post', 'int', JREQUEST_ALLOWRAW);

		//apaga os registros antigos
		$query = "DELETE FROM #__dga_documentos_usuarios_dcu WHERE id_doc=" . $id_doc;
		$db->setQuery($query);
		$db->query();

		if (count($usuarios) > 0)
		{
			$query = "INSERT INTO #__dga_documentos_usuarios_dcu (`id_doc`,`id_user`) VALUES ";

			$virgula = false;

			foreach ($usuarios as $id_user)
			{
				if ($virgula)
				{
					$query .= ',';
				}

				$query .= "($id_doc, $id_user)";

				$virgula = true;
			}

			$query .= ";";

			if($virgula)
			{
				$db->setQuery($query);
				$db->query();
			}
			//
			// Fim
			//
		}
	}

	private function saveGrupos()
	{
		$db = $this->getDbo();
		$id_doc = $this->getState($this->getName() . '.id');
		$grupos = JRequest::getVar('jform_grupos', '', 'post', 'int', JREQUEST_ALLOWRAW);

		//apaga os registros antigos
		$query = "DELETE FROM #__dga_documentos_grupos_dcg WHERE id_doc=" . $id_doc;
		$db->setQuery($query);
		$db->query();

		if (count($grupos) > 0)
		{
			$query = "INSERT INTO #__dga_documentos_grupos_dcg (`id_doc`,`id_grupo`) VALUES ";

			$virgula = false;

			foreach ($grupos as $id_grupo)
			{
				if ($virgula)
				{
					$query .= ',';
				}

				$query .= "($id_doc, $id_grupo)";

				$virgula = true;
			}

			$query .= ";";

			if($virgula)
			{
				$db->setQuery($query);
				$db->query();
			}
			//
			// Fim
			//
			}
	}

}
