<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$PATH_CSS = 'components/com_dga/assets/css/';
$PATH_JS = 'components/com_dga/assets/js/';

/* -------- CSS -------- */
JHTML::stylesheet($PATH_CSS . 'bootstrap.min.css');
JHTML::stylesheet($PATH_CSS . 'css_com_dga_area_cliente.css');
/* -------- JS -------- */
JHTML::script($PATH_JS . 'js_com_dga_arquivos.js');
JHTML::script($PATH_JS . 'ZeroClipboard.min.js');
JHTML::script($PATH_JS . 'js_com_dga_copyclipboard.js');

$user = JFactory::getUser();

$pathImage24 = JUri::root() . '/components/com_dga/assets/images/painel/icon-24-';
$pathImage32 = JUri::root() . '/components/com_dga/assets/images/painel/icon-32-';
$styleIcon = "padding-left: 50px;background-position: 8px 5px;background-repeat: no-repeat;background-image: url('" . $pathImage32;

$linkCategorias = JRoute::_('index.php?option=com_dga&view=categorias');

$iconDownload = $styleIcon . "download.png');";
?>
<div style="margin-left: 20px;">
    <?php if ($this->mostrarBotaoCategoria) : ?>
        <div style="width: 100%;position: relative;display: inline-block;margin-bottom: 8px;">
            <div style="float: right;">
                <a class="btnvoltar" href="<?php echo $linkCategorias; ?>">Voltar</a>
            </div>
        </div>
    <?php endif; ?>


    <div class="panel panel-default">
        <div class="panel-body" style="overflow: auto;">

            <?php if ($this->todasCategorias == false) : ?>
                <div class="page-header" style="margin-top: 0px;">
                    <h3><?php echo $this->items[0]->nome_cat; ?></h3>
                </div>
            <?php endif; ?>
            <form action="<?php echo JRoute::_('index.php?option=com_dga&view=arquivos&id_cat=1'); ?>" method="post" name="adminForm" id="adminForm">
                <table class="table table-striped table-bordered documentos">
                    <thead>
                        <tr>
                            <th>Arquivo</th>
                            <th>Descri&ccedil;&atilde;o</th>
                            <th>Data</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($this->items as $i => $item) :
                            $file_type_image = "<img src=\"" . JURI::root() . "administrator/components/com_dga/assets/images/file_types/" . $item->extension_doc . ".png\" border=\"0\"  class=\"hasTooltip\" title=\"Extensão: $item->extension_doc\" />";
                            $createdate_doc = date('d/m/Y', strtotime($item->create_date_doc));
                            $createdate_doc_full = date('d/m/Y H:i:s', strtotime($item->create_date_doc));
                            $downloadLink = JURI::root() . "images/dga/files/" . $item->filename_doc;
                            $newFileName = $item->title_doc . '.' . $item->extension_doc;

                            $file_type_image_path = JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_dga' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'file_types' . DIRECTORY_SEPARATOR . $item->extension_doc . '.png';

                            if (!file_exists($file_type_image_path)) {
                                $file_type_image = "<img src=\"" . JURI::root() . "administrator/components/com_dga/assets/images/file_types/_blank.png\" border=\"0\"  class=\"hasTooltip\" title=\"Extensão: $item->extension_doc\" />";
                            }
                            ?>
                            <tr class="row<?php echo $i % 2; ?>">
                                <td class="nowrap" width="20%">
                                    <h1>
                                        <?php echo $item->title_doc; ?>
                                    </h1>
                                </td>
                                <td width="60%">
                                    <p>
                                        <?php echo $item->description_doc; ?>
                                    </p>
                                </td>
                                <td class="center" width="15%">
                                    <span class="hasTooltip" title="Data de cadastro: <?php echo $createdate_doc_full; ?>"><?php echo $createdate_doc; ?></span>
                                </td>
                                <td class="center hidden-phone download" width="5%">
                                    <?php echo JHtmlPlus::DownloadControlSite("javascript:download('$item->filename_doc');"); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                    <input type="hidden" id="filekey" name="filekey" value="" />
                    <input type="hidden" name="task" value="arquivos.download" />
                </table>
            </form>
        </div>
    </div>
</div>

