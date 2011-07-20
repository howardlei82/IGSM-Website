<?php $arjunaOptions = arjuna_get_options(); ?>
<div class="sidebarIcons">
	<?php if($arjunaOptions['sidebarButtons']['RSS']['enabled']) {
		if($arjunaOptions['sidebarButtons']['RSS']['extended']) {
			print '<div class="rssBtnExtended">';
				print '<a class="primary" href="' . get_bloginfo('rss2_url') . '"></a>';
				print '<div class="extended" id="rss-extended">';
					print '<ul>';
						if(is_category()) {
							$term = get_queried_object();
							print '<li><a href="' . get_category_feed_link($term->term_id) . '">' . sprintf(__('Posts in %s', 'Arjuna'), '<em>'.single_cat_title(NULL, false).'</em>') . '</a></li>';
							print '<li class="separator"></li>';
						} elseif(is_author()) {
							$author = get_queried_object();
							print '<li><a href="' . get_author_feed_link($author->ID) . '">' . sprintf(__('Posts by %s', 'Arjuna'), '<em>'.($author->display_name?$author->display_name:$author->nickname).'</em>') . '</a></li>';
							print '<li class="separator"></li>';
						} elseif(is_single()) {
							$post = get_queried_object();
							global $authordata;
							print '<li><a href="' . get_post_comments_feed_link($post->ID) . '">' . __('Post Comments', 'Arjuna') . '</a></li>';
							print '<li><a href="' . get_author_feed_link($post->post_author) . '">' . sprintf(__('Posts by %s', 'Arjuna'), '<em>'.($authordata->display_name?$authordata->display_name:$authordata->nickname).'</em>') . '</a></li>';
							print '<li class="separator"></li>';
						} elseif(is_search()) {
							$search = get_query_var('s');
							print '<li><a href="' . get_search_feed_link($search) . '">' . __('Search Results', 'Arjuna') . '</a></li>';
							print '<li class="separator"></li>';
						}
					
						print '<li><a href="' . get_bloginfo('rss2_url') . '">' . __('Latest Posts', 'Arjuna') . '</a></li>';
						print '<li><a href="' . get_bloginfo('comments_rss2_url') . '">' . __('Latest Comments', 'Arjuna') . '</a></li>';
					print '</ul>';
				print '</div>';
				print $arjunaOptions['sidebarButtons']['RSS']['label'];
			print '</div>';
		} else {
			?><a class="rssBtn" href="<?php bloginfo('rss2_url'); ?>"><?php
				print $arjunaOptions['sidebarButtons']['RSS']['label'];
			?></a><?php
		}
		
		
	} ?>
	<?php if($arjunaOptions['sidebarButtons']['twitter']['enabled']) {
		?><a class="twitterBtn" href="<?php print $arjunaOptions['sidebarButtons']['twitter']['URL']; ?>"><?php
			if(!empty($arjunaOptions['sidebarButtons']['twitter']['label'])) { 
				print $arjunaOptions['sidebarButtons']['twitter']['label'];
			} ?></a><?php
	} ?>
	<?php if($arjunaOptions['sidebarButtons']['facebook']['enabled']) {
		?><a class="facebookBtn" href="<?php print $arjunaOptions['sidebarButtons']['facebook']['URL']; ?>"><?php
			if(!empty($arjunaOptions['sidebarButtons']['facebook']['label'])) { 
				print $arjunaOptions['sidebarButtons']['facebook']['label'];
			} ?></a><?php
	} ?>
	<?php if($arjunaOptions['sidebarButtons']['linkedIn']['enabled']) {
		?><a class="linkedInBtn" href="<?php print $arjunaOptions['sidebarButtons']['linkedIn']['URL']; ?>"><?php
			if(!empty($arjunaOptions['sidebarButtons']['linkedIn']['label'])) { 
				print $arjunaOptions['sidebarButtons']['linkedIn']['label'];
			} ?></a><?php
	} ?>
</div>