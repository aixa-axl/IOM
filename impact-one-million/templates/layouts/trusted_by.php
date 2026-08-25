<?php
/**
 * Layout: trusted_by
 *
 * Logo marquee(s) — homepage “Trusted By” or multi-group “Our Wider Network”.
 *
 * Single group: primary/secondary headings + optional intro + logos.
 * Multi group: optional section heading + repeater of title/intro/logos.
 *
 * Figma desktop: 606:17127 / mobile: 671:40683 (Trusted By)
 * Figma desktop: 634:19464 (Our Wider Network — no mobile frame)
 */

$section_heading   = get_sub_field( 'section_heading' );
$heading_primary   = get_sub_field( 'heading_primary' );
$heading_secondary = get_sub_field( 'heading_secondary' );
$intro             = get_sub_field( 'intro' );
$heading_align     = get_sub_field( 'heading_align' );
$logos             = get_sub_field( 'logos' );
$groups            = get_sub_field( 'groups' );

$theme_uri = get_stylesheet_directory_uri() . '/assets/images/logos';

if ( ! in_array( $heading_align, array( 'center', 'left' ), true ) ) {
	$heading_align = 'center';
}

if ( ! is_array( $groups ) ) {
	$groups = array();
}

if ( ! is_array( $logos ) ) {
	$logos = array();
}

$preset_files = array(
	'mcdonalds'    => 'mcdonalds.png',
	'fisher-price' => 'fisher-price.png',
	'pokemon'      => 'pokemon.png',
	'lego'         => 'lego.png',
	'scholastic'   => 'scholastic.png',
	'target'       => 'target.png',
	'walmart'      => 'walmart.png',
	'argos'        => 'argos.svg',
	'disney'       => 'disney.svg',
);

/**
 * Resolve logo src + alt for a row.
 *
 * @param array $logo Logo row.
 * @return array{src:string,alt:string}|null
 */
$iom_resolve_logo = function ( $logo ) use ( $theme_uri, $preset_files ) {
	$alt    = isset( $logo['alt'] ) ? $logo['alt'] : '';
	$preset = isset( $logo['preset'] ) ? $logo['preset'] : '';
	$img_id = isset( $logo['image'] ) ? $logo['image'] : null;

	if ( $img_id ) {
		$src = wp_get_attachment_image_url( $img_id, 'medium' );
		if ( $src ) {
			if ( ! $alt ) {
				$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
			}
			return array(
				'src' => $src,
				'alt' => $alt ? $alt : '',
			);
		}
	}

	if ( $preset && isset( $preset_files[ $preset ] ) ) {
		return array(
			'src' => $theme_uri . '/' . $preset_files[ $preset ],
			'alt' => $alt,
		);
	}

	return null;
};

/**
 * Resolve a logos repeater into src/alt rows.
 *
 * @param array $logo_rows Raw ACF rows.
 * @param bool  $use_defaults Fill presets when empty (single-group legacy).
 * @return array<int,array{src:string,alt:string}>
 */
$iom_resolve_logos = function ( $logo_rows, $use_defaults = false ) use ( $iom_resolve_logo ) {
	if ( ( ! is_array( $logo_rows ) || empty( $logo_rows ) ) && $use_defaults ) {
		$logo_rows = array(
			array( 'image' => null, 'preset' => 'mcdonalds', 'alt' => 'McDonald\'s' ),
			array( 'image' => null, 'preset' => 'fisher-price', 'alt' => 'Fisher-Price' ),
			array( 'image' => null, 'preset' => 'pokemon', 'alt' => 'Pokémon' ),
			array( 'image' => null, 'preset' => 'lego', 'alt' => 'LEGO' ),
			array( 'image' => null, 'preset' => 'scholastic', 'alt' => 'Scholastic' ),
			array( 'image' => null, 'preset' => 'target', 'alt' => 'Target' ),
			array( 'image' => null, 'preset' => 'walmart', 'alt' => 'Walmart' ),
			array( 'image' => null, 'preset' => 'argos', 'alt' => 'Argos' ),
			array( 'image' => null, 'preset' => 'disney', 'alt' => 'Disney' ),
		);
	}

	$resolved = array();
	if ( ! is_array( $logo_rows ) ) {
		return $resolved;
	}

	foreach ( $logo_rows as $logo ) {
		$item = $iom_resolve_logo( $logo );
		if ( $item && $item['src'] ) {
			$resolved[] = $item;
		}
	}

	return $resolved;
};

/**
 * Render one seamless logo marquee.
 *
 * @param array $resolved Resolved logos.
 */
$iom_render_marquee = function ( $resolved ) {
	if ( empty( $resolved ) ) {
		return;
	}

	$marquee_logos = array_merge( $resolved, $resolved );
	$count         = count( $resolved );
	?>
	<div
		class="iom-marquee relative w-full max-w-full overflow-hidden py-3"
		data-logo-marquee
	>
		<div
			class="iom-marquee-track flex w-max items-center gap-8 lg:gap-[5.75rem]"
			data-logo-marquee-track
		>
			<?php foreach ( $marquee_logos as $i => $logo ) : ?>
				<div
					class="flex h-[4.6875rem] w-auto shrink-0 items-center justify-center"
					<?php echo $i >= $count ? 'aria-hidden="true"' : ''; ?>
				>
					<img
						src="<?php echo esc_url( $logo['src'] ); ?>"
						alt="<?php echo $i >= $count ? '' : esc_attr( $logo['alt'] ); ?>"
						class="max-h-[4.6875rem] w-auto max-w-[8.75rem] object-contain"
						loading="eager"
						decoding="async"
					/>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
};

