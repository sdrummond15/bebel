<?php
defined('_JEXEC') or die;

$iconDownload     = $styleIcon. "download.png');";
?>
<div class="panel panel-default">
    <div class="panel-heading" style="<?php echo $iconDownload; ?>">Arquivos para downloads</div>
    <div class="panel-body" style="overflow: auto;">
        <div class="page-header" style="margin-top: 0px;">
        <h3>Meus arquivos</h3>
        </div>
        <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="10%" class="nowrap center">
                            Tipo
                        </th>
                        <th class="nowrap">
                            Título
                        </th>
                        <th class="nowrap">
                            Descrição
                        </th>
                        <th width="10%" class="nowrap center">
                            Data
                        </th>
                         <th width="1%" class="nowrap center hidden-phone">
                            ID
                        </th>
                        <th class="center hidden-phone">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->documentos as $i => $item) :
                        $file_type_image        = "<img src=\"" . JURI::root() . "administrator/components/com_dga/assets/images/file_types/" . $item->extension_doc . ".png\" border=\"0\"  class=\"hasTooltip\" title=\"Extensão: $item->extension_doc\" />";
                        $createdate_doc         = date('d/m/Y', strtotime($item->createdate_doc));
                        $createdate_doc_full    = date('d/m/Y H:i:s', strtotime($item->createdate_doc));
                        $downloadLink           =  JURI::root() . "images/dga/files/" . $item->filename_doc;
                        $newFileName            = $item->title_doc.'.'.$item->extension_doc;
                        
                        $file_type_image_path = JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_dga'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'file_types'.DIRECTORY_SEPARATOR.$item->extension_doc.'.png';
                            
                        if(!file_exists($file_type_image_path))
                        {
                            $file_type_image = "<img src=\"" . JURI::root() . "administrator/components/com_dga/assets/images/file_types/_blank.png\" border=\"0\"  class=\"hasTooltip\" title=\"Extensão: $item->extension_doc\" />";
                        }
                        
                        ?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td class="center">
                                <?php echo $file_type_image; ?>
                            </td>
                            <td class="nowrap">
                                <?php echo $item->title_doc; ?>
                            </td>
                            <td>
                                <?php echo $item->description_doc; ?>
                            </td>
                            <td class="center">
                                <span class="hasTooltip" title="Data de cadastro: <?php echo $createdate_doc_full; ?>"><?php echo $createdate_doc; ?></span>
                            </td>
                            <td class="center hidden-phone">
                                <?php echo $item->id_doc; ?>
                            </td>
                            <td class="center hidden-phone">
                                <?php echo JHtmlPlus::DownloadControl($downloadLink, $newFileName); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
</div>
<input type="hidden" id="senha_descompactar_pva" value="">

