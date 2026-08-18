<?php
/**
 * Press release single — all sections.
 *
 * Expects $post_id in scope.
 *
 * Figma: 634:21026 (press-release-index-lofi — detail page)
 *
 * @package Impact_One_Million
 */

if ( empty( $post_id ) ) {
	$post_id = get_the_ID();
}

$title = get_the_title( $post_id );
$date  = get_the_date( '', $post_id );

$breadcrumb_label = function_exists( 'get_field' ) ? get_field( 'pr_breadcrumb_label', $post_id ) : '';
$breadcrumb_title = function_exists( 'get_field' ) ? get_field( 'pr_breadcrumb_title', $post_id ) : '';
$display_title    = function_exists( 'get_field' ) ? get_field( 'pr_display_title', $post_id ) : '';
$intro            = function_exists( 'get_field' ) ? get_field( 'pr_intro', $post_id ) : '';
$overview         = function_exists( 'get_field' ) ? get_field( 'pr_overview', $post_id ) : '';
$meta_date        = function_exists( 'get_field' ) ? get_field( 'pr_meta_release_date', $post_id ) : '';
$meta_region      = function_exists( 'get_field' ) ? get_field( 'pr_meta_region', $post_id ) : '';
$meta_topic       = function_exists( 'get_field' ) ? get_field( 'pr_meta_topic', $post_id ) : '';
$meta_partner     = function_exists( 'get_field' ) ? get_field( 'pr_meta_partner', $post_id ) : '';
$body             = function_exists( 'get_field' ) ? get_field( 'pr_body', $post_id ) : '';
$gal_head         = function_exists( 'get_field' ) ? get_field( 'pr_gallery_heading', $post_id ) : '';
$gallery          = function_exists( 'get_field' ) ? get_field( 'pr_gallery', $post_id ) : array();
$quote            = function_exists( 'get_field' ) ? get_field( 'pr_quote', $post_id ) : '';
$quote_name       = function_exists( 'get_field' ) ? get_field( 'pr_quote_name', $post_id ) : '';
$quote_role       = function_exists( 'get_field' ) ? get_field( 'pr_quote_role', $post_id ) : '';
$rel_head         = function_exists( 'get_field' ) ? get_field( 'pr_related_heading', $post_id ) : '';
$rel_see_all      = function_exists( 'get_field' ) ? get_field( 'pr_related_see_all', $post_id ) : array();
$rel_link_label   = function_exists( 'get_field' ) ? get_field( 'pr_related_link_label', $post_id ) : '';
$related          = function_exists( 'get_field' ) ? get_field( 'pr_related', $post_id ) : array();
$partner_head     = function_exists( 'get_field' ) ? get_field( 'pr_partner_heading', $post_id ) : '';
$partner_intro    = function_exists( 'get_field' ) ? get_field( 'pr_partner_intro', $post_id ) : '';
$partner_cards    = function_exists( 'get_field' ) ? get_field( 'pr_partner_cards', $post_id ) : array();

if ( ! $gal_head ) {
	$gal_head = __( 'Gallery', 'impact-one-million' );
}
if ( ! $rel_head ) {
	$rel_head = __( 'Related Releases', 'impact-one-million' );
}
if ( ! $rel_link_label ) {
	$rel_link_label = __( 'Read press release', 'impact-one-million' );
}
if ( ! $partner_head ) {
	$partner_head = __( 'Help us reach further', 'impact-one-million' );
}
if ( ! $partner_intro ) {
	$partner_intro = __( 'Join our network of organizations committed to safer migration.', 'impact-one-million' );
}

if ( ! is_array( $gallery ) ) {
	$gallery = array();
}
if ( ! is_array( $related ) ) {
	$related = array();
}
if ( ! is_array( $rel_see_all ) ) {
	$rel_see_all = array();
}
if ( ! is_array( $partner_cards ) ) {
	$partner_cards = array();
}

$countries = get_the_terms( $post_id, 'country' );
if ( ! $meta_region && ! empty( $countries ) && ! is_wp_error( $countries ) ) {
	$meta_region = $countries[0]->name;
}
if ( ! $meta_topic && function_exists( 'iom_get_post_topic_label' ) ) {
	$meta_topic = iom_get_post_topic_label( $post_id );
}
if ( ! $meta_date && $date ) {
	$meta_date = $date;
}

