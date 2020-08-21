jQuery(document).ready(function() 
{   
    jQuery("[type='checkbox']").bootstrapSwitch();
    
    jQuery('#uploadBtnDiv').click(function() 
    {
        jQuery('#jform_filename_doc').show();
        jQuery('#jform_filename_doc').focus();
        jQuery('#jform_filename_doc').click();
        jQuery('#jform_filename_doc').hide();
    });
    
    jQuery('#jform_filename_doc').change(function() 
    {
        document.getElementById("jform_uploadFile").value = this.value;
    });
});