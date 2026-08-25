<?php
/**
 * Layout: join_reasons
 *
 * Split checklist — heading + check items.
 * Optional intro: heading full-width, then intro | checklist.
 * Without intro: heading left, checklist right (classic Why factories join).
 * Optional text under each checklist label.
 *
 * Figma desktop (classic): 670:40519
 * Figma desktop (with intro): 634:19936
 * No mobile frames — stacked adaptation
 */

$heading = get_sub_field( 'heading' );
$intro   = get_sub_field( 'intro' );
$items   = get_sub_field( 'items' );

$theme_uri = get_stylesheet_directory_uri();
$icon_uri  = $theme_uri . '/assets/images/icons/check-circle.svg';

$has_intro = (bool) $intro;

if ( ! $heading ) {
	$heading = $has_intro
		? __( 'Built on decades of experience', 'impact-one-million' )
		: __( 'Why factories join', 'impact-one-million' );
}

if ( ! is_array( $items ) || empty( $items ) ) {
	$items = $has_intro
		? array(
			array( 'label' => __( 'Built from ESCP experience', 'impact-one-million' ) ),
			array( 'label' => __( 'Proven methodologies', 'impact-one-million' ) ),
			array( 'label' => __( 'Local delivery teams', 'impact-one-million' ) ),
			array( 'label' => __( 'Trusted partnerships', 'impact-one-million' ) ),
			array( 'label' => __( 'Measurable outcomes', 'impact-one-million' ) ),
			array( 'label' => __( 'Continuous learning', 'impact-one-million' ) ),
		)
		: array(
			array( 'label' => __( 'Healthier, more engaged workforce', 'impact-one-million' ) ),
			array( 'label' => __( 'Improved retention and reduced turnover', 'impact-one-million' ) ),
			array( 'label' => __( 'Stronger leadership at every level', 'impact-one-million' ) ),
			array( 'label' => __( 'Greater resilience during periods of change', 'impact-one-million' ) ),
			array( 'label' => __( 'A more positive workplace culture', 'impact-one-million' ) ),
			array( 'label' => __( 'Improved standing with buyers who value invested suppliers', 'impact-one-million' ) ),
		);
}

/**
 * Render checklist items.
 *
 * @param array  $items    Item rows.
 * @param string $icon_uri Check icon URL.
 */
$iom_render_join_items = function ( $items, $icon_uri ) {
	?>
	<ul class="m-0 flex min-w-0 flex-1 list-none flex-col items-start gap-4 p-0">
		<?php foreach ( $items as $item ) : ?>
			<?php
			$label = isset( $item['label'] ) ? $item['label'] : '';
			$text  = isset( $item['text'] ) ? $item['text'] : '';
			if ( ! $label && ! $text ) {
				continue;
			}
			?>
			<li class="flex w-full items-start gap-3">
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
				<div class="flex min-w-0 flex-col gap-2">
					<?php if ( $label ) : ?>
						<span class="font-display text-card-title leading-none text-blue">
							<?php echo esc_html( $label ); ?>
						</span>
					<?php endif; ?>

					<?php if ( $text ) : ?>
						<p class="m-0 font-sans text-body leading-[1.2] text-muted">
							<?php echo esc_html( $text ); ?>
						</p>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
};
?>

<section class="bg-white px-page py-10 xl:p-gutter">
	<?php if ( $has_intro ) : ?>
		<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10">
			<?php if ( $heading ) : ?>
				<h2 class="m-0 w-full font-display text-headline leading-[1.2] text-blue">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<div class="flex w-full flex-col items-start gap-10 lg:flex-row lg:gap-20">
				<p class="m-0 min-w-0 flex-1 font-sans text-body leading-[1.2] text-muted">
					<?php echo esc_html( $intro ); ?>
				</p>

				<?php if ( ! empty( $items ) ) : ?>
					<?php $iom_render_join_items( $items, $icon_uri ); ?>
				<?php endif; ?>
			</div>
		</div>
	<?php else : ?>
		<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10 lg:flex-row lg:gap-20">
			<?php if ( $heading ) : ?>
				<h2 class="m-0 w-full shrink-0 font-display text-headline leading-[1.2] text-blue lg:w-[35rem]">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( ! empty( $items ) ) : ?>
				<?php $iom_render_join_items( $items, $icon_uri ); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</section>
