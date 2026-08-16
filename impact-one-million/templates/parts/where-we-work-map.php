<?php
/**
 * Interactive Where We Work map.
 * Geography PNG + per-country highlight overlays.
 * Clicks resolve via highlight alpha masks in JS.
 */

$map_base  = get_template_directory_uri() . '/assets/images/maps/where-we-work-map-base.png';
$map_dir   = get_template_directory_uri() . '/assets/images/maps';
$countries = array( 'china', 'vietnam', 'indonesia', 'india', 'bangladesh', 'sri-lanka' );
?>
<div class="relative h-full w-full cursor-pointer" data-work-map>
	<img
		class="pointer-events-none h-full w-full object-contain object-center"
		src="<?php echo esc_url( $map_base ); ?>"
		alt="<?php echo esc_attr__( 'Map of countries where we work', 'impact-one-million' ); ?>"
		width="1024"
		height="546"
		decoding="async"
		loading="lazy"
		data-map-base
	/>

	<?php foreach ( $countries as $slug ) : ?>
		<img
			class="iom-map-highlight pointer-events-none absolute inset-0 h-full w-full object-contain object-center opacity-0 transition-opacity duration-200"
			src="<?php echo esc_url( $map_dir . '/highlight-' . $slug . '.png' ); ?>"
			alt=""
			width="1024"
			height="546"
			data-country="<?php echo esc_attr( $slug ); ?>"
			decoding="async"
			aria-hidden="true"
		/>
	<?php endforeach; ?>
</div>
