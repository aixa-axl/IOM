<?php
/**
 * News article single.
 *
 * Expects $post_id in scope.
 *
 * Figma: 634:21152 (news-article-lofi)
 *
 * @package Impact_One_Million
 */

if ( empty( $post_id ) ) {
	$post_id = get_the_ID();
}

$title     = get_the_title( $post_id );
$permalink = get_permalink( $post_id );
$date      = get_the_date( '', $post_id );

$breadcrumb_label = function_exists( 'get_field' ) ? get_field( 'news_breadcrumb_label', $post_id ) : '';
$breadcrumb_title = function_exists( 'get_field' ) ? get_field( 'news_breadcrumb_title', $post_id ) : '';
$display_title    = function_exists( 'get_field' ) ? get_field( 'news_display_title', $post_id ) : '';
$author           = function_exists( 'get_field' ) ? get_field( 'news_author', $post_id ) : '';
$read_time        = function_exists( 'get_field' ) ? get_field( 'news_read_time', $post_id ) : '';
$body             = function_exists( 'get_field' ) ? get_field( 'news_body', $post_id ) : '';
$image            = function_exists( 'get_field' ) ? get_field( 'news_image', $post_id ) : null;
$image_caption    = function_exists( 'get_field' ) ? get_field( 'news_image_caption', $post_id ) : '';
$show_share       = function_exists( 'get_field' ) ? get_field( 'news_show_share', $post_id ) : true;
$rel_head         = function_exists( 'get_field' ) ? get_field( 'news_related_heading', $post_id ) : '';
$rel_see_all      = function_exists( 'get_field' ) ? get_field( 'news_related_see_all', $post_id ) : array();
$rel_link_label   = function_exists( 'get_field' ) ? get_field( 'news_related_link_label', $post_id ) : '';
$related          = function_exists( 'get_field' ) ? get_field( 'news_related', $post_id ) : array();

if ( ! $display_title ) {
	$display_title = $title;
}
if ( ! $breadcrumb_label ) {
	$breadcrumb_label = __( 'News', 'impact-one-million' );
}
if ( ! $breadcrumb_title ) {
	$breadcrumb_title = $display_title;
}
if ( ! $rel_head ) {
	$rel_head = __( 'Related Articles', 'impact-one-million' );
}
if ( ! $rel_link_label ) {
	$rel_link_label = __( 'Read news', 'impact-one-million' );
}

if ( ! $author ) {
	$author_name = get_the_author_meta( 'display_name', (int) get_post_field( 'post_author', $post_id ) );
	if ( $author_name ) {
		/* translators: %s: author display name */
		$author = sprintf( __( 'By %s', 'impact-one-million' ), $author_name );
	}
}

if ( ! $body && function_exists( 'get_post' ) ) {
	$raw = get_post_field( 'post_content', $post_id );
	if ( $raw ) {
		$body = apply_filters( 'the_content', $raw );
	}
}

if ( ! $image && has_post_thumbnail( $post_id ) ) {
	$image = get_post_thumbnail_id( $post_id );
}

if ( ! $read_time && $body ) {
	$words = str_word_count( wp_strip_all_tags( $body ) );
	$mins  = max( 1, (int) ceil( $words / 200 ) );
	/* translators: %d: estimated minutes to read */
	$read_time = sprintf( _n( '%d min read', '%d min read', $mins, 'impact-one-million' ), $mins );
}

if ( null === $show_share || '' === $show_share ) {
	$show_share = true;
}
$show_share = (bool) $show_share;

if ( ! is_array( $related ) ) {
	$related = array();
}
if ( ! is_array( $rel_see_all ) ) {
	$rel_see_all = array();
}

if ( empty( $related ) ) {
	$auto = get_posts(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 3,
			'post__not_in'        => array( $post_id ),
			'ignore_sticky_posts' => true,
			'fields'              => 'ids',
			'category_name'       => 'news',
		)
	);
	$related = is_array( $auto ) ? $auto : array();
}

$link_label = $rel_link_label;
$share_url  = rawurlencode( $permalink );
$share_text = rawurlencode( $display_title );

$btn_blue   = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-accent-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
$share_btn  = 'inline-flex items-center justify-center rounded-btn border border-solid border-accent-blue px-6 py-2 font-display text-body uppercase tracking-[1px] text-blue no-underline transition-opacity hover:opacity-80';
$share_copy = 'inline-flex items-center justify-center rounded-btn border border-solid border-accent-blue px-6 py-2 font-display text-body uppercase tracking-[1px] text-blue transition-opacity hover:opacity-80';
?>

