<?php
/**
* @version		$Id: helper.php 24/06/2011 
* @package		Joomla
* @copyright            Copyright (C) 2011 Luciano da Silva Dória. All rights reserved.
* @license		Comercial
*/
defined('_JEXEC') or die('Acesso restrito!'); 

class comGrupoJovemHelper
{
    public function GetPhotosProperties($id_iml)
    {      
        $db =& JFactory::getDBO();
        $query = 'SELECT * FROM #__grupojovem_properties_images_img WHERE id_iml=' . $id_iml;
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
    public function GetStates() 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id_etd, nome_etd, sigla_etd FROM #__grupojovem_states_etd WHERE published=1 ORDER BY nome_etd";
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
    public function GetTypeBusiness($published=true) 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id_tpo, descricao_tpo, agio_tpo FROM #__grupojovem_type_business_tpo ORDER BY order_tpo";
        
        if($published)
        {
            $query .= " WHERE published=1";
        }
        
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
    public function TypeBusinessExist($descricao_tpo) 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id_tpo FROM #__grupojovem_type_business_tpo WHERE descricao_tpo LIKE '" . $descricao_tpo . "'";
        $db->setQuery($query);
        
        return ($db->loadObjectList() == null ? false : true);
    }
    public function GetTypeBusinessByProperty($id_iml) 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id_tpo, valor_iml_tpo, mostrarvalor_iml_tpo, agio_iml_tpo FROM #__grupojovem_properties_type_business_iml_tpo WHERE id_iml=" . $id_iml;
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
    public function GetCitiesByEstates($id_etd) 
    {       
        $db =& JFactory::getDBO();
        $query = "SELECT id_cid, nome_cid FROM #__grupojovem_cities_cid ".
        " WHERE published=1 AND id_etd=" . $id_etd . " ORDER BY nome_cid";
        
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
    public function CityExist($nome_cid, $id_etd) 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id_cid FROM #__grupojovem_cities_cid ".
        " WHERE id_etd=" . $id_etd . " AND nome_cid LIKE '" . $nome_cid . "'";
        
        $db->setQuery($query);
        
        return ($db->loadObjectList() == null ? false : true);
    }
    public function GetDistricts($id_cid) 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id_brs, nome_brs FROM #__grupojovem_districts_brs ".
        " WHERE published=1 AND id_cid=" . $id_cid . " ORDER BY nome_brs";
        
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
    public function DistrictsExist($nome_brs, $id_cid) 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id_brs FROM #__grupojovem_districts_brs ".
        " WHERE id_cid=" . $id_cid . " AND nome_brs LIKE '" . $nome_brs . "'";
        
        $db->setQuery($query);
        
        return ($db->loadObjectList() == null ? false : true);
    }
    public function GetAdditionalProperties() 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id_par, descricao_par FROM #__grupojovem_additional_properties_par ORDER BY descricao_par";
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
    public function AdditionalPropertyExist($descricao_par) 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id_par FROM #__grupojovem_additional_properties_par WHERE descricao_par LIKE '" . $descricao_par . "'";
        $db->setQuery($query);
        
        return ($db->loadObjectList() == null ? false : true);
    }
    public function GetTypeProperties() 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__grupojovem_type_property_tpi ORDER BY descricao_tpi";
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
    public function TypePropertyExist($descricao_tpi) 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id_tpi FROM #__grupojovem_type_property_tpi WHERE descricao_tpi LIKE '" . $descricao_tpi . "'";
        $db->setQuery($query);
        
        return ($db->loadObjectList() == null ? false : true);
    }
    public function GetTypeProperty($id_tpi) 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__grupojovem_type_property_tpi WHERE id_tpi=" . $id_tpi;
        $db->setQuery($query);
        
        return $db->loadObject();
    }
    public function GetAdditionalPropertiesByProperty($id_iml) 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT id_par FROM #__grupojovem_properties_additional_properties_iml_par WHERE id_iml=" . $id_iml;
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
    public function GetProprietary() 
    {
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__grupojovem_proprietary_pro ORDER BY nome_pro";
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
    public function GetDocumentsProperties($id_iml)
    {      
        $db =& JFactory::getDBO();
        $query = 'SELECT doc.*, fls.filename_fls, fls.filesize_fls, usu.name AS name_usu, usu.username AS login_usu ' . 
                 ' FROM #__grupojovem_properties_documents_iml_doc AS iml_doc ' . 
                 ' LEFT JOIN #__grupojovem_documents_doc AS doc' .
                 ' ON iml_doc.id_doc = doc.id_doc' .
                 ' LEFT JOIN #__grupojovem_files_fls AS fls' .
                 ' ON doc.id_fls = fls.id_fls' .
                 ' LEFT JOIN #__users AS usu' .
                 ' ON doc.id_user = usu.id' . 
                 ' WHERE iml_doc.id_iml=' . $id_iml;
        $db->setQuery($query);
        
        return $db->loadObjectList();
    }
    
    public function GetSefUrl($id_tpi, $id_brs, $localizacao_iml) 
    {
        $db =& JFactory::getDBO();

        $query = 'SELECT descricao_tpi FROM #__grupojovem_type_property_tpi WHERE id_tpi='.$id_tpi;
        $db->setQuery($query);
        $row_tpi = $db->loadObject();
        
        $query = 'SELECT brs.nome_brs, cid.nome_cid, etd.nome_etd, etd.sigla_etd' .
                        ' FROM #__grupojovem_districts_brs AS brs' .
                        ' LEFT JOIN #__grupojovem_cities_cid AS cid' .
                        ' ON cid.id_cid=brs.id_cid' .
                        ' LEFT JOIN #__grupojovem_states_etd AS etd' .
                        ' ON etd.id_etd=cid.id_etd' .
                        ' WHERE brs.id_brs=' . $id_brs;
        $db->setQuery($query);
        $row_brs = $db->loadObject();
        
        return $row_tpi->descricao_tpi.'-'.$row_brs->nome_cid.'-'.$row_brs->sigla_etd.'-'.$row_brs->nome_brs.'-'.$localizacao_iml;
    }
    
    public static function getActions()
    {
        if (empty(self::$actions))
        {
                $user = JFactory::getUser();
                $result = new JObject;

                $actions = JAccess::getActions('com_grupojovem');

                foreach ($actions as $action)
                {
                    $result->set($action->name, $user->authorise($action->name, 'com_grupojovem'));
                }
        }

        return $result;
    }
}

?>
