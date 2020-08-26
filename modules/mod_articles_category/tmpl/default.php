<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="category-module-<?php echo $moduleclass_sfx; ?>">
	<div id="<?php echo $moduleclass_sfx; ?>" class="<?= $params->get('header_class') ?>">
		<?php if ($grouped) : ?>
			<?php foreach ($list as $group_name => $group) : ?>
				<div>
					<div class="mod-articles-category-group"><?php echo $group_name; ?></div>
					<div>
						<?php foreach ($group as $item) : ?>
							<div>
								<?php if ($params->get('link_titles') == 1) : ?>
									<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
										<?php echo $item->title; ?>
									</a>
								<?php else : ?>
									<?php echo $item->title; ?>
								<?php endif; ?>

								<?php if ($item->displayHits) : ?>
									<span class="mod-articles-category-hits">
										(<?php echo $item->displayHits; ?>)
									</span>
								<?php endif; ?>

								<?php if ($params->get('show_author')) : ?>
									<span class="mod-articles-category-writtenby">
										<?php echo $item->displayAuthorName; ?>
									</span>
								<?php endif; ?>

								<?php if ($item->displayCategoryTitle) : ?>
									<span class="mod-articles-category-category">
										(<?php echo $item->displayCategoryTitle; ?>)
									</span>
								<?php endif; ?>

								<?php if ($item->displayDate) : ?>
									<span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
								<?php endif; ?>

								<?php if ($params->get('show_introtext')) : ?>
									<p class="mod-articles-category-introtext">
										<?php echo $item->displayIntrotext; ?>
									</p>
								<?php endif; ?>

								<?php if ($params->get('show_readmore')) : ?>
									<p class="mod-articles-category-readmore">
										<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
											<?php if ($item->params->get('access-view') == false) : ?>
												<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
											<?php elseif ($readmore = $item->alternative_readmore) : ?>
												<?php echo $readmore; ?>
												<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
												<?php if ($params->get('show_readmore_title', 0) != 0) : ?>
													<?php echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit')); ?>
												<?php endif; ?>
											<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
												<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
											<?php else : ?>
												<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
												<?php echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit')); ?>
											<?php endif; ?>
										</a>
									</p>
								<?php endif; ?>
								</li>
							<?php endforeach; ?>
							</ul>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<?php foreach ($list as $key => $item) : ?>
							<div <?= ($key / 2 == 0) ? '' : 'class="livro-right"'; ?>>
								<?php if ($params->get('link_titles') == 1) : ?>
									<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
										<?php echo $item->title; ?>
									</a>
								<?php endif; ?>

								<?php
								$images = json_decode($item->images);
								if ($images->image_intro) : ?>
									<div class="img-intro-<?php echo htmlspecialchars($images->float_intro); ?>">
										<img <?= 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"' ?> src="<?= htmlspecialchars($images->image_intro) ?>" alt="<?= htmlspecialchars($images->image_intro_alt) ?>" />
									</div>
								<?php endif; ?>

								<?php if ($item->displayHits) : ?>
									<span class="mod-articles-category-hits">
										(<?php echo $item->displayHits; ?>)
									</span>
								<?php endif; ?>

								<?php if ($params->get('show_author')) : ?>
									<span class="mod-articles-category-writtenby">
										<?php echo $item->displayAuthorName; ?>
									</span>
								<?php endif; ?>

								<?php if ($item->displayCategoryTitle) : ?>
									<span class="mod-articles-category-category">
										(<?php echo $item->displayCategoryTitle; ?>)
									</span>
								<?php endif; ?>

								<?php if ($item->displayDate) : ?>
									<span class="mod-articles-category-date">
										<?php echo $item->displayDate; ?>
									</span>
								<?php endif; ?>

								<?php if ($params->get('show_introtext')) : ?>
									<div class="mod-articles-category-introtext">
										<?php echo $item->displayIntrotext; ?>
									</div>
								<?php endif; ?>

								<?php if ($params->get('show_readmore')) : ?>
									<p class="mod-articles-category-readmore">
										<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
											<?php if ($item->params->get('access-view') == false) : ?>
												<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
											<?php elseif ($readmore = $item->alternative_readmore) : ?>
												<?php echo $readmore; ?>
												<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
											<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
												<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
											<?php else : ?>
												<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
												<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
											<?php endif; ?>
										</a>
									</p>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
					</div>
				</div>