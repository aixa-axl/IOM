<?php
/**
 * Case study single — all sections.
 *
 * Expects $post_id in scope.
 *
 * @package Impact_One_Million
 */

if ( empty( $post_id ) ) {
	$post_id = get_the_ID();
}

$title     = get_the_title( $post_id );
$permalink = get_permalink( $post_id );
$date      = get_the_date( '', $post_id );

$breadcrumb_label = function_exists( 'get_field' ) ? get_field( 'cs_breadcrumb_label', $post_id ) : '';
$breadcrumb_title = function_exists( 'get_field' ) ? get_field( 'cs_breadcrumb_title', $post_id ) : '';
$display_title    = function_exists( 'get_field' ) ? get_field( 'cs_display_title', $post_id ) : '';
$intro            = function_exists( 'get_field' ) ? get_field( 'cs_intro', $post_id ) : '';
$pdf              = function_exists( 'get_field' ) ? get_field( 'cs_pdf', $post_id ) : null;
$show_share       = function_exists( 'get_field' ) ? get_field( 'cs_show_share', $post_id ) : true;
$overview    = function_exists( 'get_field' ) ? get_field( 'cs_overview', $post_id ) : '';
$meta_prog   = function_exists( 'get_field' ) ? get_field( 'cs_meta_programme', $post_id ) : '';
$meta_country = function_exists( 'get_field' ) ? get_field( 'cs_meta_country', $post_id ) : '';
$meta_dur    = function_exists( 'get_field' ) ? get_field( 'cs_meta_duration', $post_id ) : '';
$meta_part   = function_exists( 'get_field' ) ? get_field( 'cs_meta_partners', $post_id ) : '';
$meta_fund   = function_exists( 'get_field' ) ? get_field( 'cs_meta_funding', $post_id ) : '';
$chal_quote  = function_exists( 'get_field' ) ? get_field( 'cs_challenge_quote', $post_id ) : '';
$chal_body   = function_exists( 'get_field' ) ? get_field( 'cs_challenge_body', $post_id ) : '';
$appr_head   = function_exists( 'get_field' ) ? get_field( 'cs_approach_heading', $post_id ) : '';
$appr_cards  = function_exists( 'get_field' ) ? get_field( 'cs_approach_cards', $post_id ) : array();
$res_head    = function_exists( 'get_field' ) ? get_field( 'cs_results_heading', $post_id ) : '';
$res_stats   = function_exists( 'get_field' ) ? get_field( 'cs_results_stats', $post_id ) : array();
$res_image   = function_exists( 'get_field' ) ? get_field( 'cs_results_image', $post_id ) : null;
$res_points  = function_exists( 'get_field' ) ? get_field( 'cs_results_points', $post_id ) : array();
$t_quote     = function_exists( 'get_field' ) ? get_field( 'cs_testimonial_quote', $post_id ) : '';
$t_name      = function_exists( 'get_field' ) ? get_field( 'cs_testimonial_name', $post_id ) : '';
$t_role      = function_exists( 'get_field' ) ? get_field( 'cs_testimonial_role', $post_id ) : '';
$gal_head    = function_exists( 'get_field' ) ? get_field( 'cs_gallery_heading', $post_id ) : '';
$gallery     = function_exists( 'get_field' ) ? get_field( 'cs_gallery', $post_id ) : array();
$rel_head    = function_exists( 'get_field' ) ? get_field( 'cs_related_heading', $post_id ) : '';
$rel_see_all = function_exists( 'get_field' ) ? get_field( 'cs_related_see_all', $post_id ) : array();
$related     = function_exists( 'get_field' ) ? get_field( 'cs_related', $post_id ) : array();
$join_eye    = function_exists( 'get_field' ) ? get_field( 'cs_join_eyebrow', $post_id ) : '';
$join_head   = function_exists( 'get_field' ) ? get_field( 'cs_join_heading', $post_id ) : '';
$join_body   = function_exists( 'get_field' ) ? get_field( 'cs_join_body', $post_id ) : '';
$join_image  = function_exists( 'get_field' ) ? get_field( 'cs_join_image', $post_id ) : null;
$join_pri    = function_exists( 'get_field' ) ? get_field( 'cs_join_primary', $post_id ) : array();
$join_sec    = function_exists( 'get_field' ) ? get_field( 'cs_join_secondary', $post_id ) : array();

if ( null === $show_share || '' === $show_share ) {
	$show_share = true;
}
$show_share = (bool) $show_share;

