<?php
/**
 * Layout: page_hero
 *
 * Navy text hero — breadcrumb, page title, multi-paragraph body.
 * Desktop: left-aligned content capped at 800px. Mobile: stacked full-width.
 *
 * Figma desktop: 663:33042 (no mobile frame — responsive adaptation)
 */

$subtitle_parent = get_sub_field( 'subtitle_parent' );
$subtitle        = get_sub_field( 'subtitle' );
$heading         = get_sub_field( 'heading' );
$body            = get_sub_field( 'body' );

if ( ! $subtitle_parent ) {
	$subtitle_parent = __( 'About us', 'impact-one-million' );
}

if ( ! $subtitle ) {
	$subtitle = __( 'Ambassadors', 'impact-one-million' );
}

if ( ! $heading ) {
	$heading = __( 'Our Ambassadors', 'impact-one-million' );
}

if ( ! $body ) {
	$body = __( "IOM Ambassadors are champions for safe, orderly, and dignified migration. They use their voices and platforms to highlight the stories of migrants and advocate for their rights.\n\nJoin us in welcoming the individuals committed to shaping the future of global migration management.", 'impact-one-million' );
}
?>

<section class="bg-navy px-page py-20 lg:px-section lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start">
		<div class="flex w-full max-w-[50rem] flex-col items-start gap-6">
			<?php if ( $subtitle_parent || $subtitle ) : ?>
				<p class="m-0 flex flex-wrap items-start gap-2 font-display text-body uppercase tracking-[1px]">
					<?php if ( $subtitle_parent ) : ?>
						<span class="text-[#dfe8ff]"><?php echo esc_html( $subtitle_parent ); ?></span>
						<?php if ( $subtitle ) : ?>
							<span class="text-[#dfe8ff]" aria-hidden="true">/</span>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( $subtitle ) : ?>
						<span class="text-white"><?php echo esc_html( $subtitle ); ?></span>
					<?php endif; ?>
				</p>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h1 class="m-0 font-display text-title leading-[1.1] tracking-[0.02em] text-white">
					<?php echo esc_html( $heading ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( $body ) : ?>
				<div class="iom-page-hero-body m-0 font-sans text-label leading-[1.5] text-[#dfe8ff] [&_p]:m-0 [&_p+p]:mt-6">
					<?php echo wp_kses_post( wpautop( $body ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
