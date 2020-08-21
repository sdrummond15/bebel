<?php

defined('_JEXEC') or die;

class DGAHelper extends JHelperContent
{
    public static function addSubmenu($vName)
    {
        $dataFields = array();

        $dataFields[] = array('authorise' => 'dga.ciclopagamentos', 'text' => 'Ciclo de Pagamentos', 'view' => 'ciclopagamentos');
        $dataFields[] = array('authorise' => 'dga.clientes', 'text' => 'Clientes', 'view' => 'clientes');
        $dataFields[] = array('authorise' => 'dga.clientesdominios', 'text' => 'Clientes - Domínios', 'view' => 'clientesdominios');
        $dataFields[] = array('authorise' => 'dga.clienteshospedagens', 'text' => 'Clientes - Hospedagens', 'view' => 'clienteshospedagens');
        $dataFields[] = array('authorise' => 'dga.clientesprodutos', 'text' => 'Clientes - Produtos', 'view' => 'clientesprodutos');
        $dataFields[] = array('authorise' => 'dga.clientessuportes', 'text' => 'Clientes - Suportes', 'view' => 'clientessuportes');
        $dataFields[] = array('authorise' => 'dga.bairros', 'text' => 'Bairros', 'view' => 'bairros');
        $dataFields[] = array('authorise' => 'dga.cidades', 'text' => 'Cidades', 'view' => 'cidades');
        $dataFields[] = array('authorise' => 'dga.estados', 'text' => 'Estados', 'view' => 'estados');
        $dataFields[] = array('authorise' => 'dga.faturas', 'text' => 'Faturas', 'view' => 'faturas');
        $dataFields[] = array('authorise' => 'dga.faturasformaspagamentos', 'text' => 'Faturas - Formas Pagamentos', 'view' => 'faturasformaspagamentos');
        $dataFields[] = array('authorise' => 'dga.faturasitens', 'text' => 'Faturas - Itens', 'view' => 'faturasitens');
        $dataFields[] = array('authorise' => 'dga.faturasstatus', 'text' => 'Faturas - Status', 'view' => 'faturasstatus');
        $dataFields[] = array('authorise' => 'dga.hospedagens', 'text' => 'Pacotes de Hospedagens', 'view' => 'hospedagens');
        $dataFields[] = array('authorise' => 'dga.plataformas', 'text' => 'Plataformas', 'view' => 'plataformas');
        $dataFields[] = array('authorise' => 'dga.plataformasversoes', 'text' => 'Plataformas - Versões', 'view' => 'plataformasversoes');
        $dataFields[] = array('authorise' => 'dga.produtos', 'text' => 'Produtos', 'view' => 'produtos');
        $dataFields[] = array('authorise' => 'dga.produtosimagens', 'text' => 'Produtos - Imagens', 'view' => 'produtosimagens');
        $dataFields[] = array('authorise' => 'dga.produtosvalores', 'text' => 'Produtos - Valores', 'view' => 'produtosvalores');
        $dataFields[] = array('authorise' => 'dga.produtosversoes', 'text' => 'Produtos - Versões', 'view' => 'produtosversoes');
        $dataFields[] = array('authorise' => 'dga.produtosvideoaulas', 'text' => 'Produtos - Videoaulas', 'view' => 'produtosvideoaulas');
        $dataFields[] = array('authorise' => 'dga.suportes', 'text' => 'Suportes', 'view' => 'suportes');

        $dataFields[] = array('authorise' => 'dga.relatorios', 'text' => 'Relatórios', 'view' => 'relatorios');

        foreach ($dataFields as $value)
        {
            if (JFactory::getUser()->authorise($value['authorise'], 'com_dga'))
            {
                JHtmlSidebar::addEntry(JText::_($value['text']), 'index.php?option=com_dga&view=' . $value['view'], $value['view'] == $vName);
            }
        }
    }

    public static function addSubmenuRelatorios($vName)
    {
        $dataFields = array();

        $dataFields[] = array('authorise' => 'dga.relatoriotrinos', 'text' => 'Trinos', 'view' => 'relatoriotrinos');
        $dataFields[] = array('authorise' => 'dga.aspirantes', 'text' => 'Voltar', 'view' => 'aspirantes');

        foreach ($dataFields as $value)
        {
            if (JFactory::getUser()->authorise($value['authorise'], 'com_dga'))
            {
                JHtmlSidebar::addEntry(JText::_($value['text']), 'index.php?option=com_dga&view=' . $value['view'], $value['view'] == $vName);
            }
        }
    }

}
