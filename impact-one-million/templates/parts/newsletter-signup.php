<?php
/**
 * Newsletter signup markup (Stay Informed).
 *
 * Expects optional vars in scope (with defaults):
 * $heading, $body, $placeholder, $button_label, $privacy_note, $form_action, $image, $email_id
 *
 * Form posts to Mailchimp when Form Action URL is set (layout/post override, else Theme Settings).
 *
 * Figma desktop: 667:34753 / 634:21142
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
if ( empty( $form_action ) && function_exists( 'iom_get_newsletter_form_action' ) ) {
	$form_action = iom_get_newsletter_form_action();
}
if ( empty( $form_action ) ) {
	$form_action = '';
}
if ( ! isset( $image ) ) {
	$image = null;
}
if ( empty( $email_id ) ) {
	$email_id = 'iom-newsletter-email';
}

$theme_uri    = get_stylesheet_directory_uri();
$fallback_uri = $theme_uri . '/assets/images/newsletter/stay-informed.jpg';
$fallback_abs = get_stylesheet_directory() . '/assets/images/newsletter/stay-informed.jpg';
$has_fallback = file_exists( $fallback_abs );

$is_mailchimp = (bool) $form_action && false !== strpos( $form_action, 'list-manage.com' );

// Mailchimp honeypot: b_{u}_{id}
$honeypot_name = '';
if ( $is_mailchimp ) {
	$query  = wp_parse_url( $form_action, PHP_URL_QUERY );
	$params = array();
	if ( is_string( $query ) ) {
		parse_str( $query, $params );
	}
	if ( ! empty( $params['u'] ) && ! empty( $params['id'] ) ) {
		$honeypot_name = 'b_' . $params['u'] . '_' . $params['id'];
	}
}

$btn_class = 'inline-flex shrink-0 items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
?>

<section class="bg-[#dfe8ff] px-page py-gutter xl:px-gutter">
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
				class="relative flex w-full flex-col gap-4"
				method="post"
				action="<?php echo $form_action ? esc_url( $form_action ) : '#'; ?>"
				<?php echo $form_action ? ( $is_mailchimp ? 'target="_blank" novalidate' : '' ) : 'onsubmit="return false;"'; ?>
			>
				<div class="flex w-full flex-col items-stretch gap-2.5 sm:flex-row sm:items-start">
					<label class="sr-only" for="<?php echo esc_attr( $email_id ); ?>"><?php echo esc_html( $placeholder ); ?></label>
					<input
						id="<?php echo esc_attr( $email_id ); ?>"
						type="email"
						name="EMAIL"
						value=""
						required
						autocomplete="email"
						placeholder="<?php echo esc_attr( $placeholder ); ?>"
						class="w-full min-w-0 flex-1 border-0 bg-white px-3 py-3.5 font-sans text-body leading-[1.2] text-ink placeholder:text-muted focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-blue"
					>
					<button type="submit" name="subscribe" class="<?php echo esc_attr( $btn_class ); ?>">
						<?php echo esc_html( $button_label ); ?>
					</button>
				</div>

				<?php if ( $honeypot_name ) : ?>
					<div class="absolute -left-[5000px]" aria-hidden="true">
						<input type="text" name="<?php echo esc_attr( $honeypot_name ); ?>" tabindex="-1" value="" autocomplete="off">
					</div>
				<?php endif; ?>

				<?php if ( $privacy_note ) : ?>
					<p class="m-0 font-sans text-xs leading-normal text-ink">
						<?php echo esc_html( $privacy_note ); ?>
					</p>
				<?php endif; ?>
			</form>
		</div>

		<?php if ( $image || $has_fallback ) : ?>
			<div class="relative h-[16rem] w-full shrink-0 overflow-hidden lg:h-[25rem] lg:w-[36.25rem]">
				<?php if ( $image ) : ?>
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
				<?php else : ?>
					<img
						src="<?php echo esc_url( $fallback_uri ); ?>"
						alt=""
						width="580"
						height="400"
						class="absolute inset-0 size-full object-cover"
						loading="lazy"
						decoding="async"
					>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
