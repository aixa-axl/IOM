<?php
/**
 * Layout: why_it_matters
 *
 * Full-bleed stat callout — eyebrow + big number + supporting line.
 * Reused on pillar pages (Family & ECD, etc.).
 *
 * Figma desktop: 606:11694 — Figma mobile: 677:41472
 */

$eyebrow = get_sub_field( 'eyebrow' );
$stat    = get_sub_field( 'stat' );
$body    = get_sub_field( 'body' );

if ( ! $eyebrow ) {
	$eyebrow = __( 'Why it matters', 'impact-one-million' );
}

if ( ! $stat ) {
	$stat = __( '1 in 5', 'impact-one-million' );
}

if ( ! $body ) {
	$body = __( 'children in low- and middle-income countries face severe deprivation in essential areas like nutrition, healthcare and education. (UNICEF)', 'impact-one-million' );
}
?>

<section class="bg-accent px-10 py-section lg:px-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10 text-center text-white">
		<?php if ( $eyebrow ) : ?>
			<p class="m-0 font-display text-label uppercase tracking-[1px]">
				<?php echo esc_html( $eyebrow ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $stat ) : ?>
			<p class="m-0 font-display text-title leading-[1.1] tracking-[0.02em] lg:text-[7.5rem] lg:leading-none lg:tracking-normal">
				<?php echo esc_html( $stat ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $body ) : ?>
			<p class="m-0 max-w-[56.25rem] font-display text-stat-label leading-[1.2]">
				<?php echo esc_html( $body ); ?>
			</p>
		<?php endif; ?>
	</div>
</section>
