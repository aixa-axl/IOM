<?php
/**
 * Layout: our_ambition
 *
 * Split — heading + body left, accent-blue bullet list right.
 * Desktop: two columns. Mobile: stacked.
 *
 * Figma desktop: 634:20375 (no mobile frame — stacked adaptation)
 */

$heading = get_sub_field( 'heading' );
$body    = get_sub_field( 'body' );
$items   = get_sub_field( 'items' );



if ( ! is_array( $items ) ) {
	$items = array();
}

// Ambition page only: less top padding on mobile when Why This Matters precedes (set in page.php).
$section_class = ! empty( $iom_tighten_our_ambition_top )
	? 'iom-our-ambition bg-white px-page pt-6 pb-10 xl:px-section lg:py-gutter'
	: 'iom-our-ambition bg-white px-page py-10 xl:px-section lg:py-gutter';
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10 lg:flex-row lg:gap-20">
		<div class="flex w-full shrink-0 flex-col gap-6 lg:w-[31.25rem]">
			<?php if ( $heading ) : ?>
				<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( $body ) : ?>
				<?php echo iom_format_multiline_text( $body, 'm-0 font-sans text-body leading-[1.2] text-muted' ); ?>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $items ) ) : ?>
			<ul class="m-0 flex min-w-0 flex-1 list-none flex-col items-start gap-4 p-0">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$label      = isset( $item['label'] ) ? $item['label'] : '';
					$text       = isset( $item['text'] ) ? $item['text'] : '';
					$bold_label = ! empty( $item['bold_label'] );
					if ( ! $label && ! $text ) {
						continue;
					}
					$label_class = $bold_label
						? 'font-display text-label font-semibold leading-normal text-blue'
						: 'font-display text-label leading-normal text-blue';
					?>
					<li class="flex w-full items-start gap-6">
						<span class="mt-2 size-6 shrink-0 rounded-full bg-accent-blue" aria-hidden="true"></span>
						<div class="flex min-w-0 flex-col gap-2">
							<?php if ( $label ) : ?>
								<span class="<?php echo esc_attr( $label_class ); ?>">
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
		<?php endif; ?>
	</div>
</section>
