<?php
defined('_JEXEC') or die;

class DGAViewArquivos extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	public function display($tpl = null)
	{
            $this->items        = $this->get('Items');
            $this->pagination	= $this->get('Pagination');
            $this->state        = $this->get('State');

            // Check for errors.
            if (count($errors = $this->get('Errors')))
            {
                    JError::raiseError(500, implode("\n", $errors));

                    return false;
            }

            DGAHelper::addSubmenu('arquivos');

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

            if($canDo->get('core.create'))
            {
                JToolbarHelper::addNew('arquivo.add');
            }

            if ($canDo->get('core.edit'))
            {
                JToolbarHelper::editList('arquivo.edit');
            }

            if ($canDo->get('core.edit.state'))
            {
                JToolbarHelper::publish('arquivos.publish', 'JTOOLBAR_PUBLISH', true);
                JToolbarHelper::unpublish('arquivos.unpublish', 'JTOOLBAR_UNPUBLISH', true);
                JToolbarHelper::divider();
            }

            if ($canDo->get('core.delete'))
            {
                JToolbarHelper::deleteList('', 'arquivos.delete');
                JToolbarHelper::divider();
            }
            
            if($canDo->get('core.admin'))
            {
                //JToolbarHelper::preferences('com_dga');
            }
	}
}

