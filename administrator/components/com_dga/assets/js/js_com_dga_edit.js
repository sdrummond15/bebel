jQuery.fn.existsWithValue = function() 
{ 
    return this.length && this.val().length; 
}
jQuery(document).ready(function() 
{       
    jQuery('#uploadBtnDiv').click(function() 
    {
        jQuery('#jform_foto_asp').show();
        jQuery('#jform_foto_asp').focus();
        jQuery('#jform_foto_asp').click();
        jQuery('#jform_foto_asp').hide();
    });
    
    jQuery('#jform_foto_asp').change(function() 
    {
        renderFotoFile(this); 
    });
   
    jQuery('#jform_grupo_data_inicio').datepicker(
    {
      minDate: -0,
      prevText: '',
      nextText: '',
      maxDate: '+3M',
      firstDay: 1,
      showOn: "button",
      dateFormat: 'dd/mm/yy',
      onSelect: function(dateText, inst) 
      {
        jQuery('#jform_grupo_data_inicio').val(dateText);
      },
      showOptions: { direction: "up" }
    });
    
    jQuery("#jform_grupo_data_inicio").mask("99/99/9999");

    jQuery('#jform_dm_problema_saude_asp0, #jform_dm_problema_saude_asp1').live("click", function()
    {
        if(jQuery('input[id="jform_dm_problema_saude_asp0"]:checked').val())
        {
            jQuery('#controlsProblemaSaude').slideDown();
        }
        else
        {  
            jQuery('#controlsProblemaSaude').slideUp();
        }
    });
    
    jQuery('#jform_dm_acompanhamento_medico_asp0, #jform_dm_acompanhamento_medico_asp1').live("click", function()
    {
        if(jQuery('input[id="jform_dm_acompanhamento_medico_asp0"]:checked').val())
        {
            jQuery('#controlsAcompanhamentoMedico').slideDown();
        }
        else
        {  
            jQuery('#controlsAcompanhamentoMedico').slideUp();
        }
    });
    
    jQuery('#jform_id_med').change(function()
    {
        if(jQuery('#jform_id_med').val() == 2)
        {
            jQuery('#controlsDoutrinador').slideUp();
        }
        else
        {  
            jQuery('#controlsDoutrinador').slideDown();
        }
    });
});

function renderFotoFile(input) 
{
    rFilter = /^(image\/bmp|image\/cis-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x-cmu-raster|image\/x-cmx|image\/x-icon|image\/x-portable-anymap|image\/x-portable-bitmap|image\/x-portable-graymap|image\/x-portable-pixmap|image\/x-rgb|image\/x-xbitmap|image\/x-xpixmap|image\/x-xwindowdump)$/i;

    var imageTypeP = /image.*/;

    if (!input.files[0].type.match(imageTypeP)) 
    {
        return;
    }

    var reader = new FileReader();

    reader.readAsDataURL(input.files[0]);

    reader.onload = function (e) 
    {
        jQuery('#image_foto').attr('src', e.target.result);
    };
}