<?php
/**
 * Layout: process_steps
 *
 * Step cards — grid (audience “How It Works”) or vertical stack (ambition “How We’ll Get There”).
 *
 * Figma desktop (grid): 606:11829 — mobile: 677:41991
 * Figma desktop (vertical): 634:20396 (no mobile frame — stacked adaptation)
 */

$variant = get_sub_field( 'variant' );
$heading = get_sub_field( 'heading' );
$steps   = get_sub_field( 'steps' );
$cta     = get_sub_field( 'cta' );

if ( ! in_array( $variant, array( 'grid', 'vertical' ), true ) ) {
	$variant = 'grid';
}

$is_vertical = ( 'vertical' === $variant );

if ( ! $heading ) {
	$heading = $is_vertical
		? __( "How We'll Get There", 'impact-one-million' )
		: __( 'How It Works', 'impact-one-million' );
}

if ( ! is_array( $steps ) ) {
	$steps = array();
}

if ( ! is_array( $cta ) ) {
	$cta = array();
}

$btn_class = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$section_class = $is_vertical
	? 'bg-blue px-page py-section lg:py-20 xl:px-section xl:py-20'
	: 'bg-off-white px-page py-section xl:px-[7.5rem] lg:py-24';

$heading_class = $is_vertical
	? 'm-0 text-center font-display text-headline leading-[1.2] text-white'
	: 'm-0 text-center font-display text-headline leading-[1.2] text-blue';

$outer_gap = $is_vertical ? 'gap-20 lg:gap-10' : 'gap-10';
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<div class="mx-auto flex w-full max-w-site flex-col items-center <?php echo esc_attr( $outer_gap ); ?>">
		<?php if ( $heading ) : ?>
			<h2 class="<?php echo esc_attr( $heading_class ); ?>">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( ! empty( $steps ) ) : ?>
			<?php if ( $is_vertical ) : ?>
				<ol class="m-0 flex w-full max-w-[25rem] list-none flex-col items-center gap-10 p-0 lg:gap-6">
					<?php
					$step_count = 0;
					foreach ( $steps as $step ) {
						$title = isset( $step['title'] ) ? $step['title'] : '';
						$body  = isset( $step['body'] ) ? $step['body'] : '';
						if ( $title || $body ) {
							++$step_count;
						}
					}
					$rendered = 0;
					foreach ( $steps as $index => $step ) :
						$step_label = isset( $step['step_label'] ) ? $step['step_label'] : '';
						$title      = isset( $step['title'] ) ? $step['title'] : '';
						$body       = isset( $step['body'] ) ? $step['body'] : '';

						if ( ! $title && ! $body ) {
							continue;
						}

						++$rendered;

						if ( ! $step_label ) {
							/* translators: %d: step number */
							$step_label = sprintf( __( 'Step %d', 'impact-one-million' ), $rendered );
						}
						?>
						<li class="flex w-full flex-col items-center gap-10 lg:gap-4">
							<div class="flex w-full flex-col items-center justify-center gap-4 rounded-card bg-off-white p-3 text-center">
								<div class="flex w-full flex-col items-center justify-center gap-4 uppercase">
									<p class="m-0 font-display text-body tracking-[1px] text-accent">
										<?php echo esc_html( $step_label ); ?>
									</p>
									<?php if ( $title ) : ?>
										<h3 class="m-0 font-display text-card-title leading-none tracking-[2px] text-blue">
											<?php echo esc_html( $title ); ?>
										</h3>
									<?php endif; ?>
								</div>

								<?php if ( $body ) : ?>
									<p class="m-0 font-sans text-body leading-[1.2] text-muted">
										<?php echo esc_html( $body ); ?>
									</p>
								<?php endif; ?>
							</div>

							<?php if ( $rendered < $step_count ) : ?>
								<span class="flex size-11 items-center justify-center text-accent-blue" aria-hidden="true">
									<svg
										class="h-[2.8125rem] w-11 rotate-90"
										width="44"
										height="45"
										viewBox="0 0 44 45"
										fill="none"
										xmlns="http://www.w3.org/2000/svg"
										aria-hidden="true"
									>
										<path d="M0 30.99V15.787L24.64 13.449V0L44 21.635L24.64 45.023V30.99H0Z" fill="currentColor"/>
									</svg>
								</span>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ol>
			<?php else : ?>
				<ul class="m-0 grid w-full list-none grid-cols-1 gap-4 p-0 lg:grid-cols-3 lg:gap-6">
					<?php foreach ( $steps as $index => $step ) : ?>
						<?php
						$step_label = isset( $step['step_label'] ) ? $step['step_label'] : '';
						$title      = isset( $step['title'] ) ? $step['title'] : '';
						$body       = isset( $step['body'] ) ? $step['body'] : '';

						if ( ! $step_label ) {
							/* translators: %d: step number */
							$step_label = sprintf( __( 'Step %d', 'impact-one-million' ), $index + 1 );
						}

						if ( ! $title && ! $body ) {
							continue;
						}
						?>
						<li class="flex flex-col gap-4 rounded-card bg-white p-3">
							<div class="flex flex-col gap-4 uppercase">
								<p class="m-0 font-display text-body tracking-[1px] text-accent">
									<?php echo esc_html( $step_label ); ?>
								</p>
								<?php if ( $title ) : ?>
									<h3 class="m-0 font-display text-card-title leading-none tracking-[2px] text-blue">
										<?php echo esc_html( $title ); ?>
									</h3>
								<?php endif; ?>
							</div>

							<?php if ( $body ) : ?>
								<p class="m-0 font-sans text-body leading-[1.2] text-muted">
									<?php echo esc_html( $body ); ?>
								</p>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( ! empty( $cta['url'] ) ) : ?>
			<?php
			iom_render_link(
				$cta,
				$btn_class,
				__( 'Nominate a Supplier', 'impact-one-million' )
			);
			?>
		<?php endif; ?>
	</div>
</section>