if ( ! $appr_head ) {
	$appr_head = __( 'Our Approach', 'impact-one-million' );
}
if ( ! $res_head ) {
	$res_head = __( 'Results & Impact', 'impact-one-million' );
}
if ( ! $gal_head ) {
	$gal_head = __( 'Gallery', 'impact-one-million' );
}
if ( ! $rel_head ) {
	$rel_head = __( 'Related Case Studies', 'impact-one-million' );
}

if ( ! is_array( $appr_cards ) ) {
	$appr_cards = array();
}
if ( ! is_array( $res_stats ) ) {
	$res_stats = array();
}
if ( ! is_array( $res_points ) ) {
	$res_points = array();
}
if ( ! is_array( $gallery ) ) {
	$gallery = array();
}
if ( ! is_array( $related ) ) {
	$related = array();
}
if ( ! is_array( $pdf ) ) {
	$pdf = array();
}
if ( ! is_array( $rel_see_all ) ) {
	$rel_see_all = array();
}
if ( ! is_array( $join_pri ) ) {
	$join_pri = array();
}
if ( ! is_array( $join_sec ) ) {
	$join_sec = array();
}

$countries = get_the_terms( $post_id, 'country' );
if ( ! $meta_country && ! empty( $countries ) && ! is_wp_error( $countries ) ) {
	$meta_country = $countries[0]->name;
}

$theme_uri = get_stylesheet_directory_uri();
$icon_presets = array(
	$theme_uri . '/assets/images/icons/approach-literacy.svg',
	$theme_uri . '/assets/images/icons/approach-savings.svg',
	$theme_uri . '/assets/images/icons/approach-credit.svg',
);

$tags = function_exists( 'iom_get_post_topic_labels' ) ? iom_get_post_topic_labels( $post_id ) : array();
if ( ! empty( $countries ) && ! is_wp_error( $countries ) ) {
	foreach ( $countries as $c ) {
		$tags[] = $c->name;
	}
}
$tags = array_values( array_unique( array_filter( $tags ) ) );

if ( ! $breadcrumb_label ) {
	$breadcrumb_label = __( 'Case Study', 'impact-one-million' );
}
if ( ! $breadcrumb_title ) {
	$breadcrumb_title = $title;
}
if ( ! $display_title ) {
	$display_title = $title;
}

$pdf_url = ! empty( $pdf['url'] ) ? $pdf['url'] : '';

$meta_rows = array(
	array( 'label' => __( 'Programme Area', 'impact-one-million' ), 'value' => $meta_prog ),
	array( 'label' => __( 'Country', 'impact-one-million' ), 'value' => $meta_country ),
	array( 'label' => __( 'Duration', 'impact-one-million' ), 'value' => $meta_dur ),
	array( 'label' => __( 'Partner Organisations', 'impact-one-million' ), 'value' => $meta_part ),
	array( 'label' => __( 'Funding Source', 'impact-one-million' ), 'value' => $meta_fund ),
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
		)
	);
	$related = is_array( $auto ) ? $auto : array();
}

$btn_accent  = 'inline-flex items-center justify-center rounded-btn bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
$btn_outline_w = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-white px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-80';
$btn_blue    = 'inline-flex items-center justify-center rounded-btn bg-accent-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
$btn_outline_n = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-80';
$link_label  = __( 'Read case study', 'impact-one-million' );

$has_join = $join_eye || $join_head || $join_body || $join_image || ! empty( $join_pri['url'] ) || ! empty( $join_sec['url'] );
?>

