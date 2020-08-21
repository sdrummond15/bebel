<span class="documento-lista-info">Defina para ON todos os Grupos de Usuários que tem permissão de visualizar e fazer download do arquivo.<br />
    Todos os usuários que estiverem nos grupos selecionados poderão visualizar e fazer downloads do arquivo.
</span>
<?php foreach ($this->grupos as $value):

          $checked = $value->id_grupo != null ? 'checked':'';          
?>
<label for="jform_grupo_<?php echo $value->id;?>" class="hasTooltip required">
    <input id="jform_grupo_<?php echo $value->id;?>" type="checkbox" <?php echo $checked;?> data-size="mini" data-on-color="primary" data-off-color="danger" name="jform_grupos[]" value="<?php echo $value->id;?>">
    <?php echo str_repeat('<span class="gi">|&mdash;</span>', $value->level)?>
    <span class="checkbox-label-grupos"><?php echo $value->title;?></span>
</label>
<?php endforeach;?>