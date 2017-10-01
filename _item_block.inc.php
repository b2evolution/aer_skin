<?php
/**
 * This is the template that displays the item block
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template (or other templates)
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/license.html}
 * @copyright (c)2003-2009 by Francois PLANQUE - {@link http://fplanque.net/}
 *
 * @package evoskins
 * @subpackage evopress
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $Item;

// Default params:
$params = array_merge( array(
		'feature_block'   => false,
		'content_mode'    => 'auto',		// 'auto' will auto select depending on $disp-detail
		'item_class'      => 'post',
		'image_size'      => 'fit-400x320'

	), $params );

?>
<div id="<?php $Item->anchor_id() ?>" class="<?php $Item->div_classes( $params ) ?>" lang="<?php $Item->lang() ?>">

	<?php
		$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)
	?>

	<?php
		if(	$Item->is_intro() )
		{	// Display edit link only if we're displaying an intro post:
			$Item->edit_link( array( // Link to backoffice for editing
					'before'    => '<div class="floatright">',
					'after'     => '</div>',
				) );
		}
	?>

	<div class="datecomrap">
		<div class="date">
		<?php
			if( (!$Item->is_intro()))
			{	// Display only if we're *not* displaying an intro post AND we want to see the date:
				$Item->issue_time( array(
						'before'      => '',
						'after'       => '',
						'time_format' => 'M',
					) );
			}
		?>
		<br />
		<?php
		if( (!$Item->is_intro()))
		{	// Display only if we're *not* displaying an intro post AND we want to see the date:
			$Item->issue_time( array(
					'before'      => '<span style="font-size:2em; font-weight:bold;">',
					'after'       => '</span>',
					'time_format' => 'd',
				) );
		}
		?>
		<br />
		<?php
		// Display only if we're *not* displaying an intro post AND we want to see the date:
			$Item->issue_time( array(
					'before'      => '',
					'after'       => '',
					'time_format' => 'Y',
				) );
		
		?>
		
		</div><!-- end date -->

		<!-- if you don't want the comment count left of the post, erase from here ... -->
		<div class="commy">
			<?php 
				// Link to comments, trackbacks, etc.:
				$Item->feedback_link( array(
						'type'             => 'comments',
						'status'           => 'published',
						'link_before'      => '<div class="count_comments">',
						'link_after'       => '</div>',
						'link_text_zero'   => ' 0 ',
						'link_text_one'    => '1',
						'link_text_more'   => '#',
						'link_anchor_zero' => '#',
						'link_anchor_one'  => '#',
						'link_anchor_more' => '#',
						'link_title'       => '#',
						'use_popup'        => false,
						'url'              => '#',
					) );
			?>
		</div><!-- end commy -->
		<!-- to here -->

	</div><!-- end datecomrap -->

	<div class="storywrap">
		<h3 class="storytitle"><?php $Item->title(); ?></h3>
		<?php
		// ---------------------- POST CONTENT INCLUDED HERE ----------------------
		skin_include( '_item_content.inc.php', $params );
		// Note: You can customize the default item feedback by copying the generic
		// /skins/_item_content.inc.php file into the current skin folder.
		// -------------------------- END OF POST CONTENT -------------------------
		
		$Item->more_link( array(
				'force_more'  => false,
				'before'      => '',
				'after'       => '',
				'link_text'   => 'Read more',
				'anchor_text' => '#',
				'disppage'    => '#',
				'format'      => 'htmlbody'
			) );
		
		// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
		skin_include( '_item_feedback.inc.php', array(
				'before_section_title' => '<h4>',
				'after_section_title'  => '</h4>',
			) );
		// Note: You can customize the default item feedback by copying the generic
		// /skins/_item_feedback.inc.php file into the current skin folder.
		// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
		?>
	
	</div><!-- end storywrap -->
</div>

<?php
	locale_restore_previous();	// Restore previous locale (Blog locale)
?>
