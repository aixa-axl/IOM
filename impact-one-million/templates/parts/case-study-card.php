<?php
/**
 * Case study card markup (press / case-study grid).
 *
 * Expects $post_id and optional $link_label in scope.
 *
 * @package Impact_One_Million
 */

if ( ! isset( $post_id ) || ! $post_id ) {
	return;
}

$title     = get_the_title( $post_id );
$permalink = get_permalink( $post_id );
$date      = get_the_date( '', $post_id );
$excerpt   = get_the_excerpt( $post_id );

if ( empty( $link_label ) ) {
	$link_label = __( 'Read case study', 'impact-one-million' );
}

$topic = function_exists( 'iom_get_post_topic_label' ) ? iom_get_post_topic_label( $post_id ) : '';

$countries = get_the_terms( $post_id, 'country' );
$country   = ( ! empty( $countries ) && ! is_wp_error( $countries ) ) ? $countries[0]->name : '';

$img_attrs = array(
	'class'   => 'absolute inset-0 size-full object-cover',
	'loading' => 'lazy',
	'alt'     => $title ? $title : '',
);

$link_class = 'inline-flex border-b-2 border-solid border-blue py-3.5 font-display text-[20px] uppercase tracking-[1px] text-blue no-underline transition-opacity hover:opacity-70';
?>
<li class="flex flex-col overflow-hidden rounded-card border border-solid border-[#dfe8ff] bg-white">
	<a href="<?php echo esc_url( $permalink ); ?>" class="relative aspect-[5/3] w-full shrink-0 overflow-hidden border border-solid border-[#e5e7eb] no-underline">
		<?php if ( has_post_thumbnail( $post_id ) ) : ?>
			<?php echo get_the_post_thumbnail( $post_id, 'large', $img_attrs ); ?>
		<?php else : ?>
			<span class="absolute inset-0 bg-off-white" aria-hidden="true"></span>
		<?php endif; ?>
	</a>

	<div class="flex flex-1 flex-col gap-8 px-3 pb-3 pt-6">
		<div class="flex flex-col gap-4">
			<div class="flex flex-wrap items-center gap-3">
				<?php if ( $topic ) : ?>
					<span class="rounded-btn border-[1.5px] border-solid border-accent-blue px-2 py-1 font-display text-body uppercase tracking-[1px] text-accent-blue">
						<?php echo esc_html( $topic ); ?>
					</span>
				<?php endif; ?>

				<?php if ( $date ) : ?>
					<span class="font-sans text-sm leading-[1.2] text-muted">
						<?php echo esc_html( $date ); ?>
					</span>
				<?php endif; ?>
			</div>

			<?php if ( $title ) : ?>
				<h3 class="m-0">
					<a href="<?php echo esc_url( $permalink ); ?>" class="font-display text-card-title leading-none text-navy no-underline transition-opacity hover:opacity-80">
						<?php echo esc_html( $title ); ?>
					</a>
				</h3>
			<?php endif; ?>

			<?php if ( $excerpt ) : ?>
				<p class="m-0 line-clamp-2 font-sans text-body leading-[1.2] text-muted">
					<?php echo esc_html( $excerpt ); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="mt-auto flex flex-wrap items-center justify-between gap-4">
			<?php if ( $country ) : ?>
				<span class="inline-flex items-center gap-1 rounded-btn bg-[#dfe8ff] px-[7px] py-[3px] font-display text-body uppercase tracking-[1px] text-blue">
					<span class="size-2.5 shrink-0 rounded-full bg-blue" aria-hidden="true"></span>
					<?php echo esc_html( $country ); ?>
				</span>
			<?php else : ?>
				<span></span>
			<?php endif; ?>

			<a href="<?php echo esc_url( $permalink ); ?>" class="<?php echo esc_attr( $link_class ); ?>">
				<?php echo esc_html( $link_label ); ?>
			</a>
		</div>
	</div>
</li>
