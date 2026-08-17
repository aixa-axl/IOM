<?php
/**
 * Layout: join_reasons
 *
 * Split checklist — heading left, check items right (stacks on mobile).
 *
 * Figma desktop: 670:40519 (no mobile frame — stacked adaptation)
 */

$heading = get_sub_field( 'heading' );
$items   = get_sub_field( 'items' );

$theme_uri = get_stylesheet_directory_uri();
$icon_uri  = $theme_uri . '/assets/images/icons/check-circle.svg';

if ( ! $heading ) {
	$heading = __( 'Why factories join', 'impact-one-million' );
}

if ( ! is_array( $items ) || empty( $items ) ) {
	$items = array(
		array( 'label' => __( 'Healthier, more engaged workforce', 'impact-one-million' ) ),
		array( 'label' => __( 'Improved retention and reduced turnover', 'impact-one-million' ) ),
		array( 'label' => __( 'Stronger leadership at every level', 'impact-one-million' ) ),
		array( 'label' => __( 'Greater resilience during periods of change', 'impact-one-million' ) ),
		array( 'label' => __( 'A more positive workplace culture', 'impact-one-million' ) ),
		array( 'label' => __( 'Improved standing with buyers who value invested suppliers', 'impact-one-million' ) ),
	);
}
?>

<section class="bg-white px-10 py-20 lg:p-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10 lg:flex-row lg:gap-20">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 w-full shrink-0 font-display text-headline leading-[1.2] text-blue lg:w-[35rem]">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( ! empty( $items ) ) : ?>
			<ul class="m-0 flex min-w-0 flex-1 list-none flex-col items-start gap-4 p-0">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$label = isset( $item['label'] ) ? $item['label'] : '';
					if ( ! $label ) {
						continue;
					}
					?>
					<li class="flex w-full items-center gap-3">
						<img
							src="<?php echo esc_url( $icon_uri ); ?>"
							alt=""
							width="40"
							height="40"
							class="size-10 shrink-0"
							loading="lazy"
							decoding="async"
							aria-hidden="true"
						>
						<span class="min-w-0 font-display text-card-title leading-none text-blue">
							<?php echo esc_html( $label ); ?>
						</span>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
