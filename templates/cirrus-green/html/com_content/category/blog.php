<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$cparams = JComponentHelper::getParams('com_media');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<section class="blog<?php echo $this->pageclass_sfx; ?>">
    <?php if ($this->params->get('show_page_heading') != 0 or $this->params->get('show_category_title')) : ?>
        <h1>
            <?php echo $this->escape($this->params->get('page_heading')); ?>
            <?php
            if ($this->params->get('show_category_title')) {

                echo '<span class="subheading-category">' . $this->category->title . '</span>';
            }
            ?>
        </h1>
    <?php endif; ?>

    <?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
        <div class="category-desc">
            <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
                <img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
            <?php endif; ?>
            <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                <?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
            <?php endif; ?>
            <div class="clr"></div>
        </div>
    <?php endif; ?>



    <?php $leadingcount = 0; ?>
    <?php if (!empty($this->lead_items)) : ?>
        <div class="items-leading">
            <?php foreach ($this->lead_items as &$item) : ?>
                <article class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? 'system-unpublished' : null; ?>">
                    <?php
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                    ?>
                </article>
                <?php
                $leadingcount++;
                ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php
    $introcount = (count($this->intro_items));
    ?>
    <?php if (!empty($this->intro_items)) : ?>

        <?php $countArticle = 0 ?>
        <?php foreach ($this->intro_items as $key => &$item) : ?>
            <?php
                $row = $countArticle % $this->columns;
                ?>
                <div class="items-row cols-<?php echo (int) $this->columns; ?> <?php echo 'row-' . $row; ?>" 
                style="width: calc(<?= ($this->columns > 0) ? 100 / $this->columns : 100 ?>% - 15px); 
                        margin-right: <?= ($row == $this->columns - 1) ? 0 : 30 ?>px;">
               
                    <?php
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                    ?>
                    <span class="row-separator"></span>
                </div>

            <?php $countArticle++; ?>
        <?php endforeach; ?>


    <?php endif; ?>

    <?php if (!empty($this->link_items)) : ?>

        <?php echo $this->loadTemplate('links'); ?>

    <?php endif; ?>


    <?php if (is_array($this->children[$this->category->id]) && count($this->children[$this->category->id]) > 0 && $this->params->get('maxLevel') != 0) : ?>
        <div class="cat-children">
            <h3>
                <?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?>
            </h3>
            <?php echo $this->loadTemplate('children'); ?>
        </div>
    <?php endif; ?>

    <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
        <div class="pagination">
            <?php //if ($this->params->def('show_pagination_results', 1)) : ?>
            <!--<p class="counter">-->
            <?php //echo $this->pagination->getPagesCounter(); ?>
            <!--</p>-->

            <?php //endif; ?>
            <?php echo $this->pagination->getPagesLinks(); ?>
        </div>
    <?php endif; ?>

</section>


