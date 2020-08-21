<?php
defined('_JEXEC') or die;

class DGAViewArquivos extends JViewLegacy
{
    protected $items;
    protected $todasCategorias;
    protected $mostrarBotaoCategoria;

    public function display($tpl = null)
    {
        $user               = JFactory::getUser();
        $session            = JFactory::getSession();
        $this->items        = $this->get("Items");

        if($user->id == 0)
        {
            JError::raiseNotice(403, 'É preciso logar para acessar essa área!');
            return false;
        }
        
        $doc = JFactory::getDocument();
        $doc->addStyleSheet('components/com_dga/assets/css/stylearquivo.css');
        
        $app    = JFactory::getApplication();
        $params = $app->getParams();

        $dga_id_cat = $params->get('dga_id_cat', 0);
        $dga_mostrar_botao_categoria = $params->get('dga_mostrar_botao_categoria', 1);
        
        $this->todasCategorias = $dga_id_cat == 999 ? true : false;
        $this->mostrarBotaoCategoria = $dga_mostrar_botao_categoria == 1 ? true : false;
        
        parent::display($tpl);
    }

}
