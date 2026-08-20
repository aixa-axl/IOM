<?php
/**
 * Layout: impact_stats
 *
 * ACF layout name: impact_stats
 * Fields: stats (repeater: icon, icon_preset, value, prefix, label), description
 *
 * Figma desktop: 606:14375 — Figma mobile: 671:40562
 */

$stats       = get_sub_field( 'stats' );
$description = get_sub_field( 'description' );

$theme_uri  = get_stylesheet_directory_uri();
$icon_map   = array(
	'people' => $theme_uri . '/assets/images/icons/stat-people.svg',
	'coins'  => $theme_uri . '/assets/images/icons/stat-coins.svg',
	'globe'  => $theme_uri . '/assets/images/icons/stat-globe.svg',
);

if ( ! is_array( $stats ) || empty( $stats ) ) {
	$stats = array(
		array(
			'icon'        => null,
			'icon_preset' => 'people',
			'value'       => 999999,
			'prefix'      => '',
			'label'       => __( 'people impacted', 'impact-one-million' ),
		),
		array(
			'icon'        => null,
			'icon_preset' => 'coins',
			'value'       => 1050200,
			'prefix'      => '$',
			'label'       => __( 'funds deployed', 'impact-one-million' ),
		),
		array(
			'icon'        => null,
			'icon_preset' => 'globe',
			'value'       => 154,
			'prefix'      => '',
			'label'       => __( 'countries reached', 'impact-one-million' ),
		),
	);
}

if ( ! $description ) {
	$description = __( 'Impact One Million is a global movement improving the lives of supply chain workers and their families, powered by ESCP and delivered by worker Well-Being Foundation.', 'impact-one-million' );
}

/**
 * Mobile order differs from desktop: people, countries, funds.
 * Desktop order follows repeater index (people, funds, countries).
 */
$order_classes = array(
	'people' => 'order-1 lg:order-1',
	'coins'  => 'order-3 lg:order-2',
	'globe'  => 'order-2 lg:order-3',
);
$fallback_orders = array(
	'order-1 lg:order-1',
	'order-2 lg:order-2',
	'order-3 lg:order-3',
);
?>

<section class="bg-white px-page py-section lg:px-gutter lg:py-gutter" data-impact-stats>
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-20 lg:gap-[3.75rem]">
		<ul class="m-0 flex w-full list-none flex-col items-center gap-14 p-0 lg:flex-row lg:items-start lg:justify-between lg:gap-0">
			<?php foreach ( $stats as $index => $row ) : ?>
				<?php
				$icon_id     = isset( $row['icon'] ) ? $row['icon'] : null;
				$preset      = isset( $row['icon_preset'] ) ? $row['icon_preset'] : '';
				$value       = isset( $row['value'] ) ? $row['value'] : 0;
				$prefix      = isset( $row['prefix'] ) ? $row['prefix'] : '';
				$label       = isset( $row['label'] ) ? $row['label'] : '';
				$value       = is_numeric( $value ) ? (float) $value : 0;
				$order_class = isset( $order_classes[ $preset ] )
					? $order_classes[ $preset ]
					: ( isset( $fallback_orders[ $index ] ) ? $fallback_orders[ $index ] : 'order-1 lg:order-1' );
				$icon_uri    = ( $preset && isset( $icon_map[ $preset ] ) ) ? $icon_map[ $preset ] : '';
				?>
				<li class="flex w-full max-w-sm flex-col items-center text-center <?php echo esc_attr( $order_class ); ?> lg:max-w-none lg:flex-1">
					<div class="flex size-20 shrink-0 items-center justify-center lg:size-20" aria-hidden="true">
						<?php if ( $icon_id ) : ?>
							<?php
							echo wp_get_attachment_image(
								$icon_id,
								'thumbnail',
								false,
								array(
									'class'   => 'size-20 max-h-20 w-auto object-contain',
									'alt'     => '',
									'loading' => 'lazy',
								)
							);
							?>
						<?php elseif ( $icon_uri ) : ?>
							<img
								src="<?php echo esc_url( $icon_uri ); ?>"
								alt=""
								width="80"
								height="80"
								class="size-20 object-contain"
								loading="lazy"
							/>
						<?php endif; ?>
					</div>

					<p
						class="m-0 pb-2 font-display text-number text-blue"
						data-count-up
						data-count-to="<?php echo esc_attr( (string) $value ); ?>"
						data-count-prefix="<?php echo esc_attr( $prefix ); ?>"
						aria-label="<?php echo esc_attr( trim( $prefix . number_format_i18n( $value ) . ' ' . $label ) ); ?>"
					>
						<?php echo esc_html( $prefix . '0' ); ?>
					</p>

					<?php if ( $label ) : ?>
						<p class="m-0 font-display text-[20px] leading-[1.2] tracking-[0.04em] text-accent-blue opacity-60 lg:text-stat-label">
							<?php echo esc_html( $label ); ?>
						</p>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php if ( $description ) : ?>
			<p class="m-0 max-w-[56.25rem] text-center font-sans text-[20px] font-semibold leading-[1.2] text-blue lg:text-stat-label">
				<?php echo esc_html( $description ); ?>
			</p>
		<?php endif; ?>
	</div>
</section>
