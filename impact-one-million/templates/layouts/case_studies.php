<?php
/**
 * Layout: case_studies
 *
 * Blue filter bar (type / year / region / topic + search) + off-white card grid
 * with load more. Type = content categories; Topic = post tags (Topics).
 *
 * Fields: posts_per_page, link_label, load_more_label, search_placeholder
 *
 * Figma filter: 634:20514 — Figma grid: 634:20536
 */

$posts_per_page     = (int) get_sub_field( 'posts_per_page' );
$link_label         = get_sub_field( 'link_label' );
$load_more_label    = get_sub_field( 'load_more_label' );
$search_placeholder = get_sub_field( 'search_placeholder' );

if ( $posts_per_page < 1 ) {
	$posts_per_page = 6;
}

if ( ! $link_label ) {
	$link_label = __( 'Read case study', 'impact-one-million' );
}

if ( ! $load_more_label ) {
	$load_more_label = __( 'Load more', 'impact-one-million' );
}

if ( ! $search_placeholder ) {
	$search_placeholder = __( 'Search case studies...', 'impact-one-million' );
}

$theme_uri   = get_stylesheet_directory_uri();
$chevron_uri = $theme_uri . '/assets/images/icons/chevron-down.svg';
$search_uri  = $theme_uri . '/assets/images/icons/search-blue.svg';

$categories = get_categories(
	array(
		'taxonomy'   => 'category',
		'hide_empty' => false,
		'slug'       => function_exists( 'iom_content_type_slugs' ) ? iom_content_type_slugs() : array( 'case-study', 'news', 'press-release' ),
	)
);

$countries = get_terms(
	array(
		'taxonomy'   => 'country',
		'hide_empty' => true,
	)
);

$topics = get_tags(
	array(
		'hide_empty' => true,
	)
);

global $wpdb;
$years = $wpdb->get_col(
	"SELECT DISTINCT YEAR(post_date) FROM {$wpdb->posts}
	WHERE post_type = 'post' AND post_status = 'publish'
	ORDER BY YEAR(post_date) DESC"
);

$query = iom_case_studies_query(
	array(
		'paged'          => 1,
		'posts_per_page' => $posts_per_page,
	)
);

$select_class = 'appearance-none rounded-btn border border-solid border-[#e5e7eb] bg-white py-2.5 pl-4 pr-9 font-sans text-body leading-[1.2] text-blue outline-none transition-opacity hover:opacity-90 focus:border-accent-blue';
?>

<section
	class="bg-blue"
	data-case-studies
	data-per-page="<?php echo esc_attr( (string) $posts_per_page ); ?>"
	data-link-label="<?php echo esc_attr( $link_label ); ?>"
	data-page="1"
	data-max-pages="<?php echo esc_attr( (string) max( 1, (int) $query->max_num_pages ) ); ?>"
