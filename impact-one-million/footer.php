<?php
/**
 * Footer Template
 *
 * Content from ACF Options (Theme Settings → Theme Footer).
 * Figma desktop: 606:11632 — Figma mobile: 671:40748
 */

$footer_logo         = function_exists( 'get_field' ) ? get_field( 'footer_logo', 'option' ) : null;
$footer_tagline      = function_exists( 'get_field' ) ? get_field( 'footer_tagline', 'option' ) : null;
$footer_partner_logo = function_exists( 'get_field' ) ? get_field( 'footer_partner_logo', 'option' ) : null;
$footer_columns      = function_exists( 'get_field' ) ? get_field( 'footer_columns', 'option' ) : null;
$footer_copy         = function_exists( 'get_field' ) ? get_field( 'footer_copyright', 'option' ) : null;
$footer_legal        = function_exists( 'get_field' ) ? get_field( 'footer_legal_links', 'option' ) : null;

$theme_uri           = get_stylesheet_directory_uri();
$theme_dir           = get_stylesheet_directory();
$default_logo_uri    = $theme_uri . '/assets/images/impact-one-million-logo-white.png';
$default_logo_abs    = $theme_dir . '/assets/images/impact-one-million-logo-white.png';
$default_partner_uri = $theme_uri . '/assets/images/escp-founded-by-icti.svg';
$default_partner_abs = $theme_dir . '/assets/images/escp-founded-by-icti.svg';
$has_default_logo    = file_exists( $default_logo_abs );
$has_default_partner = file_exists( $default_partner_abs );

$has_columns = is_array( $footer_columns ) && ! empty( $footer_columns );
$has_legal   = is_array( $footer_legal ) && ! empty( $footer_legal );

if ( ! $footer_tagline ) {
	$footer_tagline = __( 'A global movement building a future where dignity, fair wages, and opportunity are standard across every industry.', 'impact-one-million' );
}

if ( ! $footer_copy ) {
	$footer_copy = sprintf(
		/* translators: %s: current year */
		__( '© %s Impact One Million. ESCP Initiative.', 'impact-one-million' ),
		gmdate( 'Y' )
	);
}

if ( ! $has_columns ) {
	$footer_columns = array(
		array(
			'heading' => __( 'Programmes', 'impact-one-million' ),
			'links'   => array(
				array( 'link' => array( 'url' => '#', 'title' => __( 'Family & Early Childhood', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'Gender Equality', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'Financial Well-Being', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'Healthcare', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'Education & Skills', 'impact-one-million' ), 'target' => '' ) ),
			),
		),
		array(
			'heading' => __( 'About Us', 'impact-one-million' ),
			'links'   => array(
				array( 'link' => array( 'url' => '#', 'title' => __( 'History', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'Partners', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'Link label', 'impact-one-million' ), 'target' => '' ) ),
			),
		),
		array(
			'heading' => __( 'Resources', 'impact-one-million' ),
			'links'   => array(
				array( 'link' => array( 'url' => '#', 'title' => __( 'Press Release', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'Case Studies', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'News', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'Search', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'Contact', 'impact-one-million' ), 'target' => '' ) ),
			),
		),
		array(
			'heading' => __( 'Get Involved', 'impact-one-million' ),
			'links'   => array(
				array( 'link' => array( 'url' => '#', 'title' => __( 'Buyers', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'Factories', 'impact-one-million' ), 'target' => '' ) ),
				array( 'link' => array( 'url' => '#', 'title' => __( 'Foundations', 'impact-one-million' ), 'target' => '' ) ),
			),
		),
	);
	$has_columns = true;
}

if ( ! $has_legal ) {
	$footer_legal = array(
		array( 'link' => array( 'url' => '#', 'title' => __( 'Privacy Policy', 'impact-one-million' ), 'target' => '' ) ),
		array( 'link' => array( 'url' => '#', 'title' => __( 'Terms of Service', 'impact-one-million' ), 'target' => '' ) ),
		array( 'link' => array( 'url' => '#', 'title' => __( 'Contact', 'impact-one-million' ), 'target' => '' ) ),
	);
	$has_legal = true;
}

