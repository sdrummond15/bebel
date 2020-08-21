<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

$PATH_ADMIN_CSS = 'administrator/components/com_dga/assets/css/';
$PATH_ADMIN_JS = 'administrator/components/com_dga/assets/js/';

/* -------- CSS -------- */
JHTML::stylesheet($PATH_ADMIN_CSS . 'css_com_dga_documentos.css');
JHTML::stylesheet($PATH_ADMIN_CSS . 'bootstrap-switch.min.css');
/* -------- JS -------- */
JHTML::script($PATH_ADMIN_JS . 'bootstrap-switch.min.js');
JHTML::script($PATH_ADMIN_JS . 'js_com_dga_document.js');

JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

$app = JFactory::getApplication();
?>
<script type="text/javascript">
    Joomla.submitbutton = function(task)
    {
        if (task == 'arquivo.cancel' || document.formvalidator.isValid(document.id('document-form'))) {
            Joomla.submitform(task, document.getElementById('document-form'));
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_dga&layout=edit&id_doc=' . (int) $this->item->id_doc); ?>" method="post" name="adminForm" id="document-form" class="form-validate form-horizontal" enctype="multipart/form-data">
    
            <?php echo JHtml::_('bootstrap.startTabSet', 'TABSET1', array('active' => 'edit_arquivo')); ?>
<?php
        //
        // Dados Pessoais
        //
        echo JHtml::_('bootstrap.addTab', 'TABSET1', 'edit_arquivo', 'Arquivo');
        // Chama o arquivo que monta a TAB1.
        include('edit_arquivo.php');
        echo JHtml::_('bootstrap.endTab'); 
        //
        // Dados Pessoais
        //
        echo JHtml::_('bootstrap.addTab', 'TABSET1', 'edit_usuarios', 'Usuários autorizados');
        // Chama o arquivo que monta a TAB1.
        include('edit_usuarios.php');
        echo JHtml::_('bootstrap.endTab'); 
        //
        // Grupos
        //
        echo JHtml::_('bootstrap.addTab', 'TABSET1', 'edit_grupos', 'Grupos autorizados');
        // Chama o arquivo que monta a TAB1.
        include('edit_grupos.php');
        echo JHtml::_('bootstrap.endTab'); 
        
        echo JHtml::_('bootstrap.endTabSet'); ?>

    <input type="hidden" name="id_doc" value="<?php echo $this->item->id_doc; ?>"/>
    <input type="hidden" name="task" value=""/>
    <?php echo JHTML::_('form.token'); ?>
</form>

