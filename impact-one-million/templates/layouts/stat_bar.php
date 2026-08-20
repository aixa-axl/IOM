<?php
/**
 * Layout: stat_bar
 *
 * Centered metrics row (value + label).
 * Variant navy: dark bar, white numbers, blue-tint labels (Figma 634:21259).
 * Variant light: off-white bar, blue numbers, accent-blue labels (Figma 634:20673).
 * Desktop: equal columns. Mobile: stacked.
 *
 * Fields: variant, stats (repeater: value, label)
 */

$variant = get_sub_field( 'variant' );
$stats   = get_sub_field( 'stats' );

if ( ! in_array( $variant, array( 'navy', 'light' ), true ) ) {
	$variant = 'navy';
}

$is_light = ( 'light' === $variant );

if ( ! is_array( $stats ) ) {
	$stats = array();
}

$section_class = $is_light
	? 'bg-off-white px-page py-10 lg:px-section lg:py-gutter'
	: 'bg-navy px-page py-10 lg:px-section lg:py-16';

$list_gap = $is_light
	? 'gap-10 lg:gap-8'
	: 'gap-10 lg:gap-0';

$value_class = $is_light
	? 'm-0 font-display text-number leading-none text-blue'
	: 'm-0 font-display text-number leading-none text-white';

$label_class = $is_light
	? 'm-0 text-center font-display text-body uppercase tracking-[1px] text-accent-blue'
	: 'm-0 font-display text-stat-label leading-[1.2] text-[#dfe8ff]';
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<?php if ( ! empty( $stats ) ) : ?>
		<ul class="mx-auto m-0 flex w-full max-w-site list-none flex-col items-stretch p-0 lg:flex-row lg:items-start <?php echo esc_attr( $list_gap ); ?>">
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
						<p class="<?php echo esc_attr( $value_class ); ?>">
							<?php echo esc_html( $value ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $label ) : ?>
						<p class="<?php echo esc_attr( $label_class ); ?>">
							<?php echo esc_html( $label ); ?>
						</p>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</section>
