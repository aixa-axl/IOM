<?php
/**
 * Layout: newsletter_signup
 *
 * Stay Informed — heading + email form + image.
 *
 * Fields: heading, body, placeholder, button_label, privacy_note, form_action, image
 *
 * Figma desktop: 667:34753 (also 634:21142)
 */

$heading      = get_sub_field( 'heading' );
$body         = get_sub_field( 'body' );
$placeholder  = get_sub_field( 'placeholder' );
$button_label = get_sub_field( 'button_label' );
$privacy_note = get_sub_field( 'privacy_note' );
$form_action  = get_sub_field( 'form_action' );
$image        = get_sub_field( 'image' );
$email_id     = 'iom-newsletter-email-' . uniqid( '', false );

require locate_template( 'templates/parts/newsletter-signup.php' );
