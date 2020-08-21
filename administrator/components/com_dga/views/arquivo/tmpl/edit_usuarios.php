<span class="documento-lista-info">Defina para ON todos os usuários que tem permissão de visualizar e fazer download do arquivo.</span>
<?php foreach ($this->usuarios as $value):

$checked = $value->id_user != null ? 'checked':'';
    
?>
<label for="jform_usuario_<?php echo $value->id;?>" class="hasTooltip required">
    <input id="jform_usuario_<?php echo $value->id;?>" type="checkbox" <?php echo $checked;?> data-size="mini" data-on-color="primary" data-off-color="danger" name="jform_usuarios[]" value="<?php echo $value->id;?>">
    <span class="checkbox-label-usuarios"><?php echo $value->name;?></span>
</label>
<?php endforeach;?>