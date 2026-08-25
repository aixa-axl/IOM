<?php
/**
 * Layout: where_we_work
 *
 * Interactive regional map + country detail panel.
 * Map: geography PNG + highlight overlays + SVG hit targets. List stays in sync via JS.
 *
 * Figma desktop: 623:18893 — Figma mobile: 671:40634
 * Figma off-white (no heading): 670:39157
 */

$heading     = get_sub_field( 'heading' );
$intro       = get_sub_field( 'intro' );
$helper_text = get_sub_field( 'helper_text' );
$background  = get_sub_field( 'background' );
$countries   = get_sub_field( 'countries' );
$cta         = get_sub_field( 'cta' );

if ( ! in_array( $background, array( 'white', 'off_white' ), true ) ) {
	$background = 'white';
}

$section_bg = ( 'off_white' === $background ) ? 'bg-off-white' : 'bg-white';

if ( ! $helper_text ) {
	$helper_text = __( 'Select a country to explore our programmes there.', 'impact-one-million' );
}

if ( ! is_array( $cta ) ) {
	$cta = array();
}

$btn_class = 'inline-flex items-center justify-center self-center rounded-btn border-[1.5px] border-solid border-transparent bg-accent px-6 py-4 text-center font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90 lg:py-3.5';

if ( ! is_array( $countries ) || empty( $countries ) ) {
	$countries = array(
		array(
			'name'            => __( 'China', 'impact-one-million' ),
			'slug'            => 'china',
			'workers_reached' => __( '[X,XXX] workers reached', 'impact-one-million' ),
			'factories'       => __( 'across [X] factories', 'impact-one-million' ),
			'description'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Our programmes focus on worker safety and financial literacy across garment and footwear sectors.', 'impact-one-million' ),
			'link'            => array(
				'url'    => '#',
				'title'  => __( 'See programmes in China', 'impact-one-million' ),
				'target' => '',
			),
		),
		array(
			'name'            => __( 'Vietnam', 'impact-one-million' ),
			'slug'            => 'vietnam',
			'workers_reached' => __( '[X,XXX] workers reached', 'impact-one-million' ),
			'factories'       => __( 'across [X] factories', 'impact-one-million' ),
			'description'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Our programmes focus on worker safety and financial literacy across garment and footwear sectors.', 'impact-one-million' ),
			'link'            => array(
				'url'    => '#',
				'title'  => __( 'See programmes in Vietnam', 'impact-one-million' ),
				'target' => '',
			),
		),
		array(
			'name'            => __( 'Indonesia', 'impact-one-million' ),
			'slug'            => 'indonesia',
			'workers_reached' => __( '[X,XXX] workers reached', 'impact-one-million' ),
			'factories'       => __( 'across [X] factories', 'impact-one-million' ),
			'description'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Our programmes focus on worker safety and financial literacy across garment and footwear sectors.', 'impact-one-million' ),
			'link'            => array(
				'url'    => '#',
				'title'  => __( 'See programmes in Indonesia', 'impact-one-million' ),
				'target' => '',
			),
		),
		array(
			'name'            => __( 'India', 'impact-one-million' ),
			'slug'            => 'india',
			'workers_reached' => __( '[X,XXX] workers reached', 'impact-one-million' ),
			'factories'       => __( 'across [X] factories', 'impact-one-million' ),
			'description'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Our programmes focus on worker safety and financial literacy across garment and footwear sectors.', 'impact-one-million' ),
			'link'            => array(
				'url'    => '#',
				'title'  => __( 'See programmes in India', 'impact-one-million' ),
				'target' => '',
			),
		),
		array(
			'name'            => __( 'Bangladesh', 'impact-one-million' ),
			'slug'            => 'bangladesh',
			'workers_reached' => __( '[X,XXX] workers reached', 'impact-one-million' ),
			'factories'       => __( 'across [X] factories', 'impact-one-million' ),
			'description'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Our programmes focus on worker safety and financial literacy across garment and footwear sectors.', 'impact-one-million' ),
			'link'            => array(
				'url'    => '#',
				'title'  => __( 'See programmes in Bangladesh', 'impact-one-million' ),
				'target' => '',
			),
		),
		array(
			'name'            => __( 'Sri Lanka', 'impact-one-million' ),
			'slug'            => 'sri-lanka',
			'workers_reached' => __( '[X,XXX] workers reached', 'impact-one-million' ),
			'factories'       => __( 'across [X] factories', 'impact-one-million' ),
			'description'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Our programmes focus on worker safety and financial literacy across garment and footwear sectors.', 'impact-one-million' ),
			'link'            => array(
				'url'    => '#',
				'title'  => __( 'See programmes in Sri Lanka', 'impact-one-million' ),
				'target' => '',
			),
		),
	);
}