>
	<div class="mx-auto flex w-full max-w-site flex-col gap-4 px-10 py-6 lg:flex-row lg:items-center lg:justify-between lg:gap-8 lg:px-10 lg:py-6">
		<form class="flex w-full flex-col gap-4 lg:flex-row lg:flex-wrap lg:items-center lg:gap-4" data-case-studies-filters>
			<div class="flex flex-wrap items-center gap-4">
				<label class="relative inline-flex shrink-0">
					<span class="sr-only"><?php echo esc_html__( 'Type', 'impact-one-million' ); ?></span>
					<select name="category" class="<?php echo esc_attr( $select_class ); ?>" data-filter="category">
						<option value=""><?php echo esc_html__( 'Type', 'impact-one-million' ); ?></option>
						<?php foreach ( $categories as $term ) : ?>
							<option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
					<img src="<?php echo esc_url( $chevron_uri ); ?>" alt="" width="12" height="12" class="pointer-events-none absolute right-4 top-1/2 size-3 -translate-y-1/2" aria-hidden="true">
				</label>

				<label class="relative inline-flex shrink-0">
					<span class="sr-only"><?php echo esc_html__( 'Year', 'impact-one-million' ); ?></span>
					<select name="year" class="<?php echo esc_attr( $select_class ); ?>" data-filter="year">
						<option value=""><?php echo esc_html__( 'Year', 'impact-one-million' ); ?></option>
						<?php foreach ( $years as $year ) : ?>
							<option value="<?php echo esc_attr( (string) $year ); ?>"><?php echo esc_html( (string) $year ); ?></option>
						<?php endforeach; ?>
					</select>
					<img src="<?php echo esc_url( $chevron_uri ); ?>" alt="" width="12" height="12" class="pointer-events-none absolute right-4 top-1/2 size-3 -translate-y-1/2" aria-hidden="true">
				</label>

				<label class="relative inline-flex shrink-0">
					<span class="sr-only"><?php echo esc_html__( 'Region', 'impact-one-million' ); ?></span>
					<select name="region" class="<?php echo esc_attr( $select_class ); ?>" data-filter="region">
						<option value=""><?php echo esc_html__( 'Region', 'impact-one-million' ); ?></option>
						<?php if ( ! is_wp_error( $countries ) ) : ?>
							<?php foreach ( $countries as $term ) : ?>
								<option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
					<img src="<?php echo esc_url( $chevron_uri ); ?>" alt="" width="12" height="12" class="pointer-events-none absolute right-4 top-1/2 size-3 -translate-y-1/2" aria-hidden="true">
				</label>

				<label class="relative inline-flex shrink-0">
					<span class="sr-only"><?php echo esc_html__( 'Topic', 'impact-one-million' ); ?></span>
					<select name="topic" class="<?php echo esc_attr( $select_class ); ?>" data-filter="topic">
						<option value=""><?php echo esc_html__( 'Topic', 'impact-one-million' ); ?></option>
						<?php if ( ! empty( $topics ) && ! is_wp_error( $topics ) ) : ?>
							<?php foreach ( $topics as $term ) : ?>
								<option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
					<img src="<?php echo esc_url( $chevron_uri ); ?>" alt="" width="12" height="12" class="pointer-events-none absolute right-4 top-1/2 size-3 -translate-y-1/2" aria-hidden="true">
				</label>
			</div>

			<label class="relative flex h-11 w-full items-center gap-3 rounded-btn border border-solid border-[#e5e7eb] bg-white px-4 lg:ml-auto lg:w-auto lg:min-w-[16rem]">
				<span class="sr-only"><?php echo esc_html__( 'Search', 'impact-one-million' ); ?></span>
				<img src="<?php echo esc_url( $search_uri ); ?>" alt="" width="16" height="16" class="size-4 shrink-0" aria-hidden="true">
				<input
					type="search"
					name="search"
					value=""
					placeholder="<?php echo esc_attr( $search_placeholder ); ?>"
					class="w-full border-0 bg-transparent p-0 font-sans text-body leading-[1.2] text-blue outline-none placeholder:text-blue"
					data-filter="search"
					autocomplete="off"
				>
			</label>
		</form>
	</div>

	<div class="bg-off-white px-10 py-[100px] lg:px-10">
		<div class="mx-auto flex w-full max-w-site flex-col items-center gap-16">
			<ul class="m-0 grid w-full list-none grid-cols-1 gap-6 p-0 sm:grid-cols-2 lg:grid-cols-3" data-case-studies-grid>
				<?php
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$post_id = get_the_ID();
						require locate_template( 'templates/parts/case-study-card.php' );
					}
					wp_reset_postdata();
				}
				?>
			</ul>

			<p class="m-0 hidden text-center font-sans text-body text-muted" data-case-studies-empty>
				<?php echo esc_html__( 'No case studies match your filters.', 'impact-one-million' ); ?>
			</p>

			<button
				type="button"
				class="inline-flex items-center justify-center rounded-btn bg-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white transition-opacity hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-40<?php echo ( (int) $query->max_num_pages <= 1 ) ? ' hidden' : ''; ?>"
				data-case-studies-more
			>
				<?php echo esc_html( $load_more_label ); ?>
			</button>
		</div>
	</div>
</section>
