<?php
/**
 * Layout: latest_news
 *
 * Off-white band — heading + “See all” CTA + post cards from WP Posts.
 * Cards pull topic, date, title, excerpt, country, permalink.
 * Optional featured images (news) or text-only (case studies).
 *
 * Figma desktop (with image): 663:31960
 * Figma desktop (no image):   669:37757
 * No mobile frames — stacked adaptation
 */

$heading      = get_sub_field( 'heading' );
$see_all      = get_sub_field( 'see_all' );
$posts_count  = (int) get_sub_field( 'posts_count' );
$manual_posts = get_sub_field( 'posts' );
$link_label   = get_sub_field( 'link_label' );
$show_images  = get_sub_field( 'show_images' );

// Unset = on (legacy news sections). Explicit 0/false = case-study cards.
if ( null === $show_images || '' === $show_images ) {
	$show_images = true;
} else {
	$show_images = (bool) $show_images;
}

if ( ! $heading ) {
	$heading = __( 'Latest News', 'impact-one-million' );
}

if ( $posts_count < 1 ) {
	$posts_count = 3;
}

if ( ! $link_label ) {
	$link_label = __( 'Read case study', 'impact-one-million' );
}

$query_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);

if ( is_array( $manual_posts ) && ! empty( $manual_posts ) ) {
	$post_ids = array();
	foreach ( $manual_posts as $item ) {
		$post_ids[] = is_object( $item ) ? (int) $item->ID : (int) $item;
	}
	$post_ids = array_filter( $post_ids );

	$query_args['post__in']       = $post_ids;
	$query_args['orderby']        = 'post__in';
	$query_args['posts_per_page'] = count( $post_ids );
} else {
	$query_args['posts_per_page'] = $posts_count;
	$query_args['orderby']        = 'date';
	$query_args['order']          = 'DESC';
}

$news_query = new WP_Query( $query_args );

$btn_class  = 'inline-flex w-full items-center justify-center rounded-btn bg-accent-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90 lg:w-auto';
$link_class = 'inline-flex border-b-2 border-solid border-blue py-3.5 font-display text-[20px] uppercase tracking-[1px] text-blue no-underline transition-opacity hover:opacity-70';
?>

<section class="bg-off-white px-10 py-[100px] lg:px-16">
	<div class="mx-auto flex w-full max-w-site flex-col items-stretch gap-11">
		<div class="flex w-full flex-col items-start gap-6 lg:flex-row lg:items-center lg:justify-between lg:gap-8">
			<?php if ( $heading ) : ?>
				<h2 class="m-0 font-display text-headline leading-[1.2] text-navy">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( ! empty( $see_all['url'] ) ) : ?>
				<?php
				iom_render_link(
					$see_all,
					$btn_class,
					__( 'See all news', 'impact-one-million' )
				);
				?>
			<?php endif; ?>
		</div>

		<?php if ( $news_query->have_posts() ) : ?>
			<ul class="m-0 grid w-full list-none grid-cols-1 gap-6 p-0 lg:grid-cols-3">
				<?php
				while ( $news_query->have_posts() ) :
					$news_query->the_post();

					$post_id   = get_the_ID();
					$title     = get_the_title();
					$permalink = get_permalink();
					$date      = get_the_date();
					$excerpt   = get_the_excerpt();

					$topic = function_exists( 'iom_get_post_topic_label' ) ? iom_get_post_topic_label( $post_id ) : '';

					$countries = get_the_terms( $post_id, 'country' );
					$country   = ( ! empty( $countries ) && ! is_wp_error( $countries ) ) ? $countries[0]->name : '';

					$img_attrs = array(
						'class'   => 'absolute inset-0 size-full object-cover',
						'loading' => 'lazy',
						'alt'     => $title ? $title : '',
					);
					?>
					<li class="flex flex-col overflow-hidden rounded-card border border-solid border-[#dfe8ff] bg-white">
						<?php if ( $show_images ) : ?>
							<a href="<?php echo esc_url( $permalink ); ?>" class="relative aspect-[5/3] w-full shrink-0 overflow-hidden border border-solid border-[#e5e7eb] no-underline">
								<?php if ( has_post_thumbnail( $post_id ) ) : ?>
									<?php echo get_the_post_thumbnail( $post_id, 'large', $img_attrs ); ?>
								<?php else : ?>
									<span class="absolute inset-0 bg-off-white" aria-hidden="true"></span>
								<?php endif; ?>
							</a>
						<?php endif; ?>

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
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
		<?php endif; ?>
	</div>
</section>
