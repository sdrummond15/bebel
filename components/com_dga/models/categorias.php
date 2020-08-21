<?php
defined('_JEXEC') or die;

class DGAModelCategorias extends JModelList
{

    /**
     * Constructor.
     *
     * @param   array  An optional associative array of configuration settings.
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    protected function populateState($ordering = null, $direction = null)
    {
        // Load the filter state.
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $state = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string');
        $this->setState('filter.state', $state);
        
        // List state information.
        parent::populateState('a.nome_cat', 'asc');
    }

    protected function getListQuery()
    {
        $user = JFactory::getUser();
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id_cat AS id_cat, count(*) AS total');
        $query->from('#__dga_documentos_doc AS a');
        $query->select('cat.nome_cat AS nome_cat, cat.descricao_cat AS descricao_cat')
                ->join('LEFT', '#__dga_categorias_cat AS cat ON a.id_cat = cat.id_cat');

        $query->where('(a.data_inicio_publicacao_doc <= NOW() AND a.data_fim_publicacao_doc > NOW() AND a.id_doc IN (SELECT dcu.id_doc FROM #__dga_documentos_usuarios_dcu AS dcu WHERE dcu.id_user='.$user->id.'))' . 
                      ' OR (a.data_inicio_publicacao_doc <= NOW() AND a.data_fim_publicacao_doc > NOW() AND a.id_doc IN (SELECT dcg.id_doc FROM #__dga_documentos_grupos_dcg AS dcg WHERE dcg.id_grupo IN (SELECT map.group_id FROM #__user_usergroup_map AS map WHERE map.user_id='.$user->id.')))'); 

        $query->group('a.id_cat, cat.nome_cat, cat.descricao_cat');
        $query->order('cat.nome_cat ASC');

        $db->setQuery($query);
        
        return $query;
    }

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param   type      The table type to instantiate
     * @param   string    A prefix for the table class name. Optional.
     * @param   array     Configuration array for model. Optional.
     * @return  JTable    A database object
     * @since   1.6
     */
    public function getTable($type = 'Categorias', $prefix = 'DGATable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }    

}
