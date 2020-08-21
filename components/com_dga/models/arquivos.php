<?php
defined('_JEXEC') or die;

class DGAModelArquivos extends JModelList
{
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    protected function populateState($ordering = null, $direction = null)
    {
        $id_cat = $this->getUserStateFromRequest('id_cat', 'id_cat', 0);
                
        $app    = JFactory::getApplication();
        $params = $app->getParams();

        $dga_id_cat = $params->get('dga_id_cat', 0);
        
        if($dga_id_cat != 0)
        {
            $this->setState('id_cat', $dga_id_cat);
        }
        else
        {
            $this->setState('id_cat', $id_cat);
        }
        
        // List state information.
        parent::populateState('a.nome_cli', 'asc');
    }

    protected function getListQuery()
    {
        $user = JFactory::getUser();
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $id_cat = $this->getState("id_cat", 0);
        $queryCatergoria = '';
        
        if($id_cat != 999)
        {
            $queryCatergoria = 'a.id_cat='.$id_cat.' AND';
        }

        $query->select('a.id_doc AS id_doc, ' .
                        'a.title_doc AS title_doc, ' .
                        'a.description_doc AS description_doc, ' .
                        'a.create_date_doc AS create_date_doc, ' .
                        'a.extension_doc AS extension_doc, ' .
                        'a.filename_doc AS filename_doc, ' .
                        'a.filesize_doc AS filesize_doc, ' .
                        'a.create_user_doc AS create_user_doc, ' .
                        'a.published AS published');

        $query->from('#__dga_documentos_doc AS a');
        
        $query->select('cat.nome_cat AS nome_cat')
                        ->join('LEFT', '#__dga_categorias_cat AS cat ON a.id_cat = cat.id_cat');
        
        $query->where('a.published=1');
        $query->where('('.$queryCatergoria.' a.data_inicio_publicacao_doc <= NOW() AND a.data_fim_publicacao_doc > NOW() AND a.id_doc IN (SELECT dcu.id_doc FROM #__dga_documentos_usuarios_dcu AS dcu WHERE dcu.id_user='.$user->id.'))' . 
                      ' OR ('.$queryCatergoria.' a.data_inicio_publicacao_doc <= NOW() AND a.data_fim_publicacao_doc > NOW() AND a.id_doc IN (SELECT dcg.id_doc FROM #__dga_documentos_grupos_dcg AS dcg WHERE dcg.id_grupo IN (SELECT map.group_id FROM #__user_usergroup_map AS map WHERE map.user_id='.$user->id.')))');        

        $query->limit(999);

        return $query;
    }

    public function getTable($type = 'Arquivos', $prefix = 'DGATable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }
}
