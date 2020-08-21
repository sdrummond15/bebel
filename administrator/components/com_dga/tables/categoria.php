<?php
defined('_JEXEC') or die('Acesso restrito!');

class DGATableCategoria extends JTable
{
    var $id_cat = null;
    var $nome_cat = null;
    var $descricao_cat = null;

    function __construct(&$db) 
    {
        parent::__construct('#__dga_categorias_cat', 'id_cat', $db);
    }
}

?>

