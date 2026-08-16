<?php
/**
 * Layout: process_steps
 *
 * "How It Works" step cards for audience pages.
 * Desktop: 3 on first row, 2 on second. Mobile: stacked.
 *
 * Figma desktop: 606:11829 — Figma mobile: 677:41991
 */

$heading = get_sub_field( 'heading' );
$steps   = get_sub_field( 'steps' );
$cta     = get_sub_field( 'cta' );

if ( ! $heading ) {
	$heading = __( 'How It Works', 'impact-one-million' );
}

if ( ! is_array( $steps ) || empty( $steps ) ) {
	$steps = array(
		array(
			'step_label' => __( 'Step 1', 'impact-one-million' ),
			'title'      => __( 'Nominate', 'impact-one-million' ),
			'body'       => __( 'Identify supplier factories in your chain. IOM reviews against eligibility criteria. You receive confirmation the supplier is in scope.', 'impact-one-million' ),
		),
		array(
			'step_label' => __( 'Step 2', 'impact-one-million' ),
			'title'      => __( 'Fund', 'impact-one-million' ),
			'body'       => __( 'Commit funding to the programme. IOM designs a tailored programme for that factory. You receive a programme plan.', 'impact-one-million' ),
		),
		array(
			'step_label' => __( 'Step 3', 'impact-one-million' ),
			'title'      => __( 'Report', 'impact-one-million' ),
			'body'       => __( 'The programme runs on the ground. IOM tracks delivery throughout. You receive transparent, regular reporting.', 'impact-one-million' ),
		),
		array(
			'step_label' => __( 'Step 4', 'impact-one-million' ),
			'title'      => __( 'Measure', 'impact-one-million' ),
			'body'       => __( 'Outcomes tracked against canonical impact metrics. You receive measurable results tied to your own ESG and impact commitments.', 'impact-one-million' ),
		),
		array(
			'step_label' => __( 'Step 5', 'impact-one-million' ),
			'title'      => __( 'Scale', 'impact-one-million' ),
			'body'       => __( 'Review outcomes with IOM. Option to expand the programme to more suppliers or renew for another cycle.', 'impact-one-million' ),
		),
	);
}

if ( ! is_array( $cta ) || empty( $cta['url'] ) ) {
	$cta = array(
		'url'    => '#',
		'title'  => __( 'Nominate a Supplier', 'impact-one-million' ),
		'target' => '',
	);
}

$btn_class = 'inline-flex items-center justify-center rounded-btn bg-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
?>

<section class="bg-off-white px-10 py-section lg:px-[7.5rem] lg:py-24">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 text-center font-display text-headline leading-[1.2] text-blue">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( ! empty( $steps ) ) : ?>
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