if ( ! $breadcrumb_label ) {
	$breadcrumb_label = __( 'About Us', 'impact-one-million' );
}
if ( ! $breadcrumb_title ) {
	$breadcrumb_title = $title;
}
if ( ! $display_title ) {
	$display_title = $title;
}

$meta_rows = array(
	array( 'label' => __( 'Release Date', 'impact-one-million' ), 'value' => $meta_date ),
	array( 'label' => __( 'Region', 'impact-one-million' ), 'value' => $meta_region ),
	array( 'label' => __( 'Topic', 'impact-one-million' ), 'value' => $meta_topic ),
	array( 'label' => __( 'Partner', 'impact-one-million' ), 'value' => $meta_partner ),
);
$has_meta = false;
foreach ( $meta_rows as $row ) {
	if ( ! empty( $row['value'] ) ) {
		$has_meta = true;
		break;
	}
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
			'category_name'       => 'press-release',
		)
	);
	$related = is_array( $auto ) ? $auto : array();
}

$btn_blue = 'inline-flex items-center justify-center rounded-btn bg-accent-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
$btn_navy = 'inline-flex items-center justify-center rounded-btn bg-navy px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
$link_label = $rel_link_label;

$has_partner = ! empty( $partner_cards );
?>

<article id="post-<?php echo esc_attr( (string) $post_id ); ?>" <?php post_class(); ?>>

	<!-- Hero -->
	<header class="bg-blue px-10 py-16 lg:px-section lg:py-gutter">
		<div class="mx-auto flex w-full max-w-site flex-col gap-8 lg:max-w-[50rem]">
			<nav class="font-display text-body uppercase tracking-[1px] text-white/80" aria-label="<?php echo esc_attr__( 'Breadcrumb', 'impact-one-million' ); ?>">
				<?php if ( $breadcrumb_label ) : ?>
					<span><?php echo esc_html( $breadcrumb_label ); ?></span>
				<?php endif; ?>
				<?php if ( $breadcrumb_title ) : ?>
					<?php if ( $breadcrumb_label ) : ?>
						<span aria-hidden="true"> / </span>
					<?php endif; ?>
					<span class="text-white"><?php echo esc_html( $breadcrumb_title ); ?></span>
				<?php endif; ?>
			</nav>

			<?php if ( $display_title ) : ?>
				<h1 class="m-0 font-display text-headline leading-[1.1] text-white lg:text-title lg:leading-[1.1]">
					<?php echo esc_html( $display_title ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( $intro ) : ?>
				<p class="m-0 font-sans text-label leading-[1.5] text-white">
					<?php echo esc_html( $intro ); ?>
				</p>
			<?php endif; ?>
		</div>
	</header>

	<!-- Overview + body -->
	<?php if ( $overview || $has_meta || $body ) : ?>
		<section class="border-t border-solid border-[#dfe8ff] bg-white px-10 py-20 lg:px-section lg:py-gutter">
			<div class="mx-auto flex w-full max-w-site flex-col items-start gap-20 lg:gap-[6.25rem]">
				<?php if ( $overview || $has_meta ) : ?>
					<div class="flex w-full flex-col items-start gap-12 lg:flex-row lg:gap-[6.25rem]">
						<?php if ( $overview ) : ?>
							<div class="flex w-full max-w-[43.75rem] flex-col gap-8">
								<p class="m-0 font-display text-label uppercase tracking-[1px] text-accent">
									<?php echo esc_html__( 'Project Overview', 'impact-one-million' ); ?>
								</p>
								<div class="font-sans text-label leading-[1.5] text-ink [&_p]:m-0 [&_p+p]:mt-8 [&_p+p]:text-body [&_p+p]:leading-[1.2]">
									<?php echo wp_kses_post( $overview ); ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( $has_meta ) : ?>
							<dl class="m-0 flex w-full max-w-[25rem] shrink-0 flex-col divide-y divide-solid divide-[#dfe8ff] rounded-card border border-solid border-[#dfe8ff] bg-off-white p-8">
								<?php foreach ( $meta_rows as $row ) : ?>
									<?php if ( empty( $row['value'] ) ) { continue; } ?>
									<div class="flex flex-col gap-2 py-4 first:pt-0 last:pb-0">
										<dt class="font-display text-body uppercase tracking-[1px] text-blue">
											<?php echo esc_html( $row['label'] ); ?>
										</dt>
										<dd class="m-0 font-sans text-body leading-[1.2] text-ink">
											<?php echo esc_html( $row['value'] ); ?>
										</dd>
									</div>
								<?php endforeach; ?>
							</dl>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( $body ) : ?>
					<div class="w-full font-sans text-[17px] leading-normal text-ink [&_p]:m-0 [&_p+p]:mt-6">
						<?php echo wp_kses_post( $body ); ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Gallery -->
	<?php if ( ! empty( $gallery ) ) : ?>
		<section class="bg-white px-10 py-20 lg:px-section lg:py-gutter">
			<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10">
				<?php if ( $gal_head ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-navy">
						<?php echo esc_html( $gal_head ); ?>
					</h2>
				<?php endif; ?>
				<ul class="m-0 grid w-full list-none grid-cols-1 gap-8 p-0 sm:grid-cols-2 lg:grid-cols-3">
					<?php foreach ( $gallery as $image_id ) : ?>
						<li class="relative aspect-[378/297] overflow-hidden rounded-card">
							<?php
							echo wp_get_attachment_image(
								(int) $image_id,
								'large',
								false,
								array(
									'class'   => 'absolute inset-0 size-full object-cover',
									'loading' => 'lazy',
									'alt'     => '',
								)
							);
							?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<!-- Quote -->
	<?php if ( $quote || $quote_name || $quote_role ) : ?>
		<section class="bg-navy px-10 py-20 lg:px-section lg:py-[7.5rem]">
			<div class="mx-auto flex w-full max-w-[62.5rem] flex-col items-center gap-8 text-center">
				<?php if ( $quote ) : ?>
					<blockquote class="m-0 font-sans text-[2rem] font-extrabold leading-10 text-white lg:text-quote lg:leading-[48px]">
						<?php echo esc_html( $quote ); ?>
					</blockquote>
				<?php endif; ?>
				<?php if ( $quote_name || $quote_role ) : ?>
					<footer class="flex flex-col items-center gap-1">
						<?php if ( $quote_name ) : ?>
							<cite class="not-italic font-sans text-label leading-[1.5] text-white"><?php echo esc_html( $quote_name ); ?></cite>
						<?php endif; ?>
						<?php if ( $quote_role ) : ?>
							<p class="m-0 font-display text-body uppercase tracking-[1px] text-[#dfe8ff]"><?php echo esc_html( $quote_role ); ?></p>
						<?php endif; ?>
					</footer>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Related -->
	<?php if ( ! empty( $related ) ) : ?>
		<section class="bg-white px-10 py-20 lg:px-gutter lg:py-gutter">
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

	<!-- Become a Partner -->
	<?php if ( $has_partner ) : ?>
		<section class="bg-ink px-10 py-section lg:px-section">
			<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10">
				<div class="flex w-full max-w-[40rem] flex-col items-center gap-4 text-center">
					<?php if ( $partner_head ) : ?>
						<h2 class="m-0 font-display text-headline leading-[1.2] text-white">
							<?php echo esc_html( $partner_head ); ?>
						</h2>
					<?php endif; ?>
					<?php if ( $partner_intro ) : ?>
						<p class="m-0 font-sans text-body leading-[1.2] text-white">
							<?php echo esc_html( $partner_intro ); ?>
						</p>
					<?php endif; ?>
				</div>

				<ul class="m-0 grid w-full list-none grid-cols-1 gap-8 p-0 lg:grid-cols-3">
					<?php foreach ( $partner_cards as $card ) : ?>
						<?php
						$c_title = isset( $card['title'] ) ? $card['title'] : '';
						$c_body  = isset( $card['body'] ) ? $card['body'] : '';
						$c_link  = isset( $card['link'] ) && is_array( $card['link'] ) ? $card['link'] : array();
						if ( ! $c_title && ! $c_body && empty( $c_link['url'] ) ) {
							continue;
						}
						?>
						<li class="flex w-full flex-col items-center gap-6 rounded-card bg-white p-10 text-center">
							<div class="flex flex-col items-center gap-3">
								<?php if ( $c_title ) : ?>
									<h3 class="m-0 font-display text-card-title text-blue">
										<?php echo esc_html( $c_title ); ?>
									</h3>
								<?php endif; ?>
								<?php if ( $c_body ) : ?>
									<p class="m-0 font-sans text-sm leading-normal text-ink">
										<?php echo esc_html( $c_body ); ?>
									</p>
								<?php endif; ?>
							</div>
							<?php
							if ( ! empty( $c_link['url'] ) ) {
								iom_render_link( $c_link, $btn_navy, __( 'Partner With Us', 'impact-one-million' ) );
							}
							?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

</article>
