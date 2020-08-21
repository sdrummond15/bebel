<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

$PATH_ADMIN_CSS = 'administrator/components/com_dga/assets/css/';

/* -------- CSS -------- */
JHTML::stylesheet($PATH_ADMIN_CSS . 'css_com_dga.css');

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
<form action="<?php echo JRoute::_('index.php?option=com_dga&view=arquivosusuarios'); ?>" method="post" name="adminForm" id="adminForm">
    <?php if (!empty($this->sidebar)) : ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this->sidebar; ?>
        </div>
        <div id="j-main-container" class="span10">
        <?php else : ?>
            <div id="j-main-container">
            <?php endif; ?>
            <div style="margin-bottom: 10px;">
            
<?php 
             //
             // Search Tools
             //
            echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
?>
                
            </div>
            <div class="clearfix"> </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="nowrap">
                            Usuário
                        </th>
                        <th width="10%" class="nowrap center">
                            Data primeiro download
                        </th>
                        <th width="10%" class="nowrap center">
                            Data último download
                        </th>
                        <th width="10%" class="nowrap center">
                            <div title="Quantidade de vezes que o usuário baixou este arquivo" class="hasTooltip">Downloads</div> 
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <?php echo $this->pagination->getListFooter(); ?>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    
                    $pathIconUserInfo =  JURI::root() . "administrator/components/com_dga/assets/images/icon-24-info_user.png";
                    
                    foreach ($this->items as $i => $item) :

                        if($item->create_date_udd != null)
                        {
                            
                            $create_date_udd        = $item->create_date_udd != null ? JHtmlPlus::GetDate($item->create_date_udd, true) : ""; 
                            $last_date_download_udd = $item->last_date_download_udd != null ? JHtmlPlus::GetDate($item->last_date_download_udd, true) : ""; 
                            $downloads_count_udd    = $item->downloads_count_udd; 
                        }
                        else
                        {
                            $create_date_udd        = '<span class="label label-warning">Nunca fez download</span>';
                            $last_date_download_udd = '<span class="label label-warning">Nunca fez download</span>';
                            $downloads_count_udd    = '<span class="label label-warning">Nunca fez download</span>';
                        }
                        
                        ?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td>
                                <?php echo $item->name_user; ?>
                            </td>
                            <td class="center">
                                <?php echo $create_date_udd; ?>
                            </td>
                            <td class="center">
                                <?php echo $last_date_download_udd; ?>
                            </td>
                            <td class="center">
                                <?php echo $downloads_count_udd; ?>
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

