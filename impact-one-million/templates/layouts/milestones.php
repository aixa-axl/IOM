<?php
/**
 * Layout: milestones
 *
 * Vertical journey timeline — alternating left/right on desktop, stacked on mobile.
 *
 * Figma desktop: 634:19972 (no mobile frame — left-rail adaptation)
 */

$eyebrow    = get_sub_field( 'eyebrow' );
$heading    = get_sub_field( 'heading' );
$milestones = get_sub_field( 'milestones' );

if ( ! $eyebrow ) {
	$eyebrow = __( 'Our Journey', 'impact-one-million' );
}

if ( ! $heading ) {
	$heading = __( 'Milestones of Change', 'impact-one-million' );
}

if ( ! is_array( $milestones ) ) {
	$milestones = array();
}

/**
 * Render milestone title + body.
 *
 * @param string $title Title / year.
 * @param string $body  Description.
 * @param bool   $right Whether text is right-aligned (desktop left column).
 */
$iom_render_milestone_copy = function ( $title, $body, $right = false ) {
	$align = $right ? 'items-end text-right' : 'items-start text-left';
	?>
	<div class="flex flex-col gap-2 <?php echo esc_attr( $align ); ?>">
		<?php if ( $title ) : ?>
			<p class="m-0 font-display text-[2rem] leading-none lg:text-number">
				<?php echo esc_html( $title ); ?>
			</p>
		<?php endif; ?>
		<?php if ( $body ) : ?>
			<p class="m-0 max-w-md font-sans text-label leading-normal">
				<?php echo esc_html( $body ); ?>
			</p>
		<?php endif; ?>
	</div>
	<?php
};
?>

<section class="bg-blue px-10 py-[100px] text-white lg:px-[6.25rem]">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-20">
		<?php if ( $eyebrow || $heading ) : ?>
			<div class="flex w-full flex-col items-center gap-4 text-center">
				<?php if ( $eyebrow ) : ?>
					<p class="m-0 font-display text-label uppercase tracking-[1px] text-[#dfe8ff]">
						<?php echo esc_html( $eyebrow ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-[2.5rem] leading-[1.1] tracking-[0.02em] lg:text-title">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $milestones ) ) : ?>
			<ol class="relative m-0 flex w-full list-none flex-col p-0">
				<span
					class="absolute bottom-0 left-5 top-0 w-0.5 bg-[#dfe8ff] lg:left-1/2 lg:-translate-x-1/2"
					aria-hidden="true"
				></span>

				<?php foreach ( $milestones as $index => $item ) : ?>
					<?php
					$title = isset( $item['title'] ) ? $item['title'] : '';
					$body  = isset( $item['body'] ) ? $item['body'] : '';
					if ( ! $title && ! $body ) {
						continue;
					}

					$is_left = ( 0 === ( $index % 2 ) );
					?>
					<li class="relative flex w-full items-start py-8 lg:items-center lg:py-10">
						<!-- Desktop left column -->
						<div class="hidden min-w-0 flex-1 justify-end pr-[3.75rem] lg:flex">
							<?php if ( $is_left ) : ?>
								<?php $iom_render_milestone_copy( $title, $body, true ); ?>
							<?php endif; ?>
						</div>

						<!-- Node -->
						<span
							class="relative z-10 mt-1 size-10 shrink-0 rounded-full bg-[#dfe8ff] lg:mt-0"
							aria-hidden="true"
						></span>

						<!-- Mobile content (all) + desktop right column -->
						<div class="flex min-w-0 flex-1 pl-6 lg:pl-[3.75rem]">
							<div class="<?php echo $is_left ? 'lg:hidden' : ''; ?>">
								<?php $iom_render_milestone_copy( $title, $body, false ); ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		<?php endif; ?>
	</div>
</section>
