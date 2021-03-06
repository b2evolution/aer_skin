<?php
/**
 * This is the template that displays the message user form
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template.
 * To display a feedback, you should call a stub AND pass the right parameters
 * For example: /blogs/index.php?disp=msgform&recipient_id=n
 * Note: don't code this URL by hand, use the template functions to generate it!
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/license.html}
 * @copyright (c)2003-2009 by Francois PLANQUE - {@link http://fplanque.net/}
 *
 * @package evoskins
 *
 * @todo dh> A user/blog might want to accept only mails from logged in users (fp>yes!)
 * @todo dh> For logged in users the From name and address should be not editable/displayed
 *           (the same as when commenting). (fp>yes!!!)
 * @todo dh> Display recipient's avatar?! fp> of course! :p
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $cookie_name, $cookie_email;

global $DB;
?>
<div class="datecomrap">
		<div class="date"></div>
		<div class="commy"></div>
</div>
<div class="storywrap">
<?php 
// Parameters
/* TODO: dh> params should get remembered, e.g. if somebody clicks on the
 *       login/logout link from the msgform page.
 *       BUT, for the logout link remembering it here is too late normally.. :/
 */
$redirect_to = param( 'redirect_to', 'string', '' ); // pass-through (hidden field)
$recipient_id = param( 'recipient_id', 'integer', '' );
$post_id = param( 'post_id', 'integer', '' );
$comment_id = param( 'comment_id', 'integer', '' );
$subject = param( 'subject', 'string', '' );


// User's preferred name or the stored value in her cookie (from commenting):
$email_author = '';
if( is_logged_in() )
{
	$email_author = $current_User->get_preferred_name();
}
if( ! strlen($email_author) && isset($_COOKIE[$cookie_name]) )
{
	$email_author = trim($_COOKIE[$cookie_name]);
}

// User's email address or the stored value in her cookie (from commenting):
$email_author_address = '';
if( is_logged_in() )
{
	$email_author_address = $current_User->email;
}
if( ! strlen($email_author_address) && isset($_COOKIE[$cookie_email]) )
{
	$email_author_address = trim($_COOKIE[$cookie_email]);
}

$recipient_User = NULL;
$Comment = NULL;


// Get the name of the recipient and check if he wants to receive mails through the message form


if( ! empty($recipient_id) )
{ // If the email is to a registered user get the email address from the users table
	$UserCache = & get_UserCache();
	$recipient_User = & $UserCache->get_by_ID( $recipient_id );

	if( $recipient_User )
	{
		if( empty($recipient_User->allow_msgform) )
		{ // should be prevented by UI
			echo '<p class="error">The user does not want to receive emails through the message form.</p>';
			return;
		}
		$recipient_name = $recipient_User->get('preferredname');
		$recipient_address = $recipient_User->get('email');
	}
}
elseif( ! empty($comment_id) )
{ // If the email is through a comment, get the email address from the comments table (or the linked member therein):

	// Load comment from DB:
	$row = $DB->get_row( '
		SELECT *
		  FROM T_comments
		 WHERE comment_ID = '.$comment_id, ARRAY_A );

	if( $row )
	{
		$Comment = new Comment( $row );

		if( $comment_author_User = & $Comment->get_author_User() )
		{ // Source comment is from a registered user:
			if( ! $comment_author_User->allow_msgform )
			{
				echo '<p class="error">The user does not want to get contacted through the message form.</p>'; // should be prevented by UI
				return;
			}
		}
		elseif( ! $Comment->allow_msgform )
		{ // Source comment is from an anonymou suser:
			echo '<p class="error">This commentator does not want to get contacted through the message form.</p>'; // should be prevented by UI
			return;
		}

		$recipient_name = $Comment->get_author_name();
		$recipient_address = $Comment->get_author_email();
	}
}

if( empty($recipient_address) )
{	// We should never have called this in the first place!
	// Could be that commenter did not provide an email, etc...
	echo 'No recipient specified!';
	return;
}

// Get the suggested subject for the email:
if( empty($subject) )
{ // no subject provided by param:
	if( ! empty($comment_id) )
	{
		$row = $DB->get_row( '
			SELECT post_title
			  FROM T_items__item, T_comments
			 WHERE comment_ID = '.$DB->quote($comment_id).'
			   AND post_ID = comment_post_ID' );

		if( $row )
		{
			$subject = T_('Re:').' '.sprintf( /* TRANS: Used as mail subject; %s gets replaced by an item's title */ T_( 'Comment on %s' ), $row->post_title );
		}
	}

	if( empty($subject) && ! empty($post_id) )
	{
		$row = $DB->get_row( '
				SELECT post_title
				  FROM T_items__item
				 WHERE post_ID = '.$post_id );
		if( $row )
		{
			$subject = T_('Re:').' '.$row->post_title;
		}
	}
}
?>

<!-- form to send email -->
<?php

$Form = new Form( $htsrv_url.'message_send.php' );
	$Form->begin_form( 'bCommentMessageSend' );

	$Form->add_crumb( 'newmessage' );
	if( !empty( $Blog ) )
	{
		$Form->hidden( 'blog', $Blog->ID );
	}
	$Form->hidden( 'recipient_id', $recipient_id );
	$Form->hidden( 'post_id', $post_id );
	$Form->hidden( 'comment_id', $comment_id );
	$Form->hidden( 'redirect_to', url_rel_to_same_host($redirect_to, $htsrv_url) );

	?>

	<fieldset>
		<div class="label"><label><?php echo T_('To')?>:</label></div>
		<div class="info"><strong><?php echo $recipient_name;?></strong></div>
	</fieldset>

	<?php
	// Note: we use funky field name in order to defeat the most basic guestbook spam bots:
	$Form->text( 'd', $email_author, 40, T_('From'), T_('Your name.'), 50, 'bComment' );
	$Form->text( 'f', $email_author_address, 40, T_('Email'), T_('Your email address. (Will <strong>not</strong> be displayed on this site.)'), 100, 'bComment' );
	$Form->text( 'g', $subject, 40, T_('Subject'), T_('Subject of email message.'), 255, 'bComment' );
	$Form->textarea( 'h', '', 15, T_('Message'), T_('Plain text only.'), 40, 'bComment' );

	$Plugins->trigger_event( 'DisplayMessageFormFieldset', array( 'Form' => & $Form,
		'recipient_ID' => & $recipient_id, 'item_ID' => $post_id, 'comment_ID' => $comment_id ) );

	$Form->begin_fieldset();
	?>
		<div class="input">
			<?php
			$Form->button_input( array( 'name' => 'submit_message_'.$recipient_id, 'class' => 'submit', 'value' => T_('Send message') ) );

			$Plugins->trigger_event( 'DisplayMessageFormButton', array( 'Form' => & $Form,
				'recipient_ID' => & $recipient_id, 'item_ID' => $post_id, 'comment_ID' => $comment_id ) );
			?>
		</div>
		<?php
	$Form->end_fieldset();
	?>

	<div class="clear"></div>

<?php
	$Form->end_form();
?>
</div>