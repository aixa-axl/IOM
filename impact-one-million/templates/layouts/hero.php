<?php
/**
 * Layout: hero
 *
 * ACF layout name: hero
 * Fields: heading, subheading, background_image (ID), cta (link)
 */

$heading    = get_sub_field( 'heading' );
$subheading = get_sub_field( 'subheading' );
$image_id   = get_sub_field( 'background_image' );
$cta        = get_sub_field( 'cta' );
?>

<section class="relative flex min-h-[70vh] items-center overflow-hidden bg-off-white">
	<?php if ( $image_id ) : ?>
		<?php
		echo wp_get_attachment_image(
			$image_id,
			'full',
			false,
			array(
				'class'         => 'absolute inset-0 h-full w-full object-cover',
				'fetchpriority' => 'high',
			)
		);
		?>
	<?php endif; ?>

	<div class="relative z-10 mx-auto flex w-full max-w-site justify-end px-5 py-20 lg:px-gutter">
		<div class="flex w-full max-w-xl flex-col items-start gap-6 bg-white p-8 shadow-sm lg:p-10">
			<?php if ( $heading ) : ?>
				<h1 class="font-display text-headline text-navy">
					<?php echo esc_html( $heading ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( $subheading ) : ?>
				<p class="font-sans text-body text-muted">
					<?php echo esc_html( $subheading ); ?>
				</p>
			<?php endif; ?>

			<?php if ( ! empty( $cta['url'] ) ) : ?>
				<a
					href="<?php echo esc_url( $cta['url'] ); ?>"
					class="inline-flex items-center rounded-btn bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90"
					<?php echo ! empty( $cta['target'] ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
				>
					<?php echo esc_html( $cta['title'] ? $cta['title'] : __( 'Join the Movement', 'impact-one-million' ) ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
