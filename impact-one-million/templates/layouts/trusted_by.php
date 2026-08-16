<?php
/**
 * Layout: trusted_by
 *
 * Headline + continuous scrolling partner logo banner.
 *
 * Figma desktop: 606:17127 — Figma mobile: 671:40683
 */

$heading_primary   = get_sub_field( 'heading_primary' );
$heading_secondary = get_sub_field( 'heading_secondary' );
$logos             = get_sub_field( 'logos' );

$theme_uri = get_stylesheet_directory_uri() . '/assets/images/logos';

if ( ! $heading_primary ) {
	$heading_primary = __( '20 years of delivery.', 'impact-one-million' );
}

if ( ! $heading_secondary ) {
	$heading_secondary = __( '150,000+ workers reached across 6 countries.', 'impact-one-million' );
}

if ( ! is_array( $logos ) || empty( $logos ) ) {
	$logos = array(
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

$resolved = array();
foreach ( $logos as $logo ) {
	$item = $iom_resolve_logo( $logo );
	if ( $item && $item['src'] ) {
		$resolved[] = $item;
	}
}

if ( empty( $resolved ) ) {
	return;
}

// Duplicate set for seamless marquee loop.
$marquee_logos = array_merge( $resolved, $resolved );
?>

<section class="overflow-hidden bg-white py-section" aria-label="<?php echo esc_attr__( 'Trusted by', 'impact-one-million' ); ?>">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10 px-10 lg:px-gutter">
		<div class="flex max-w-[67.5rem] flex-col items-center gap-3 text-center">
			<?php if ( $heading_primary ) : ?>
				<p class="m-0 font-display text-number text-navy">
					<?php echo esc_html( $heading_primary ); ?>
				</p>
			<?php endif; ?>
			<?php if ( $heading_secondary ) : ?>
				<p class="m-0 font-display text-headline leading-[1.2] text-blue">
					<?php echo esc_html( $heading_secondary ); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>

	<div class="relative w-full overflow-hidden py-3" data-logo-marquee>
		<div class="iom-marquee-track flex w-max items-center gap-8 lg:gap-[5.75rem]" data-logo-marquee-track>
			<?php foreach ( $marquee_logos as $i => $logo ) : ?>
				<div class="flex h-[4.6875rem] shrink-0 items-center justify-center" <?php echo $i >= count( $resolved ) ? 'aria-hidden="true"' : ''; ?>>
					<img
						src="<?php echo esc_url( $logo['src'] ); ?>"
						alt="<?php echo $i >= count( $resolved ) ? '' : esc_attr( $logo['alt'] ); ?>"
						class="max-h-[4.6875rem] w-auto max-w-[8.75rem] object-contain"
						loading="lazy"
						decoding="async"
					/>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
