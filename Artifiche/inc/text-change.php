<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Artifiche
 */

/**
 * Change text for forgot password in site
 */
function login_error_message( $error ) {
	// check if that's the error you are looking for
	$username = trim( wp_unslash( $_POST['username'] ) );
	if ( ICL_LANGUAGE_CODE == 'en' ) {
		$pos = strpos( $error, 'Lost' );
		$pos1 = strpos( $error, 'password' );
		if (( is_int( $pos )) && (is_int( $pos1 ) )) {
			// its the right error so you can overwrite it
			$error = __( '<strong>Error</strong>: The password you entered for the username <strong>' . $username . '</strong> is incorrect.', 'artifiche' )
			. '<a href="' . wp_lostpassword_url() . '">' . __( ' Forgot your password ?', 'artifiche' ) . '</a>';
		}
		if ( $error == 'Unknown email address. Check again or try your username.' ) {
			$error = __( 'Unknown e-mail address. Please check again or try your username.', 'artifiche' );
		}
	}
	if ( ICL_LANGUAGE_CODE == 'de' ) {
		// commented because err in de is okay
		$pos  = strpos( $error, 'E-Mail-Adresse' );
		$pos1 = strpos( $error, 'eingegebene' );
		$pos2 = strpos( $error, 'Passwort' );
		$pos4 = strpos( $error, 'Lost' );
		$pos5 = strpos( $error, 'password' );
		if (( is_int( $pos ) && is_int( $pos1 ) && is_int( $pos2 ) ) || (is_int( $pos4 ) && is_int( $pos5 ))) {
			// its the right error so you can overwrite it
			$error = __( '<strong>Fehler</strong>: Das Passwort, das Sie für den Benutzernamen <strong>' . $username . '</strong> eingegeben haben, ist nicht korrekt.', 'artifiche' )
			. '<a href="' . wp_lostpassword_url() . '">' . __( ' Passwort vergessen?', 'artifiche' ) . '</a>';
		}
		if ( $error == 'Unbekannte E-Mail-Adresse. Überprüfe sie noch einmal oder versuche es mit deinem Benutzernamen.' ) {
			$error = __( 'Unbekannte E-Mail-Adresse. Bitte überprüfen Sie sie noch einmal oder versuchen Sie es mit Ihrem Benutzernamen.', 'artifiche' );
		}
	}
	return $error;
}
add_filter( 'login_errors', 'login_error_message' );



/**
 * Change the WordPress password hint text. Note: This won't change any password checking functionality.
 * Add this code to your child theme functions.php or via a custom plugin.
 */
function artf_change_password_hint( $hint_text ) {
	$change = __( 'Note: The password should be at least twelve characters long. To make it stronger, use upper and lower case letters, numbers, and special characters like ! " ? $ % ^ & ).', 'artifiche' );
	return $change;
}
add_filter( 'password_hint', 'artf_change_password_hint', 10, 1 );




/**
* Change validation text in delete account
*/
add_filter( 'gettext', 'artf_change_string', 10, 3 );
function artf_change_string( $translation, $text, $domain ) {
	$change_text = 'Empty Password.';
	if ( $text == $change_text ) {
		$translation = __( 'Please enter password.', 'artifiche' );
	}
	return $translation;
}
