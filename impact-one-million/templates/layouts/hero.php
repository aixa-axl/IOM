<?php
/**
 * Layout: hero
 *
 * Reused on homepage, pillar pages, and mid-page CTAs.
 *
 * Fields: background_color, background_image, show_logo, logo, subtitle_parent,
 *         subtitle, heading, body, primary_cta_style, primary_cta,
 *         secondary_cta_style, secondary_cta, tertiary_cta
 *
 * Figma: 606:17106 / 671:40553 (homepage navy)
 *        623:18990 / 671:40741 (mid-page accent blue)
 *        623:18563 / 677:41851 (pillar page with subtitle + body)
 *        634:19230 / 677:41883 (join CTA — 3 navy buttons)
 */

$background_color    = get_sub_field( 'background_color' );
$background_image    = get_sub_field( 'background_image' );
$show_logo           = get_sub_field( 'show_logo' );
$logo_id             = get_sub_field( 'logo' );
$subtitle_parent     = get_sub_field( 'subtitle_parent' );
$subtitle            = get_sub_field( 'subtitle' );
$heading             = get_sub_field( 'heading' );
$body                = get_sub_field( 'body' );
$primary_cta_style   = get_sub_field( 'primary_cta_style' );
$primary_cta          = get_sub_field( 'primary_cta' );
$secondary_cta_style = get_sub_field( 'secondary_cta_style' );
$secondary_cta       = get_sub_field( 'secondary_cta' );
$tertiary_cta        = get_sub_field( 'tertiary_cta' );

$filled_styles = array( 'accent', 'accent_blue', 'navy' );

if ( ! in_array( $background_color, array( 'navy', 'accent_blue' ), true ) ) {
	$background_color = 'navy';
}

if ( ! in_array( $primary_cta_style, $filled_styles, true ) ) {
	$primary_cta_style = 'accent';
}

if ( ! in_array( $secondary_cta_style, array_merge( array( 'outline' ), $filled_styles ), true ) ) {
	$secondary_cta_style = 'outline';
}

// Existing rows may not have show_logo yet — default on.
if ( null === $show_logo ) {
	$show_logo = true;
}
$show_logo = (bool) $show_logo;

$is_accent   = ( 'accent_blue' === $background_color );
$has_eyebrow = ( $subtitle_parent || $subtitle );
$has_body    = (bool) $body;
$is_content  = ( $has_eyebrow || $has_body );

$bg_class = $is_accent ? 'bg-accent-blue' : 'bg-navy';

$default_logo_uri = get_stylesheet_directory_uri() . '/assets/images/impact-one-million-logo.png';
$default_logo_abs = get_stylesheet_directory() . '/assets/images/impact-one-million-logo.png';
$has_default_logo = $show_logo && ! $is_accent && file_exists( $default_logo_abs );

// Mid-page accent variant uses h2; page heroes use h1.
$heading_tag = $is_accent ? 'h2' : 'h1';

$fill_bg = array(
	'accent'      => 'bg-accent',
	'accent_blue' => 'bg-accent-blue',
	'navy'        => 'bg-navy',
);

$btn_filled_base = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90 lg:w-auto';
$btn_outline     = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-80 lg:w-auto';

$btn_primary = $btn_filled_base . ' ' . $fill_bg[ $primary_cta_style ];

if ( 'outline' === $secondary_cta_style ) {
	$btn_secondary = $btn_outline;
} else {
	$btn_secondary = $btn_filled_base . ' ' . $fill_bg[ $secondary_cta_style ];
}

$btn_tertiary = $btn_filled_base . ' ' . $fill_bg[ $primary_cta_style ];

// Accent mid-page CTAs centre on mobile; pillar navy content stays left.
if ( $is_accent ) {
	$text_align = 'text-center lg:text-left';
} elseif ( $is_content ) {
	$text_align = 'text-left';
} else {
	$text_align = 'text-center lg:text-left';
}

$img_wrap_class = $is_accent
	? 'relative h-[251px] w-full lg:absolute lg:inset-y-0 lg:left-0 lg:h-auto lg:w-[min(100%,67.5rem)] lg:max-w-[75%]'
	: 'relative h-[260px] w-full lg:absolute lg:inset-y-0 lg:left-0 lg:h-auto lg:w-[min(100%,67.5rem)] lg:max-w-[75%]';

$outer_class = $is_accent
	? 'relative z-10 mx-auto flex w-full max-w-site flex-col px-page pb-10 pt-0 lg:min-h-[41.75rem] lg:flex-row lg:items-center lg:justify-end lg:px-gutter lg:py-20'
	: 'relative z-10 mx-auto flex w-full max-w-site flex-col px-page pb-12 pt-0 lg:min-h-[52.5rem] lg:flex-row lg:items-center lg:justify-end lg:px-gutter lg:py-20';

