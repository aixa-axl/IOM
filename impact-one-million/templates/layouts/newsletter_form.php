<?php
/**
 * Layout: newsletter_form
 *
 * Subscribe / newsletter page — same two-column shell as Contact,
 * with a Fluent Forms shortcode embed (temporary until Mailchimp URL is ready).
 *
 * Fields: heading, intro, form_shortcode
 */

$heading        = get_sub_field( 'heading' );
$intro          = get_sub_field( 'intro' );
$form_shortcode = get_sub_field( 'form_shortcode' );

$form_shortcode = is_string( $form_shortcode ) ? trim( $form_shortcode ) : '';
$form_shortcode = $form_shortcode ? html_entity_decode( $form_shortcode, ENT_QUOTES, 'UTF-8' ) : '';
$form_shortcode = $form_shortcode ? trim( wp_strip_all_tags( $form_shortcode ) ) : '';

// Allow pasting either `[fluentform id="1"]` or just `1`.
$form_id = 0;
if ( $form_shortcode && ctype_digit( $form_shortcode ) ) {
	$form_id        = (int) $form_shortcode;
	$form_shortcode = '[fluentform id="' . $form_id . '"]';
} elseif ( $form_shortcode && preg_match( '/id=["\']?(\d+)["\']?/i', $form_shortcode, $matches ) ) {
	$form_id = (int) $matches[1];
	if ( false === strpos( $form_shortcode, '[' ) ) {
		$form_shortcode = '[fluentform id="' . $form_id . '"]';
	}
}

$form_html = '';
if ( $form_shortcode ) {
	if ( shortcode_exists( 'fluentform' ) ) {
		$form_html = do_shortcode( $form_shortcode );
	} elseif ( $form_id && function_exists( 'fluentForm' ) ) {
		ob_start();
		fluentForm( $form_id );
		$form_html = ob_get_clean();
	}
}
?>

<section class="bg-white px-page py-10 xl:px-gutter lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10 xl:flex-row xl:gap-[7.5rem]">
		<div class="flex w-full max-w-[32.5rem] shrink-0 flex-col items-start gap-10">
			<?php if ( $heading ) : ?>
				<h1 class="m-0 w-full font-display text-headline leading-[1.2] text-blue lg:text-title lg:leading-[1.1] lg:tracking-[0.02em]">
					<?php echo esc_html( $heading ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( $intro ) : ?>
				<?php echo iom_format_multiline_text( $intro, 'm-0 w-full font-sans text-body leading-[1.2] text-muted' ); ?>
			<?php endif; ?>
		</div>

		<div class="iom-contact-form min-w-0 w-full flex-1">
			<?php if ( $form_html ) : ?>
				<?php echo $form_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Fluent Forms markup ?>
			<?php endif; ?>
		</div>
	</div>
</section>
