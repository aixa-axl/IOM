<?php
/**
 * Interactive Where We Work map.
 * Geography PNG + per-country highlight overlays (1x / 2x / 3x for sharpness).
 * Clicks resolve via highlight alpha masks in JS.
 *
 * Note: do not reuse $countries — that var holds ACF country rows in the parent layout.
 */

$map_dir    = get_template_directory_uri() . '/assets/images/maps';
$map_base   = $map_dir . '/where-we-work-map-base.png';
$map_2x     = $map_dir . '/where-we-work-map-base@2x.png';
$map_3x     = $map_dir . '/where-we-work-map-base@3x.png';
$map_slugs  = array( 'china', 'vietnam', 'indonesia', 'india', 'bangladesh', 'sri-lanka' );
$map_active = isset( $iom_map_active_slug ) ? (string) $iom_map_active_slug : 'china';
?>
<div class="relative flex w-full cursor-pointer items-center justify-center py-6 lg:py-10" data-work-map>
	<div class="relative w-[82%] max-w-full">
		<img
			class="pointer-events-none block h-auto w-full max-w-full"
			src="<?php echo esc_url( $map_3x ); ?>"
			srcset="<?php echo esc_attr( $map_base . ' 1024w, ' . $map_2x . ' 2048w, ' . $map_3x . ' 3072w' ); ?>"
			sizes="(min-width: 1200px) 984px, 82vw"
			alt="<?php echo esc_attr__( 'Map of countries where we work', 'impact-one-million' ); ?>"
			width="1024"
			height="546"
			decoding="async"
			loading="lazy"
			data-map-base
		/>

		<?php foreach ( $map_slugs as $slug ) : ?>
			<?php
			$hl         = $map_dir . '/highlight-' . $slug . '.png';
			$hl_2x      = $map_dir . '/highlight-' . $slug . '@2x.png';
			$hl_3x      = $map_dir . '/highlight-' . $slug . '@3x.png';
			$is_active  = ( $slug === $map_active );
			$hl_opacity = $is_active ? 'opacity-100 is-active' : 'opacity-0';
			?>
			<img
				class="iom-map-highlight pointer-events-none absolute inset-0 h-full w-full object-fill transition-opacity duration-200 <?php echo esc_attr( $hl_opacity ); ?>"
				src="<?php echo esc_url( $hl_3x ); ?>"
				srcset="<?php echo esc_attr( $hl . ' 1024w, ' . $hl_2x . ' 2048w, ' . $hl_3x . ' 3072w' ); ?>"
				sizes="(min-width: 1200px) 984px, 82vw"
				alt=""
				width="1024"
				height="546"
				data-country="<?php echo esc_attr( $slug ); ?>"
				decoding="async"
				aria-hidden="true"
			/>
		<?php endforeach; ?>
	</div>
</div>
