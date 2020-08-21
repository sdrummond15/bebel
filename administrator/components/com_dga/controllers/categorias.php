<?php

defined('_JEXEC') or die('Acesso restrito!');
jimport('joomla.application.component.controller');

class DGAControllerCategorias extends JControllerAdmin
{
    
    public function __construct($config = array())
    {
            parent::__construct($config);

            $this->registerTask('sticky_unpublish', 'sticky_publish');
    }
    
    public function getModel($name = 'Categoria', $prefix = 'DGAModel', $config = array('ignore_request' => true))
    {
            $model = parent::getModel($name, $prefix, $config);
            return $model;
    }
}

?>

