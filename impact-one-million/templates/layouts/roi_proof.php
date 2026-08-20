<?php
/**
 * Layout: roi_proof
 *
 * Eyebrow + heading + value cards + CTA ("Evidence you can measure").
 *
 * Figma desktop: 606:11728 — Figma mobile: 677:41490
 */

$eyebrow = get_sub_field( 'eyebrow' );
$heading = get_sub_field( 'heading' );
$stats   = get_sub_field( 'stats' );
$cta     = get_sub_field( 'cta' );

if ( ! $eyebrow ) {
	$eyebrow = __( 'Stats', 'impact-one-million' );
}

if ( ! $heading ) {
	$heading = __( 'Evidence you can measure', 'impact-one-million' );
}

if ( ! is_array( $stats ) || empty( $stats ) ) {
	$stats = array(
		array(
			'value' => '20',
			'label' => __( 'years of family and early childhood programmes, delivered across [X] communities', 'impact-one-million' ),
		),
		array(
			'value' => '[X,XXX]',
			'label' => __( 'parents supported through early years programmes to date.', 'impact-one-million' ),
		),
	);
}

if ( ! is_array( $cta ) || empty( $cta['url'] ) ) {
	$cta = array(
		'url'    => '#',
		'title'  => __( 'How can i make an impact?', 'impact-one-million' ),
		'target' => '',
	);
}

$btn_class = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
?>

<section class="bg-off-white px-page py-section xl:px-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-20 lg:gap-8">
		<div class="flex flex-col gap-10 lg:gap-8">
			<?php if ( $eyebrow ) : ?>
				<p class="m-0 font-display text-label uppercase tracking-[1px] text-accent">
					<?php echo esc_html( $eyebrow ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $stats ) ) : ?>
			<ul class="m-0 flex w-full list-none flex-col gap-[3.75rem] p-0 lg:flex-row lg:gap-8">
				<?php foreach ( $stats as $stat ) : ?>
					<?php
					$value = isset( $stat['value'] ) ? $stat['value'] : '';
					$label = isset( $stat['label'] ) ? $stat['label'] : '';
					if ( ! $value && ! $label ) {
						continue;
					}
					?>
					<li class="flex w-full flex-col items-center justify-center gap-6 rounded-card bg-white px-10 py-5 lg:flex-1 lg:items-start lg:self-stretch">
						<?php if ( $value ) : ?>
							<p class="m-0 font-display text-number leading-none text-navy">
								<?php echo esc_html( $value ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $label ) : ?>
							<p class="m-0 w-full text-center font-sans text-label leading-6 text-blue lg:text-left">
								<?php echo esc_html( $label ); ?>
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
				__( 'How can i make an impact?', 'impact-one-million' )
			);
			?>
		<?php endif; ?>
	</div>
</section>
