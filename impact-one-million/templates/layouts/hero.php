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

if ( ! is_array( $primary_cta ) ) {
	$primary_cta = array();
}

if ( ! is_array( $secondary_cta ) ) {
	$secondary_cta = array();
}

if ( ! is_array( $tertiary_cta ) ) {
	$tertiary_cta = array();
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

// Explicit CMS toggle, or auto for navy mid-page CTAs (no logo / no eyebrow+body).
$center_content = (bool) get_sub_field( 'center_content' );
if ( ! $center_content && ! $is_accent && ! $show_logo && ! $is_content ) {
	$center_content = true;
}

// Last flexible-content row on this page (bottom-of-page boxed mobile shell).
// $iom_is_last_section is set in page.php; fall back to counting rows if missing.
if ( isset( $iom_is_last_section ) ) {
	$is_last_layout = (bool) $iom_is_last_section;
} else {
	$page_sections  = function_exists( 'get_field' ) ? get_field( 'page_sections' ) : null;
	$is_last_layout = is_array( $page_sections ) && (int) get_row_index() === count( $page_sections );
}
// Any navy hero as the final layout — not only center_content mid-CTAs (e.g. Ambassadors).
$is_last_mid_cta = $is_last_layout && ! $is_accent;

// Homepage only: first page_sections row = full-viewport hero.
if ( isset( $iom_section_i ) ) {
	$is_first_section = ( 1 === (int) $iom_section_i );
} else {
	$is_first_section = ( 1 === (int) get_row_index() );
}
$is_home_hero = function_exists( 'is_front_page' ) && is_front_page() && $is_first_section;

$bg_class = $is_accent ? 'bg-accent-blue' : 'bg-navy';

$default_logo_uri = get_stylesheet_directory_uri() . '/assets/images/impact-one-million-logo.png';
$default_logo_abs = get_stylesheet_directory() . '/assets/images/impact-one-million-logo.png';
$has_default_logo = $show_logo && ! $is_accent && file_exists( $default_logo_abs );

// Mid-page CTAs use h2; top-of-page heroes use h1.
$heading_tag = ( $is_accent || $center_content ) ? 'h2' : 'h1';

$fill_bg = array(
	'accent'      => 'bg-accent',
	'accent_blue' => 'bg-accent-blue',
	'navy'        => 'bg-navy',
);

$btn_filled_base = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90 md:w-auto';
$btn_outline     = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-80 md:w-auto';

// History page bottom navy CTA only: mild desktop type tweak so dual buttons fit the card.
if ( $is_last_mid_cta && function_exists( 'is_page' ) && is_page( 'history' ) ) {
	$btn_filled_base .= ' md:px-5 md:text-[22px] md:tracking-[1.5px]';
	$btn_outline     .= ' md:px-5 md:text-[22px] md:tracking-[1.5px]';
}

// Family & ECD page top hero only: long primary CTA — smaller desktop type.
$iom_is_family_ecd_page = function_exists( 'is_page' ) && (
	is_page(
		array(
			'family-and-early-childhood-development',
			'family-early-childhood-development',
			'family-and-early-childhood',
		)
	)
	|| ( is_singular( 'page' ) && false !== stripos( (string) get_the_title(), 'Family and Early Childhood' ) )
);
if ( $is_first_section && ! $is_accent && $iom_is_family_ecd_page ) {
	$btn_filled_base .= ' lg:text-[20px] lg:tracking-[1.5px]';
	$btn_outline     .= ' lg:text-[20px] lg:tracking-[1.5px]';
}

// Gender Equality page top hero only: keep CTA label on one line on mobile.
$iom_is_gender_equality_page = function_exists( 'is_page' ) && (
	is_page(
		array(
			'gender-equality',
			'gender-and-equality',
			'gender',
		)
	)
	|| ( is_singular( 'page' ) && false !== stripos( (string) get_the_title(), 'Gender Equality' ) )
);
if ( $is_first_section && ! $is_accent && $iom_is_gender_equality_page ) {
	$btn_filled_base .= ' whitespace-nowrap px-4 text-[18px] tracking-[1px] md:px-6 md:text-card-title md:tracking-[2px]';
	$btn_outline     .= ' whitespace-nowrap px-4 text-[18px] tracking-[1px] md:px-6 md:text-card-title md:tracking-[2px]';
}

// Financial Wellbeing page top hero only: slightly smaller CTA text so it fits one line on mobile.
$iom_is_financial_wellbeing_page = function_exists( 'is_page' ) && (
	is_page(
		array(
			'financial-wellbeing',
			'financial-well-being',
			'financial-wellbeing-development',
		)
	)
	|| ( is_singular( 'page' ) && false !== stripos( (string) get_the_title(), 'Financial Wellbeing' ) )
	|| ( is_singular( 'page' ) && false !== stripos( (string) get_the_title(), 'Financial Well-being' ) )
);
if ( $is_first_section && ! $is_accent && $iom_is_financial_wellbeing_page ) {
	$btn_filled_base .= ' whitespace-nowrap text-[16px] tracking-[1px] md:text-card-title md:tracking-[2px]';
	$btn_outline     .= ' whitespace-nowrap text-[16px] tracking-[1px] md:text-card-title md:tracking-[2px]';
}

$btn_primary = $btn_filled_base . ' ' . $fill_bg[ $primary_cta_style ];

if ( 'outline' === $secondary_cta_style ) {
	$btn_secondary = $btn_outline;
} else {
	$btn_secondary = $btn_filled_base . ' ' . $fill_bg[ $secondary_cta_style ];
}

$btn_tertiary = $btn_filled_base . ' ' . $fill_bg[ $primary_cta_style ];

// Accent mid-page: centre mobile / left from tablet (md+). Navy mid-page CTA: centre mobile only.
// Last navy hero (bottom of page): always centre on mobile. Pillar navy content: left.
// Homepage navy: centre mobile / left from tablet (md+).
if ( $is_last_mid_cta || $center_content || $is_accent ) {
	$text_align = 'text-center md:text-left';
} elseif ( $is_content ) {
	$text_align = 'text-left';
} else {
	$text_align = 'text-center md:text-left';
}

// Bottom-of-page navy mid CTA (mobile): boxed card like accent mid-page — no overlap, 11px inset.
if ( $is_accent || $is_last_mid_cta ) {
	$img_wrap_class = 'relative h-[251px] w-full md:absolute md:inset-y-0 md:left-0 md:h-auto md:w-[min(100%,67.5rem)] md:max-w-[75%]';
} else {
	$img_wrap_class = 'relative h-[260px] w-full md:absolute md:inset-y-0 md:left-0 md:h-auto md:w-[min(100%,67.5rem)] md:max-w-[75%]';
}

if ( $is_accent ) {
	$outer_class = 'relative z-10 mx-auto flex w-full max-w-site flex-col px-[11px] pb-[11px] pt-[11px] md:min-h-[41.75rem] md:flex-row md:items-center md:justify-end md:px-[30px] md:py-20 xl:px-gutter';
} elseif ( $is_last_mid_cta ) {
	// Navy mid-page CTA: match accent height on tablet; keep taller desktop height.
	$outer_class = 'relative z-10 mx-auto flex w-full max-w-site flex-col px-[11px] pb-[11px] pt-[11px] md:min-h-[41.75rem] md:flex-row md:items-center md:justify-end md:px-[30px] md:py-20 xl:min-h-[52.5rem] xl:px-gutter';
} elseif ( $is_home_hero ) {
	// Fill the 100svh section; floor height handled on the section itself.
	$outer_class = 'relative z-10 mx-auto flex w-full max-w-site flex-1 flex-col px-page pb-10 pt-0 md:flex-row md:items-center md:justify-end md:py-20 xl:px-gutter';
} elseif ( $center_content ) {
	// Navy mid-page CTA (centered): same tablet height as accent.
	$outer_class = 'relative z-10 mx-auto flex w-full max-w-site flex-col px-page pb-10 pt-0 md:min-h-[41.75rem] md:flex-row md:items-center md:justify-end md:py-20 xl:min-h-[52.5rem] xl:px-gutter';
} else {
	$outer_class = 'relative z-10 mx-auto flex w-full max-w-site flex-col px-page pb-10 pt-0 md:min-h-[52.5rem] md:flex-row md:items-center md:justify-end md:py-20 xl:px-gutter';
}

if ( $is_accent ) {
	$card_class = 'mt-0 flex w-full flex-col items-center gap-8 self-center rounded-card bg-white p-[11px] md:mt-0 md:max-w-[36.625rem] md:items-start md:self-auto md:p-5';
} elseif ( $is_last_mid_cta ) {
	// Boxed + centered on mobile (Ambassadors-style bottom CTA).
	$card_class = 'mt-0 flex w-full flex-col items-center gap-8 self-center rounded-card bg-white p-[11px] md:mt-0 md:max-w-[36.625rem] md:items-start md:gap-8 md:self-auto md:p-5';
} elseif ( $center_content ) {
	$card_class = '-mt-[4.5rem] flex w-full max-w-[21.75rem] flex-col items-center gap-5 self-center rounded-card bg-white p-5 md:mt-0 md:max-w-[36.625rem] md:items-start md:gap-8 md:self-auto md:p-5';
} elseif ( $is_content ) {
	$card_class = '-mt-[4.5rem] flex w-full max-w-[21.75rem] flex-col items-start gap-5 self-center rounded-card bg-white p-5 md:mt-0 md:max-w-[36.625rem] md:gap-8 md:self-auto md:p-5';
} else {
	// Mobile Figma 671:40555 — 20px padding, 20px stack gap (was 60px).
	$card_class = '-mt-[4.5rem] flex w-full max-w-[21.75rem] flex-col items-center gap-5 self-center rounded-card bg-white p-5 md:mt-0 md:max-w-[36.625rem] md:items-start md:gap-8 md:self-auto md:p-5';
}

$cta_row_class = ( $center_content || $is_last_mid_cta || $is_accent )
	? 'flex w-full flex-col items-center gap-4 md:flex-row md:flex-nowrap md:items-start md:justify-start md:gap-4 md:whitespace-nowrap'
	: 'flex w-full flex-col items-stretch gap-4 md:flex-row md:flex-nowrap md:items-start md:gap-4 md:whitespace-nowrap';

$body_class = $is_accent
	? 'm-0 w-full font-sans text-label leading-[1.5] text-muted ' . $text_align
	: 'm-0 w-full font-sans text-body leading-[1.2] text-ink ' . ( ( $center_content || $is_last_mid_cta ) ? 'text-center md:text-left' : 'text-left' );

$has_ctas = ( ! empty( $primary_cta['url'] ) || ! empty( $secondary_cta['url'] ) || ! empty( $tertiary_cta['url'] ) );

/**
 * Eyebrow colour: single subtitle on accent = blue; breadcrumb uses muted + ink.
 */
$eyebrow_is_simple = $subtitle && ! $subtitle_parent;

$section_class = 'iom-hero relative overflow-hidden ' . $bg_class;
if ( $is_home_hero ) {
	// Full viewport on homepage only; 35rem floor protects short / landscape phones.
	$section_class .= ' iom-hero--home flex min-h-[35rem] min-h-[100svh] flex-col';
}
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<?php if ( $background_image ) : ?>
		<div class="iom-hero__media <?php echo esc_attr( $img_wrap_class ); ?>">
			<?php
			$hero_sizes = '(max-width: 767px) 100vw, min(1080px, 75vw)';
			$img_attrs  = array(
				'class' => 'absolute inset-0 h-full w-full object-cover object-[center_30%] md:object-cover',
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
		<div class="iom-hero__media <?php echo esc_attr( $img_wrap_class . ' ' . $bg_class ); ?>" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="iom-hero__outer <?php echo esc_attr( $outer_class ); ?>">
		<div class="iom-hero__card <?php echo esc_attr( $card_class ); ?>">
			<?php if ( $logo_id && $show_logo ) : ?>
				<div class="md:pl-5 md:pt-5">
					<?php
					echo wp_get_attachment_image(
						(int) $logo_id,
						'medium',
						false,
						array(
							'class'    => 'h-auto w-[8.75rem] max-w-full object-contain object-left md:w-[11.1875rem]',
							'alt'      => __( 'Impact One Million', 'impact-one-million' ),
							'loading'  => 'eager',
							'decoding' => 'async',
							'sizes'    => '(max-width: 767px) 140px, 179px',
						)
					);
					?>
				</div>
			<?php elseif ( $has_default_logo ) : ?>
				<div class="md:pl-5 md:pt-5">
					<img
						src="<?php echo esc_url( $default_logo_uri ); ?>"
						alt="<?php echo esc_attr__( 'Impact One Million', 'impact-one-million' ); ?>"
						class="h-auto w-[8.75rem] max-w-full object-contain object-left md:w-[11.1875rem]"
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
						<?php echo iom_format_multiline_text( $body, $body_class ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $has_ctas ) : ?>
				<div class="iom-hero__ctas <?php echo esc_attr( $cta_row_class ); ?>">
					<?php
					if ( ! empty( $primary_cta['url'] ) ) {
						iom_render_link(
							$primary_cta,
							$btn_primary,
							''
						);
					}
					if ( ! empty( $secondary_cta['url'] ) ) {
						iom_render_link(
							$secondary_cta,
							$btn_secondary,
							''
						);
					}
					if ( ! empty( $tertiary_cta['url'] ) ) {
						iom_render_link(
							$tertiary_cta,
							$btn_tertiary,
							''
						);
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
