<?php

/**
 * @subpackage	Cirrus Green v1.6 HM02J
 * @copyright	Copyright (C) 2010-2013 Hurricane Media - All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');
$LeftMenuOn = ($this->countModules('position-7'));
$RightMenuOn = ($this->countModules('position-6'));
$TopNavOn = ($this->countModules('position-13'));
$app = JFactory::getApplication();
$sitename = $app->getCfg('sitename');
$logopath = $this->baseurl . '/templates/' . $this->template . '/images/logo-demo-green.gif';
$logo = $this->params->get('logo', $logopath);
$logoimage = $this->params->get('logoimage');
$sitetitle = $this->params->get('sitetitle');
$sitedescription = $this->params->get('sitedescription');
?>

<?php
$app = JFactory::getApplication();
$menu = $app->getMenu();
$lang = JFactory::getLanguage();
if ($menu->getActive() == $menu->getDefault($lang->getTag())) {
    $home = 1;
    $backhome = 'class="home-article"';
} else {
    $home = 0;
    $backhome = '';
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <jdoc:include type="head" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/fontawesome-all.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
    <link href='//fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/sfhover.js"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery-1.11.3.js"></script>
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-24132529-40', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<body>
    <div id="home" class="section"></div>
    <div id="wrapper">
        <div id="header_wrap">

            <!-- Search -->
            <?php if ($this->countModules('position-0')) : ?>
                <div id="search_wrap">
                    <div id="search">
                        <jdoc:include type="modules" name="position-0" />
                    </div>
                </div>
            <?php endif; ?>

            <div id="header">

                <!-- Logo -->
                <div id="logo">

                    <?php if ($logo && $logoimage == 1) : ?>
                        <a href="<?= ($home == 1) ? '#home' : $this->baseurl ?>">
                            <img src="<?php echo htmlspecialchars($logo); ?>" alt="<?php echo $sitename; ?>" />
                        </a>
                    <?php endif; ?>
                    <?php if (!$logo || $logoimage == 0) : ?>

                        <?php if ($sitetitle) : ?>
                            <a href="<?php echo $this->baseurl ?>"><?php echo htmlspecialchars($sitetitle); ?></a><br />
                        <?php endif; ?>

                        <?php if ($sitedescription) : ?>
                            <div class="sitedescription"><?php echo htmlspecialchars($sitedescription); ?></div>
                        <?php endif; ?>

                    <?php endif; ?>

                </div>
                <div class="menutop">
                    <div id="topmenu_wrap">
                        <div id="topmenu">
                            <jdoc:include type="modules" name="position-1" />
                        </div>
                    </div>

                    <div class="gotomenu">
                        <div id="gotomenu">
                            <img src="images/menu.png" />
                        </div>
                    </div>
                    <div class="menuresp">
                        <jdoc:include type="modules" name="position-1" />
                    </div>
                </div>
            </div>
        </div>

        <!-- TopNav -->
        <?php if ($TopNavOn) : ?>
            <div id="topnav_wrap">
                <div id="topnav">
                    <jdoc:include type="modules" name="position-13" style="xhtml" />
                </div>
            </div>
        <?php endif; ?>

        <!-- Breadcrumbs -->
        <?php if ($this->countModules('position-2')) : ?>
            <div id="breadcrumbs">
                <div class="right-angle"></div>
                <jdoc:include type="modules" name="position-2" />
                <div class="left-angle"></div>
            </div>
        <?php endif; ?>

        <?php if ($this->countModules('position-12')) : ?>
            <div id="content-top">
                <jdoc:include type="modules" name="position-12" />
            </div>
        <?php endif; ?>

        <?php if ($this->countModules('position-5')) : ?>
            <div id="content-bottom">
                <div class="content-bottom">
                    <jdoc:include type="modules" name="position-5" />
                </div>
            </div>
        <?php endif; ?>


        <!-- Content/Menu Wrap -->
        <div id="content-menu_wrap_bg" <?php echo $backhome; ?>>
            <?php if ($home == 1) : ?>
                <div class="right-angle"></div>
                <div id="padecendo-no-paraiso" class="section">
                <?php endif; ?>
                <div id="content-menu_wrap">

                    <!-- Left Menu -->
                    <?php if ($LeftMenuOn) : ?>
                        <div id="leftmenu">
                            <jdoc:include type="modules" name="position-7" style="xhtml" />

                        </div>
                    <?php endif; ?>

                    <?php if ($this->countModules('position-4')) : ?>
                        <div id="padecendo">
                            <jdoc:include type="modules" name="position-4" style="xhtml" />
                        </div>
                    <?php endif; ?>


                    <!-- Contents -->
                    <?php
                    if ($LeftMenuOn and $RightMenuOn) :
                        $w = 'w1';
                    elseif ($LeftMenuOn or $RightMenuOn) :
                        $w = 'w2';
                    else :
                        $w = 'w3';
                    endif;
                    ?>
                    <div id="content-<?php echo $w; ?>">
                        <jdoc:include type="message" />
                        <jdoc:include type="component" />
                    </div>

                    <?php if ($home == 1) : ?>
                        <div id="noticias">
                            <a href="index.php/noticias" class="btn btn-noticias">Todas as notícias</a>
                        </div>
                    <?php endif; ?>


                    <!-- Right Menu -->
                    <?php if ($RightMenuOn) : ?>
                        <div id="rightmenu">
                            <jdoc:include type="modules" name="position-6" style="xhtml" />
                        </div>
                    <?php endif; ?>


                </div>
                <?php if ($home == 1) : ?>
                </div>
            <?php endif; ?>

            <!-- Content Footer -->
            <?php if ($this->countModules('position-3')) : ?>
                <div id="footer_wrap" <?php echo $backfooter; ?>>
                    <div id="<?= ($home == 1) ? 'clube-pecadoras' : 'footer' ?>" class="section">
                        <jdoc:include type="modules" name="position-3" style="xhtml" />
                    </div>
                </div>
            <?php endif; ?>

            <div class="left-angle <?= ($home == 0) ? 'branco' : '' ?>"></div>
        </div>




        <!-- Units -->
        <?php if ($this->countModules('position-8')) : ?>
            <div id="units_wrap">
                <div id="units">
                    <jdoc:include type="modules" name="position-8" />
                </div>
            </div>
        <?php endif; ?>


        <!-- Banner/Links -->

        <div id="box_wrap">
            <div id="box_placeholder">
                <?php if (
                    ($this->countModules('position-9')) ||
                    ($this->countModules('position-10')) ||
                    ($this->countModules('position-11'))
                ) : ?>
                    <div id="minhas-colunas" class="section">
                        <div id="box1">
                            <jdoc:include type="modules" name="position-9" style="xhtml" />
                        </div>
                        <div id="box2">
                            <jdoc:include type="modules" name="position-10" style="xhtml" />
                        </div>
                        <div id="box3">
                            <jdoc:include type="modules" name="position-11" style="xhtml" />
                        </div>
                    </div>
                <?php endif; ?>
                <div id="box4">
                    <jdoc:include type="modules" name="position-14" style="xhtml" />
                </div>
            </div>
        </div>


    </div>

    <!-- Page End -->
    <div id="copyright">
        <div class="copyrightint">
            Copyright &copy;<?php echo date('Y'); ?> <?php echo $sitename; ?> - Todos os direitos reservados
        </div>
    </div>
    <div class="sd">
        <a href="http://www.sdrummond.com.br" title="Sdrummond Tecnologia">
            <img src="images/sd.png" alt="Sdrummond Tecnologia" title="Sdrummond Tecnologia" />
        </a>
    </div>
    </div>



    <script>
        jQuery.noConflict();
        jQuery(function() {
            jQuery(window).on('resize', function() {
                var largura = jQuery(window).width();
                var altura = jQuery(window).height();

                var slide = altura * 0.5;

                jQuery('.slideshowck').css('height', slide);

                if (largura <= 1000) {
                    jQuery('#topmenu_wrap').hide();
                    jQuery("#topmenu_wrap").css('visibility', 'hidden');
                    jQuery('#topmenu').hide();
                    jQuery("#gotomenu").show();
                    jQuery('.gotomenu').css('visibility', 'visible');
                } else {
                    jQuery("#topmenu_wrap").show();
                    jQuery("#topmenu_wrap").css('visibility', 'visible');
                    jQuery('#topmenu').show();
                    jQuery('#gotomenu').hide();
                    jQuery('.menuresp').hide();
                    jQuery('.gotomenu').css('visibility', 'hidden');
                }

                if (largura <= 600) {
                    jQuery('.area_cliente_login img').attr("src", '<?php echo JURI::base(); ?>/images/loginsmall.png');
                    jQuery('.area_cliente_logout img').attr("src", '<?php echo JURI::base(); ?>/images/logoutsmall.png');
                } else {
                    jQuery('.area_cliente_login img').attr("src", '<?php echo JURI::base(); ?>/images/login.png');
                    jQuery('.area_cliente_logout img').attr("src", '<?php echo JURI::base(); ?>/images/logout.png');
                }

                var menu = jQuery('#header_wrap').height();

                jQuery('#header_wrap').next().css("margin-top", menu);

                if (largura <= 590) {
                    jQuery('.custom-endereco iframe').css("pointer-events", "none");
                } else {
                    jQuery('.custom-endereco iframe').css("pointer-events", "auto");
                }

                /**** PADDING PARA MENU ****/
                var menuH = jQuery('#header_wrap').height();
                jQuery("#bebel-soares, #livros, #padecendo-no-paraiso, #clube-pecadoras, #minhas-colunas, #fale-comigo").css('padding-top', menuH + 40);
                jQuery("#bebel-soares, #livros, #padecendo-no-paraiso, #clube-pecadoras, #minhas-colunas, #fale-comigo").css('margin-top', (menuH) * (-1));
                /**** FIM PADDING PARA MENU ****/



                /**** SCROLL MENU SLOW****/
                var itemMenuId = '';
                jQuery('#topmenu a, #logo a').click(function() {
                    itemMenuId = jQuery(this).attr('href');
                    var alvo = jQuery(this).attr('href').split('#').pop();
                    jQuery('html, body').animate({
                        scrollTop: jQuery('#' + alvo).offset().top
                    }, 500);
                    if (jQuery(this).parent('div').attr('id') == 'logo') {
                        jQuery('#topmenu .menu-home').find('a').parent('li').removeClass('active');
                    }
                    return false;
                });
                /**** FIM SCROLL MENU SLOW ****/

                var sections = jQuery('div.section'),
                    nav = jQuery('#topmenu .menu-home'),
                    nav_resp = jQuery('.menuresp .menu-home'),
                    nav_height = nav.outerHeight();

                jQuery(window).on('scroll', function() {
                    var cur_pos = jQuery(this).scrollTop();

                    sections.each(function() {
                        var top = jQuery(this).offset().top,
                            bottom = top + jQuery(this).outerHeight();

                        if (cur_pos >= top && cur_pos <= bottom) {
                            nav.find('a').parent('li').removeClass('active');
                            nav.find('a[href="#' + jQuery(this).attr('id') + '"]').parent('li').addClass('active');
                            nav_resp.find('a').parent('li').removeClass('active');
                            nav_resp.find('a[href="#' + jQuery(this).attr('id') + '"]').parent('li').addClass('active');
                        }
                    });
                });
                /**** FIM EFEITO MENU ****/


                jQuery('.blog-noticias .img-intro-left').height(parseInt(jQuery('.blog-noticias .img-intro-left').width() * 0.75));

            }).trigger('resize');
        });

        jQuery('.menuresp').hide();

        jQuery("#gotomenu").click(function() {
            jQuery('.menuresp').css('visibility', 'visible');
            jQuery('.menuresp').slideToggle();
        });

        jQuery(document).ready(function($) {
            jQuery(".scroll").click(function(event) {
                event.preventDefault();
                jQuery('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 1000);
            });
        });
    </script>



</body>

</html>