<?php

// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );


// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php' );
// Note: You can customize the default HTML header by copying the generic
// /skins/_html_header.inc.php file into the current skin folder.
// -------------------------------- END OF HEADER --------------------------------


// ------------------------- BODY HEADER INCLUDED HERE --------------------------
skin_include( '_body_header.inc.php' );
// Note: You can customize the default BODY header by copying the generic
// /skins/_body_footer.inc.php file into the current skin folder.
// ------------------------------- END OF FOOTER --------------------------------

// Display message if no post:
display_if_empty();

?>
<div id="content" class="widecolumn">


<?php
	// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
	messages( array(
			'block_start' => '<div class="action_messages">',
			'block_end'   => '</div>',
		) );
	// --------------------------------- END OF MESSAGES ---------------------------------
?>

<?php
// Display message if no post:
display_if_empty();

while( $Item = & mainlist_get_item() )
{	// For each blog post, do everything below up to the closing curly brace "}"
	?>

	<?php
		$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)
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
	</div><!-- end datecomrap -->
	
	<div class="storywrap">
		<h3 class="storytitle"><?php $Item->title(); ?></h3>
		<div id="<?php $Item->anchor_id() ?>" class="post post<?php $Item->status_raw() ?>" lang="<?php $Item->lang() ?>">
			<?php
				// ---------------------- POST CONTENT INCLUDED HERE ----------------------
				skin_include( '_item_content.inc.php', array(
						'image_size'	=>	'fit-400x320',
					) );
				// Note: You can customize the default item feedback by copying the generic
				// /skins/_item_feedback.inc.php file into the current skin folder.
				// -------------------------- END OF POST CONTENT -------------------------
			?>
			<div class="meta">
				<?php
					$Item->author( array(
										'before'      => T_('Written by '),
									) );
					
					$Item->categories( array(
								'before'          => ' '.T_('in').' ',
								'after'           => '.',
								'include_main'    => true,
								'include_other'   => true,
								'include_external'=> true,
								'link_categories' => true,
							) );
					// List all tags attached to this post:
					$Item->tags( array(
							'before' =>         ' | '.T_('Tags').': ',
							'after' =>          ' ',
							'separator' =>      ', ',
						) );
					
					$Item->edit_link( array( // Link to backoffice for editing
							'before'    => '<div class="edit_link">',
							'after'     => '</div><div class="clear"></div>',
						) );
						
				?>
				
				
				<!-- Written by Joe in: <a rel="category tag" title="View all posts in Themes" href="http://thebuckmaker.com/preview/category/themes/">Themes</a> | Tags: <a rel="tag" href="http://thebuckmaker.com/preview/tag/links/">Links</a> <br>  -->
			</div>
		</div>
		
		<?php
		// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
		skin_include( '_item_feedback.inc.php', array(
				'before_section_title' => '<h2 class="comments">',
				'after_section_title'  => '</h2>'
			) );
		// Note: You can customize the default item feedback by copying the generic
		// /skins/_item_feedback.inc.php file into the current skin folder.
		// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
		?>
		
	</div>
	
<?php
	locale_restore_previous();	// Restore previous locale (Blog locale)
}
?>

</div>

<?php
	// ------------------------- SIDEBAR INCLUDED HERE --------------------------
	skin_include( '_sidebar.inc.php' );
	// Note: You can customize the default BODY footer by copying the
	// _body_footer.inc.php file into the current skin folder.
	// ----------------------------- END OF SIDEBAR -----------------------------
?>


	<?php 
// ------------------------- BODY FOOTER INCLUDED HERE --------------------------
skin_include( '_body_footer.inc.php' );
// Note: You can customize the default BODY footer by copying the
// _body_footer.inc.php file into the current skin folder.
// ------------------------------- END OF FOOTER --------------------------------

// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// Note: You can customize the default HTML footer by copying the
// _html_footer.inc.php file into the current skin folder.
// ------------------------------- END OF FOOTER --------------------------------
?>