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
?>

<section class="bg-white px-page py-10 lg:px-gutter lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10">
		<?php if ( $heading ) : ?>
			<h1 class="m-0 w-full font-display text-headline leading-[1.2] text-blue lg:text-title lg:leading-[1.1] lg:tracking-[0.02em]">
				<?php echo esc_html( $heading ); ?>
			</h1>
		<?php endif; ?>

		<div class="flex w-full flex-col items-start gap-10 lg:flex-row lg:gap-[7.5rem]">
			<?php if ( $intro ) : ?>
				<p class="m-0 w-full max-w-[32.5rem] shrink-0 font-sans text-body leading-[1.2] text-muted">
					<?php echo esc_html( $intro ); ?>
				</p>
			<?php endif; ?>

			<div class="iom-contact-form min-w-0 w-full flex-1">
				<?php if ( $form_shortcode ) : ?>
					<?php echo do_shortcode( $form_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- shortcode HTML from Fluent Forms ?>
				<?php elseif ( current_user_can( 'edit_pages' ) ) : ?>
					<p class="m-0 rounded-card border border-dashed border-[#dfe8ff] bg-off-white p-5 font-sans text-body leading-[1.2] text-muted">
						<?php esc_html_e( 'Add a Fluent Forms shortcode in this section (e.g. [fluentform id="1"]).', 'impact-one-million' ); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