<article id="post-<?php echo esc_attr( (string) $post_id ); ?>" <?php post_class(); ?>>

	<!-- Hero -->
	<header class="bg-blue px-10 py-16 lg:px-section lg:py-[7.5rem]">
		<div class="mx-auto flex w-full max-w-site flex-col gap-10">
			<div class="flex w-full max-w-[50rem] flex-col gap-4">
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

				<?php if ( $date ) : ?>
					<p class="m-0 font-sans text-body leading-[1.2] text-white/90">
						<?php echo esc_html( $date ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $display_title ) : ?>
					<h1 class="m-0 font-display text-title leading-[1.1] text-white">
						<?php echo esc_html( $display_title ); ?>
					</h1>
				<?php endif; ?>

				<?php if ( ! empty( $tags ) ) : ?>
					<ul class="m-0 flex list-none flex-wrap items-center gap-4 p-0">
						<?php foreach ( $tags as $tag ) : ?>
							<li class="rounded-card border border-solid border-white px-3 py-2 font-display text-label uppercase tracking-[1px] text-white">
								<?php echo esc_html( $tag ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<?php if ( $intro || $pdf_url || $show_share ) : ?>
				<div class="flex w-full max-w-[45rem] flex-col items-start gap-8">
					<?php if ( $intro ) : ?>
						<p class="m-0 font-sans text-label leading-[1.5] text-white">
							<?php echo esc_html( $intro ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $pdf_url || $show_share ) : ?>
						<div class="flex flex-wrap items-center gap-4">
							<?php if ( $pdf_url ) : ?>
								<a href="<?php echo esc_url( $pdf_url ); ?>" class="<?php echo esc_attr( $btn_accent ); ?>" target="_blank" rel="noopener noreferrer">
									<?php echo esc_html__( 'Download PDF', 'impact-one-million' ); ?>
								</a>
							<?php endif; ?>

							<?php if ( $show_share ) : ?>
								<button
									type="button"
									class="<?php echo esc_attr( $btn_outline_w ); ?>"
									data-share-url="<?php echo esc_url( $permalink ); ?>"
									data-share-title="<?php echo esc_attr( $display_title ); ?>"
								>
									<?php echo esc_html__( 'Share', 'impact-one-million' ); ?>
								</button>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</header>

	<!-- Overview -->
	<?php if ( $overview || $has_meta ) : ?>
		<section class="bg-white px-10 py-20 lg:px-section lg:py-gutter">
			<div class="mx-auto flex w-full max-w-site flex-col items-start gap-12 lg:flex-row lg:justify-between lg:gap-20">
				<?php if ( $overview ) : ?>
					<div class="flex w-full max-w-[43.75rem] flex-col gap-4">
						<p class="m-0 font-display text-body uppercase tracking-[1px] text-navy">
							<?php echo esc_html__( 'Project Overview', 'impact-one-million' ); ?>
						</p>
						<div class="font-sans text-body leading-[1.2] text-muted [&_p]:m-0 [&_p+p]:mt-6">
							<?php echo wp_kses_post( $overview ); ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $has_meta ) : ?>
					<dl class="m-0 flex w-full max-w-[25rem] shrink-0 flex-col divide-y divide-solid divide-[#dfe8ff] rounded-card border border-solid border-[#dfe8ff] bg-off-white p-8">
						<?php foreach ( $meta_rows as $row ) : ?>
							<?php if ( empty( $row['value'] ) ) { continue; } ?>
							<div class="flex flex-col gap-2 py-4 first:pt-0 last:pb-0">
								<dt class="font-display text-body uppercase tracking-[1px] text-navy">
									<?php echo esc_html( $row['label'] ); ?>
								</dt>
								<dd class="m-0 font-sans text-body leading-[1.2] text-muted">
									<?php echo esc_html( $row['value'] ); ?>
								</dd>
							</div>
						<?php endforeach; ?>
					</dl>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Challenge -->
	<?php if ( $chal_quote || $chal_body ) : ?>
		<section class="bg-navy px-10 py-20 lg:px-section lg:py-[7.5rem]">
			<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10 lg:flex-row lg:justify-between lg:gap-20">
				<?php if ( $chal_quote ) : ?>
					<div class="flex w-full max-w-[43.75rem] flex-col gap-4">
						<p class="m-0 font-display text-body uppercase tracking-[1px] text-[#dfe8ff]">
							<?php echo esc_html__( 'The Challenge', 'impact-one-million' ); ?>
						</p>
						<blockquote class="m-0 font-sans text-quote font-extrabold text-white">
							<?php echo esc_html( $chal_quote ); ?>
						</blockquote>
					</div>
				<?php endif; ?>

				<?php if ( $chal_body ) : ?>
					<p class="m-0 w-full max-w-[26.25rem] font-sans text-body leading-[1.2] text-[#dfe8ff] lg:pt-10">
						<?php echo esc_html( $chal_body ); ?>
					</p>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Approach + Results -->
	<?php if ( ! empty( $appr_cards ) || ! empty( $res_stats ) || $res_image || ! empty( $res_points ) ) : ?>
		<section class="bg-white px-10 py-20 lg:px-section lg:py-[7.5rem]">
			<div class="mx-auto flex w-full max-w-site flex-col items-start gap-20">
				<?php if ( ! empty( $appr_cards ) ) : ?>
					<div class="flex w-full flex-col items-start gap-10">
						<?php if ( $appr_head ) : ?>
							<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
								<?php echo esc_html( $appr_head ); ?>
							</h2>
						<?php endif; ?>

						<ul class="m-0 grid w-full list-none grid-cols-1 gap-4 p-0 sm:grid-cols-2 lg:grid-cols-3">
							<?php foreach ( $appr_cards as $index => $card ) : ?>
								<?php
								$c_title = isset( $card['title'] ) ? $card['title'] : '';
								$c_body  = isset( $card['body'] ) ? $card['body'] : '';
								$c_icon  = isset( $card['icon'] ) ? $card['icon'] : null;
								if ( ! $c_title && ! $c_body && ! $c_icon ) {
									continue;
								}
								$preset = isset( $icon_presets[ $index % count( $icon_presets ) ] ) ? $icon_presets[ $index % count( $icon_presets ) ] : '';
								?>
								<li class="flex flex-col items-start gap-4 rounded-card border border-solid border-[#dfe8ff] bg-off-white p-6">
									<div class="flex h-[2.8125rem] w-11 items-center justify-start" aria-hidden="true">
										<?php if ( $c_icon ) : ?>
											<?php
											echo wp_get_attachment_image(
												(int) $c_icon,
												'thumbnail',
												false,
												array(
													'class'   => 'h-11 w-11 object-contain',
													'alt'     => '',
													'loading' => 'lazy',
												)
											);
											?>
										<?php elseif ( $preset ) : ?>
											<img src="<?php echo esc_url( $preset ); ?>" alt="" width="44" height="45" class="h-11 w-11 object-contain" loading="lazy" decoding="async">
										<?php endif; ?>
									</div>
									<?php if ( $c_title ) : ?>
										<h3 class="m-0 font-display text-card-title leading-none text-blue">
											<?php echo esc_html( $c_title ); ?>
										</h3>
									<?php endif; ?>
									<?php if ( $c_body ) : ?>
										<p class="m-0 font-sans text-body leading-[1.2] text-muted">
											<?php echo esc_html( $c_body ); ?>
										</p>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $res_stats ) ) : ?>
					<div class="flex w-full flex-col items-center gap-6 py-6">
						<?php if ( $res_head ) : ?>
							<h2 class="m-0 text-center font-display text-header leading-none text-accent">
								<?php echo esc_html( $res_head ); ?>
							</h2>
						<?php endif; ?>
						<ul class="m-0 flex w-full list-none flex-col items-stretch gap-10 p-0 lg:flex-row lg:gap-0">
							<?php foreach ( $res_stats as $stat ) : ?>
								<?php
								$val = isset( $stat['value'] ) ? $stat['value'] : '';
								$lab = isset( $stat['label'] ) ? $stat['label'] : '';
								if ( ! $val && ! $lab ) {
									continue;
								}
								?>
								<li class="flex min-w-0 flex-1 flex-col items-center gap-2 text-center">
									<?php if ( $val ) : ?>
										<p class="m-0 font-display text-number leading-none text-blue"><?php echo esc_html( $val ); ?></p>
									<?php endif; ?>
									<?php if ( $lab ) : ?>
										<p class="m-0 font-display text-stat-label leading-[1.2] text-accent-blue"><?php echo esc_html( $lab ); ?></p>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php if ( $res_image || ! empty( $res_points ) ) : ?>
					<div class="flex w-full flex-col items-center gap-10 lg:flex-row lg:gap-16">
						<?php if ( $res_image ) : ?>
							<div class="relative h-[16rem] w-full shrink-0 overflow-hidden rounded-card lg:h-[26rem] lg:w-[39rem]">
								<?php
								echo wp_get_attachment_image(
									(int) $res_image,
									'large',
									false,
									array(
										'class'   => 'absolute inset-0 size-full object-cover',
										'loading' => 'lazy',
										'alt'     => '',
									)
								);
								?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $res_points ) ) : ?>
							<ul class="m-0 flex w-full list-none flex-col items-start gap-6 p-0 lg:flex-1">
								<?php foreach ( $res_points as $point ) : ?>
									<?php
									$label = isset( $point['label'] ) ? $point['label'] : '';
									if ( ! $label ) {
										continue;
									}
									?>
									<li class="font-display text-card-title leading-[1.2] text-blue">
										<?php echo esc_html( $label ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Testimonial -->
	<?php if ( $t_quote || $t_name || $t_role ) : ?>
		<section class="bg-navy px-10 py-20 lg:px-section lg:py-[7.5rem]">
			<div class="mx-auto flex w-full max-w-[62.5rem] flex-col items-center gap-8 text-center">
				<?php if ( $t_quote ) : ?>
					<blockquote class="m-0 font-sans text-quote font-extrabold text-white">
						<?php echo esc_html( $t_quote ); ?>
					</blockquote>
				<?php endif; ?>
				<?php if ( $t_name || $t_role ) : ?>
					<footer class="flex flex-col items-center gap-1">
						<?php if ( $t_name ) : ?>
							<cite class="not-italic font-sans text-label leading-[1.5] text-white"><?php echo esc_html( $t_name ); ?></cite>
						<?php endif; ?>
						<?php if ( $t_role ) : ?>
							<p class="m-0 font-display text-body uppercase tracking-[1px] text-[#dfe8ff]"><?php echo esc_html( $t_role ); ?></p>
						<?php endif; ?>
					</footer>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Gallery -->
	<?php if ( ! empty( $gallery ) ) : ?>
		<section class="bg-white px-10 py-20 lg:px-section lg:py-[7.5rem]">
			<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10">
				<?php if ( $gal_head ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
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

	<!-- Related -->
	<?php if ( ! empty( $related ) ) : ?>
		<section class="bg-off-white px-10 py-20 lg:px-section lg:py-gutter">
			<div class="mx-auto flex w-full max-w-site flex-col items-stretch gap-11">
				<div class="flex w-full flex-col items-start gap-6 lg:flex-row lg:items-center lg:justify-between">
					<?php if ( $rel_head ) : ?>
						<h2 class="m-0 font-display text-headline leading-[1.2] text-navy">
							<?php echo esc_html( $rel_head ); ?>
						</h2>
					<?php endif; ?>
					<?php
					if ( ! empty( $rel_see_all['url'] ) ) {
						iom_render_link( $rel_see_all, $btn_blue, __( 'See all studies', 'impact-one-million' ) );
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

	<!-- Join CTA -->
	<?php if ( $has_join ) : ?>
		<section class="relative overflow-hidden bg-accent-blue">
			<?php if ( $join_image ) : ?>
				<div class="relative h-[16rem] w-full lg:absolute lg:inset-y-0 lg:left-0 lg:h-auto lg:w-[min(100%,67.5rem)] lg:max-w-[75%]">
					<?php
					echo wp_get_attachment_image(
						(int) $join_image,
						'large',
						false,
						array(
							'class'         => 'absolute inset-0 size-full object-cover',
							'loading'       => 'lazy',
							'fetchpriority' => 'low',
							'alt'           => '',
						)
					);
					?>
				</div>
			<?php endif; ?>

			<div class="relative z-10 mx-auto flex w-full max-w-site flex-col px-10 pb-10 pt-0 lg:min-h-[41.75rem] lg:flex-row lg:items-center lg:justify-end lg:px-gutter lg:py-20">
				<div class="mt-0 flex w-full flex-col items-start gap-8 self-center rounded-card bg-white p-10 lg:max-w-[36.625rem] lg:self-auto lg:p-5">
					<div class="flex w-full flex-col gap-4">
						<?php if ( $join_eye ) : ?>
							<p class="m-0 font-display text-body uppercase tracking-[1px] text-blue">
								<?php echo esc_html( $join_eye ); ?>
							</p>
						<?php endif; ?>
						<?php if ( $join_head ) : ?>
							<h2 class="m-0 font-display text-title leading-[1.1] tracking-[0.02em] text-blue">
								<?php echo esc_html( $join_head ); ?>
							</h2>
						<?php endif; ?>
						<?php if ( $join_body ) : ?>
							<p class="m-0 font-sans text-label leading-[1.5] text-muted">
								<?php echo esc_html( $join_body ); ?>
							</p>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $join_pri['url'] ) || ! empty( $join_sec['url'] ) ) : ?>
						<div class="flex w-full flex-col items-stretch gap-3 lg:flex-row lg:flex-nowrap lg:items-start lg:gap-4">
							<?php
							if ( ! empty( $join_pri['url'] ) ) {
								iom_render_link( $join_pri, $btn_accent . ' lg:w-auto', __( 'Get involved', 'impact-one-million' ) );
							}
							if ( ! empty( $join_sec['url'] ) ) {
								iom_render_link( $join_sec, $btn_outline_n . ' lg:w-auto', __( 'Contact us', 'impact-one-million' ) );
							}
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

</article>
