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


?>

<section class="bg-accent-blue px-page py-10 text-white xl:px-section lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10 lg:gap-20">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 font-display text-headline leading-[1.2]">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( $body ) : ?>
			<?php echo iom_format_multiline_text( $body, 'm-0 font-sans text-label font-semibold leading-[1.2] lg:text-stat-label' ); ?>
		<?php endif; ?>
	</div>
</section>
