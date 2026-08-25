<?php
/**
 * Layout: audience_hero
 *
 * Accent-blue split hero for audience pages (Buyers / Factories / Foundations).
 * Desktop: text left + rounded image right. Mobile: text + CTA, then image.
 *
 * Figma desktop: 606:11795 — Figma mobile: 677:41976
 */

$subtitle_parent = get_sub_field( 'subtitle_parent' );
$subtitle        = get_sub_field( 'subtitle' );
$heading         = get_sub_field( 'heading' );
$body            = get_sub_field( 'body' );
$image_id        = get_sub_field( 'image' );
$cta             = get_sub_field( 'cta' );

if ( ! is_array( $cta ) ) {
	$cta = array();
}

$btn_class = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$img_attrs = array(
	'class'         => 'absolute inset-0 size-full rounded-card object-cover',
	'fetchpriority' => 'high',
	'alt'           => $heading ? $heading : '',
);
?>

<section class="bg-accent-blue px-page py-section xl:px-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-8 lg:flex-row lg:items-center lg:gap-8">
		<div class="flex w-full flex-col items-start gap-8 lg:w-[36.5rem] lg:shrink-0">
			<div class="flex w-full flex-col gap-4">
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
					<?php echo iom_format_multiline_text( $body, 'm-0 font-sans text-label leading-[1.5] text-white' ); ?>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $cta['url'] ) ) : ?>
				<?php
				iom_render_link(
					$cta,
					$btn_class,
					''
				);
				?>
			<?php endif; ?>
		</div>

		<div class="relative h-[18.625rem] w-full overflow-hidden rounded-card lg:h-[31.3125rem] lg:min-w-0 lg:flex-1">
			<?php if ( $image_id ) : ?>
				<?php echo wp_get_attachment_image( (int) $image_id, 'large', false, $img_attrs ); ?>
			<?php endif; ?>
		</div>
	</div>
</section>
