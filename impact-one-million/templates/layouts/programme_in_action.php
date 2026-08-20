<?php
/**
 * Layout: programme_in_action
 *
 * Story block — eyebrow, quote, body, CTAs + image.
 * Desktop: text left / image right. Mobile: image above text.
 *
 * Figma desktop: 606:11740 — Figma mobile: 677:41502
 */

$eyebrow       = get_sub_field( 'eyebrow' );
$heading       = get_sub_field( 'heading' );
$body          = get_sub_field( 'body' );
$image_id      = get_sub_field( 'image' );
$primary_cta   = get_sub_field( 'primary_cta' );
$secondary_cta = get_sub_field( 'secondary_cta' );

$theme_uri    = get_stylesheet_directory_uri();
$fallback     = $theme_uri . '/assets/images/programme-in-action/story.jpg';
$fallback_abs = get_stylesheet_directory() . '/assets/images/programme-in-action/story.jpg';

if ( ! $eyebrow ) {
	$eyebrow = __( 'Story: Mai & Linh', 'impact-one-million' );
}

if ( ! $heading ) {
	$heading = __( '“I finally felt like I knew what I was doing.”', 'impact-one-million' );
}

if ( ! $body ) {
	$body = __( 'Mai, a factory worker, struggled to balance her long shifts with caring for her daughter, Linh. Through our early development programme, she gained the tools to support Linh\'s learning at home.', 'impact-one-million' );
}

if ( ! is_array( $primary_cta ) || empty( $primary_cta['url'] ) ) {
	$primary_cta = array(
		'url'    => '#',
		'title'  => __( 'get involved', 'impact-one-million' ),
		'target' => '',
	);
}

if ( ! is_array( $secondary_cta ) || empty( $secondary_cta['url'] ) ) {
	$secondary_cta = array(
		'url'    => '#',
		'title'  => __( 'read more', 'impact-one-million' ),
		'target' => '',
	);
}

$btn_primary = 'inline-flex flex-1 items-center justify-center whitespace-nowrap rounded-btn border-[1.5px] border-solid border-transparent bg-accent-blue px-4 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90 lg:flex-none lg:px-6';
$btn_outline = 'inline-flex flex-1 items-center justify-center whitespace-nowrap rounded-btn border-[1.5px] border-solid border-navy px-4 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-80 lg:flex-none lg:px-6';

$img_attrs = array(
	'class'   => 'absolute inset-0 size-full rounded-card object-cover',
	'loading' => 'lazy',
	'alt'     => $eyebrow ? $eyebrow : '',
);
?>

<section class="bg-white px-page py-section xl:px-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-20 lg:flex-row lg:items-center lg:gap-[6.25rem]">
		<div class="relative aspect-[549/379] w-full shrink-0 overflow-hidden rounded-card lg:order-2 lg:h-[23.6875rem] lg:w-[34.3125rem] lg:aspect-auto">
			<?php if ( $image_id ) : ?>
				<?php echo wp_get_attachment_image( (int) $image_id, 'large', false, $img_attrs ); ?>
			<?php elseif ( file_exists( $fallback_abs ) ) : ?>
				<img
					src="<?php echo esc_url( $fallback ); ?>"
					alt="<?php echo esc_attr( $eyebrow ); ?>"
					class="<?php echo esc_attr( $img_attrs['class'] ); ?>"
					loading="lazy"
					decoding="async"
				>
			<?php endif; ?>
		</div>

		<div class="flex w-full flex-col gap-8 lg:order-1 lg:min-w-0 lg:flex-1">
			<div class="flex flex-col gap-3">
				<?php if ( $eyebrow ) : ?>
					<p class="m-0 font-display text-label uppercase tracking-[1px] text-accent">
						<?php echo esc_html( $eyebrow ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-stat-label leading-[1.2] text-blue">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $body ) : ?>
					<p class="m-0 font-sans text-body leading-[1.2] text-navy">
						<?php echo esc_html( $body ); ?>
					</p>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $primary_cta['url'] ) || ! empty( $secondary_cta['url'] ) ) : ?>
				<div class="flex w-full flex-nowrap items-stretch gap-3 lg:w-auto lg:items-start lg:gap-4">
					<?php
					if ( ! empty( $primary_cta['url'] ) ) {
						iom_render_link(
							$primary_cta,
							$btn_primary,
							__( 'get involved', 'impact-one-million' )
						);
					}
					if ( ! empty( $secondary_cta['url'] ) ) {
						iom_render_link(
							$secondary_cta,
							$btn_outline,
							__( 'read more', 'impact-one-million' )
						);
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
