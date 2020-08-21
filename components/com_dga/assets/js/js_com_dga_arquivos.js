function download(filekey)
{
    jQuery('#filekey').val(filekey);
    jQuery('#adminForm').submit();

    return false;
}

