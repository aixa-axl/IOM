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


if ( ! is_array( $items ) ) {
	$items = array();
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
						<?php echo iom_format_multiline_text( $text, 'm-0 font-sans text-body leading-[1.2] text-muted' ); ?>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
};

// Supply chain page only: less bottom padding when Pillars follows (set in page.php).
$section_class = ! empty( $iom_tighten_join_reasons_bottom )
	? 'iom-join-reasons bg-white px-page py-10 xl:px-gutter xl:pt-gutter xl:pb-10'
	: 'iom-join-reasons bg-white px-page py-10 xl:p-gutter';
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<?php if ( $has_intro ) : ?>
		<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10">
			<?php if ( $heading ) : ?>
				<h2 class="m-0 w-full font-display text-headline leading-[1.2] text-blue">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<div class="flex w-full flex-col items-start gap-10 lg:flex-row lg:gap-20">
				<div class="min-w-0 flex-1">
					<?php echo iom_format_multiline_text( $intro, 'm-0 font-sans text-body leading-[1.2] text-muted' ); ?>
				</div>

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
