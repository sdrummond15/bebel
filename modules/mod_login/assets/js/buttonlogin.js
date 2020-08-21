//BOTAO LOGIN
jQuery(function () {

    jQuery('.form-login').hide();

    jQuery(".area_cliente_login").click(function () {
        jQuery('.form-login').css('visibility', 'visible');
        jQuery('.form-login').slideToggle();
    });

//BOTAO LOGOUT

    jQuery('.form-logout').hide();

    jQuery(".area_cliente_logout").click(function () {
        jQuery('.form-logout').css('visibility', 'visible');
        jQuery('.form-logout').slideToggle();
    });
    
    jQuery(window).on('resize', function () {
        var tela = jQuery(window).width();
        var searchW = jQuery('#search').width();
        var searchH = jQuery('#search').height();
        var right = (tela - searchW) / 2;
        jQuery('.form-login').css('right', right);
        jQuery('.form-login').css('top', searchH);
        jQuery('.form-logout').css('right', right);
        jQuery('.form-logout').css('top', searchH);
    });
});
