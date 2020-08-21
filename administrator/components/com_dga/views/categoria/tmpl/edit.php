<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

$PATH_ADMIN_CSS = 'administrator/components/com_dga/assets/css/';

/* -------- CSS -------- */
JHTML::stylesheet($PATH_ADMIN_CSS . 'css_com_dga_edit.css');

$app = JFactory::getApplication();
$pathImage = JURI::root() . "/administrator/components/com_dga/assets/images/fieldsets/"
?>
<script type="text/javascript">
    Joomla.submitbutton = function (task) {
        if (task == 'categoria.cancel' || document.formvalidator.isValid(document.id('categoria-form'))) {
            Joomla.submitform(task, document.getElementById('categoria-form'));
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_dga&layout=edit&id_cat='.(int)$this->item->id_cat); ?>" method="post" name="adminForm" id="categoria-form" class="form-validate form-horizontal">
    <fieldset class="fieldsetGroup">
        <legend>
            <img src="<?php echo $pathImage; ?>icon-24-form.png" alt="dados_mediunicos"></span> Dados da Categoria</legend>
        <div class="control-group">
            <div class="control-group">
                <div class="control-label">
                    <?php echo $this->form->getLabel('nome_cat'); ?>
                </div>
                <div class="controls">
                    <?php echo $this->form->getInput('nome_cat'); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <?php echo $this->form->getLabel('descricao_cat'); ?>
                </div>
                <div class="controls">
                    <?php echo $this->form->getInput('descricao_cat'); ?>
                </div>
            </div>
        </div>
    </fieldset>
    <input type="hidden" name="task" value="" />
    <?php echo JHTML::_('form.token');?>
</form>

