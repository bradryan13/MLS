<?php
add_shortcode( 'tb_contact', 'tb_contact_shortcode' );
function tb_contact_shortcode( $atts, $content = null, $code = "" ) {
	extract( shortcode_atts( array(
		'mailto' => get_option('tb_contact_email'),
		'title' => get_option('tb_contact_title')
	), $atts ) );
	global $post;
	if(isset($_POST['contact-submitted'])) {
		if(trim($_POST['contact-name']) === '') {
			$nameError = __('Please enter your name.', 'themeboy');
			$hasError = true;
		} else {
			$name = trim($_POST['contact-name']);
		}
	
		if(trim($_POST['contact-email']) === '')  {
			$emailError = __('Please enter your email address.', 'themeboy');
			$hasError = true;
		} else if (!is_valid_email($_POST['contact-email'])) {
			$emailError = __('You entered an invalid email address.', 'themeboy');
			$hasError = true;
		} else {
			$email = trim($_POST['contact-email']);
		}
	
		if(trim($_POST['contact-team']) != '')  {
			$team = trim($_POST['contact-team']);
		}
	
		if(trim($_POST['contact-comments']) === '') {
			$commentError = __('Please enter a message.', 'themeboy');
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['contact-comments']));
			} else {
				$comments = trim($_POST['contact-comments']);
			}
		}
		if(!isset($hasError)) {
			if (!isset($mailto) || ($mailto == '') ){
				$mailto = get_option('admin_email');
			}
			// mail to admin
			$subject = '['.get_bloginfo('namee').'] '.__('You\'ve received a new message from ', 'themeboy').$name;
			$body = __('Name:', 'themeboy')." $name \n\n".__('Email:', 'themeboy')." $email".($team != null ? "\n\n".__('Team:', 'themeboy')." $team" : '')." \n\n".__('Comments:', 'themeboy')." $comments";
			$headers = 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;
	
			mail($mailto, $subject, $body, $headers);
			
			// mail to sender
			$subject = get_option('tb_contact_thanks_subject');
			$body = get_option('tb_contact_thanks_email')."\n\n";
			$body = __('Name:', 'themeboy')." $name \n\n".__('Email:', 'themeboy')." $email".($team != null ? "\n\n".__('Team:', 'themeboy')." $team" : '')." \n\n".__('Comments:', 'themeboy')." $comments";
			$headers = 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;
	
			mail($email, $subject, $body, $headers);
			$emailSent = true;
		}
	
	}
	$output = '';
	if(isset($hasError) || isset($captchaError)) {
		$output .= '<p class="error">'.get_option('tb_contact_error_text').'<p>';
	}
	if(isset($emailSent) && $emailSent == true) {
		$output .= '<div class="thanks">
			<p>'.get_option('tb_contact_thanks_text').'</p>
		</div>';
	} else {
		$output .=
		'<form action="'.get_permalink().'" class="contactform" id="contactform" method="post">
			<label for="contact-name">'.__('Name', 'themeboy').'</label>
			<input type="text" name="contact-name" id="contact-name" value="'.(isset($_POST['contact-name']) ? $_POST['contact-name'] : '').'" class="required required-field" />
			'.(isset($nameError) && $nameError != '' ? '<span class="error">'.$nameError.'</span>' : '').'
			<label for="contact-email">'.__('Email', 'themeboy').'</label>
			<input type="text" name="contact-email" id="contact-email" value="'.(isset($_POST['contact-email']) ? $_POST['contact-email'] : '').'" class="required required-field email" />
			'.(isset($emailError) && $emailError != '' ? '<span class="error">'.$emailError.'</span>' : '').'
			<label for="contact-team">'.__('Team Name (optional)', 'themeboy').'</label>
			<input type="text" name="contact-team" id="contact-team" value="'.(isset($_POST['contact-team']) ? $_POST['contact-team'] : '').'" />
			<label for="contact-comments">'.__('Message', 'themeboy').'</label>
			<textarea name="contact-comments" id="contact-comments" rows="10" cols="30" class="required required-field">'.(isset($_POST['contact-comments']) ?
				(function_exists('stripslashes') ? stripslashes($_POST['contact-comments']) : $_POST['contact-comments']) : ''
			).'</textarea>
			'.(isset($commentError) && $commentError != '' ? '<span class="error">'.$commentError.'</span>' : '').'
			<span><input class="button" type="submit" value="'.__('Send email', 'themeboy').'" /></span>
			<input type="hidden" name="contact-submitted" id="contact-submitted" value="true" />
		</form>';
	}
	return $output;
}
?>