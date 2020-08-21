<?php
defined('_JEXEC') or die;

class DGAViewArquivosUsuarios extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	public function display($tpl = null)
	{
            $this->items        = $this->get('Items');
            $this->pagination	= $this->get('Pagination');
            $this->state        = $this->get('State');
            $this->filterForm    = $this->get('FilterForm');
	        $this->activeFilters = $this->get('ActiveFilters');

            // Check for errors.
            if (count($errors = $this->get('Errors')))
            {
                    JError::raiseError(500, implode("\n", $errors));

                    return false;
            }

            DGAHelper::addSubmenu('arquivosusuarios');

            $this->addToolbar();

            // Include the component HTML helpers.
            JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

            $this->sidebar = JHtmlSidebar::render();

            parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
            require_once JPATH_COMPONENT . '/helpers/dga.php';

            $canDo = JHelperContent::getActions($this->state->get('filter.category_id'), 0, 'com_dga');

            JToolbarHelper::title('Arquivos', '{IMAGE_TITLE}');
	}
}

