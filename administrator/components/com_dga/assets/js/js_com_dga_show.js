jQuery(document).ready(function() 
{       
    jQuery("#btnLiberar").click(function()
    {
        jQuery("#id_sag").val('2');
        jQuery("#task").val('aspirantesgrupo.alterstatus');
        jQuery("#dialogAcoes").dialog({title: 'Liberar Aspirante'});
        jQuery("#dialogAcoes").dialog("open");
    }); 
    
    jQuery("#btnCancelar").click(function()
    {
        jQuery("#id_sag").val('3');
        jQuery("#task").val('aspirantesgrupo.alterstatus');
        jQuery("#dialogAcoes").dialog({title: 'Cancelar Aspirante'});
        jQuery("#dialogAcoes").dialog("open");
    });
    
    jQuery("#dialogAcoes").dialog({
            autoOpen: false,
            modal: true,
            width: 460,
            height: 500,
            resizable: false,
            title: 'Liberar Aspirante',
            show: "scale",
            hide: "puff",
            buttons: {
                        "OK": 
                        function() 
                        {
                            jQuery("#data_liberado_asg").val(jQuery("#jform_data_liberado_asg").val());
                            jQuery("#observacoes_asg").val(jQuery("#jform_observacoes_asg").val());
                            jQuery("#data_inicio_asg").val(jQuery("#jform_data_inicio_asg").val());
                            jQuery("#id_grp").val(jQuery("#jform_id_grp").val());
                            jQuery('#adminForm').submit();
                            //jQuery(this).dialog("close");
                        },
                        "Cancelar": 
                        function() 
                        {
                            jQuery(this).dialog("close");
                        }
                    }
            });
            
    jQuery("#btnAddAula").click(function()
    {
        jQuery("#task").val('aspirantesgrupo.addaula');
        jQuery("#dialogAddAula").dialog("open");
    }); 
    
    jQuery("#dialogAddAula").dialog({
            autoOpen: false,
            modal: true,
            width: 460,
            height: 230,
            resizable: false,
            title: 'Adicionar Aula',
            show: "scale",
            hide: "puff",
            buttons: {
                        "OK": 
                        function() 
                        {
                            jQuery("#data_aula_als").val(jQuery("#jform_data_aula_als").val());
                            jQuery("#id_apr").val(jQuery("#jform_id_apr").val());
                            jQuery('#adminForm').submit();
                        },
                        "Cancelar": 
                        function() 
                        {
                            jQuery(this).dialog("close");
                        }
                    }
            });
});
