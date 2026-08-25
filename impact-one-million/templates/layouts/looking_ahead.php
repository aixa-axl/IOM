<?php
/**
 * Layout: looking_ahead
 *
 * Centered eyebrow + heading, navy goal pills, outline CTA.
 *
 * Figma desktop: 634:20193 (no mobile frame — stacked / wrap adaptation)
 */

$eyebrow = get_sub_field( 'eyebrow' );
$heading = get_sub_field( 'heading' );
$goals   = get_sub_field( 'goals' );
$cta     = get_sub_field( 'cta' );

if ( ! $eyebrow ) {
	$eyebrow = __( 'Looking Ahead', 'impact-one-million' );
}

if ( ! $heading ) {
	$heading = __( 'Future impact goals', 'impact-one-million' );
}

if ( ! is_array( $goals ) ) {
	$goals = array();
}

if ( ! is_array( $cta ) ) {
	$cta = array();
}

$btn_class = 'inline-flex w-full max-w-[21.75rem] items-center justify-center rounded-btn border-[1.5px] border-solid border-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-80 lg:w-auto lg:max-w-none';
?>

<section class="iom-looking-ahead bg-white px-page py-10 xl:p-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10">
		<?php if ( $eyebrow || $heading ) : ?>
			<div class="flex w-full flex-col items-center gap-4 text-center">
				<?php if ( $eyebrow ) : ?>
					<p class="m-0 font-display text-body uppercase tracking-[1px] text-accent">
						<?php echo esc_html( $eyebrow ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $goals ) ) : ?>
			<ul class="m-0 flex w-full max-w-[55.375rem] list-none flex-wrap content-start items-start justify-center gap-4 p-0">
				<?php foreach ( $goals as $goal ) : ?>
					<?php
					$label = isset( $goal['label'] ) ? $goal['label'] : '';
					if ( ! $label ) {
						continue;
					}
					?>
					<li class="flex w-full items-start justify-center rounded-card bg-navy px-6 py-3 sm:w-auto">
						<span class="text-center font-display text-label leading-[1.2] text-white lg:text-stat-label">
							<?php echo esc_html( $label ); ?>
						</span>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( ! empty( $cta['url'] ) ) : ?>
			<?php
			iom_render_link(
				$cta,
				$btn_class,
				__( 'View our ambition', 'impact-one-million' )
			);
			?>
		<?php endif; ?>
	</div>
</section>
