<?php
/**
 * Layout: featured_case_study
 *
 * Featured post / case study — image left, meta + title + excerpt + CTA right.
 * Editors pick which post to feature via ACF post object.
 *
 * Fields: case_study (post), featured_label, cta_label
 *
 * Figma desktop: 634:20500 (no mobile frame — stacked adaptation)
 */

$case_study     = get_sub_field( 'case_study' );
$featured_label = get_sub_field( 'featured_label' );
$cta_label      = get_sub_field( 'cta_label' );

if ( null === $featured_label ) {
	$featured_label = __( 'Featured', 'impact-one-million' );
}

if ( ! $cta_label ) {
	$cta_label = __( 'Read case study', 'impact-one-million' );
}

$post_id = 0;
if ( $case_study instanceof WP_Post ) {
	$post_id = (int) $case_study->ID;
} elseif ( is_numeric( $case_study ) ) {
	$post_id = (int) $case_study;
}

if ( ! $post_id || 'publish' !== get_post_status( $post_id ) ) {
	return;
}

$title     = get_the_title( $post_id );
$permalink = get_permalink( $post_id );
$date      = get_the_date( '', $post_id );
$excerpt   = get_the_excerpt( $post_id );

$topic = function_exists( 'iom_get_post_topic_label' ) ? iom_get_post_topic_label( $post_id ) : '';

$btn_class = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$img_attrs = array(
	'class'   => 'absolute inset-0 size-full object-cover',
	'loading' => 'lazy',
	'alt'     => $title ? $title : '',
);
?>

<section class="bg-white px-10 py-20 lg:px-section lg:py-gutter">
	<article class="mx-auto flex w-full max-w-site flex-col items-stretch gap-8 lg:flex-row lg:items-center lg:gap-8">
		<a
			href="<?php echo esc_url( $permalink ); ?>"
			class="relative aspect-[748/500] w-full shrink-0 overflow-hidden border border-solid border-[#e5e7eb] no-underline lg:aspect-auto lg:h-[31.25rem] lg:w-[62.333%] lg:max-w-[46.75rem]"
		>
			<?php if ( has_post_thumbnail( $post_id ) ) : ?>
				<?php echo get_the_post_thumbnail( $post_id, 'large', $img_attrs ); ?>
			<?php else : ?>
				<span class="absolute inset-0 bg-off-white" aria-hidden="true"></span>
			<?php endif; ?>
		</a>

		<div class="flex min-w-0 flex-1 flex-col items-start gap-8">
			<div class="flex w-full flex-col items-start gap-4">
				<div class="flex w-full flex-wrap items-center justify-between gap-3">
					<div class="flex flex-wrap items-center gap-3">
						<?php if ( $topic ) : ?>
							<span class="rounded-btn border-[1.5px] border-solid border-transparent bg-accent-blue px-2 py-1 font-display text-body uppercase tracking-[1px] text-white">
								<?php echo esc_html( $topic ); ?>
							</span>
						<?php endif; ?>

						<?php if ( $date ) : ?>
							<span class="font-sans text-body leading-[1.2] text-muted">
								<?php echo esc_html( $date ); ?>
							</span>
						<?php endif; ?>
					</div>

					<?php if ( $featured_label ) : ?>
						<span class="font-display text-[22px] uppercase leading-none text-accent">
							<?php echo esc_html( $featured_label ); ?>
						</span>
					<?php endif; ?>
				</div>

				<?php if ( $title ) : ?>
					<h2 class="m-0">
						<a href="<?php echo esc_url( $permalink ); ?>" class="font-display text-header leading-none text-navy no-underline transition-opacity hover:opacity-80">
							<?php echo esc_html( $title ); ?>
						</a>
					</h2>
				<?php endif; ?>

				<?php if ( $excerpt ) : ?>
					<p class="m-0 font-sans text-body leading-[1.2] text-muted">
						<?php echo esc_html( $excerpt ); ?>
					</p>
				<?php endif; ?>
			</div>

			<a href="<?php echo esc_url( $permalink ); ?>" class="<?php echo esc_attr( $btn_class ); ?>">
				<?php echo esc_html( $cta_label ); ?>
			</a>
		</div>
	</article>
</section>
