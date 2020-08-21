<?php

class JHtmlPlus
{
    public static function EditControl($i, $command, $title='Editar', $menuGroup = false, $text = '')
    {
        return JHtmlPlus::GetButtonControl($i, $command, 'edit', $title, $menuGroup, $text); 
    }
    
    public static function DeleteControl($i, $command, $title='Excluir', $menuGroup = false, $text = '')
    {
        return JHtmlPlus::GetButtonControl($i, $command, 'delete', $title, $menuGroup, $text); 
    }
    
    public static function PrintControl($i, $command, $title = 'Imprimir', $menuGroup = false, $text = '')
    {
        return JHtmlPlus::GetButtonControl($i, $command, 'print',  $title, $menuGroup, $text); 
    }
    
    public static function GetButtonControl($i, $command, $icon, $title, $menuGroup = false, $text = '')
    {
        $html = '';
        
        if($menuGroup)
        {
            $html = "<a href=\"#\" onclick=\"return listItemTask('cb$i','$command');\" title=\"$title\">" .
                    "<span class=\"icon-$icon\"></span> $text" .
                    "</a>";
        }
        else
        {
            $html = "<button onclick=\"return listItemTask('cb$i','$command');\" class=\"btn btn-small hasTooltip floated\" title=\"$title\">" .
                    "<span class=\"icon-$icon\">$text</span>" .
                    "</button>";
        }
        
        return $html;    
    }
    
    public static function DownloadControl($url, $newFileName)
    {
        return "<a href=\"".$url."\" target=\"_blank\" class=\"btn btn-small hasTooltip floated\" title=\"Fazer download do arquivo\" download=\"".$newFileName."\">" .
               "<span class=\"icon-download\" style=\"width:95px;\"> Baixar arquivo</span>" .
               "</a>";  
    }
    
    public static function DownloadControlSite($href)
    {
        return "<a href=\"$href\" target=\"_self\" class=\"btn btn-small hasTooltip floated\" title=\"Fazer download do arquivo\">" .
               "<span class=\"icon-download\" style=\"width:95px;\"> Baixar arquivo</span>" .
               "</a>";  
    }
    
    public static function DatepickerControl($id, $name, $dateFormat = 'dd/mm/yy', $mask = '99/99/9999', $minDate = 'null', $value = '')
    {                
            $document = JFactory::getDocument();
            $document->addScriptDeclaration(
                                    'window.addEvent(\'domready\', function() {'. 
                                    'jQuery("#'.$id.'").datepicker('.
                                    '{'.
                                      'minDate: '.$minDate.','.
                                      'firstDay: 1,'.
                                      'showOn: "button",'.
                                      'dateFormat: "'.$dateFormat.'",'.
                                      'onSelect: function(dateText, inst)'. 
                                      '{'.
                                        'jQuery("#'.$id.'").val(dateText);'.
                                      '},'.
                                      'showOptions: { direction: "up" }'.
                                    '});'.
                                    'jQuery("#'.$id.'").mask("'.$mask.'");'.
                                    '});'
                            );

            $PATH_ADMIN_CSS = 'administrator/components/com_dga/assets/css/';
            $PATH_ADMIN_JS = 'administrator/components/com_dga/assets/js/';

            JHTML::stylesheet($PATH_ADMIN_CSS . 'smoothness/jquery-ui-1.9.2.custom.min.css');

            /* -------- JS -------- */
            JHTML::script($PATH_ADMIN_JS . 'jquery-ui-1.9.2.min.js');
            JHTML::script($PATH_ADMIN_JS . 'jquery.ui.datepicker-pt-BR.js');
            JHTML::script($PATH_ADMIN_JS . 'jquery.maskedinput-1.3.1.min.js');

            return '<div class="input-append"><input type="text" title="" name="'.$name.'" id="'.$id.'" value="'.$value.'" class="input-medium hasTooltip" ></div>';
    }
    
    public static function MaskControl($id, $name, $mask, $value = '')
    {                
        $document = JFactory::getDocument();
        $document->addScriptDeclaration(
                                'window.addEvent(\'domready\', function() {'. 
                                    'jQuery("#'.$id.'").mask("'.$mask.'");'.
                                '});'
                        );

        $PATH_ADMIN_JS = 'administrator/components/com_dga/assets/js/';

        /* -------- JS -------- */
        JHTML::script($PATH_ADMIN_JS . 'jquery.maskedinput-1.3.1.min.js');

        return '<input type="text" title="" name="'.$name.'" id="'.$id.'" value="'.$value.'" class="input-medium hasTooltip" data-original-title="" >';
    }
    
