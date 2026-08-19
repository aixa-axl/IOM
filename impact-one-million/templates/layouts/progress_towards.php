<?php
/**
 * Layout: progress_towards
 *
 * Centered heading + subtitle, then a row of text stats (value + label).
 * Desktop: evenly spaced row. Mobile: stacked.
 *
 * Figma desktop: 634:20464 (no mobile frame — stacked adaptation)
 */

$heading  = get_sub_field( 'heading' );
$subtitle = get_sub_field( 'subtitle' );
$stats    = get_sub_field( 'stats' );

if ( ! $heading ) {
	$heading = __( 'Progress Towards One Million', 'impact-one-million' );
}

if ( ! $subtitle ) {
	$subtitle = __( 'Real-time data from our partner network.', 'impact-one-million' );
}

if ( ! is_array( $stats ) ) {
	$stats = array();
}
?>

<section class="border-y border-solid border-[#e5e7eb] bg-white px-page py-20 lg:px-section lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-16">
		<?php if ( $heading || $subtitle ) : ?>
			<div class="flex w-full flex-col items-center gap-4 text-center">
				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $subtitle ) : ?>
					<p class="m-0 font-sans text-body leading-[1.2] text-muted">
						<?php echo esc_html( $subtitle ); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $stats ) ) : ?>
			<ul class="m-0 flex w-full list-none flex-col items-center gap-10 p-0 lg:flex-row lg:items-start lg:justify-between lg:gap-4">
				<?php foreach ( $stats as $stat ) : ?>
					<?php
					$value = isset( $stat['value'] ) ? $stat['value'] : '';
					$label = isset( $stat['label'] ) ? $stat['label'] : '';
					if ( ! $value && ! $label ) {
						continue;
					}
					?>
					<li class="flex flex-col items-center gap-2 text-center">
						<?php if ( $value ) : ?>
							<p class="m-0 font-display text-number leading-none text-blue">
								<?php echo esc_html( $value ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $label ) : ?>
							<p class="m-0 font-display text-label uppercase leading-[1.2] tracking-[1px] text-accent-blue">
								<?php echo esc_html( $label ); ?>
							</p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
