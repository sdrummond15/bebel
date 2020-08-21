<?php

defined('_JEXEC') or die;

class DGAModelArquivos extends JModelList {

    /**
     * Constructor.
     *
     * @param   array  An optional associative array of configuration settings.
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id_doc', 'a.id_doc',
                'title_doc', 'a.title_doc',
                'description_doc', 'a.description_doc',
                'create_date_doc', 'a.create_date_doc',
                'extension_doc', 'a.extension_doc',
                'filename_doc', 'a.filename_doc',
                'filesize_doc', 'a.filesize_doc',
                'create_user_doc', 'a.create_user_doc',
                'downloads_count_doc','a.downloads_count_doc',
                'published', 'a.published');
        }

        parent::__construct($config);
    }

    protected function populateState($ordering = null, $direction = null) {
        // Load the filter state.
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $state = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string');
        $this->setState('filter.state', $state);

        // List state information.
        parent::populateState('a.create_date_doc', 'desc');
    }

    protected function getListQuery() {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $user = JFactory::getUser();
        
        //$user->get('id');

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 
                        'a.id_cat AS id_cat, ' .
                        'a.id_doc AS id_doc, ' .
                        'a.title_doc AS title_doc, ' .
                        'cat.nome_cat AS nome_cat, ' .
                        'a.description_doc AS description_doc, ' .
                        'a.create_date_doc AS create_date_doc, ' .
                        'a.update_date_doc AS update_date_doc, ' .
                        'a.update_user_doc AS update_user_doc, ' .
                        'a.extension_doc AS extension_doc, ' .
                        'a.filename_doc AS filename_doc, ' .
                        'a.filesize_doc AS filesize_doc, ' .
                        'a.create_user_doc AS create_user_doc, ' .
                        'a.downloads_count_doc AS downloads_count_doc, ' .
                        'a.data_inicio_publicacao_doc AS data_inicio_publicacao_doc, ' .
                        'a.data_fim_publicacao_doc AS data_fim_publicacao_doc, ' .
                        'a.published AS published')
        );
        
        $query->from('#__dga_documentos_doc AS a');

        $query->select('usu.name AS create_name_usu')
                ->join('LEFT', '#__users AS usu ON a.create_user_doc = usu.id');
        
        $query->select('usu2.name AS update_name_usu')
                ->join('LEFT', '#__users AS usu2 ON a.update_user_doc = usu2.id');
        
        $query->select('cat.nome_cat AS nome_cat')
                ->join('LEFT', '#__dga_categorias_cat AS cat ON a.id_cat = cat.id_cat');

        // Filter by published state.
        $state = $this->getState('filter.state');

        if (is_numeric($state)) 
        {
            $query->where('a.published = ' . (int) $state);
            
        } elseif ($state === '') 
        {
            $query->where('(a.published IN (0, 1))');
        }

        // Filter by search in subject or banner.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            $search = $db->quote('%' . $db->escape($search, true) . '%', false);
            $query->where('a.title_doc LIKE ' . $search);
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'a.create_date_doc');
        $orderDirn = $this->state->get('list.direction', 'ASC');

        $query->order($db->escape($orderCol . ' ' . $orderDirn));

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
    public function getTable($type = 'Arquivo', $prefix = 'DGATable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

}
