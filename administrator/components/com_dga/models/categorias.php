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
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
                                'id_cat', 'a.id_cat',
'nome_cat', 'a.nome_cat');
		}

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
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id_cat AS id_cat, ' .
                'a.nome_cat AS nome_cat,'.
                'a.descricao_cat AS descricao_cat')
		);
		$query->from('#__dga_categorias_cat AS a');

		
		// Filter by published state.
		$state = $this->getState('filter.state');
		
		

		// Filter by search in subject or banner.
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			$search = $db->quote('%' . $db->escape($search, true) . '%', false);
			$query->where('a.nome_cat LIKE ' . $search);
		}

        // Add the list ordering clause.
		$orderCol   = $this->state->get('list.ordering', 'nome_cat');
		$orderDirn  = $this->state->get('list.direction', 'ASC');
        
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
	public function getTable($type = 'Categoria', $prefix = 'DGATable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
}

