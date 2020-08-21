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
 * Banners master display controller.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 * @since       1.6
 */
class DGAController extends JControllerLegacy
{
        protected $default_view = 'clientes';
	/**
	 * Method to display a view.
	 *
	 * @param   boolean			If true, the view output will be cached
	 * @param   array  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController		This object to support chaining.
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/dga.php';

                //GrupoJovemHelper::updateReset();

		$view   = $this->input->get('view', 'home');
		$layout = $this->input->get('layout', 'default');

                
		// Check for edit form.
		/*if ($view == 'banner' && $layout == 'edit' && !$this->checkEditId('com_banners.edit.banner', $id)) {

			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_banners&view=banners', false));

			return false;
		}
		elseif ($view == 'client' && $layout == 'edit' && !$this->checkEditId('com_banners.edit.client', $id)) {

			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_banners&view=clients', false));

			return false;
		}*/

		parent::display();

		return $this;
	}
                
        private function cadastrar($keyField, $valueField, $tableName)
        {
            $db = JFactory::getDbo();
            $response = array();
            
            $field = JRequest::getVar($valueField, '', 'post', 'string', JREQUEST_ALLOWRAW);

            $query = "INSERT INTO $tableName ($valueField) VALUES ('$field');"; 
            $db->setQuery($query);
            
            if($db->query())
            {
                $options = (array)$this->getOptions($keyField, $valueField, 'SELECT '.$keyField.', '.$valueField.' FROM '.$tableName.' ORDER BY ' . $valueField, $field);
                
                $response['Status']     = "OK";
                $response['Message']    = "Cadastrado com sucesso!";
                $response['Result']     = implode("", $options);
            }
            else
            {
                $response['Status']     = "ERROR";
                $response['Message']    = "Ocorreu um erro ao tentar cadastrar!";
                $response['Result']     = "";
            }
            
            echo json_encode($response);
        }
        
        private function getOptions($keyField, $valueField, $query, $selected = null)
        {
            $options = array();

            // Initialize some field attributes.
            $key   = $keyField;
            $value = $valueField;

            // Get the database object.
            $db = JFactory::getDbo();

            // Set the query and get the result list.
            $db->setQuery($query);
            $items = $db->loadObjectlist();

            // Build the field options.
            if (!empty($items))
            {
                $options[] = '<option value="0" >-- Selecione uma opção --</option>';
                
                foreach ($items as $item)
                {
                    $textSelected = $item->$value ==  $selected ? 'selected="selected"' : '';

                    $options[] = '<option value="'.$item->$key.'" '.$textSelected.' >'.$item->$value.'</option>';
                }
            }
            else
            {
                $options[] = '<option value="0" >-- Selecione uma opção --</option>';
            }

            return $options;
        }
        
        public function mediunidade_cadastrar()
        {
            $this->cadastrar('id_med', 'descricao_med', '#__dga_mediunidade_med');
        }
        
        public function falangemissionaria_cadastrar()
        {
            $this->cadastrar('id_flm', 'descricao_flm', '#__dga_falange_missiornaria_flm');
        }
        
        public function profissao_cadastrar()
        {
            $this->cadastrar('id_pro', 'descricao_pro', '#__dga_profissao_pro');
        }
        
        public function nacionalidade_cadastrar()
        {
            $this->cadastrar('id_nac', 'descricao_nac', '#__dga_nacionalidades_nac');
        }
        
        public function estadocivil_cadastrar()
        {
            $this->cadastrar('id_etc', 'descricao_etc', '#__dga_estado_civil_etc');
        }
        
        public function orgaoexpeditor_cadastrar()
        {
            $this->cadastrar('id_oex', 'descricao_oex', '#__dga_orgaoexpeditor_oex');
        }
        
        public function cidade_cadastrar()
        {
            try
            {
                JTable::addIncludePath(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'tables');
                
                $response = array();

                $nome_cid   = JRequest::getVar('nome_cid', '', 'post', 'string', JREQUEST_ALLOWRAW);
                $nome_bai   = JRequest::getVar('nome_bai', '', 'post', 'string', JREQUEST_ALLOWRAW);
                $id_est     = JRequest::getVar('id_est', '', 'post', 'int', JREQUEST_ALLOWRAW);

                $table_cidade = JTable::getInstance('Cidade', 'DGATable');
                
                $table_cidade->nome_cid = $nome_cid;
                $table_cidade->id_est   = $id_est;
                $table_cidade->id_cid   = (int)$table_cidade->id_cid;
                
                if($table_cidade->store())
                {
                    $table_bairro = JTable::getInstance('Bairro', 'DGATable');
                    
                    $table_bairro->nome_bai = $nome_bai; 
                    $table_bairro->id_cid   = $table_cidade->id_cid;
                    $table_bairro->id_bai   = (int)$table_bairro->id_bai;

                    if($table_bairro->store())
                    {
                        $options1 = (array)$this->getOptions('id_cid', 'nome_cid', 'SELECT id_cid, nome_cid FROM #__dga_cidades_cid WHERE id_est='.$id_est.' ORDER BY nome_cid', $nome_cid);
                        $options2 = (array)$this->getOptions('id_bai','nome_bai', 'SELECT id_bai, nome_bai FROM #__dga_bairros_bai WHERE id_cid='.$table_cidade->id_cid.' ORDER BY nome_bai', $nome_bai);

                        $result1 = implode("", $options1); 
                        $result2 = implode("", $options2);
                        
                        //$result1 = str_replace('\"', '\\"', $result1);
                        //$result2 = str_replace('\"', '\\"', $result2);
                        
                        $response['Status']     = "OK";
                        $response['Message']    = "Cadastrado com sucesso!";
                        $response['Result1']    = $result1;
                        $response['Result2']    = $result2;
                    }
                    else
                    {
                        $response['Status']     = "ERROR";
                        $response['Message']    = "Ocorreu um erro ao tentar cadastrar!";
                        $response['Result']     = "";
                    }
                }
                else
                {
                    $response['Status']     = "ERROR";
                    $response['Message']    = "Ocorreu um erro ao tentar cadastrar!";
                    $response['Result']     = "";
                }
            } 
            catch (Exception $e) 
            {
                $response['Status']     = "ERROR";
                $response['Message']    = "Ocorreu um erro ao tentar cadastrar!" . $e->getMessage();
                $response['Result']     = "";
            }
            
            $return = json_encode($response);
            
            //$return = str_replace('\\"', '\\\"', $return);
            
            echo trim($return);
        }
        
        public function bairro_cadastrar()
        {
            try
            {
                $db = JFactory::getDbo();
                $response = array();

                $keyField = 'id_bai';
                $valueField = 'nome_bai';
                $tableName = '#__dga_bairros_bai';

                $nome_bai   = JRequest::getVar('nome_bai', '', 'post', 'string', JREQUEST_ALLOWRAW);
                $id_cid     = JRequest::getVar('id_cid', '', 'post', 'int', JREQUEST_ALLOWRAW);

                $query = "INSERT INTO $tableName (nome_bai, id_cid) VALUES ('$nome_bai', $id_cid);"; 
                $db->setQuery($query);

                if($db->query())
                {
                    $options = (array)$this->getOptions($keyField, $valueField, 'SELECT '.$keyField.', '.$valueField.' FROM '.$tableName.' WHERE id_cid='.$id_cid.' ORDER BY ' . $valueField, $nome_bai);

                    $response['Status']     = "OK";
                    $response['Message']    = "Cadastrado com sucesso!";
                    $response['Result']     = implode("", $options);
                }
                else
                {
                    $response['Status']     = "ERROR";
                    $response['Message']    = "Ocorreu um erro ao tentar cadastrar!";
                    $response['Result']     = "";
                }
            } 
            catch (Exception $e) 
            {
                $response['Status']     = "ERROR";
                $response['Message']    = "Ocorreu um erro ao tentar cadastrar!" . $e->getMessage();
                $response['Result']     = "";
            }
            
            echo json_encode($response);
        }
        
        public function getCities()
        {
            try
            {
                $response = array();

                $keyField = 'id_cid';
                $valueField = 'nome_cid';
                $tableName = '#__dga_cidades_cid';

                $id_est     = JRequest::getVar('id_est', '', 'post', 'int', JREQUEST_ALLOWRAW);

                $options = (array)$this->getOptions($keyField, $valueField, 'SELECT '.$keyField.', '.$valueField.' FROM '.$tableName.' WHERE id_est='.$id_est.' ORDER BY ' . $valueField, $field);

                $response['Status']     = "OK";
                $response['Message']    = "Carregado com sucesso!";
                $response['Result']     = implode("", $options);

            } 
            catch (Exception $e) 
            {
                $response['Status']     = "ERROR";
                $response['Message']    = "Ocorreu um erro ao tentar cadastrar!" . $e->getMessage();
                $response['Result']     = "";
            }
            
            echo json_encode($response);
        }
        
        public function getBairros()
        {
            try
            {
                $response = array();

                $keyField = 'id_bai';
                $valueField = 'nome_bai';
                $tableName = '#__dga_bairros_bai';

                $id_cid     = JRequest::getVar('id_cid', '', 'post', 'int', JREQUEST_ALLOWRAW);

                $options = (array)$this->getOptions($keyField, $valueField, 'SELECT '.$keyField.', '.$valueField.' FROM '.$tableName.' WHERE id_cid='.$id_cid.' ORDER BY ' . $valueField, $field);

                $response['Status']     = "OK";
                $response['Message']    = "Carregado com sucesso!";
                $response['Result']     = implode("", $options);
           } 
            catch (Exception $e) 
            {
                $response['Status']     = "ERROR";
                $response['Message']    = "Ocorreu um erro ao tentar cadastrar!" . $e->getMessage();
                $response['Result']     = "";
            }
            
            echo json_encode($response);
        }
}
