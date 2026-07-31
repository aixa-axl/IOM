<?php
/**
 * Layout: hero
 *
 * ACF layout name: hero
 * Fields: background_image (ID), logo (ID), heading, primary_cta (link), secondary_cta (link)
 *
 * Figma: Impact One Million — node 606:17106
 */

$background_image = get_sub_field( 'background_image' );
$logo_id          = get_sub_field( 'logo' );
$heading          = get_sub_field( 'heading' );
$primary_cta      = get_sub_field( 'primary_cta' );
$secondary_cta    = get_sub_field( 'secondary_cta' );

$default_logo_uri = get_stylesheet_directory_uri() . '/assets/images/impact-one-million-logo.png';
$default_logo_abs = get_stylesheet_directory() . '/assets/images/impact-one-million-logo.png';
$has_default_logo = file_exists( $default_logo_abs );

$btn_primary = 'inline-flex items-center justify-center rounded-btn bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
$btn_outline = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-80';
?>

<section class="relative overflow-hidden bg-navy">
	<?php if ( $background_image ) : ?>
		<div class="absolute inset-0 lg:right-[12%]">
			<?php
			echo wp_get_attachment_image(
				$background_image,
				'full',
				false,
				array(
					'class'         => 'absolute inset-0 h-full w-full object-cover',
					'fetchpriority' => 'high',
					'alt'           => '',
				)
			);
			?>
		</div>
	<?php endif; ?>

	<div class="relative z-10 mx-auto flex min-h-[70vh] w-full max-w-site items-center px-5 py-12 lg:min-h-[52.5rem] lg:justify-end lg:px-gutter lg:py-20">
		<div class="flex w-full max-w-xl flex-col items-start gap-8 rounded-card bg-white p-5 shadow-sm lg:max-w-[36.625rem] lg:gap-8 lg:p-10">
			<?php if ( $logo_id ) : ?>
				<div class="pl-5 pt-5">
					<?php
					echo wp_get_attachment_image(
						$logo_id,
						'medium',
						false,
						array(
							'class'         => 'h-auto w-[7.5rem] max-w-full object-contain object-left lg:w-[11.1875rem]',
							'alt'           => __( 'Impact One Million', 'impact-one-million' ),
							'fetchpriority' => 'high',
						)
					);
					?>
				</div>
			<?php elseif ( $has_default_logo ) : ?>
				<div class="pl-5 pt-5">
					<img
						src="<?php echo esc_url( $default_logo_uri ); ?>"
						alt="<?php echo esc_attr__( 'Impact One Million', 'impact-one-million' ); ?>"
						class="h-auto w-[7.5rem] max-w-full object-contain object-left lg:w-[11.1875rem]"
						width="179"
						height="136"
						fetchpriority="high"
					/>
				</div>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h1 class="font-display text-[2.5rem] leading-[1.1] tracking-[0.02em] text-blue lg:text-title">
					<?php echo esc_html( $heading ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( ! empty( $primary_cta['url'] ) || ! empty( $secondary_cta['url'] ) ) : ?>
				<div class="flex flex-col items-stretch gap-4 sm:flex-row sm:items-start sm:gap-4">
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
