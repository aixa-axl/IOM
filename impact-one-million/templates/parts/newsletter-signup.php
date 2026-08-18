<?php
/**
 * Newsletter signup markup (Stay Informed).
 *
 * Expects optional vars in scope (with defaults):
 * $heading, $body, $placeholder, $button_label, $privacy_note, $form_action, $image, $email_id
 *
 * Figma desktop: 634:21142
 *
 * @package Impact_One_Million
 */

if ( ! isset( $heading ) || ! $heading ) {
	$heading = __( 'Stay Informed', 'impact-one-million' );
}
if ( ! isset( $body ) || ! $body ) {
	$body = __( 'Get the latest news, campaign updates, and press releases delivered directly to your inbox. No spam — just the stories that matter.', 'impact-one-million' );
}
if ( ! isset( $placeholder ) || ! $placeholder ) {
	$placeholder = __( 'Your email address', 'impact-one-million' );
}
if ( ! isset( $button_label ) || ! $button_label ) {
	$button_label = __( 'Subscribe', 'impact-one-million' );
}
if ( ! isset( $privacy_note ) || ! $privacy_note ) {
	$privacy_note = __( 'We respect your privacy. Unsubscribe at any time.', 'impact-one-million' );
}
if ( ! isset( $form_action ) ) {
	$form_action = '';
}
if ( ! isset( $image ) ) {
	$image = null;
}
if ( empty( $email_id ) ) {
	$email_id = 'iom-newsletter-email';
}

$btn_class = 'inline-flex shrink-0 items-center justify-center rounded-btn bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
?>

<section class="bg-[#dfe8ff] px-10 py-gutter lg:px-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10 lg:flex-row lg:gap-20">
		<div class="flex w-full max-w-[37.5rem] flex-col items-start gap-10">
			<div class="flex w-full flex-col gap-4">
				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $body ) : ?>
					<p class="m-0 font-sans text-body leading-[1.2] text-ink">
						<?php echo esc_html( $body ); ?>
					</p>
				<?php endif; ?>
			</div>

			<form
				class="flex w-full flex-col gap-4"
				method="post"
				action="<?php echo $form_action ? esc_url( $form_action ) : '#'; ?>"
				<?php echo $form_action ? '' : 'onsubmit="return false;"'; ?>
			>
				<div class="flex w-full flex-col items-stretch gap-2.5 sm:flex-row sm:items-start">
					<label class="sr-only" for="<?php echo esc_attr( $email_id ); ?>"><?php echo esc_html( $placeholder ); ?></label>
					<input
						id="<?php echo esc_attr( $email_id ); ?>"
						type="email"
						name="email"
						required
						autocomplete="email"
						placeholder="<?php echo esc_attr( $placeholder ); ?>"
						class="w-full min-w-0 flex-1 border-0 bg-white px-3 py-3.5 font-sans text-body leading-[1.2] text-ink placeholder:text-muted focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-blue"
					>
					<button type="submit" class="<?php echo esc_attr( $btn_class ); ?>">
						<?php echo esc_html( $button_label ); ?>
					</button>
				</div>

				<?php if ( $privacy_note ) : ?>
					<p class="m-0 font-sans text-xs leading-normal text-ink">
						<?php echo esc_html( $privacy_note ); ?>
					</p>
				<?php endif; ?>
			</form>
		</div>

		<?php if ( $image ) : ?>
			<div class="relative h-[16rem] w-full shrink-0 overflow-hidden lg:h-[25rem] lg:w-[36.25rem]">
				<?php
				echo wp_get_attachment_image(
					(int) $image,
					'large',
					false,
					array(
						'class'   => 'absolute inset-0 size-full object-cover',
						'loading' => 'lazy',
						'alt'     => '',
					)
				);
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
