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
$helper_text = get_sub_field( 'helper_text' );
$background  = get_sub_field( 'background' );
$countries   = get_sub_field( 'countries' );

if ( ! in_array( $background, array( 'white', 'off_white' ), true ) ) {
	$background = 'white';
}

$section_bg = ( 'off_white' === $background ) ? 'bg-off-white' : 'bg-white';

if ( ! $helper_text ) {
	$helper_text = __( 'Select a country to explore our programmes there.', 'impact-one-million' );
}

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
	class="<?php echo esc_attr( $section_bg ); ?> px-page py-section lg:px-gutter lg:py-gutter"
	data-where-we-work
	data-active-country="<?php echo esc_attr( $default_slug ); ?>"
>
	<script type="application/json" data-countries-json>
		<?php echo wp_json_encode( $countries_json ); ?>
	</script>

	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10 lg:gap-10">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 text-center font-display text-number text-navy">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<div class="relative w-full max-w-[75rem]">
			<div class="relative bg-white">
				<?php require locate_template( 'templates/parts/where-we-work-map.php' ); ?>

				<!-- Desktop overlay panel — lower-left over the map -->
				<aside
					class="absolute bottom-8 left-8 z-10 hidden w-[21.25rem] flex-col gap-6 rounded-xl border border-solid border-[#dfe8ff] bg-white p-8 lg:flex"
					data-country-panel
					aria-live="polite"
				>
					<h3 class="m-0 font-display text-header text-blue" data-panel-name>
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
				<h3 class="m-0 font-display text-header text-blue" data-panel-name>
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
			<ul class="m-0 flex list-none flex-wrap items-center justify-center gap-x-10 gap-y-3.5 p-0">
				<?php
				$total = count( $countries );
				$i     = 0;
				foreach ( $countries as $c ) :
					$i++;
					$name = isset( $c['name'] ) ? $c['name'] : '';
					$slug = ! empty( $c['slug'] ) ? sanitize_title( $c['slug'] ) : sanitize_title( $name );
					if ( ! $slug ) {
						continue;
					}
					$is_active = ( $slug === $default_slug );
					?>
					<li class="inline-flex items-center gap-6">
						<button
							type="button"
							class="border-0 border-b-2 border-solid bg-transparent p-0 font-display text-label uppercase tracking-[1px] text-navy transition-opacity hover:opacity-70 <?php echo $is_active ? 'border-navy' : 'border-transparent'; ?>"
							data-country-tab
							data-country="<?php echo esc_attr( $slug ); ?>"
							aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>"
						>
							<?php echo esc_html( $name ); ?>
						</button>
						<?php if ( $i < $total ) : ?>
							<span class="text-sm text-gray-300" aria-hidden="true">·</span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</div>
</section>
