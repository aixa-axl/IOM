<?php
/**
 * Header Template
 *
 * Two-tier navbar from ACF Options (Theme Settings → Theme Header).
 * Figma: Impact One Million — node 606:11424
 */

$header_logo     = function_exists( 'get_field' ) ? get_field( 'header_logo', 'option' ) : null;
$utility_links   = function_exists( 'get_field' ) ? get_field( 'header_utility_links', 'option' ) : null;
$search_link     = function_exists( 'get_field' ) ? get_field( 'header_search_link', 'option' ) : null;
$language_link   = function_exists( 'get_field' ) ? get_field( 'header_language_link', 'option' ) : null;
$header_nav      = function_exists( 'get_field' ) ? get_field( 'header_nav_links', 'option' ) : null;
$secondary_cta   = function_exists( 'get_field' ) ? get_field( 'header_secondary_cta', 'option' ) : null;
$primary_cta     = function_exists( 'get_field' ) ? get_field( 'header_primary_cta', 'option' ) : null;

$has_acf_nav   = is_array( $header_nav ) && ! empty( $header_nav );
$has_utility   = is_array( $utility_links ) && ! empty( $utility_links );
$search_label  = ! empty( $search_link['title'] ) ? $search_link['title'] : __( 'Search', 'impact-one-million' );
$has_util_bar  = true;

$theme_uri         = get_stylesheet_directory_uri();
$default_logo_uri  = $theme_uri . '/assets/images/impact-one-million-logo.png';
$default_logo_abs  = get_stylesheet_directory() . '/assets/images/impact-one-million-logo.png';
$has_default_logo  = file_exists( $default_logo_abs );
$icon_search_uri   = $theme_uri . '/assets/images/icons/search.svg';
$icon_globe_uri    = $theme_uri . '/assets/images/icons/globe.svg';

