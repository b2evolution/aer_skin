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
<div id="content">
	
	<?php
		// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
		skin_include( '$disp$', array(
			) );
		// Note: you can customize any of the sub templates included here by
		// copying the matching php file into your skin directory.
		// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
		
	?>
	
</div>

<?php
	// ------------------------- SIDEBAR INCLUDED HERE --------------------------
	skin_include( '_sidebar.inc.php' );
	// Note: You can customize the default BODY footer by copying the
	// _body_footer.inc.php file into the current skin folder.
	// ----------------------------- END OF SIDEBAR -----------------------------
	 
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