if ( $is_accent ) {
	$card_class = 'mt-0 flex w-full flex-col items-center gap-8 self-center rounded-card bg-white p-10 lg:mt-0 lg:max-w-[36.625rem] lg:items-start lg:self-auto lg:p-5';
} elseif ( $is_content ) {
	$card_class = '-mt-[4.5rem] flex w-full max-w-[21.75rem] flex-col items-start gap-8 self-center rounded-card bg-white p-5 lg:mt-0 lg:max-w-[36.625rem] lg:self-auto lg:p-5';
} else {
	$card_class = '-mt-[4.5rem] flex w-full max-w-[21.75rem] flex-col items-center gap-[3.75rem] self-center rounded-card bg-white p-5 lg:mt-0 lg:max-w-[36.625rem] lg:items-start lg:gap-8 lg:self-auto lg:p-5';
}

$has_ctas = ( ! empty( $primary_cta['url'] ) || ! empty( $secondary_cta['url'] ) || ! empty( $tertiary_cta['url'] ) );

/**
 * Eyebrow colour: single subtitle on accent = blue; breadcrumb uses muted + ink.
 */
$eyebrow_is_simple = $subtitle && ! $subtitle_parent;
?>

<section class="relative overflow-hidden <?php echo esc_attr( $bg_class ); ?>">
	<?php if ( $background_image ) : ?>
		<div class="<?php echo esc_attr( $img_wrap_class ); ?>">
			<?php
			$hero_sizes = '(max-width: 1023px) 100vw, min(1080px, 75vw)';
			$img_attrs  = array(
				'class' => 'absolute inset-0 h-full w-full object-cover object-[center_30%] lg:object-cover',
				'alt'   => '',
				'sizes' => $hero_sizes,
			);
			if ( $is_accent ) {
				$img_attrs['loading']  = 'lazy';
				$img_attrs['decoding'] = 'async';
			} else {
				// LCP: eager + high priority; sync decode paints as soon as bytes arrive.
				$img_attrs['loading']       = 'eager';
				$img_attrs['fetchpriority'] = 'high';
				$img_attrs['decoding']      = 'sync';
			}
			echo iom_get_hero_background_image( (int) $background_image, $img_attrs );
			?>
		</div>
	<?php else : ?>
		<div class="<?php echo esc_attr( $img_wrap_class . ' ' . $bg_class ); ?>" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="<?php echo esc_attr( $outer_class ); ?>">
		<div class="<?php echo esc_attr( $card_class ); ?>">
			<?php if ( $logo_id && $show_logo ) : ?>
				<div class="lg:pl-5 lg:pt-5">
					<?php
					echo wp_get_attachment_image(
						(int) $logo_id,
						'medium',
						false,
						array(
							'class'    => 'h-auto w-[4.875rem] max-w-full object-contain object-left lg:w-[11.1875rem]',
							'alt'      => __( 'Impact One Million', 'impact-one-million' ),
							'loading'  => 'eager',
							'decoding' => 'async',
							'sizes'    => '(max-width: 1023px) 78px, 179px',
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
						loading="eager"
						decoding="async"
					/>
				</div>
			<?php endif; ?>

			<?php if ( $has_eyebrow || $heading || $has_body ) : ?>
				<div class="flex w-full flex-col gap-3">
					<?php if ( $has_eyebrow ) : ?>
						<?php if ( $eyebrow_is_simple ) : ?>
							<p class="m-0 w-full font-display text-body uppercase tracking-[1px] <?php echo esc_attr( $is_accent ? 'text-blue ' . $text_align : 'text-ink ' . $text_align ); ?>">
								<?php echo esc_html( $subtitle ); ?>
							</p>
						<?php else : ?>
							<p class="m-0 flex flex-wrap items-start gap-2 font-display text-body uppercase tracking-[1px] <?php echo esc_attr( $text_align ); ?>">
								<?php if ( $subtitle_parent ) : ?>
									<span class="text-muted"><?php echo esc_html( $subtitle_parent ); ?></span>
									<?php if ( $subtitle ) : ?>
										<span class="text-muted" aria-hidden="true">/</span>
									<?php endif; ?>
								<?php endif; ?>
								<?php if ( $subtitle ) : ?>
									<span class="text-ink"><?php echo esc_html( $subtitle ); ?></span>
								<?php endif; ?>
							</p>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( $heading ) : ?>
						<<?php echo esc_attr( $heading_tag ); ?> class="m-0 w-full font-display text-title leading-[1.1] tracking-[0.02em] text-blue <?php echo esc_attr( $text_align ); ?>">
							<?php echo esc_html( $heading ); ?>
						</<?php echo esc_attr( $heading_tag ); ?>>
					<?php endif; ?>

					<?php if ( $has_body ) : ?>
						<p class="m-0 w-full font-sans <?php echo esc_attr( $is_accent ? 'text-label leading-[1.5] text-muted ' . $text_align : 'text-body leading-[1.2] text-ink text-left' ); ?>">
							<?php echo esc_html( $body ); ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $has_ctas ) : ?>
				<div class="flex w-full flex-col items-stretch gap-3 lg:flex-row lg:flex-nowrap lg:items-start lg:gap-4 lg:whitespace-nowrap">
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
							$btn_secondary,
							__( 'Track your impact', 'impact-one-million' )
						);
					}
					if ( ! empty( $tertiary_cta['url'] ) ) {
						iom_render_link(
							$tertiary_cta,
							$btn_tertiary,
							__( 'Foundations', 'impact-one-million' )
						);
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
