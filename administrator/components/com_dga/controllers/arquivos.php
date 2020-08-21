<?php

defined('_JEXEC') or die('Acesso restrito!');
jimport('joomla.application.component.controller');

class DGAControllerArquivos extends JControllerAdmin
{    
    public function __construct($config = array())
    {
            parent::__construct($config);

            $this->registerTask('sticky_unpublish', 'sticky_publish');
    }
    
    public function getModel($name = 'Arquivo', $prefix = 'DGAModel', $config = array('ignore_request' => true))
    {
            $model = parent::getModel($name, $prefix, $config);
            return $model;
    }
    
    public function publish()
    {
        if (!JFactory::getUser()->authorise('core.admin', $this->option))
        {
                JError::raiseError(500, JText::_('JERROR_ALERTNOAUTHOR'));
                jexit();
        }

        return parent::publish();
    }
    public function delete()
    {
        if (!JFactory::getUser()->authorise('core.admin', $this->option))
        {
            JError::raiseError(500, JText::_('JERROR_ALERTNOAUTHOR'));
            jexit();
        }

        // Get the task
        $jinput = JFactory::getApplication()->input;
        
        $id_docs = $jinput->get('cid', "", array());

        foreach($id_docs as $id_doc)
        {
            $this->deleteDocumentUser($id_doc);
        }
        
        return parent::delete();
    }
    
    private function deleteDocumentUser($id_doc)
    {
        //$db = JFactory::getDBO();
        $row = $this->getDocumentsById($id_doc);

        $filename = JPATH_SITE.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'dga'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$row->filename_doc;       
        
        //apagar o arquivo do servidor
        if(file_exists($filename))
        {
            unlink($filename);
        }
        
        //apaga o registo da tabela
        /*$queryDelete = "DELETE FROM #__dga_documentos_doc WHERE id_doc=$id_doc";
        $db->setQuery($queryDelete);
        $db->query();*/
    }
    
    private function getDocumentsById($id_doc)
    {
        $db = JFactory::getDBO();
        
        $query = "SELECT * FROM #__dga_documentos_doc WHERE id_doc=$id_doc";

        $db->setQuery($query);
        $db->query();
        
        return $db->loadObject(); 
    }
}

?>

