<?php
/**
 * Layout: contact
 *
 * Get in touch — heading + intro + Fluent Forms shortcode embed.
 *
 * Fields: heading, intro, form_shortcode
 *
 * Figma desktop: 776:8680
 */

$heading        = get_sub_field( 'heading' );
$intro          = get_sub_field( 'intro' );
$form_shortcode = get_sub_field( 'form_shortcode' );

if ( ! $heading ) {
	$heading = __( 'Get in touch', 'impact-one-million' );
}

if ( ! $intro ) {
	$intro = __( 'We’d love to hear from you! Please complete this short form and a member of the team will be in touch shortly.', 'impact-one-million' );
}

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
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10">
		<?php if ( $heading ) : ?>
			<h1 class="m-0 w-full font-display text-headline leading-[1.2] text-blue lg:text-title lg:leading-[1.1] lg:tracking-[0.02em]">
				<?php echo esc_html( $heading ); ?>
			</h1>
		<?php endif; ?>

		<div class="flex w-full flex-col items-start gap-10 xl:flex-row xl:gap-[7.5rem]">
			<?php if ( $intro ) : ?>
				<?php echo iom_format_multiline_text( $intro, 'm-0 w-full max-w-[32.5rem] shrink-0 font-sans text-body leading-[1.2] text-muted' ); ?>
			<?php endif; ?>

			<div class="iom-contact-form min-w-0 w-full flex-1">
				<?php if ( $form_html ) : ?>
					<?php echo $form_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Fluent Forms markup ?>
				<?php elseif ( current_user_can( 'edit_pages' ) ) : ?>
					<p class="m-0 rounded-card border border-dashed border-[#dfe8ff] bg-off-white p-5 font-sans text-body leading-[1.2] text-muted">
						<?php if ( ! $form_shortcode ) : ?>
							<?php esc_html_e( 'Add a Fluent Forms shortcode in this Contact section (e.g. [fluentform id="1"]), then Update the page.', 'impact-one-million' ); ?>
						<?php elseif ( ! shortcode_exists( 'fluentform' ) ) : ?>
							<?php esc_html_e( 'Fluent Forms does not look active — check the plugin is installed and enabled.', 'impact-one-million' ); ?>
						<?php else : ?>
							<?php
							printf(
								/* translators: %s: shortcode value from CMS */
								esc_html__( 'Fluent Forms did not render for: %s — confirm the form ID exists and is published.', 'impact-one-million' ),
								esc_html( $form_shortcode )
							);
							?>
						<?php endif; ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