$default_slug = 'china';
$has_china    = false;
foreach ( $countries as $c ) {
	$slug = ! empty( $c['slug'] ) ? sanitize_title( $c['slug'] ) : sanitize_title( isset( $c['name'] ) ? $c['name'] : '' );
	if ( 'china' === $slug ) {
		$has_china    = true;
		$default_slug = 'china';
		break;
	}
}
if ( ! $has_china && ! empty( $countries[0] ) ) {
	$default_slug = ! empty( $countries[0]['slug'] )
		? sanitize_title( $countries[0]['slug'] )
		: sanitize_title( isset( $countries[0]['name'] ) ? $countries[0]['name'] : 'china' );
}

$countries_json = array();
foreach ( $countries as $c ) {
	$slug = ! empty( $c['slug'] ) ? sanitize_title( $c['slug'] ) : sanitize_title( isset( $c['name'] ) ? $c['name'] : '' );
	if ( ! $slug ) {
		continue;
	}
	$link = isset( $c['link'] ) && is_array( $c['link'] ) ? $c['link'] : array();
	$countries_json[ $slug ] = array(
		'name'            => isset( $c['name'] ) ? $c['name'] : '',
		'workers_reached' => isset( $c['workers_reached'] ) ? $c['workers_reached'] : '',
		'factories'       => isset( $c['factories'] ) ? $c['factories'] : '',
		'description'     => isset( $c['description'] ) ? $c['description'] : '',
		'link_url'        => ! empty( $link['url'] ) ? $link['url'] : '',
		'link_title'      => ! empty( $link['title'] ) ? $link['title'] : '',
		'link_target'     => ! empty( $link['target'] ) ? $link['target'] : '',
	);
}

$initial = isset( $countries_json[ $default_slug ] )
	? $countries_json[ $default_slug ]
	: ( ! empty( $countries_json ) ? reset( $countries_json ) : array(
		'name'            => '',
		'workers_reached' => '',
		'factories'       => '',
		'description'     => '',
		'link_url'        => '',
		'link_title'      => '',
		'link_target'     => '',
	) );

if ( ! isset( $countries_json[ $default_slug ] ) && ! empty( $countries_json ) ) {
	$default_slug = (string) array_key_first( $countries_json );
}
?>

<section
	class="<?php echo esc_attr( $section_bg ); ?> px-page py-section xl:px-gutter lg:py-gutter"
	data-where-we-work
	data-active-country="<?php echo esc_attr( $default_slug ); ?>"