    public static function SQLControl($id, $name, $keyField, $valueField, $query, $value = 0, $readonly = false, $required = false, $onchange = '')
    {                
        $html = array();
        $attr = '';

        // Initialize some field attributes.
        /*$attr .= !empty($this->class) ? ' class="' . $this->class . '"' : '';
        $attr .= !empty($this->size) ? ' size="' . $this->size . '"' : '';
        $attr .= $this->multiple ? ' multiple' : '';
        
        $attr .= $this->autofocus ? ' autofocus' : '';*/

        $attr .= $required ? ' required aria-required="true"' : '';
        $attr .= $onchange;
        
        // To avoid user's confusion, readonly="true" should imply disabled="true".
        if ((string) $readonly == '1' || (string)$readonly == 'true')
        {
                $attr .= ' disabled="disabled"';
        }

        // Initialize JavaScript field attributes.
        //$attr .= $this->onchange ? ' onchange="' . $this->onchange . '"' : '';

        // Get the field options.
        $options = (array) JHtmlPlus::getOptions($keyField, $valueField, $query);

        // Create a read-only list (no name) with a hidden input to store the value.
        if ((string) $readonly == '1' || (string) $readonly == 'true')
        {
                $html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $value, $id);
                $html[] = '<input type="hidden" name="' . $name . '" value="' . $value . '"/>';
        }
        else
        // Create a regular list.
        {
                $html[] = JHtml::_('select.genericlist', $options, $name, trim($attr), 'value', 'text', $value, $id);
        }

