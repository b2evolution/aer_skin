<div id="rap">
	
	<div id="headmenu">
		<?php
			// Display container and contents:
			//<li class="headlip2">Pages:</li>
			skin_container( NT_('Page Top'), array(
					// The following params will be used as defaults for widgets included in this container:
					'block_start' => '<div class="$wi_class$">',
					'block_end' => '</div>',
					'block_display_title' => false,
					'list_start' => '<ul>',
					'list_end' => '</ul>',
					'item_start' => '<li>',
					'item_end' => '</li>',
				) );
		?>
	</div><!-- end headmenu -->

	<div id="header">
		<div id="headerleft">
			<h1><a href="<?php $Blog->disp('url'); ?>"><?php $Blog->disp('name'); ?></a></h1>
			<h2><?php $Blog->tagline(); ?></h2>
		</div><!-- end headerleft -->
		
		<div id="headerright">
			<a href="<?php $Blog->disp('rss_url'); ?>" title="GET MY FEED"></a>
		</div><!-- end headerright -->
	</div><!-- end header -->

	<div id="headmenu2">
		<?php
			// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
			// Display container and contents:
			//<li class="headlip">Custom Links:</li>
			skin_container( NT_('Menu'), array(
					// The following params will be used as defaults for widgets included in this container:
					'block_start' => '<div class="$wi_class$">',
					'block_end' => '</div>',
					'block_display_title' => false,
					'list_start' => '<ul>',
					'list_end' => '</ul>',
					'item_start' => '<li>',
					'item_end' => '</li>',
				) );
			// ----------------------------- END OF "Menu" CONTAINER -----------------------------
		?>
	</div><!-- end headmenu2 -->

