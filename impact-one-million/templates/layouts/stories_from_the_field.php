<?php
/**
 * Layout: stories_from_the_field
 *
 * Quote card with portrait — image left (desktop) / top (mobile).
 *
 * Figma desktop: 606:11593 — Figma mobile: 671:40731
 */

$heading   = get_sub_field( 'heading' );
$quote     = get_sub_field( 'quote' );
$name      = get_sub_field( 'name' );
$role      = get_sub_field( 'role' );
$image_id  = get_sub_field( 'image' );
$show_cta  = (bool) get_sub_field( 'show_cta' );
$cta       = get_sub_field( 'cta' );

$theme_uri    = get_stylesheet_directory_uri();
$fallback     = $theme_uri . '/assets/images/stories-from-the-field/story.jpg';
$fallback_abs = get_stylesheet_directory() . '/assets/images/stories-from-the-field/story.jpg';

if ( ! $heading ) {
	$heading = __( 'Stories from the field', 'impact-one-million' );
}

if ( ! $quote ) {
	$quote = __( '"[Quote text placeholder. A impactful statement about how the programme changed a life or a business operation.]"', 'impact-one-million' );
}

if ( ! $name ) {
	$name = __( '[Name Placeholder]', 'impact-one-million' );
}

if ( ! $role ) {
	$role = __( '[Role/Location Placeholder]', 'impact-one-million' );
}

if ( ! is_array( $cta ) ) {
	$cta = array();
}

$btn_class = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$img_attrs = array(
	'class'    => 'absolute inset-0 size-full object-cover',
	'loading'  => 'lazy',
	'alt'      => $name ? $name : '',
);
?>

<section class="bg-[#f9fcff] px-page py-section xl:px-gutter lg:py-[100px]">
	<div class="mx-auto flex w-full max-w-site flex-col gap-12">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<article class="flex w-full flex-col overflow-hidden rounded-2xl bg-white lg:flex-row">
			<div class="relative h-[185px] w-full shrink-0 lg:h-auto lg:w-[549px] lg:self-stretch">
				<?php if ( $image_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						(int) $image_id,
						'large',
						false,
						$img_attrs
					);
					?>
				<?php elseif ( file_exists( $fallback_abs ) ) : ?>
					<img
						src="<?php echo esc_url( $fallback ); ?>"
						alt="<?php echo esc_attr( $name ); ?>"
						class="<?php echo esc_attr( $img_attrs['class'] ); ?>"
						loading="lazy"
						decoding="async"
					>
				<?php endif; ?>
			</div>

			<div class="flex flex-1 flex-col items-start justify-center gap-8 p-5 lg:p-16">
				<?php if ( $quote ) : ?>
					<blockquote class="m-0 font-display text-stat-label leading-[1.2] text-blue">
						<?php echo esc_html( $quote ); ?>
					</blockquote>
				<?php endif; ?>

				<?php if ( $name || $role ) : ?>
					<footer class="flex flex-col gap-1">
						<?php if ( $name ) : ?>
							<p class="m-0 font-display text-card-title leading-none text-ink">
								<?php echo esc_html( $name ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $role ) : ?>
							<p class="m-0 font-sans text-label leading-[1.5] text-muted">
								<?php echo esc_html( $role ); ?>
							</p>
						<?php endif; ?>
					</footer>
				<?php endif; ?>

				<?php if ( $show_cta && ! empty( $cta['url'] ) ) : ?>
					<?php
					iom_render_link(
						$cta,
						$btn_class,
						__( 'Learn more', 'impact-one-million' )
					);
					?>
				<?php endif; ?>
			</div>
		</article>
	</div>
</section>
