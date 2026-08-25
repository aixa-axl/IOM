<?php
/**
 * Layout: governance_structure
 *
 * Blue band — heading left, body + item list right.
 * Desktop: two columns. Mobile: stacked.
 *
 * Figma desktop: 662:31367 (no mobile frame — stacked adaptation)
 */

$heading = get_sub_field( 'heading' );
$body    = get_sub_field( 'body' );
$items   = get_sub_field( 'items' );



if ( ! is_array( $items ) ) {
	$items = array();
}
?>

<section class="bg-blue px-page py-10 text-white xl:px-section lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10 lg:flex-row lg:gap-20">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 w-full shrink-0 font-display text-headline leading-[1.2] lg:w-[31.25rem]">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<div class="flex min-w-0 flex-1 flex-col items-start gap-8">
			<?php if ( $body ) : ?>
				<div class="m-0 font-sans text-body leading-[1.2] [&_a]:underline [&_b]:font-semibold [&_p]:m-0 [&_p+p]:mt-2 [&_strong]:font-semibold">
					<?php echo wp_kses_post( $body ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $items ) ) : ?>
				<ul class="m-0 flex w-full list-none flex-col items-start gap-4 p-0">
					<?php foreach ( $items as $item ) : ?>
						<?php
						$label = isset( $item['label'] ) ? $item['label'] : '';
						if ( ! $label ) {
							continue;
						}
						?>
						<li class="font-display text-card-title leading-none">
							<?php echo esc_html( $label ); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>
