<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');

$PATH_CSS = 'components/com_dga/assets/css/';
$PATH_JS = 'components/com_dga/assets/js/';

/* -------- CSS -------- */
JHTML::stylesheet($PATH_CSS . 'bootstrap.min.css');
JHTML::stylesheet($PATH_CSS . 'css_com_dga_categorias.css');
JHTML::stylesheet($PATH_CSS . 'bootstrap-select.min.css');
/* -------- JS -------- */
JHTML::script($PATH_JS . 'bootstrap-select.min.js');
//JHTML::script($PATH_JS . 'bootstrap_3_1_1/js/bootstrap.min.js');


$pathImage              = JUri::root().'/components/com_dga/assets/images/icon-48-folder_documents.png';
?>
<div class="page-header">
  <h1>Todos os Documentos</h1>
</div>
<?php foreach ($this->items as $item): ?>
<div class="categoria">
    <div class="panel panel-default categoria-hover" onclick="javascript:location.href='<?php echo JRoute::_("index.php?option=com_dga&view=arquivos&id_cat=$item->id_cat");?>'">
        <div class="panel-body" style="min-height: 62px;display: block;padding: 5px;">

            <div class="categoria-imagem">
                <img src="<?php echo $pathImage; ?>">
            </div>
            <div class="categoria-texto">
                <span class="categoria-titulo"><?php echo $item->nome_cat;?></span>
                <span class="categoria-descricao"><?php echo $item->descricao_cat;?></span><br/>
                Total de arquivos: <span class="badge"><?php echo $item->total;?></span>
            </div>

        </div>
    </div>
</div>
<?php endforeach; ?>