<article id="post-<?php echo esc_attr( (string) $post_id ); ?>" <?php post_class(); ?>>

	<!-- Hero -->
	<header class="bg-blue px-page py-16 xl:px-section lg:py-gutter">
		<div class="mx-auto flex w-full max-w-site flex-col">
			<div class="flex w-full max-w-[50rem] flex-col gap-6">
				<nav class="flex flex-wrap items-start gap-2 font-display text-body uppercase tracking-[1px]" aria-label="<?php echo esc_attr__( 'Breadcrumb', 'impact-one-million' ); ?>">
					<?php if ( $breadcrumb_label ) : ?>
						<span class="text-[#dfe8ff]"><?php echo esc_html( $breadcrumb_label ); ?></span>
					<?php endif; ?>
					<?php if ( $breadcrumb_title ) : ?>
						<?php if ( $breadcrumb_label ) : ?>
							<span class="text-[#dfe8ff]" aria-hidden="true">/</span>
						<?php endif; ?>
						<span class="text-white"><?php echo esc_html( $breadcrumb_title ); ?></span>
					<?php endif; ?>
				</nav>

				<?php if ( $display_title ) : ?>
					<h1 class="m-0 font-display text-title leading-[1.1] tracking-[0.02em] text-white">
						<?php echo esc_html( $display_title ); ?>
					</h1>
				<?php endif; ?>

				<?php if ( $date || $author || $read_time ) : ?>
					<ul class="m-0 flex list-none flex-wrap items-center gap-x-3 gap-y-2 p-0 font-display text-body uppercase tracking-[1px] text-white">
						<?php
						$meta_bits = array_filter( array( $date, $author, $read_time ) );
						$meta_i    = 0;
						foreach ( $meta_bits as $bit ) :
							if ( $meta_i > 0 ) :
								?>
								<li class="opacity-70" aria-hidden="true">·</li>
								<?php
							endif;
							?>
							<li><?php echo esc_html( $bit ); ?></li>
							<?php
							++$meta_i;
						endforeach;
						?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</header>

	<!-- Body + image + share -->
	<?php if ( $body || $image || $show_share ) : ?>
		<section class="bg-white px-page py-20 xl:px-section lg:py-gutter">
			<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10 lg:gap-12">
				<?php if ( $body ) : ?>
					<div class="w-full max-w-[75rem] font-sans text-[17px] leading-normal text-ink [&_p]:m-0 [&_p+p]:mt-6">
						<?php echo wp_kses_post( $body ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $image ) : ?>
					<figure class="m-0 flex w-full max-w-[75rem] flex-col items-center gap-3">
						<div class="relative aspect-[748/500] w-full max-w-[46.75rem] overflow-hidden">
							<?php
							echo wp_get_attachment_image(
								(int) $image,
								'large',
								false,
								array(
									'class'   => 'absolute inset-0 size-full object-cover',
									'loading' => 'lazy',
									'alt'     => $image_caption ? $image_caption : '',
								)
							);
							?>
						</div>
						<?php if ( $image_caption ) : ?>
							<figcaption class="max-w-[37.375rem] text-center font-display text-body uppercase tracking-[1px] text-blue">
								<?php
								/* translators: %s: image caption text */
								echo esc_html( sprintf( __( 'Caption: %s', 'impact-one-million' ), $image_caption ) );
								?>
							</figcaption>
						<?php endif; ?>
					</figure>
				<?php endif; ?>

				<?php if ( $show_share ) : ?>
					<div class="flex w-full max-w-[47.5rem] flex-col items-start gap-4 sm:flex-row sm:items-center sm:gap-6">
						<p class="m-0 shrink-0 font-sans text-label leading-[1.5] text-ink">
							<?php echo esc_html__( 'Share this article:', 'impact-one-million' ); ?>
						</p>
						<ul class="m-0 flex list-none flex-wrap items-center gap-4 p-0">
							<li>
								<a
									href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . $share_url ); ?>"
									class="<?php echo esc_attr( $share_btn ); ?>"
									target="_blank"
									rel="noopener noreferrer"
								>
									<?php echo esc_html__( 'LinkedIn', 'impact-one-million' ); ?>
								</a>
							</li>
							<li>
								<a
									href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $share_url ); ?>"
									class="<?php echo esc_attr( $share_btn ); ?>"
									target="_blank"
									rel="noopener noreferrer"
								>
									<?php echo esc_html__( 'Facebook', 'impact-one-million' ); ?>
								</a>
							</li>
							<li>
								<button
									type="button"
									class="<?php echo esc_attr( $share_copy ); ?>"
									data-share-copy
									data-share-url="<?php echo esc_url( $permalink ); ?>"
								>
									<?php echo esc_html__( 'Copy Link', 'impact-one-million' ); ?>
								</button>
							</li>
							<li>
								<a
									href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $share_text ); ?>"
									class="<?php echo esc_attr( $share_btn ); ?>"
									target="_blank"
									rel="noopener noreferrer"
								>
									<?php echo esc_html__( 'X (Twitter)', 'impact-one-million' ); ?>
								</a>
							</li>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Related -->
	<?php if ( ! empty( $related ) ) : ?>
		<section class="bg-off-white px-page py-20 xl:px-gutter lg:py-gutter">
			<div class="mx-auto flex w-full max-w-site flex-col items-stretch gap-11">
				<div class="flex w-full flex-col items-start gap-6 lg:flex-row lg:items-center lg:justify-between">
					<?php if ( $rel_head ) : ?>
						<h2 class="m-0 font-display text-headline leading-[1.2] text-navy">
							<?php echo esc_html( $rel_head ); ?>
						</h2>
					<?php endif; ?>
					<?php
					if ( ! empty( $rel_see_all['url'] ) ) {
						iom_render_link( $rel_see_all, $btn_blue, __( 'See all news', 'impact-one-million' ) );
					}
					?>
				</div>
				<ul class="m-0 grid w-full list-none grid-cols-1 gap-6 p-0 lg:grid-cols-3">
					<?php
					$current_post_id = $post_id;
					foreach ( $related as $related_id ) {
						$post_id = (int) $related_id;
						require locate_template( 'templates/parts/case-study-card.php' );
					}
					$post_id = $current_post_id;
					?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

</article>
