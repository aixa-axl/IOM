<?php
/**
 * Layout: why_model_works
 *
 * Accent-blue band — left-aligned headline + large demi body.
 *
 * Figma desktop: 606:12530 (no mobile frame — stacked adaptation)
 */

$heading = get_sub_field( 'heading' );
$body    = get_sub_field( 'body' );

if ( ! $heading ) {
	$heading = __( 'A model built on partnership', 'impact-one-million' );
}

if ( ! $body ) {
	$body = __( 'Impact One Million works because it sits where the need is greatest — inside the supply chains that touch millions of lives every day. By partnering with buyers and factories directly, funding reaches workers and their families faster, with less overhead and more accountability than delivering support from the outside in.', 'impact-one-million' );
}
?>

<section class="bg-accent-blue px-page py-10 text-white lg:px-section lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10 lg:gap-20">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 font-display text-headline leading-[1.2]">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( $body ) : ?>
			<p class="m-0 font-sans text-label font-semibold leading-[1.2] lg:text-stat-label">
				<?php echo esc_html( $body ); ?>
			</p>
		<?php endif; ?>
	</div>
</section>