>
	<script type="application/json" data-countries-json>
		<?php echo wp_json_encode( $countries_json ); ?>
	</script>

	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10 lg:gap-10">
		<?php if ( $heading || $intro ) : ?>
			<div class="flex w-full max-w-[50rem] flex-col items-center gap-4 text-center">
				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-[32px] leading-none text-navy lg:text-number">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $intro ) : ?>
					<?php echo iom_format_multiline_text( $intro, 'm-0 font-sans text-body leading-[1.2] text-muted' ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="relative w-full max-w-[75rem]">
			<div class="relative bg-white">
				<?php
				$iom_map_active_slug = $default_slug;
				require locate_template( 'templates/parts/where-we-work-map.php' );
				unset( $iom_map_active_slug );
				?>

				<!-- Desktop overlay panel — lower-left over the map -->
				<aside
					class="absolute bottom-8 left-8 z-10 hidden w-[21.25rem] flex-col gap-6 rounded-xl border border-solid border-[#dfe8ff] bg-white p-8 lg:flex"
					data-country-panel
					aria-live="polite"
				>
					<h3 class="m-0 font-display text-[24px] leading-none text-blue lg:text-header" data-panel-name>
						<?php echo esc_html( $initial['name'] ); ?>
					</h3>
					<div class="flex flex-col gap-2 border-b border-t border-solid border-gray-300 py-3 font-sans text-sm font-semibold text-ink">
						<p class="m-0" data-panel-workers><?php echo esc_html( $initial['workers_reached'] ); ?></p>
						<p class="m-0" data-panel-factories><?php echo esc_html( $initial['factories'] ); ?></p>
					</div>
					<p class="m-0 font-sans text-sm leading-[1.2] text-muted" data-panel-description>
						<?php echo esc_html( $initial['description'] ); ?>
					</p>
					<a
						class="inline-flex items-center gap-2 font-display text-body uppercase tracking-[1px] text-blue no-underline transition-opacity hover:opacity-70"
						data-panel-link
						href="<?php echo esc_url( $initial['link_url'] ? $initial['link_url'] : '#' ); ?>"
						<?php echo ! empty( $initial['link_target'] ) ? 'target="' . esc_attr( $initial['link_target'] ) . '" rel="noopener noreferrer"' : ''; ?>
					>
						<span data-panel-link-label><?php echo esc_html( $initial['link_title'] ? $initial['link_title'] : __( 'See programmes', 'impact-one-million' ) ); ?></span>
						<span aria-hidden="true">→</span>
					</a>
				</aside>
			</div>

			<!-- Mobile panel below map -->
			<aside
				class="mt-6 flex w-full flex-col gap-6 rounded-xl border border-solid border-[#dfe8ff] bg-off-white p-8 lg:hidden"
				data-country-panel-mobile
				aria-live="polite"
			>
				<h3 class="m-0 font-display text-[24px] leading-none text-blue lg:text-header" data-panel-name>
					<?php echo esc_html( $initial['name'] ); ?>
				</h3>
				<div class="flex flex-col gap-2 border-b border-solid border-blue pb-3 font-sans text-body text-ink">
					<p class="m-0" data-panel-workers><?php echo esc_html( $initial['workers_reached'] ); ?></p>
					<p class="m-0" data-panel-factories><?php echo esc_html( $initial['factories'] ); ?></p>
				</div>
				<p class="m-0 font-sans text-sm leading-[1.2] text-muted" data-panel-description>
					<?php echo esc_html( $initial['description'] ); ?>
				</p>
				<a
					class="inline-flex items-center gap-2 font-display text-body uppercase tracking-[1px] text-blue no-underline transition-opacity hover:opacity-70"
					data-panel-link
					href="<?php echo esc_url( $initial['link_url'] ? $initial['link_url'] : '#' ); ?>"
					<?php echo ! empty( $initial['link_target'] ) ? 'target="' . esc_attr( $initial['link_target'] ) . '" rel="noopener noreferrer"' : ''; ?>
				>
					<span data-panel-link-label><?php echo esc_html( $initial['link_title'] ? $initial['link_title'] : __( 'See programmes', 'impact-one-million' ) ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
			</aside>
		</div>

		<?php if ( $helper_text ) : ?>
			<p class="m-0 text-center font-sans text-sm leading-[1.2] text-blue">
				<?php echo esc_html( $helper_text ); ?>
			</p>
		<?php endif; ?>

		<nav aria-label="<?php echo esc_attr__( 'Countries', 'impact-one-million' ); ?>">
			<?php
			$country_tabs = array();
			foreach ( $countries as $c ) {
				$name = isset( $c['name'] ) ? $c['name'] : '';
				$slug = ! empty( $c['slug'] ) ? sanitize_title( $c['slug'] ) : sanitize_title( $name );
				if ( ! $slug ) {
					continue;
				}
				$country_tabs[] = array(
					'name' => $name,
					'slug' => $slug,
				);
			}
			// Mobile Figma (671:40649): row 1 = first 4 (nowrap), row 2 = rest (centered).
			$row_one = array_slice( $country_tabs, 0, 4 );
			$row_two = array_slice( $country_tabs, 4 );

			/**
			 * @param array  $tabs   Tab rows.
			 * @param string $active Active slug.
			 * @param bool   $lead_dot Prefix a desktop-only leading · (row 2).
			 */
			$iom_render_country_row = function ( $tabs, $active, $lead_dot = false ) {
				$count = count( $tabs );
				if ( ! $count ) {
					return;
				}
				if ( $lead_dot ) :
					?>
					<span class="hidden text-sm leading-none text-gray-300 lg:inline" aria-hidden="true">·</span>
					<?php
				endif;
				foreach ( $tabs as $i => $tab ) :
					$is_active = ( $tab['slug'] === $active );
					?>
					<button
						type="button"
						class="shrink-0 border-0 border-b-2 border-solid bg-transparent p-0 font-display text-label uppercase leading-[1.2] tracking-[1px] transition-colors hover:opacity-70 <?php echo $is_active ? 'border-blue text-blue' : 'border-transparent text-navy'; ?>"
						data-country-tab
						data-country="<?php echo esc_attr( $tab['slug'] ); ?>"
						aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>"
					>
						<?php echo esc_html( $tab['name'] ); ?>
					</button>
					<?php if ( $i < $count - 1 ) : ?>
						<span class="shrink-0 text-sm leading-none text-gray-300" aria-hidden="true">·</span>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php
			};
			?>
			<ul class="m-0 flex list-none flex-col items-center gap-y-3.5 p-0 lg:flex-row lg:flex-wrap lg:justify-center lg:gap-x-10 lg:gap-y-3.5">
				<li class="flex max-w-full flex-nowrap items-center justify-center gap-x-2.5 sm:gap-x-4 lg:contents">
					<?php $iom_render_country_row( $row_one, $default_slug, false ); ?>
				</li>
				<?php if ( ! empty( $row_two ) ) : ?>
					<li class="flex max-w-full flex-nowrap items-center justify-center gap-x-2.5 sm:gap-x-4 lg:contents">
						<?php $iom_render_country_row( $row_two, $default_slug, true ); ?>
					</li>
				<?php endif; ?>
			</ul>
		</nav>

		<?php if ( ! empty( $cta['url'] ) ) : ?>
			<div class="flex w-full justify-center">
				<?php
				iom_render_link(
					$cta,
					$btn_class,
					__( 'Learn more', 'impact-one-million' )
				);
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
