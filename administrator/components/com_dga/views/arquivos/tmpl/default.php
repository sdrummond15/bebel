<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

$PATH_ADMIN_CSS = 'administrator/components/com_dga/assets/css/';

/* -------- CSS -------- */
JHTML::stylesheet($PATH_ADMIN_CSS . 'css_com_dga_show.css');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
?>
<script type="text/javascript">
    Joomla.orderTable = function()
    {
        table = document.getElementById("sortTable");
        direction = document.getElementById("directionTable");
        order = table.options[table.selectedIndex].value;
        if (order != '<?php echo $listOrder; ?>')
        {
            dirn = 'asc';
        }
        else
        {
            dirn = direction.options[direction.selectedIndex].value;
        }
        Joomla.tableOrdering(order, dirn, '');
    }
</script>
<form action="<?php echo JRoute::_('index.php?option=com_dga&view=arquivos'); ?>" method="post" name="adminForm" id="adminForm">
    <?php if (!empty($this->sidebar)) : ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this->sidebar; ?>
        </div>
        <div id="j-main-container" class="span10">
        <?php else : ?>
            <div id="j-main-container">
            <?php endif; ?>
            <div id="filter-bar" class="btn-toolbar">
                <div class="filter-search btn-group pull-left">
                    <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('Pesquisa pelo Título'); ?>" />
                </div>
                <div class="btn-group pull-left">
                    <button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
                    <button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value = '';
                            this.form.submit();"><i class="icon-remove"></i></button>
                </div>
            </div>

            <div class="clearfix"> </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="1%" class="center hidden-phone">
                            <?php echo JHtml::_('grid.checkall'); ?>
                        </th>
                        <th width="1%" class="nowrap center">
                            <?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
                        </th>
                        <th width="1%" class="nowrap center">
                            <?php echo JHtml::_('grid.sort', 'Tipo', 'a.extension_doc', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap">
                            <?php echo JHtml::_('grid.sort', 'Título', 'a.title_doc', $listDirn, $listOrder); ?>
                        </th>
                        <th width="10%" class="nowrap center">
                            <?php echo JHtml::_('grid.sort', 'Categoria', 'cat.nome_cat', $listDirn, $listOrder); ?>
                        </th>
                        <th width="10%" class="nowrap center">
                            <?php echo JHtml::_('grid.sort', 'Data de criação', 'a.create_date_doc', $listDirn, $listOrder); ?>
                        </th>
                        <th width="10%" class="nowrap center">
                            <?php echo JHtml::_('grid.sort', 'Fim da publicação ', 'a.data_fim_publicacao_doc', $listDirn, $listOrder); ?>
                        </th>
                        <th width="10%" class="nowrap center">
                            Status
                        </th>
                        <th width="10%" class="nowrap center">
                            <?php echo JHtml::_('grid.sort', 'Downloads', 'a.downloads_count_doc', $listDirn, $listOrder); ?>
                        </th>
                         <th width="1%" class="nowrap center hidden-phone">
                            <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id_doc', $listDirn, $listOrder); ?>
                        </th>
                        <th width="24px" class="nowrap center">
                        </th>
                        <th class="center hidden-phone">
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="12">
                            <?php echo $this->pagination->getListFooter(); ?>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $pathIconUserInfo =  JURI::root() . "administrator/components/com_dga/assets/images/icon-24-info_user.png";
                    
                    foreach ($this->items as $i => $item) :
                        $canChange              = true; //$user->authorise('core.edit.state', 'com_dga');
                        $link                   = JRoute::_('index.php?option=com_dga&view=arquivo&layout=edit&id_doc=' . (int) $item->id_doc);
                        $file_type_image        = "<img src=\"" . JURI::root() . "administrator/components/com_dga/assets/images/file_types/" . $item->extension_doc . ".png\" border=\"0\" />";
                        $file_type_image        = "<img src=\"" . JURI::root() . "administrator/components/com_dga/assets/images/file_types/" . $item->extension_doc . ".png\" border=\"0\" />";
                        $create_date_doc         = date('d/m/Y', strtotime($item->create_date_doc));
                        $create_date_doc_full    = date('d/m/Y H:i:s', strtotime($item->create_date_doc));
                        $data_fim_publicacao_doc = date('d/m/Y', strtotime($item->data_fim_publicacao_doc));
                        $downloadLink           =  JURI::root() . "images/dga/files/" . $item->filename_doc;
                        $newFileName            = $item->title_doc.'.'.$item->extension_doc;
                        $update_date_doc_full   = '';
                        
                        if($item->update_date_doc != null)
                        {
                            $update_date_doc_full  = date('d/m/Y H:i:s', strtotime($item->update_date_doc));
                        }
                        
                        
                        $userinfo =  "<img src=\"$pathIconUserInfo\" class=\"center hasTooltip\" title=\"Cadastrado por: $item->create_name_usu<br/>Data de cadastro: $create_date_doc_full<br/>Atualizado por: $item->update_name_usu<br/>Data de atualização: $update_date_doc_full\" border=\"0\" />"; 
                        
                        $file_type_image_path = JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_dga'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'file_types'.DIRECTORY_SEPARATOR.$item->extension_doc.'.png';
                            
                        if(!file_exists($file_type_image_path))
                        {
                            $file_type_image = "<img src=\"" . JURI::root() . "administrator/components/com_dga/assets/images/file_types/_blank.png\" border=\"0\"  class=\"hasTooltip\" title=\"Extensão: $item->extension_doc\" />";
                        }
                        
                        $status = 'Ativo';
                        $status_color = 'success';

                        if($item->published == false)
                        {
                            $status = 'Arquivo está inativo';
                            $status_color = 'danger';
                        }
                        else
                        {
                            if($item->data_fim_publicacao_doc < utils_DateNow())
                            {
                                $status = 'Arquivo chegou ao fim da publicação';
                                $status_color = 'warning';
                            }
                        }

                        ?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td class="center hidden-phone">
                                <?php echo JHtml::_('grid.id', $i, $item->id_doc); ?>
                            </td>
                            <td class="center">
                                <?php echo JHtml::_('jgrid.published', $item->published, $i, 'arquivos.', $canChange); ?>
                            </td>
                            <td>
                                <a href="<?php echo $link; ?>" class="center hasTooltip" title="<?php echo 'Extensão: '.$item->extension_doc; ?>"><?php echo $file_type_image; ?></a>
                            </td>
                            <td>
                                <a href="<?php echo $link; ?>" class="nowrap hasTooltip" title="<?php echo 'Descricão: '.$item->description_doc; ?>"><?php echo $item->title_doc; ?></a>
                            </td>
                            <td class="center">
                                <a href="<?php echo $link; ?>"> <?php echo $item->nome_cat; ?></a>
                            </td>
                            <td class="center">
                                <a href="<?php echo $link; ?>"> <?php echo $create_date_doc; ?></a>
                            </td>
                            <td class="center">
                                <a href="<?php echo $link; ?>"> <?php echo $data_fim_publicacao_doc; ?></a>
                            </td>
                            <td class="center">
                                <span class="badge alert-<?php echo $status_color;?>"><?php echo $status;?></span>
                            </td>
                            <td class="center">
                                <a href="<?php echo $link; ?>"> <?php echo $item->downloads_count_doc; ?></a>
                            </td>
                            <td class="center hidden-phone">
                                <a href="<?php echo $link; ?>"><?php echo $item->id_doc; ?></a>
                            </td>
                            <td class="center">
                                <a href="<?php echo $link; ?>"><?php echo $userinfo; ?></a>
                            </td>
                            <td class="center hidden-phone">
                                <?php echo JHtmlPlus::DownloadControl($downloadLink, $newFileName); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div>
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
                <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
                <?php echo JHtml::_('form.token'); ?>
            </div>
        </div>
</form>

