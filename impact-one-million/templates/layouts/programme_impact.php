<?php
/**
 * Layout: programme_impact
 *
 * Navy band — rounded image + heading, 2×2 stat cards, CTA.
 * Desktop: image left / content right. Mobile: image top, then stats.
 *
 * Figma desktop: 637:24230 — Figma mobile: 677:42001
 */

$heading  = get_sub_field( 'heading' );
$image_id = get_sub_field( 'image' );
$stats    = get_sub_field( 'stats' );
$cta      = get_sub_field( 'cta' );

$theme_uri    = get_stylesheet_directory_uri();
$fallback     = $theme_uri . '/assets/images/programme-impact/impact.jpg';
$fallback_abs = get_stylesheet_directory() . '/assets/images/programme-impact/impact.jpg';

if ( ! $heading ) {
	$heading = __( 'Programme Impact', 'impact-one-million' );
}

if ( ! is_array( $stats ) || empty( $stats ) ) {
	$stats = array(
		array(
			'value' => '12,000+',
			'label' => __( 'Workers Reached', 'impact-one-million' ),
		),
		array(
			'value' => '85',
			'label' => __( 'Suppliers Enrolled', 'impact-one-million' ),
		),
		array(
			'value' => '40%',
			'label' => __( 'Average Wage Increase', 'impact-one-million' ),
		),
		array(
			'value' => '23',
			'label' => __( 'Countries', 'impact-one-million' ),
		),
	);
}

if ( ! is_array( $cta ) || empty( $cta['url'] ) ) {
	$cta = array(
		'url'    => '#',
		'title'  => __( 'Join the Movement', 'impact-one-million' ),
		'target' => '',
	);
}

// Mobile: white outline. Desktop: solid white / navy text (per Figma).
$btn_class = 'inline-flex w-full max-w-[21.75rem] items-center justify-center rounded-btn border-[1.5px] border-solid border-white bg-transparent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90 lg:w-auto lg:max-w-none lg:border-0 lg:bg-white lg:text-navy';

$img_attrs = array(
	'class'   => 'absolute inset-0 size-full rounded-card object-cover',
	'loading' => 'lazy',
	'alt'     => $heading ? $heading : '',
);
?>

<section class="bg-navy px-page py-10 lg:p-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-stretch gap-20 lg:flex-row lg:items-center lg:gap-20">
		<div class="relative h-[12.625rem] w-full shrink-0 overflow-hidden rounded-card lg:h-[37.5rem] lg:min-w-0 lg:flex-1">
			<?php if ( $image_id ) : ?>
				<?php echo wp_get_attachment_image( (int) $image_id, 'large', false, $img_attrs ); ?>
			<?php elseif ( file_exists( $fallback_abs ) ) : ?>
				<img
					src="<?php echo esc_url( $fallback ); ?>"
					alt="<?php echo esc_attr( $heading ); ?>"
					class="<?php echo esc_attr( $img_attrs['class'] ); ?>"
					loading="lazy"
					decoding="async"
				>
			<?php endif; ?>
		</div>

		<div class="flex w-full flex-col items-center gap-10 lg:min-w-0 lg:flex-1 lg:items-start">
			<?php if ( $heading ) : ?>
				<h2 class="m-0 text-center font-display text-headline leading-[1.2] text-white lg:text-left">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( ! empty( $stats ) ) : ?>
				<ul class="m-0 grid w-full list-none grid-cols-2 gap-3 p-0 lg:gap-8">
					<?php foreach ( $stats as $stat ) : ?>
						<?php
						$value = isset( $stat['value'] ) ? $stat['value'] : '';
						$label = isset( $stat['label'] ) ? $stat['label'] : '';
						if ( ! $value && ! $label ) {
							continue;
						}
						?>
						<li class="flex flex-col items-center gap-2 rounded-card bg-white p-8">
							<?php if ( $value ) : ?>
								<p class="m-0 text-center font-display text-number leading-none text-navy">
									<?php echo esc_html( $value ); ?>
								</p>
							<?php endif; ?>
							<?php if ( $label ) : ?>
								<p class="m-0 text-center font-display text-label leading-[1.2] uppercase tracking-[1px] text-accent-blue">
									<?php echo esc_html( $label ); ?>
								</p>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ( ! empty( $cta['url'] ) ) : ?>
				<?php
				iom_render_link(
					$cta,
					$btn_class,
					__( 'Join the Movement', 'impact-one-million' )
				);
				?>
			<?php endif; ?>
		</div>
	</div>
</section>
