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

if ( ! $heading ) {
	$heading = __( 'Our Ambition', 'impact-one-million' );
}

if ( ! $body ) {
	$body = __( "Our vision is long-term. We don't just fix symptoms; we address the root causes of worker vulnerability by transforming the ecosystem of the workplace and the home.", 'impact-one-million' );
}

if ( ! is_array( $items ) ) {
	$items = array();
}
?>

<section class="bg-white px-page py-10 xl:px-section lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10 lg:flex-row lg:gap-20">
		<div class="flex w-full shrink-0 flex-col gap-6 lg:w-[31.25rem]">
			<?php if ( $heading ) : ?>
				<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( $body ) : ?>
				<p class="m-0 font-sans text-body leading-[1.2] text-muted">
					<?php echo esc_html( $body ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $items ) ) : ?>
			<ul class="m-0 flex min-w-0 flex-1 list-none flex-col items-start gap-8 p-0">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$label = isset( $item['label'] ) ? $item['label'] : '';
					if ( ! $label ) {
						continue;
					}
					?>
					<li class="flex w-full items-center gap-6">
						<span class="size-6 shrink-0 rounded-full bg-accent-blue" aria-hidden="true"></span>
						<span class="min-w-0 font-sans text-label leading-normal text-blue">
							<?php echo esc_html( $label ); ?>
						</span>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
