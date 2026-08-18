<?php
/**
 * Layout: stat_bar
 *
 * Full-width navy bar of centered metrics (value + label).
 * Desktop: equal columns in one row. Mobile: stacked.
 *
 * Fields: stats (repeater: value, label)
 *
 * Figma desktop: 634:21259 (no mobile frame — stacked adaptation)
 */

$stats = get_sub_field( 'stats' );

if ( ! is_array( $stats ) ) {
	$stats = array();
}
?>

<section class="bg-navy px-10 py-12 lg:px-section lg:py-16">
	<?php if ( ! empty( $stats ) ) : ?>
		<ul class="mx-auto m-0 flex w-full max-w-site list-none flex-col items-stretch gap-10 p-0 lg:flex-row lg:items-start lg:gap-0">
			<?php foreach ( $stats as $stat ) : ?>
				<?php
				$value = isset( $stat['value'] ) ? $stat['value'] : '';
				$label = isset( $stat['label'] ) ? $stat['label'] : '';

				if ( ! $value && ! $label ) {
					continue;
				}
				?>
				<li class="flex min-w-0 flex-1 flex-col items-center gap-2 text-center">
					<?php if ( $value ) : ?>
						<p class="m-0 font-display text-number leading-none text-white">
							<?php echo esc_html( $value ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $label ) : ?>
						<p class="m-0 font-display text-stat-label leading-[1.2] text-[#dfe8ff]">
							<?php echo esc_html( $label ); ?>
						</p>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</section>
