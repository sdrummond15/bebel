<?php

defined('_JEXEC') or die;

class DGAModelArquivosUsuarios extends JModelList {

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

        $id_doc = $this->getUserStateFromRequest($this->context . '.filter.id_doc', 'filter_id_doc', '0');
		$this->setState('filter.id_doc', $id_doc);

        // List state information.
        parent::populateState('a.name', 'asc');
    }

    protected function getListQuery() {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $user = JFactory::getUser();
        
        //$user->get('id');
        $id_doc = $this->getState('filter.id_doc');


        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 
                        'a.id AS id, ' .
                        'a.name AS name_user, ' .
                        'a.email AS email,'.
                        '(SELECT udd.create_date_udd FROM #__dga_usuarios_downloads_documentos_udd AS udd WHERE udd.id_user=a.id AND udd.id_doc='.$id_doc.') AS create_date_udd,'.
                        '(SELECT udd.last_date_download_udd FROM #__dga_usuarios_downloads_documentos_udd AS udd WHERE udd.id_user=a.id AND udd.id_doc='.$id_doc.') AS last_date_download_udd,'.
                        '(SELECT udd.downloads_count_udd FROM #__dga_usuarios_downloads_documentos_udd AS udd WHERE udd.id_user=a.id AND udd.id_doc='.$id_doc.') AS downloads_count_udd'));
        
        $query->from('#__users AS a');
        
                
        // Filter by search in subject or banner.
        $search = $this->getState('filter.search');
        
        if (!empty($search)) {
            $search = $db->quote('%' . $db->escape($search, true) . '%', false);
            $query->where('a.name LIKE ' . $search);
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'a.name');
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
    public function getTable($type = 'Documento', $prefix = 'DGATable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

}