        return implode($html);
    }
    
    private static function getOptions($keyField, $valueField, $query, $translate = false)
    {
        $options = array();

        // Initialize some field attributes.
        $key   = $keyField;
        $value = $valueField;

        // Get the database object.
        $db = JFactory::getDbo();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
                foreach ($items as $item)
                {
                        if ($translate == true)
                        {
                                $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                        }
                        else
                        {
                                $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                        }
                }
        }

        return $options;
    }
    
    public static function GruposControl($id, $name, $value = 0, $selectOptionText = true, $onchange = '', $required = false, $readonly = false)
    {  
        $selectOptionTextQuery = '';
        
        if($selectOptionText)
        {
          $selectOptionTextQuery = "SELECT '0' AS id_grp, '-- Selecione uma opção --' AS nome_grp, '0' AS ordem_grp  UNION ";  
        }
        
        return JHtmlPlus::SQLControl($id, $name, 'id_grp', 'nome_grp', $selectOptionTextQuery . "SELECT id_grp, nome_grp, ordem_grp FROM #__dga_grupos_grp ORDER BY ordem_grp, nome_grp", $value, $readonly, $required, $onchange);
    }
    
    public static function EstadosControl($id, $name, $value = 0, $fieldControlPopulate = null, $required = false)
    {       
        if($value == null){$value = 0;}
        
        if($fieldControlPopulate != null)
        {
            JHtmlPlus::addScriptDeclarationRegion($id, $name, 'getCities', $fieldControlPopulate, 'id_est');
        }
        
        return JHtmlPlus::SQLControl($id, $name, 'id_est', 'nome_est', "SELECT '0' AS id_est, '-- Selecione uma opção --' AS nome_est UNION SELECT id_est, nome_est FROM #__dga_estados_est ORDER BY nome_est", $value, false, $required);
    }
    
    public static function CidadesControl($id, $name, $id_est, $value = 0, $fieldControlPopulate = null, $required = false)
    {  
        if($value == null){$value = 0;}
        
        if($fieldControlPopulate != null)
        {
            JHtmlPlus::addScriptDeclarationRegion($id, $name, 'getBairros', $fieldControlPopulate, 'id_cid');
        }
        
        return JHtmlPlus::SQLControl($id, $name, 'id_cid', 'nome_cid', "SELECT '0' AS id_cid, '-- Selecione uma opção --' AS nome_cid UNION SELECT id_cid, nome_cid FROM #__dga_cidades_cid WHERE id_est=$id_est ORDER BY nome_cid", $value, false, $required);
    }
    
    public static function BairrosControl($id, $name, $id_cid, $value = 0, $required = false)
    {  
        if($value == null){$value = 0;}
        
        return JHtmlPlus::SQLControl($id, $name, 'id_bai', 'nome_bai', "SELECT '0' AS id_bai, '-- Selecione uma opção --' AS nome_bai UNION SELECT id_bai, nome_bai FROM #__dga_bairros_bai WHERE id_cid=$id_cid ORDER BY nome_bai", $value, false, $required);
    }
    
    private static function addScriptDeclarationRegion($id, $name, $task,  $fieldControlPopulate, $keyField)
    { 
        $newLine = "\r\n";
        
        $document = JFactory::getDocument();
        $document->addScriptDeclaration(
                                "window.addEvent('domready', function() {". $newLine .
                                "jQuery(\"#$id\").change" . $newLine .
                                "(" . $newLine .
                                "function()" . $newLine .
                                "{" . $newLine .
                                "jQuery(\"#$fieldControlPopulate\").html('<option value=\"0\">Carregando...</option>');" . $newLine .
                                "jQuery(\"#$fieldControlPopulate\").trigger(\"liszt:updated\");" . $newLine .
                                "var url = \"".JURI::root()."administrator/index.php?option=com_dga&task=$task&format=raw\";" . $newLine .
                                "jQuery.post(url," . $newLine .
                                "{" . $newLine .
                                "'$keyField': jQuery('#$id').val()," . $newLine .
                                "'dataType': 'json'" . $newLine .
                                "}," . $newLine .
                                "function(data)" . $newLine .
                                "{" . $newLine .
                                "var response = jQuery.parseJSON(data);" . $newLine .
                                "switch (response.Status)" . $newLine .
                                "{" . $newLine .
                                "case \"OK\":" . $newLine .
                                "{" . $newLine .
                                "jQuery(\"#$fieldControlPopulate\").html(response.Result);" . $newLine .
                                "jQuery(\"#$fieldControlPopulate\").trigger(\"liszt:updated\");" . $newLine .
                                "jQuery(\"#$fieldControlPopulate\").change();" . $newLine .
                                "break;" . $newLine .
                                "}" . $newLine .
                                "case \"ERRO\":" . $newLine .
                                "{" . $newLine .
                                "alert('Atenção gerou um erro!' + response.Message);" . $newLine .
                                "break;" . $newLine .
                                "}" . $newLine .
                                "}" . $newLine .
                                "})" . $newLine .
                                "});" . $newLine .
                                "});" . $newLine
                        );
    }
        
    public static function GruposDesenvolvimentosControl($id, $name, $id_agd, $ordem)
    {  
        $query = 'SELECT asg.id_grp AS id_grp, grp.nome_grp AS nome_grp FROM #__dga_aspirantes_grupos_asg AS asg' .
                 ' LEFT JOIN #__dga_grupos_grp AS grp ON grp.id_grp=asg.id_grp'.
                 ' WHERE asg.ordem_asg > '.$ordem.' AND asg.id_agd='.$id_agd.
                 ' ORDER BY asg.ordem_asg';
        
        return JHtmlPlus::SQLControl($id, $name, 'id_grp', 'nome_grp', $query, 0, false, false);
    }
    
    public static function DialogAddFieldControl($selectID, $task, $field, $title, $maxlength = 100)
    {     
        $buttonID       = 'btnAdd'.$selectID;
        $dialogDivID    = 'dialogAdd'.$selectID;
        $jform_field = 'jform_'.$field .'_'. $selectID;
        
        $newLine = "\r\n";
        
        $document = JFactory::getDocument();
        $document->addScriptDeclaration(
                                "window.addEvent('domready', function() {". $newLine .
                                "jQuery(\"#$buttonID\").click(function()" . $newLine .
                                "{" . $newLine .
                                "jQuery(\"#$dialogDivID\").dialog(\"open\");" . $newLine .
                                "});" . $newLine .
                                "jQuery(\"#$dialogDivID\").dialog({" . $newLine .
                                "autoOpen: false," . $newLine .
                                "modal: true," . $newLine .
                                "width: 460," . $newLine .
                                "height: 170," . $newLine .
                                "resizable: false," . $newLine .
                                "title: '$title'," . $newLine .
                                "show: \"scale\"," . $newLine .
                                "hide: \"puff\"," . $newLine .
                                "buttons: {" . $newLine .
                                "\"Cadastrar\":" . $newLine .
                                "function()" . $newLine .
                                "{" . $newLine .
                                "var form = this;" . $newLine .
                                "var url = \"".JURI::root()."administrator/index.php?option=com_dga&task=$task&format=raw\";" . $newLine .
                                "jQuery.post(url," . $newLine .
                                "{" . $newLine .
                                "'$field': jQuery('#$jform_field').val()," . $newLine .
                                "'dataType': 'json'" . $newLine .
                                "}," . $newLine .
                                "function(data)" . $newLine .
                                "{" . $newLine .
                                "var response  = jQuery.parseJSON(data);" . $newLine .
                                "" . $newLine .
                                "switch(response.Status)" . $newLine .
                                "{" . $newLine .
                                "case \"OK\":" . $newLine .
                                "{" . $newLine .
                                "jQuery(form).effect('transfer', {to: jQuery('#jform_".$selectID."_chzn'), className: \"ui-effects-transfer\"}, 500, function()" . $newLine .
                                "{" . $newLine .
                                "jQuery(\"#jform_$selectID\").html(response.Result);" . $newLine .
                                "jQuery(\"#jform_$selectID\").trigger(\"liszt:updated\");" . $newLine .
                                "jQuery('#$jform_field').val('');" . $newLine .
                                "jQuery(form).dialog(\"close\");" . $newLine .
                                "});" . $newLine .
                                "break;" . $newLine .
                                "}" . $newLine .
                                "case \"OBRIGATORIO\":" . $newLine .
                                "{" . $newLine .
                                "alert('Atenção!\\n\\n' + response.Message.replace('#', '\\n'));" . $newLine .
                                "break;" . $newLine .
                                "}" . $newLine .
                                "case \"ERRO\":" . $newLine .
                                "{" . $newLine .
                                "alert('Atenção gerou um erro!\\n\\n' + response.Message);" . $newLine .
                                "jQuery(form).dialog(\"close\");" . $newLine .
                                "break;" . $newLine .
                                "}" . $newLine .
                                "}" . $newLine .
                                "});" . $newLine .
                                "}," . $newLine .
                                "\"Cancelar\":" . $newLine .
                                "function()" . $newLine .
                                "{" . $newLine .
                                "jQuery('#$jform_field').val('');" . $newLine .
                                "jQuery(this).dialog(\"close\");" . $newLine .
                                "}" . $newLine .
                                "}," . $newLine .
                                "open: function()" . $newLine .
                                "{" . $newLine .
                                "jQuery('#$jform_field').focus();" . $newLine .
                                "}" . $newLine .
                                "});" . $newLine .
                                "});" . $newLine
                        );

        //$PATH_ADMIN_CSS = 'administrator/components/com_dga/assets/css/';
        //$PATH_ADMIN_JS = 'administrator/components/com_dga/assets/js/';

        /* -------- CSS -------- */
        //JHTML::stylesheet($PATH_ADMIN_CSS . 'smoothness/jquery-ui-1.9.2.custom.min.css');

        /* -------- JS -------- */
        //JHTML::script($PATH_ADMIN_JS . 'jquery.maskedinput-1.3.1.min.js');

        return '<a id="'.$buttonID.'" href="#" class="btn btn-small hasTooltip floated " style="vertical-align: top;" title="'.$title.'"><span class="icon-plus"></span></a>' .
                '<div id="'.$dialogDivID.'" style="display: none;">' .
                '<div class="form-horizontal">' .
                '<div class="control-group">' .
                '<div class="control-label">' .
                'Descrição:' .
                '</div>' .
                '<div class="controls">' .
                '<input type="text" title="" id="'.$jform_field.'" value="" maxlength="'.$maxlength.'" class="input-large hasTooltip" data-original-title="">' .
                '</div>' .
                '</div>' .
                '</div>' .
                '</div>';
    }
    
    public static function DialogAddMediunidadeControl($selectID)
    { 
        return JHtmlPlus::DialogAddFieldControl($selectID, 'mediunidade_cadastrar', 'descricao_med', 'Cadastrar nova Mediunidade', 50);
    }
    
    public static function DialogAddFalangeMissionariaControl($selectID)
    { 
        return JHtmlPlus::DialogAddFieldControl($selectID, 'falangemissionaria_cadastrar', 'descricao_flm', 'Cadastrar nova Falange Missionária', 100);
    }
    
    public static function DialogAddProfissaoControl($selectID)
    { 
        return JHtmlPlus::DialogAddFieldControl($selectID, 'profissao_cadastrar', 'descricao_pro', 'Cadastrar nova Profissão', 255);
    }
    
    public static function DialogAddNacionalidadeControl($selectID)
    { 
        return JHtmlPlus::DialogAddFieldControl($selectID, 'nacionalidade_cadastrar', 'descricao_nac', 'Cadastrar nova Nacionalidade', 100);
    }
    
    public static function DialogAddEstadoCivilControl($selectID)
    { 
        return JHtmlPlus::DialogAddFieldControl($selectID, 'estadocivil_cadastrar', 'descricao_etc', 'Cadastrar novo Estado Civil', 50);
    }
    
    public static function DialogAddOrgaoExpeditorControl($selectID)
    { 
        return JHtmlPlus::DialogAddFieldControl($selectID, 'orgaoexpeditor_cadastrar', 'descricao_oex', 'Cadastrar novo Orgão Expeditor', 100);
    }
    
    public static function DialogAddBairroControl($selectID, $keyfieldCid)
    { 
        return JHtmlPlus::DialogAddFieldControlBairro($selectID, 'bairro_cadastrar', 'nome_bai', 'id_cid', $keyfieldCid , 'Cadastrar novo Bairro', 255);
    }
    
    public static function DialogAddFieldControlBairro($selectID, $task, $field1, $field2, $keyfieldCid, $title, $maxlength = 100)
    {     
        $buttonID       = 'btnAdd'.$selectID;
        $dialogDivID    = 'dialogAdd'.$selectID;
        $jform_field1   = 'jform_'.$field1 .'_'. $selectID;
        $jform_field2   = $keyfieldCid;
        
        $newLine = "\r\n";
        
        $document = JFactory::getDocument();
        $document->addScriptDeclaration(
                                "window.addEvent('domready', function() {". $newLine .
                                "jQuery(\"#$buttonID\").click(function()" . $newLine .
                                "{" . $newLine .
                                "jQuery(\"#$dialogDivID\").dialog(\"open\");" . $newLine .
                                "});" . $newLine .
                                "jQuery(\"#$dialogDivID\").dialog({" . $newLine .
                                "autoOpen: false," . $newLine .
                                "modal: true," . $newLine .
                                "width: 460," . $newLine .
                                "height: 170," . $newLine .
                                "resizable: false," . $newLine .
                                "title: '$title'," . $newLine .
                                "show: \"scale\"," . $newLine .
                                "hide: \"puff\"," . $newLine .
                                "buttons: {" . $newLine .
                                "\"Cadastrar\":" . $newLine .
                                "function()" . $newLine .
                                "{" . $newLine .
                                "var form = this;" . $newLine .
                                "var url = \"".JURI::root()."administrator/index.php?option=com_dga&task=$task&format=raw\";" . $newLine .
                                "jQuery.post(url," . $newLine .
                                "{" . $newLine .
                                "'$field1': jQuery('#$jform_field1').val()," . $newLine .
                                "'$field2': jQuery('#$jform_field2').val()," . $newLine .
                                "'dataType': 'json'" . $newLine .
                                "}," . $newLine .
                                "function(data)" . $newLine .
                                "{" . $newLine .
                                "var response  = jQuery.parseJSON(data.trim());" . $newLine .
                                "" . $newLine .
                                "switch(response.Status)" . $newLine .
                                "{" . $newLine .
                                "case \"OK\":" . $newLine .
                                "{" . $newLine .
                                "jQuery(form).effect('transfer', {to: jQuery('#jform_".$selectID."_chzn'), className: \"ui-effects-transfer\"}, 500, function()" . $newLine .
                                "{" . $newLine .
                                "jQuery(\"#jform_$selectID\").html(response.Result);" . $newLine .
                                "jQuery(\"#jform_$selectID\").trigger(\"liszt:updated\");" . $newLine .
                                "jQuery('#$jform_field1').val('');" . $newLine .
                                "jQuery(form).dialog(\"close\");" . $newLine .
                                "});" . $newLine .
                                "break;" . $newLine .
                                "}" . $newLine .
                                "case \"OBRIGATORIO\":" . $newLine .
                                "{" . $newLine .
                                "alert('Atenção!\\n\\n' + response.Message.replace('#', '\\n'));" . $newLine .
                                "break;" . $newLine .
                                "}" . $newLine .
                                "case \"ERRO\":" . $newLine .
                                "{" . $newLine .
                                "alert('Atenção gerou um erro!\\n\\n' + response.Message);" . $newLine .
                                "jQuery(form).dialog(\"close\");" . $newLine .
                                "break;" . $newLine .
                                "}" . $newLine .
                                "}" . $newLine .
                                "});" . $newLine .
                                "}," . $newLine .
                                "\"Cancelar\":" . $newLine .
                                "function()" . $newLine .
                                "{" . $newLine .
                                "jQuery('#$jform_field1').val('');" . $newLine .
                                "jQuery(this).dialog(\"close\");" . $newLine .
                                "}" . $newLine .
                                "}," . $newLine .
                                "open: function()" . $newLine .
                                "{" . $newLine .
                                "jQuery('#$jform_field1').focus();" . $newLine .
                                "}" . $newLine .
                                "});" . $newLine .
                                "});" . "\r\n"
                        );

        //$PATH_ADMIN_CSS = 'administrator/components/com_dga/assets/css/';
        //$PATH_ADMIN_JS = 'administrator/components/com_dga/assets/js/';

        /* -------- CSS -------- */
        //JHTML::stylesheet($PATH_ADMIN_CSS . 'smoothness/jquery-ui-1.9.2.custom.min.css');

        /* -------- JS -------- */
        //JHTML::script($PATH_ADMIN_JS . 'jquery.maskedinput-1.3.1.min.js');

        return '<a id="'.$buttonID.'" href="#" class="btn btn-small hasTooltip floated " style="vertical-align: top;" title="'.$title.'"><span class="icon-plus"></span></a>' .
                '<div id="'.$dialogDivID.'" style="display: none;">' .
                '<div class="form-horizontal">' .
                '<div class="control-group">' .
                '<div class="control-label">' .
                'Descrição:' .
                '</div>' .
                '<div class="controls">' .
                '<input type="text" title="" id="'.$jform_field1.'" value="" maxlength="'.$maxlength.'" class="input-large hasTooltip" data-original-title="">' .
                '</div>' .
                '</div>' .
                '</div>' .
                '</div>';
    }
    
    public static function DialogAddCidadeControl($selectIDCidade, $selectIDBairro, $id_est_field)
    { 
        return JHtmlPlus::DialogAddFieldControlCidade($selectIDCidade, 
                                                       $selectIDBairro,
                                                       $id_est_field);
    }
    
    public static function DialogAddFieldControlCidade($selectIDCidade, 
                                                       $selectIDBairro,
                                                       $id_est_field)
    {     
        $buttonID       = 'btnAdd'.$selectIDCidade;
        $dialogDivID    = 'dialogAdd'.$selectIDCidade;
        $task           = 'cidade_cadastrar';
        $title          ='Cadastrar nova Cidade e Bairro'; 
        $jform_field1   = 'jform_nome_cid_'. $selectIDCidade;
        $jform_field2   = 'jform_nome_bai_'. $selectIDBairro;
        $jform_field3   = $id_est_field;
        $maxlength1     = 100;
        $maxlength2     = 255;
        
        $newLine = "\r\n";
        
        $document = JFactory::getDocument();
        $document->addScriptDeclaration(
                                "window.addEvent('domready', function() {". $newLine .
                                "jQuery(\"#$buttonID\").click(function()" . $newLine .
                                "{" . $newLine .
                                "jQuery(\"#$dialogDivID\").dialog(\"open\");" . $newLine .
                                "});" . $newLine .
                                "jQuery(\"#$dialogDivID\").dialog({" . $newLine .
                                "autoOpen: false," . $newLine .
                                "modal: true," . $newLine .
                                "width: 460," . $newLine .
                                "height: 220," . $newLine .
                                "resizable: false," . $newLine .
                                "title: '$title'," . $newLine .
                                "show: \"scale\"," . $newLine .
                                "hide: \"puff\"," . $newLine .
                                "buttons: {" . $newLine .
                                "\"Cadastrar\":" . $newLine .
                                "function()" . $newLine .
                                "{" . $newLine .
                                "var form = this;" . $newLine .
                                "var url = \"".JURI::root()."administrator/index.php?option=com_dga&task=$task&format=raw\";" . $newLine .
                                "jQuery.post(url," . $newLine .
                                "{" . $newLine .
                                "'nome_cid': jQuery('#$jform_field1').val()," . $newLine .
                                "'nome_bai': jQuery('#$jform_field2').val()," . $newLine .
                                "'id_est': jQuery('#$jform_field3').val()," . $newLine .
                                "'dataType': 'json'" . $newLine .
                                "}," . $newLine .
                                "function(data)" . $newLine .
                                "{" . $newLine .
                                "var response  = jQuery.parseJSON(data.trim());" . $newLine .
                                "" . $newLine .
                                "switch(response.Status)" . $newLine .
                                "{" . $newLine .
                                "case \"OK\":" . $newLine .
                                "{" . $newLine .
                                "jQuery(form).effect('transfer', {to: jQuery('#".$selectIDCidade."_chzn'), className: \"ui-effects-transfer\"}, 500, function()" . $newLine .
                                "{" . $newLine .
                                "jQuery(\"#$selectIDCidade\").html(response.Result1);" . $newLine .
                                "jQuery(\"#$selectIDCidade\").trigger(\"liszt:updated\");" . $newLine .
                                "jQuery(form).effect('transfer', {to: jQuery('#".$selectIDBairro."_chzn'), className: \"ui-effects-transfer\"}, 500, function()" . $newLine .
                                "{" . $newLine .
                                "jQuery(\"#$selectIDBairro\").html(response.Result2);" . $newLine .
                                "jQuery(\"#$selectIDBairro\").trigger(\"liszt:updated\");" . $newLine .
                                "jQuery('#$jform_field1').val('');" . $newLine .
                                "jQuery('#$jform_field2').val('');" . $newLine .
                                "jQuery(form).dialog(\"close\");" . $newLine .
                                "});" . $newLine .
                                "});" . $newLine .
                                "break;" . $newLine .
                                "}" . $newLine .
                                "case \"OBRIGATORIO\":" . $newLine .
                                "{" . $newLine .
                                "alert('Atenção!\\n\\n' + response.Message.replace('#', '\\n'));" . $newLine .
                                "break;" . $newLine .
                                "}" . $newLine .
                                "case \"ERRO\":" . $newLine .
                                "{" . $newLine .
                                "alert('Atenção gerou um erro!\\n\\n' + response.Message);" . $newLine .
                                "jQuery(form).dialog(\"close\");" . $newLine .
                                "break;" . $newLine .
                                "}" . $newLine .
                                "}" . $newLine .
                                "});" . $newLine .
                                "}," . $newLine .
                                "\"Cancelar\":" . $newLine .
                                "function()" . $newLine .
                                "{" . $newLine .
                                "jQuery('#$jform_field1').val('');" . $newLine .
                                "jQuery('#$jform_field2').val('');" . $newLine .
                                "jQuery(this).dialog(\"close\");" . $newLine .
                                "}" . $newLine .
                                "}," . $newLine .
                                "open: function()" . $newLine .
                                "{" . $newLine .
                                "jQuery('#$jform_field1').focus();" . $newLine .
                                "}" . $newLine .
                                "});" . $newLine .
                                "});" . "\r\n"
                        );

        //$PATH_ADMIN_CSS = 'administrator/components/com_dga/assets/css/';
        //$PATH_ADMIN_JS = 'administrator/components/com_dga/assets/js/';

        /* -------- CSS -------- */
        //JHTML::stylesheet($PATH_ADMIN_CSS . 'smoothness/jquery-ui-1.9.2.custom.min.css');

        /* -------- JS -------- */
        //JHTML::script($PATH_ADMIN_JS . 'jquery.maskedinput-1.3.1.min.js');

        return '<a id="'.$buttonID.'" href="#" class="btn btn-small hasTooltip floated " style="vertical-align: top;" title="'.$title.'"><span class="icon-plus"></span></a>' .
                '<div id="'.$dialogDivID.'" style="display: none;">' .
                '<div class="form-horizontal">' .
                '<div class="control-group">' .
                '<div class="control-label">' .
                'Cidade:' .
                '</div>' .
                '<div class="controls">' .
                '<input type="text" title="" id="'.$jform_field1.'" value="" maxlength="'.$maxlength1.'" class="input-large hasTooltip" data-original-title="">' .
                '</div>' .
                '</div>' .
                '<div class="control-group">' .
                '<div class="control-label">' .
                'Bairro:' .
                '</div>' .
                '<div class="controls">' .
                '<input type="text" title="" id="'.$jform_field2.'" value="" maxlength="'.$maxlength2.'" class="input-large hasTooltip" data-original-title="">' .
                '</div>' .
                '</div>' .
                '</div>' .
                '</div>';
    }
        
    public static function GetInstrutoresFromGrupo($id_grp)
    {
        $query = 'SELECT ins.nome_ins FROM #__dga_instrutores_grupos_ing AS ing'.
                 ' LEFT JOIN #__dga_instrutores_ins AS ins ON ins.id_ins = ing.id_ins'.
                 ' WHERE ing.id_grp='.$id_grp.' AND ins.id_ins NOT IN (SELECT id_ins FROM #__dga_grupos_grp AS grp WHERE grp.id_grp=ing.id_grp)'.
                 ' ORDER BY ins.nome_ins';

        return JHtmlPlus::getInstrutores($query);
    }
    public static function GetInstrutoresFromDesenvolvimento($id_asg)
    {
        $query = 'SELECT ins.nome_ins FROM #__dga_aspirantes_grupos_instrutores_agi AS agi'.
                 ' LEFT JOIN #__dga_instrutores_ins AS ins ON ins.id_ins = agi.id_ins'.
                 ' WHERE agi.id_asg='.$id_asg. ' AND ins.id_ins NOT IN (SELECT id_ins FROM #__dga_aspirantes_grupos_asg AS asg WHERE asg.id_asg=agi.id_asg)'.
                 ' ORDER BY ins.nome_ins';
              
        return JHtmlPlus::getInstrutores($query);
    }
    
    private static function getInstrutores($query)
    {
        $intrutores = array();

        $db = JFactory::getDbo();
        
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        if (!empty($items))
        {
                foreach ($items as $item)
                {
                    $intrutores[] = $item->nome_ins;
                }
        }

        $return = "";
        
        if(count($intrutores))
        {
           $return = "<br/>" . implode("<br/>", $intrutores);
        }
        
        return $return;
    }
    
    public static function MascaraNumeroFatura($numero)
    {
        return str_pad($numero, 6, '0', STR_PAD_LEFT);
    }
    
    public static function GetIdade($dataNascimento)
    {
        $idade = '';
        // Separa em dia, mês e ano
        //list($dia, $mes, $ano) = explode('/', $dataNascimento);
        list($ano, $mes, $dia) = explode('-', $dataNascimento);
        
        if($ano == '0000')
        {
            $idade = '';
        }
        else 
        {
           // Descobre que dia é hoje e retorna a unix timestamp
           $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
           // Descobre a unix timestamp da data de nascimento do fulano
           $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

           // Depois apenas fazemos o cálculo já citado :)
           $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);  
        }
        
        return $idade;
    }
    
    public static function SendEmail($from, $to, $subject, $body, $html = true, $cco = null)
    {
        $result = new JObject();
        $db = JFactory::getDbo();
        $date = JFactory::getDate();
        
        $dateNow = $date->toSql();
        
        $result->ID = 0;
        $result->Send = false;
        $result->Message = '';
        
        //
        // GRAVA EMAIL NO BANCO
        //       
        $html_eml = $html ? 1 : 0;
        
        $queryEmailInsert = "INSERT INTO `#__dga_emails_eml` (`date_eml`,`from_eml`,`to_eml`,`subject_eml`,`body_eml`,`html_eml`,`send_eml`,`message_eml`) VALUES " . 
                                                                        "('$dateNow','$from','$to','$subject','$body',$html_eml,null,null)";
        $db->setQuery($queryEmailInsert);
        $db->query();
        
        $id_eml = $db->insertid();
        
        $mailer = JFactory::getMailer();
        $config = JFactory::getConfig();

        $sender = array( 
                $config->get('mailfrom'),
                $config->get('fromname'));

        $mailer->setSender($sender);
        $mailer->addRecipient($to);
        
        if($cco != null)
        {
            $mailer->addBCC($cco);
        }
        
        $mailer->setSubject($subject);
        $mailer->isHTML($html);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
            
        $send = $mailer->Send();
    
        $result->ID = $id_eml;
        
        if($send == true)
        {
            $result->Send = true;
            $result->Message = 'Enviado com sucesso!';
        }
        else
        {
            $result->Send = false;
            $result->Message = 'E-mail não foi enviado!' . $send->message;
        }
        
        //
        // ALTERA O STATUS DO EMAIL
        //       
        $send_eml = $result->Send ? 1 : 0;
        
        $queryEmailUpdate = "UPDATE `#__dga_emails_eml` SET send_eml=$send_eml, message_eml='$result->Message' WHERE id_eml=$id_eml";
        $db->setQuery($queryEmailUpdate);
        $db->query();
        
        return $result;
    }
    
    public static function GetTable($query, $labelFields, $rowsFields, $caption = null, $totalRows = true)
    {
        $db = JFactory::getDbo();
        
        $db->setQuery($query);

        $rows = $db->loadObjectlist();
        
        $html = "<table style=\"border-collapse:collapse;text-align:left;\">\r\n";
        
        if($caption != null)
        {
            $html .= "<caption style=\"white-space:nowrap;background:0;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699',endColorstr='#00557F');background-color:#069;color:#FFF;font-size:15px;font-weight:700;border-bottom:1px solid #0070A8;\">";
            $html .= $caption;
            $html .= "</caption>";
        }
        
        $html .= "<thead>\r\n";
        $html .= "<tr style=\"padding:3px 10px;\">\r\n";
        
        foreach ($labelFields as $key => $labelField) 
        {       
            $html .= "<th style=\"background:0;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699',endColorstr='#00557F');background-color:#069;color:#FFF;font-size:15px;font-weight:700;border-left:1px solid #0070A8;\">";
            $html .= $labelField;
            $html .= "</th>\r\n";              
        }
                
        $html .= "</tr>\r\n";
        $html .= "</thead>\r\n";
        $html .= "<tbody>\r\n";

        foreach ($rows as $key => $value) 
        {       
            $html .= "<tr style=\"padding:3px 10px;\">\r\n";
           
            foreach ($rowsFields as $key => $rowsField) 
            {       
                $html .= "<td style=\"padding:3px 10px;color:#00557F;border:1px solid #E1EEF4;font-size:12px;font-weight:400;\">";
                $html .= $value->$rowsField;
                $html .= "</td>\r\n";        
            }
            
            $html .= "</tr>\r\n";               
        }
        
        $html .= "</tbody>\r\n";
        
        if($totalRows)
        {
            $html .= "<tfoot>";
            $html .= "<tr>";
            $html .= "<td colspan=\"".count($labelFields)."\">";
            $html .= "Total: " . count($rows);
            $html .= "</td>";
            $html .= "</tr>";
            $html .= "</tfoot>";
        }
        
        $html .= "</table>";
        
        return $html;
    }
    
    public static function GetTableCountAspirantesMediunidades($id_meds, $id_grp = 0, $returnTable = false, $caption = null)
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        $query->select('a.id_med AS id_med, COUNT(*) AS Total');
        $query->from('#__dga_aspirantes_asp AS a');
        $query->select('med.descricao_med AS descricao_med')
                ->join('LEFT', '#__dga_mediunidade_med AS med ON a.id_med = med.id_med');
        $query->join('LEFT', '#__dga_aspirantes_grupos_desenvolvimentos_agd AS agd ON agd.id_asp = a.id_asp');
        $query->join('LEFT', '#__dga_aspirantes_grupos_asg AS asg ON asg.id_agd = agd.id_agd');
        $query->where('a.published = 1');
        $query->where('agd.id_std = 1');
        $query->where('asg.id_sag = 1');
        
        if(((int)$id_grp) > 0)
        {
            $query->where('asg.id_grp = '. $id_grp); 
        }
        
        $query->where('a.id_med IN ('.implode(",", $id_meds).')');
        $query->group('a.id_med, med.descricao_med');
        $query->order('med.descricao_med');
        
        $db->setQuery($query);

        $rows = $db->loadObjectlist();
        
        if($returnTable)
        {           
            $html = "<table style=\"border-collapse:collapse;text-align:left;\">\r\n";
            
            if($caption != null)
            {
                $html .= "<caption style=\"white-space:nowrap;background:0;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699',endColorstr='#00557F');background-color:#069;color:#FFF;font-size:15px;font-weight:700;border-bottom:1px solid #0070A8;\">";
                $html .= $caption;
                $html .= "</caption>";
            }
            
            $html .= "<thead>\r\n";
            $html .= "<tr style=\"padding:3px 10px;\">\r\n";
            
            foreach ($rows as $key => $row) 
            {       
                $html .= "<th style=\"text-align:center;background:0;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699',endColorstr='#00557F');background-color:#069;color:#FFF;font-size:15px;font-weight:700;border-left:1px solid #0070A8;\">";
                $html .= $row->descricao_med;
                $html .= "</th>\r\n";              
            }
            
            $html .= "</tr>";
            $html .= "</thead>";
            $html .= "<tbody>";
            
            $html .= "<tr style=\"padding:3px 10px;\">\r\n";
                
            foreach ($rows as $key => $row) 
            {       
                $html .= "<td style=\"text-align:center;padding:3px 10px;color:#00557F;border:1px solid #E1EEF4;font-size:12px;font-weight:400;\">";
                $html .= $row->Total;
                $html .= "</td>\r\n";        
            }
                
            $html .= "</tr>\r\n";               
            
            $html .= "</tbody>";
            $html .= "</table>";
            
            return $html;
        }
        
        return $rows;
    }
    
    public static function GetDate($data, $withTime = false, $timezone = false)
    {
        $format = $withTime ? 'd/m/Y H:i:s' : 'd/m/Y';
        
        return date($format, strtotime($data . ($timezone == true ? ' -3 hours': '')));
    }
    
    public static function ConvertReal($valor)
    {
        return number_format($valor, 2,',','.');
    }
    

}


