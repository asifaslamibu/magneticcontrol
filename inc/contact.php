<?php
/**
 * Contact page form: posts to admin-post.php, emails the site contact address.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle a contact form submission, then redirect back with ?sent=1 or ?sent=0.
 */
function mc_handle_contact() {
	$back = wp_get_referer() ? wp_get_referer() : mc_page_url( 'contact' );
	$back = remove_query_arg( 'sent', $back );

	if ( ! isset( $_POST['mc_contact_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['mc_contact_nonce'] ) ), 'mc_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '0', $back ) . '#mc-contact-form' );
		exit;
	}

	// Honeypot: real visitors never fill this hidden field.
	if ( ! empty( $_POST['mc_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $back ) . '#mc-contact-form' );
		exit;
	}

	// Flood protection: at most 5 messages per IP per hour.
	$rate_key = 'mc_contact_' . md5( mc_client_ip() );
	$sent_count = (int) get_transient( $rate_key );
	if ( $sent_count >= 5 ) {
		wp_safe_redirect( add_query_arg( 'sent', '0', $back ) . '#mc-contact-form' );
		exit;
	}
	set_transient( $rate_key, $sent_count + 1, HOUR_IN_SECONDS );

	$field = function ( $key, $sanitize = 'sanitize_text_field' ) {
		return isset( $_POST[ $key ] ) ? call_user_func( $sanitize, wp_unslash( $_POST[ $key ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified above.
	};

	$name    = $field( 'mc_name' );
	$email   = $field( 'mc_email', 'sanitize_email' );
	$phone   = $field( 'mc_phone' );
	$company = $field( 'mc_company' );
	$subject = $field( 'mc_subject' );
	$message = $field( 'mc_message', 'sanitize_textarea_field' );

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'sent', '0', $back ) . '#mc-contact-form' );
		exit;
	}

	$body = implode( "\n", array_filter( array(
		'Name: ' . $name,
		'Email: ' . $email,
		$phone ? 'Phone: ' . $phone : '',
		$company ? 'Company: ' . $company : '',
		$subject ? 'Subject: ' . $subject : '',
		'',
		$message,
	), 'strlen' ) );

	$sent = wp_mail(
		mc_contact( 'email' ),
		/* translators: %s: subject or visitor name */
		sprintf( __( '[Website enquiry] %s', 'magneticcontrol' ), $subject ? $subject : $name ),
		$body,
		array( 'Reply-To: ' . $name . ' <' . $email . '>' )
	);

	wp_safe_redirect( add_query_arg( 'sent', $sent ? '1' : '0', $back ) . '#mc-contact-form' );
	exit;
}
add_action( 'admin_post_nopriv_mc_contact', 'mc_handle_contact' );
add_action( 'admin_post_mc_contact', 'mc_handle_contact' );
