<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_article_single
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$sufixo = '';
if ($params->get('moduleclass_sfx')) {
    $sufixo = '-' . $params->get('moduleclass_sfx');
}
?>
<div id="article-home" class="article-home<?php echo $sufixo; ?>">
    <?php foreach ($article as $article): ?>
        <?php $images = json_decode($article->images);?>
        <div class="article-home">
            <div class="description">
                <?php if($images->image_intro): ?>
                    
                <div class="img-single-article">
                    <a href="<?php echo JRoute::_("index.php?Itemid={$link}"); ?>">
                        <span style="background-image: url('<?= $images->image_intro ?>');" ></span>
                    </a>
                </div>
                <?php endif; ?>
                <h1>
                <a href="<?php echo JRoute::_("index.php?Itemid={$link}"); ?>">
                    <?= $article->title ?>
                </a>
                </h1>
                <div class="text-description">
                <a href="<?php echo JRoute::_("index.php?Itemid={$link}"); ?>">
                    <?= $article->introtext ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script>
    jQuery('document').ready(function ($) {
        $(window).on('resize', function () {
            $('#article-home .img-single-article').height(parseInt($('#article-home .img-single-article').width()));
        }).trigger('resize');
    });
</script>