$has_groups = ! empty( $groups );

// Build renderable groups.
$render_groups = array();

if ( $has_groups ) {
	foreach ( $groups as $group ) {
		$g_title = isset( $group['title'] ) ? $group['title'] : '';
		$g_intro = isset( $group['intro'] ) ? $group['intro'] : '';
		$g_align = isset( $group['title_align'] ) ? $group['title_align'] : 'center';
		if ( ! in_array( $g_align, array( 'center', 'left' ), true ) ) {
			$g_align = 'center';
		}
		$g_logos = $iom_resolve_logos( isset( $group['logos'] ) ? $group['logos'] : array(), false );

		if ( ! $g_title && ! $g_intro && empty( $g_logos ) ) {
			continue;
		}

		$render_groups[] = array(
			'title' => $g_title,
			'intro' => $g_intro,
			'align' => $g_align,
			'logos' => $g_logos,
		);
	}
} else {
	// Legacy single-group mode.
	$single_logos = $iom_resolve_logos( $logos, true );
	if ( empty( $single_logos ) && ! $heading_primary && ! $heading_secondary && ! $intro && ! $section_heading ) {
		return;
	}

	$render_groups[] = array(
		'title'       => '',
		'intro'       => $intro,
		'align'       => $heading_align,
		'logos'       => $single_logos,
		'primary'     => $heading_primary,
		'secondary'   => $heading_secondary,
		'is_legacy'   => true,
	);
}

if ( empty( $render_groups ) && ! $section_heading ) {
	return;
}

$aria = $section_heading
	? $section_heading
	: __( 'Trusted by', 'impact-one-million' );
?>

<section class="border-b border-solid border-[#e5e7eb] bg-white py-10 lg:py-24" aria-label="<?php echo esc_attr( $aria ); ?>">
	<div class="mx-auto flex w-full max-w-site flex-col items-stretch gap-10 px-0 lg:gap-16">
		<?php if ( $section_heading ) : ?>
			<div class="px-page xl:px-section">
				<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
					<?php echo esc_html( $section_heading ); ?>
				</h2>
			</div>
		<?php endif; ?>

		<div class="flex w-full flex-col items-stretch gap-10 lg:gap-40">
			<?php foreach ( $render_groups as $group ) : ?>
				<?php
				$is_legacy = ! empty( $group['is_legacy'] );
				$align     = $group['align'];
				$is_left   = ( 'left' === $align );
				$text_box  = $is_left
					? 'items-start text-left'
					: 'items-center text-center';
				?>
				<div class="flex w-full min-w-0 flex-col items-stretch gap-6">
					<?php if ( $is_legacy ) : ?>
						<?php if ( ! empty( $group['primary'] ) || ! empty( $group['secondary'] ) || ! empty( $group['intro'] ) ) : ?>
							<div class="mx-auto flex w-full max-w-site flex-col px-page xl:px-gutter <?php echo $is_left ? 'items-start' : 'items-center'; ?>">
								<div class="flex w-full max-w-[67.5rem] flex-col gap-3 <?php echo esc_attr( $text_box ); ?>">
									<?php if ( ! empty( $group['primary'] ) ) : ?>
										<p class="m-0 font-display text-number text-navy">
											<?php echo esc_html( $group['primary'] ); ?>
										</p>
									<?php endif; ?>
									<?php if ( ! empty( $group['secondary'] ) ) : ?>
										<p class="m-0 font-display text-headline leading-[1.2] text-blue">
											<?php echo esc_html( $group['secondary'] ); ?>
										</p>
									<?php endif; ?>
									<?php if ( ! empty( $group['intro'] ) ) : ?>
										<p class="m-0 max-w-[37.5rem] font-sans text-body leading-[1.2] text-blue">
											<?php echo esc_html( $group['intro'] ); ?>
										</p>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					<?php else : ?>
						<?php if ( ! empty( $group['title'] ) || ! empty( $group['intro'] ) ) : ?>
							<div class="mx-auto flex w-full max-w-site flex-col px-page xl:px-section <?php echo $is_left ? 'items-start' : 'items-center'; ?>">
								<div class="flex w-full max-w-[37.5rem] flex-col gap-6 <?php echo esc_attr( $text_box ); ?>">
									<?php if ( ! empty( $group['title'] ) ) : ?>
										<h3 class="m-0 font-display text-header leading-none text-blue">
											<?php echo esc_html( $group['title'] ); ?>
										</h3>
									<?php endif; ?>
									<?php if ( ! empty( $group['intro'] ) ) : ?>
										<p class="m-0 font-sans text-body leading-[1.2] text-blue">
											<?php echo esc_html( $group['intro'] ); ?>
										</p>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php $iom_render_marquee( $group['logos'] ); ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