$link_class  = 'font-sans text-body text-white no-underline transition-opacity hover:opacity-70';
$legal_class = 'font-sans text-[10px] font-semibold uppercase leading-none tracking-[1px] text-white no-underline transition-opacity hover:opacity-70';
?>

	<footer id="site-footer" class="site-footer mt-auto bg-blue px-page py-20 text-white lg:px-gutter lg:py-[3.75rem]">
		<div class="mx-auto flex w-full max-w-site flex-col gap-[3.75rem] lg:gap-12">
			<div class="order-1 flex flex-col gap-20 lg:flex-row lg:items-start lg:justify-between lg:gap-10">
				<div class="flex w-full flex-col items-start gap-6 border-b border-solid border-white pb-4 lg:max-w-[18.75rem] lg:border-b-0 lg:pb-0">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block shrink-0 no-underline">
						<?php if ( $footer_logo ) : ?>
							<?php
							echo wp_get_attachment_image(
								$footer_logo,
								'medium',
								false,
								array(
									'class'   => 'h-[5.4375rem] w-auto max-w-[7.1875rem] object-contain object-left',
									'alt'     => get_bloginfo( 'name' ),
									'loading' => 'lazy',
								)
							);
							?>
						<?php elseif ( $has_default_logo ) : ?>
							<img
								src="<?php echo esc_url( $default_logo_uri ); ?>"
								alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
								class="h-[5.4375rem] w-auto max-w-[7.1875rem] object-contain object-left"
								width="115"
								height="87"
								loading="lazy"
							/>
						<?php else : ?>
							<span class="font-display text-label uppercase tracking-[1px]">
								<?php bloginfo( 'name' ); ?>
							</span>
						<?php endif; ?>
					</a>

					<?php if ( $footer_tagline ) : ?>
						<p class="m-0 w-full font-sans text-label leading-[1.5] text-white lg:text-body lg:leading-[1.2]">
							<?php echo esc_html( $footer_tagline ); ?>
						</p>
					<?php endif; ?>
				</div>

				<?php if ( $has_columns ) : ?>
					<nav
						class="grid w-full grid-flow-col grid-cols-2 grid-rows-2 gap-10 py-10 lg:flex lg:w-auto lg:grid-flow-row lg:gap-10 lg:py-0"
						aria-label="<?php echo esc_attr__( 'Footer', 'impact-one-million' ); ?>"
					>
						<?php foreach ( $footer_columns as $column ) : ?>
							<?php
							$heading = isset( $column['heading'] ) ? $column['heading'] : '';
							$links   = isset( $column['links'] ) && is_array( $column['links'] ) ? $column['links'] : array();
							if ( ! $heading && empty( $links ) ) {
								continue;
							}
							?>
							<div class="flex min-w-0 flex-col gap-4">
								<?php if ( $heading ) : ?>
									<p class="m-0 font-display text-label uppercase tracking-[1px] text-white">
										<?php echo esc_html( $heading ); ?>
									</p>
								<?php endif; ?>
								<?php if ( ! empty( $links ) ) : ?>
									<ul class="m-0 flex list-none flex-col gap-2 p-0">
										<?php foreach ( $links as $row ) : ?>
											<?php
											$link = isset( $row['link'] ) ? $row['link'] : null;
											if ( empty( $link['url'] ) ) {
												continue;
											}
											?>
											<li>
												<?php iom_render_link( $link, $link_class ); ?>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</nav>
				<?php endif; ?>
			</div>

			<div class="order-2 h-px w-full bg-white lg:order-3" aria-hidden="true"></div>

			<?php if ( $footer_partner_logo || $has_default_partner ) : ?>
				<div class="order-3 flex w-full justify-center py-10 lg:order-2 lg:justify-start lg:py-0">
					<div class="w-[12.5rem] max-w-full">
						<?php if ( $footer_partner_logo ) : ?>
							<?php
							echo wp_get_attachment_image(
								$footer_partner_logo,
								'medium',
								false,
								array(
									'class'   => 'h-auto w-full max-w-[12.5rem] object-contain object-left',
									'alt'     => __( 'Ethical Supply Chain Program, founded by ICTI', 'impact-one-million' ),
									'loading' => 'lazy',
								)
							);
							?>
						<?php else : ?>
							<img
								src="<?php echo esc_url( $default_partner_uri ); ?>"
								alt="<?php echo esc_attr__( 'Ethical Supply Chain Program, founded by ICTI', 'impact-one-million' ); ?>"
								class="h-auto w-full max-w-[12.5rem] object-contain object-left"
								width="200"
								height="72"
								loading="lazy"
							/>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="order-4 flex flex-col items-center justify-center gap-3.5 text-center font-sans text-[10px] font-semibold uppercase leading-none tracking-[1px] text-white lg:flex-row lg:items-center lg:justify-between lg:gap-4 lg:text-left">
				<p class="m-0">
					<?php echo esc_html( $footer_copy ); ?>
				</p>

				<?php if ( $has_legal ) : ?>
					<nav aria-label="<?php echo esc_attr__( 'Legal', 'impact-one-million' ); ?>">
						<ul class="m-0 flex list-none flex-wrap justify-center gap-x-6 gap-y-2 p-0 lg:justify-start">
							<?php foreach ( $footer_legal as $row ) : ?>
								<?php
								$link = isset( $row['link'] ) ? $row['link'] : null;
								if ( empty( $link['url'] ) ) {
									continue;
								}
								?>
								<li>
									<?php iom_render_link( $link, $legal_class ); ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</nav>
				<?php endif; ?>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
