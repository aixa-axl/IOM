<?php
/**
 * Layout: hero
 *
 * ACF layout name: hero
 * Fields: background_image (ID), logo (ID), heading, primary_cta (link), secondary_cta (link)
 *
 * Figma desktop: 606:17106 — Figma mobile: 671:40553
 */

$background_image = get_sub_field( 'background_image' );
$logo_id          = get_sub_field( 'logo' );
$heading          = get_sub_field( 'heading' );
$primary_cta      = get_sub_field( 'primary_cta' );
$secondary_cta    = get_sub_field( 'secondary_cta' );

$default_logo_uri = get_stylesheet_directory_uri() . '/assets/images/impact-one-million-logo.png';
$default_logo_abs = get_stylesheet_directory() . '/assets/images/impact-one-million-logo.png';
$has_default_logo = file_exists( $default_logo_abs );

$btn_primary = 'inline-flex w-full items-center justify-center rounded-btn bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90 lg:w-auto';
$btn_outline = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-80 lg:w-auto';
?>

<section class="relative overflow-hidden bg-navy">
	<?php if ( $background_image ) : ?>
		<div class="relative h-[260px] w-full lg:absolute lg:inset-y-0 lg:left-0 lg:h-auto lg:w-[min(100%,67.5rem)] lg:max-w-[75%]">
			<?php
			echo wp_get_attachment_image(
				$background_image,
				'full',
				false,
				array(
					'class'         => 'absolute inset-0 h-full w-full object-cover object-[center_30%] lg:object-cover',
					'fetchpriority' => 'high',
					'alt'           => '',
				)
			);
			?>
		</div>
	<?php else : ?>
		<div class="relative h-[260px] w-full bg-navy lg:absolute lg:inset-y-0 lg:left-0 lg:h-auto lg:w-[75%]" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="relative z-10 mx-auto flex w-full max-w-site flex-col px-[1.625rem] pb-12 pt-0 lg:min-h-[52.5rem] lg:flex-row lg:items-center lg:justify-end lg:px-gutter lg:py-20">
		<div class="-mt-[4.5rem] flex w-full max-w-[21.75rem] flex-col items-center gap-[3.75rem] self-center rounded-card bg-white p-5 lg:mt-0 lg:max-w-[36.625rem] lg:items-start lg:gap-8 lg:self-auto lg:p-5">
			<?php if ( $logo_id ) : ?>
				<div class="lg:pl-5 lg:pt-5">
					<?php
					echo wp_get_attachment_image(
						$logo_id,
						'medium',
						false,
						array(
							'class'         => 'h-auto w-[4.875rem] max-w-full object-contain object-left lg:w-[11.1875rem]',
							'alt'           => __( 'Impact One Million', 'impact-one-million' ),
							'fetchpriority' => 'high',
						)
					);
					?>
				</div>
			<?php elseif ( $has_default_logo ) : ?>
				<div class="lg:pl-5 lg:pt-5">
					<img
						src="<?php echo esc_url( $default_logo_uri ); ?>"
						alt="<?php echo esc_attr__( 'Impact One Million', 'impact-one-million' ); ?>"
						class="h-auto w-[4.875rem] max-w-full object-contain object-left lg:w-[11.1875rem]"
						width="179"
						height="136"
						fetchpriority="high"
					/>
				</div>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h1 class="w-full text-center font-display text-title leading-[1.1] tracking-[0.02em] text-blue lg:text-left">
					<?php echo esc_html( $heading ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( ! empty( $primary_cta['url'] ) || ! empty( $secondary_cta['url'] ) ) : ?>
				<div class="flex w-full flex-col items-stretch gap-4 lg:flex-row lg:items-start lg:whitespace-nowrap">
					<?php
					if ( ! empty( $primary_cta['url'] ) ) {
						iom_render_link(
							$primary_cta,
							$btn_primary,
							__( 'Join the Movement', 'impact-one-million' )
						);
					}
					if ( ! empty( $secondary_cta['url'] ) ) {
						iom_render_link(
							$secondary_cta,
							$btn_outline,
							__( 'Track your impact', 'impact-one-million' )
						);
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
