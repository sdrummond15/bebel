<?php
defined('_JEXEC') or die;

class DGAViewCategorias extends JViewLegacy
{
    protected $items;
    protected $pagination;
    protected $state;
        
    public function display($tpl = null)
    {
        $user       = JFactory::getUser();
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        if($user->id == 0)
        {
            JError::raiseNotice(403, 'É preciso logar para acessar essa área!');
            return false;
        }
        
        parent::display($tpl);
    }

}