$util_link_class = 'font-display text-label uppercase tracking-[1px] text-white no-underline transition-opacity hover:opacity-80';
$nav_link_class  = 'font-display text-label uppercase tracking-[1px] text-navy no-underline transition-opacity hover:opacity-70';
$btn_outline     = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-80';
$btn_primary     = 'inline-flex items-center justify-center rounded-btn bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-site-bg text-ink antialiased' ); ?>>
	<?php wp_body_open(); ?>

	<header id="masthead" class="site-header sticky top-0 z-50 bg-white" data-mobile-nav>
		<div class="mx-auto flex w-full max-w-site items-center justify-between gap-6 px-5 py-3 lg:items-end lg:gap-20 lg:px-gutter lg:py-3">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="shrink-0 no-underline">
				<?php if ( $header_logo ) : ?>
					<?php
					echo wp_get_attachment_image(
						$header_logo,
						'medium',
						false,
						array(
							'class'         => 'h-[4.5rem] w-auto max-w-[7.5rem] object-contain object-left lg:h-[7rem] lg:max-w-[9.25rem]',
							'alt'           => get_bloginfo( 'name' ),
							'fetchpriority' => 'high',
						)
					);
					?>
				<?php elseif ( $has_default_logo ) : ?>
					<img
						src="<?php echo esc_url( $default_logo_uri ); ?>"
						alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
						class="h-[4.5rem] w-auto max-w-[7.5rem] object-contain object-left lg:h-[7rem] lg:max-w-[9.25rem]"
						width="148"
						height="112"
						fetchpriority="high"
					/>
				<?php else : ?>
					<span class="font-display text-label uppercase tracking-wide text-navy">
						<?php bloginfo( 'name' ); ?>
					</span>
				<?php endif; ?>
			</a>

			<div class="hidden min-w-0 flex-1 flex-col items-end gap-3 lg:flex">
				<?php if ( $has_util_bar ) : ?>
					<div class="flex items-center justify-end gap-10 rounded-card bg-blue px-6 py-3">
						<?php if ( $has_utility ) : ?>
							<?php foreach ( $utility_links as $row ) : ?>
								<?php
								$link = isset( $row['link'] ) ? $row['link'] : null;
								if ( empty( $link['url'] ) ) {
									continue;
								}
								iom_render_link( $link, $util_link_class );
								?>
							<?php endforeach; ?>
						<?php endif; ?>

						<?php require locate_template( 'templates/parts/inline-search.php' ); ?>

						<?php if ( ! empty( $language_link['url'] ) ) : ?>
							<a
								href="<?php echo esc_url( $language_link['url'] ); ?>"
								class="inline-flex shrink-0 items-center"
								aria-label="<?php echo esc_attr( ! empty( $language_link['title'] ) ? $language_link['title'] : __( 'Language', 'impact-one-million' ) ); ?>"
								<?php echo ! empty( $language_link['target'] ) ? 'target="' . esc_attr( $language_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>
							>
								<img
									src="<?php echo esc_url( $icon_globe_uri ); ?>"
									alt=""
									width="18"
									height="18"
									class="size-[18px]"
									aria-hidden="true"
								/>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="flex flex-nowrap items-center justify-end gap-8">
					<nav class="min-w-0" aria-label="<?php echo esc_attr__( 'Primary', 'impact-one-million' ); ?>">
						<?php if ( $has_acf_nav ) : ?>
							<ul class="m-0 flex list-none flex-nowrap items-center gap-8 p-0">
								<?php foreach ( $header_nav as $row ) : ?>
									<?php
									$link     = isset( $row['link'] ) ? $row['link'] : null;
									$children = isset( $row['children'] ) && is_array( $row['children'] ) ? $row['children'] : array();
									$children = array_values(
										array_filter(
											$children,
											static function ( $child ) {
												return ! empty( $child['link']['url'] );
											}
										)
									);
									if ( empty( $link['url'] ) ) {
										continue;
									}
									$has_children = ! empty( $children );
									?>
									<li class="<?php echo $has_children ? 'group relative shrink-0' : 'shrink-0'; ?>">
										<?php if ( $has_children ) : ?>
											<a
												href="<?php echo esc_url( $link['url'] ); ?>"
												class="<?php echo esc_attr( $nav_link_class . ' whitespace-nowrap' ); ?>"
												aria-haspopup="true"
												<?php echo ! empty( $link['target'] ) ? 'target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>
											>
												<?php echo esc_html( ! empty( $link['title'] ) ? $link['title'] : '' ); ?>
											</a>
											<ul
												class="invisible absolute left-0 top-full z-[60] m-0 min-w-[16.5rem] list-none bg-blue p-0 opacity-0 shadow-lg transition-[opacity,visibility] duration-150 group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100"
												role="list"
											>
												<?php foreach ( $children as $child ) : ?>
													<?php $child_link = $child['link']; ?>
													<li class="m-0">
														<a
															href="<?php echo esc_url( $child_link['url'] ); ?>"
															class="block whitespace-nowrap px-6 py-3.5 font-display text-label uppercase tracking-[1px] text-white no-underline transition-colors hover:bg-white/20 focus:bg-white/20 focus:outline-none"
															<?php echo ! empty( $child_link['target'] ) ? 'target="' . esc_attr( $child_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>
														>
															<?php echo esc_html( ! empty( $child_link['title'] ) ? $child_link['title'] : '' ); ?>
														</a>
													</li>
												<?php endforeach; ?>
											</ul>
										<?php else : ?>
											<?php iom_render_link( $link, $nav_link_class . ' whitespace-nowrap' ); ?>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php else : ?>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'container'      => false,
									'menu_class'     => 'm-0 flex list-none flex-nowrap items-center gap-8 p-0',
									'fallback_cb'    => false,
								)
							);
							?>
						<?php endif; ?>
					</nav>

					<?php if ( ! empty( $secondary_cta['url'] ) || ! empty( $primary_cta['url'] ) ) : ?>
						<div class="flex shrink-0 flex-nowrap items-center gap-3">
							<?php
							if ( ! empty( $secondary_cta['url'] ) ) {
								iom_render_link(
									$secondary_cta,
									$btn_outline . ' whitespace-nowrap',
									__( 'Members Login', 'impact-one-million' )
								);
							}
							if ( ! empty( $primary_cta['url'] ) ) {
								iom_render_link(
									$primary_cta,
									$btn_primary . ' whitespace-nowrap',
									__( 'Join Now', 'impact-one-million' )
								);
							}
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<button
				type="button"
				class="inline-flex size-10 items-center justify-center text-navy lg:hidden"
				data-mobile-nav-toggle
				aria-expanded="false"
				aria-controls="mobile-nav-panel"
			>
				<span class="sr-only"><?php esc_html_e( 'Open menu', 'impact-one-million' ); ?></span>
				<svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
					<path stroke-linecap="round" stroke-width="1.5" d="M4 7h16M4 12h16M4 17h16" />
				</svg>
			</button>
		</div>

		<div
			id="mobile-nav-panel"
			class="border-t border-black/10 px-5 py-6 lg:hidden"
			data-mobile-nav-panel
			hidden
		>
			<?php if ( $has_util_bar ) : ?>
				<div class="mb-6 flex flex-col gap-3 rounded-card bg-blue px-5 py-4">
					<?php if ( $has_utility ) : ?>
						<?php foreach ( $utility_links as $row ) : ?>
							<?php
							$link = isset( $row['link'] ) ? $row['link'] : null;
							if ( empty( $link['url'] ) ) {
								continue;
							}
							iom_render_link( $link, $util_link_class );
							?>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php require locate_template( 'templates/parts/inline-search.php' ); ?>

					<?php if ( ! empty( $language_link['url'] ) ) : ?>
						<a
							href="<?php echo esc_url( $language_link['url'] ); ?>"
							class="inline-flex items-center gap-2 <?php echo esc_attr( $util_link_class ); ?>"
							<?php echo ! empty( $language_link['target'] ) ? 'target="' . esc_attr( $language_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>
						>
							<img
								src="<?php echo esc_url( $icon_globe_uri ); ?>"
								alt=""
								width="18"
								height="18"
								class="size-[18px] shrink-0"
								aria-hidden="true"
							/>
							<span><?php echo esc_html( ! empty( $language_link['title'] ) ? $language_link['title'] : __( 'Language', 'impact-one-million' ) ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $has_acf_nav ) : ?>
				<nav aria-label="<?php echo esc_attr__( 'Primary', 'impact-one-million' ); ?>">
					<ul class="m-0 flex list-none flex-col gap-4 p-0">
						<?php foreach ( $header_nav as $row ) : ?>
							<?php
							$link = isset( $row['link'] ) ? $row['link'] : null;
							if ( empty( $link['url'] ) ) {
								continue;
							}
							?>
							<li>
								<?php iom_render_link( $link, $nav_link_class ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php else : ?>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => 'nav',
						'menu_class'     => 'm-0 flex list-none flex-col gap-4 p-0',
						'fallback_cb'    => false,
					)
				);
				?>
			<?php endif; ?>

			<?php if ( ! empty( $secondary_cta['url'] ) || ! empty( $primary_cta['url'] ) ) : ?>
				<div class="mt-6 flex flex-col gap-3">
					<?php
					if ( ! empty( $secondary_cta['url'] ) ) {
						iom_render_link(
							$secondary_cta,
							$btn_outline,
							__( 'Members Login', 'impact-one-million' )
						);
					}
					if ( ! empty( $primary_cta['url'] ) ) {
						iom_render_link(
							$primary_cta,
							$btn_primary,
							__( 'Join Now', 'impact-one-million' )
						);
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</header>
