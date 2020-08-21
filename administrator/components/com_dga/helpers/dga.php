<?php

defined('_JEXEC') or die;

class DGAHelper extends JHelperContent
{
    public static function addSubmenu($vName)
    {
        $dataFields = array();


        
        $dataFields[] = array('authorise' => 'dga.arquivos', 'text' => 'Arquivos', 'view' => 'arquivos');
        $dataFields[] = array('authorise' => 'dga.categorias', 'text' => 'Categorias', 'view' => 'categorias');
        $dataFields[] = array('authorise' => 'dga.arquivosusuarios', 'text' => 'Downloads por Usuários', 'view' => 'arquivosusuarios');


        foreach ($dataFields as $value)
        {
            //if (JFactory::getUser()->authorise($value['authorise'], 'com_dga'))
            //{
                JHtmlSidebar::addEntry(JText::_($value['text']), 'index.php?option=com_dga&view=' . $value['view'], $value['view'] == $vName);
            //}
        }
    }

}
