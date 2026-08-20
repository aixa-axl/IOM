<?php
/**
 * Header Template
 *
 * Two-tier navbar from ACF Options (Theme Settings → Theme Header).
 * Figma desktop: 606:11424 / dropdown 739:5184
 * Figma mobile: 739:5231 (default) / 739:5375 (expanded)
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
// Header-cropped mark (transparent padding removed) so object-contain isn't clipped.
$default_logo_uri  = $theme_uri . '/assets/images/impact-one-million-logo-header.png';
$default_logo_abs  = get_stylesheet_directory() . '/assets/images/impact-one-million-logo-header.png';
$has_default_logo  = file_exists( $default_logo_abs );
$icon_search_uri   = $theme_uri . '/assets/images/icons/search.svg';
$icon_globe_uri    = $theme_uri . '/assets/images/icons/globe.svg';

$util_link_class = 'font-display text-label uppercase tracking-[1px] text-white no-underline transition-opacity hover:opacity-80';
$nav_link_class  = 'font-display text-label uppercase tracking-[1px] text-navy no-underline transition-opacity hover:opacity-70';
$btn_outline     = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-80';
$btn_primary     = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$mobile_nav_class     = 'font-display text-label uppercase tracking-[1px] text-white no-underline text-left';
$mobile_child_class   = 'block px-page py-3 font-sans text-body leading-[1.2] text-white no-underline transition-colors hover:bg-[#dfe8ff] hover:text-blue focus:bg-[#dfe8ff] focus:text-blue focus:outline-none';
$mobile_btn_primary   = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-accent px-2 py-3.5 font-display text-label uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
$mobile_btn_outline   = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-white px-2 py-3.5 font-display text-label uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-80';
$mobile_util_class    = 'font-display text-body uppercase tracking-[1px] text-white no-underline transition-opacity hover:opacity-80';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'overflow-x-hidden bg-site-bg text-ink antialiased' ); ?>>
	<?php wp_body_open(); ?>

	<header id="masthead" class="site-header relative sticky top-0 z-50 bg-white" data-mobile-nav>
		<div class="relative z-50 mx-auto flex w-full max-w-site items-center justify-between gap-6 px-page py-3 xl:gap-20 xl:px-gutter xl:py-3">
			<a
				href="<?php echo esc_url( home_url( '/' ) ); ?>"
				class="site-header__logo flex h-[58px] w-[77px] shrink-0 items-center justify-center no-underline xl:h-auto xl:w-[152px] xl:self-stretch"
			>
				<?php
				/*
				 * Prefer the theme’s tightly cropped header mark. ACF uploads are usually the
				 * square master (extra top pad) which makes the logo look sunk in the bar.
				 * Desktop: self-stretch + 92% height centers the mark in the full header column.
				 */
				if ( $has_default_logo ) :
					?>
					<img
						src="<?php echo esc_url( $default_logo_uri ); ?>"
						alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
						class="pointer-events-none h-full w-auto max-w-full object-contain object-center xl:h-[92%]"
						width="152"
						height="115"
						loading="eager"
						decoding="async"
						<?php echo ( ! function_exists( 'iom_page_has_lcp_hero' ) || ! iom_page_has_lcp_hero() ) ? 'fetchpriority="high"' : ''; ?>
					/>
				<?php elseif ( $header_logo ) :
					$header_logo_attrs = array(
						'class'    => 'pointer-events-none h-full w-auto max-w-full object-contain object-center xl:h-[92%]',
						'alt'      => get_bloginfo( 'name' ),
						'decoding' => 'async',
						'loading'  => 'eager',
					);
					if ( ! function_exists( 'iom_page_has_lcp_hero' ) || ! iom_page_has_lcp_hero() ) {
						$header_logo_attrs['fetchpriority'] = 'high';
					}
					echo wp_get_attachment_image( $header_logo, 'medium', false, $header_logo_attrs );
				else :
					?>
					<span class="font-display text-label uppercase tracking-wide text-navy">
						<?php bloginfo( 'name' ); ?>
					</span>
				<?php endif; ?>
			</a>

			<div class="hidden min-w-0 flex-1 flex-col items-end gap-3 xl:flex">
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
												class="invisible absolute left-0 top-full z-[60] m-0 mt-3 min-w-[16.5rem] list-none overflow-hidden rounded-btn border-[1.5px] border-solid border-transparent bg-blue p-0 opacity-0 shadow-lg transition-[opacity,visibility] duration-150 before:absolute before:inset-x-0 before:-top-3 before:h-3 before:content-[''] group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100"
												role="list"
											>
												<?php foreach ( $children as $child ) : ?>
													<?php $child_link = $child['link']; ?>
													<li class="m-0">
														<a
															href="<?php echo esc_url( $child_link['url'] ); ?>"
															class="block whitespace-nowrap px-6 py-3.5 font-display text-label uppercase tracking-[1px] text-white no-underline transition-colors hover:bg-[#dfe8ff] hover:text-blue focus:bg-[#dfe8ff] focus:text-blue focus:outline-none"
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
				class="relative z-50 inline-flex size-8 items-center justify-center text-blue xl:hidden"
				data-mobile-nav-toggle
				aria-expanded="false"
				aria-controls="mobile-nav-panel"
				aria-label="<?php echo esc_attr__( 'Open menu', 'impact-one-million' ); ?>"
				data-label-open="<?php echo esc_attr__( 'Open menu', 'impact-one-million' ); ?>"
				data-label-close="<?php echo esc_attr__( 'Close menu', 'impact-one-million' ); ?>"
			>
				<svg class="pointer-events-none size-8" viewBox="0 0 32 32" fill="none" aria-hidden="true" data-mobile-nav-icon-open>
					<path d="M4.8 9.6h22.4M4.8 16h17.6M4.8 22.4h22.4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
				</svg>
				<svg class="pointer-events-none hidden size-8" viewBox="0 0 24 24" fill="none" aria-hidden="true" data-mobile-nav-icon-close>
					<path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
				</svg>
			</button>
		</div>

		<div
			id="mobile-nav-panel"
			class="absolute inset-x-0 top-full z-40 h-[calc(100dvh-6rem)] max-h-[calc(100dvh-6rem)] flex-col overflow-y-auto bg-blue md:h-auto xl:hidden"
			data-mobile-nav-panel
			data-open="false"
			hidden
		>
			<div class="mx-auto flex w-full max-w-[22rem] flex-1 flex-col gap-8 px-page pb-8 pt-7 md:mx-0 md:max-w-none md:flex-none md:gap-4 md:px-[30px] md:pb-4">
				<?php if ( $has_acf_nav ) : ?>
					<nav aria-label="<?php echo esc_attr__( 'Primary', 'impact-one-million' ); ?>">
						<ul class="m-0 flex list-none flex-col items-start gap-8 p-0">
							<?php foreach ( $header_nav as $index => $row ) : ?>
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
								if ( empty( $link['url'] ) && empty( $children ) ) {
									continue;
								}
								$has_children = ! empty( $children );
								$panel_id     = 'mobile-nav-sub-' . (int) $index;
								$title        = ! empty( $link['title'] ) ? $link['title'] : '';
								?>
								<li class="m-0">
									<?php if ( $has_children ) : ?>
										<div class="flex flex-col gap-3">
											<button
												type="button"
												class="flex w-full items-center justify-between border-0 bg-transparent p-0 text-left <?php echo esc_attr( $mobile_nav_class ); ?>"
												data-mobile-nav-accordion
												aria-expanded="false"
												aria-controls="<?php echo esc_attr( $panel_id ); ?>"
											>
												<span><?php echo esc_html( $title ); ?></span>
												<span class="sr-only"><?php esc_html_e( 'Toggle submenu', 'impact-one-million' ); ?></span>
											</button>
											<ul
												id="<?php echo esc_attr( $panel_id ); ?>"
												class="m-0 hidden list-none overflow-hidden rounded-btn p-0"
												data-mobile-nav-submenu
												hidden
											>
												<?php foreach ( $children as $child ) : ?>
													<?php
													$child_link  = $child['link'];
													$child_url   = ! empty( $child_link['url'] ) ? $child_link['url'] : '';
													$current_url = home_url( isset( $GLOBALS['wp']->request ) ? $GLOBALS['wp']->request : '' );
													$is_current  = $child_url && untrailingslashit( $child_url ) === untrailingslashit( $current_url );
													$child_cls   = $mobile_child_class . ( $is_current ? ' bg-[#dfe8ff] text-blue' : '' );
													?>
													<li class="m-0">
														<a
															href="<?php echo esc_url( $child_url ); ?>"
															class="<?php echo esc_attr( $child_cls ); ?>"
															<?php echo $is_current ? 'aria-current="page"' : ''; ?>
															<?php echo ! empty( $child_link['target'] ) ? 'target="' . esc_attr( $child_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>
														>
															<?php echo esc_html( ! empty( $child_link['title'] ) ? $child_link['title'] : '' ); ?>
														</a>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php elseif ( ! empty( $link['url'] ) ) : ?>
										<?php iom_render_link( $link, $mobile_nav_class ); ?>
									<?php endif; ?>
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
							'menu_class'     => 'm-0 flex list-none flex-col gap-8 p-0',
							'fallback_cb'    => false,
						)
					);
					?>
				<?php endif; ?>

				<?php if ( ! empty( $primary_cta['url'] ) || ! empty( $secondary_cta['url'] ) ) : ?>
					<div class="mt-auto flex w-full flex-col gap-5 md:mt-0 md:max-w-[22rem]">
						<?php
						if ( ! empty( $primary_cta['url'] ) ) {
							iom_render_link(
								$primary_cta,
								$mobile_btn_primary,
								__( 'Join Now', 'impact-one-million' )
							);
						}
						if ( ! empty( $secondary_cta['url'] ) ) {
							iom_render_link(
								$secondary_cta,
								$mobile_btn_outline,
								__( 'Members Login', 'impact-one-million' )
							);
						}
						?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $has_util_bar ) : ?>
				<div class="mt-auto flex w-full flex-col gap-5 bg-ink px-page py-5 md:mt-0 md:px-[30px]">
					<?php if ( $has_utility ) : ?>
						<?php foreach ( $utility_links as $row ) : ?>
							<?php
							$link = isset( $row['link'] ) ? $row['link'] : null;
							if ( empty( $link['url'] ) ) {
								continue;
							}
							iom_render_link( $link, $mobile_util_class );
							?>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php
					$util_link_class   = $mobile_util_class;
					$search_icon_class = 'size-[18px]';
					require locate_template( 'templates/parts/inline-search.php' );
					unset( $search_icon_class );
					?>

					<?php if ( ! empty( $language_link['url'] ) ) : ?>
						<a
							href="<?php echo esc_url( $language_link['url'] ); ?>"
							class="inline-flex items-center gap-2 <?php echo esc_attr( $mobile_util_class ); ?>"
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
		</div>
	</header>
