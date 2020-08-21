<div class="control-group">
    <div class="control-group">
        <div class="control-label">
            <?php echo $this->form->getLabel('id_cat'); ?>
        </div>
        <div class="controls">
            <?php echo $this->form->getInput('id_cat'); ?>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <?php echo $this->form->getLabel('filename_doc'); ?>
        </div>
        <div class="controls">
            <!--<input id="uploadFile" type="text" placeholder="Escolha um arquivo" disabled="disabled" />-->
            <?php echo $this->form->getInput('uploadFile'); ?>
            <div id="uploadBtnDiv" class="fileUpload btn btn-primary">
                <span>Escolher arquivo</span>
            </div>
            <input type="file" name="jform_filename_doc" id="jform_filename_doc" value="" accept="*" class="uploadBtn" size="10240">
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <?php echo $this->form->getLabel('title_doc'); ?>
        </div>
        <div class="controls">
            <?php echo $this->form->getInput('title_doc'); ?>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <?php echo $this->form->getLabel('description_doc'); ?>
        </div>
        <div class="controls">
            <?php echo $this->form->getInput('description_doc'); ?>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <?php echo $this->form->getLabel('data_inicio_publicacao_doc'); ?>
        </div>
        <div class="controls">
            <?php echo $this->form->getInput('data_inicio_publicacao_doc'); ?>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <?php echo $this->form->getLabel('data_fim_publicacao_doc'); ?>
        </div>
        <div class="controls">
            <?php echo $this->form->getInput('data_fim_publicacao_doc'); ?>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <?php echo $this->form->getLabel('published'); ?>
        </div>
        <div class="controls">
            <?php echo $this->form->getInput('published'); ?>
        </div>
    </div>
</div>    