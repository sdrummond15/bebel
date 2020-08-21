<?php

defined('_JEXEC') or die('Acesso restrito!');

class DGATableArquivo extends JTable
{
    var $id_doc = null;
    var $title_doc = null;
    var $description_doc = null;
    var $extension_doc = null;
    var $filename_doc = null;
    var $filesize_doc = null;
    var $create_user_doc = null;
    var $create_date_doc = null;
    var $update_user_doc = null;
    var $update_date_doc = null;
    var $data_inicio_publicacao_doc = null;
    var $data_fim_publicacao_doc = null;
    var $downloads_count_doc = null;
    var $published = null;

    function __construct(&$db)
    {
        parent::__construct('#__dga_documentos_doc', 'id_doc', $db);
    }

}
?>

