<?php
/**
 * Header Template
 *
 * Content from ACF Options (Theme Settings → Theme Header).
 */

$header_logo = function_exists( 'get_field' ) ? get_field( 'header_logo', 'option' ) : null;
$header_nav  = function_exists( 'get_field' ) ? get_field( 'header_nav_links', 'option' ) : null;
$header_cta  = function_exists( 'get_field' ) ? get_field( 'header_cta', 'option' ) : null;
$has_acf_nav = is_array( $header_nav ) && ! empty( $header_nav );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-site-bg text-ink antialiased' ); ?>>
	<?php wp_body_open(); ?>

	<header id="masthead" class="site-header sticky top-0 z-50 bg-white" data-mobile-nav>
		<div class="mx-auto flex w-full max-w-site items-center justify-between gap-6 px-5 py-4 lg:px-gutter lg:py-5">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="shrink-0 no-underline">
				<?php if ( $header_logo ) : ?>
					<?php
					echo wp_get_attachment_image(
						$header_logo,
						'medium',
						false,
						array(
							'class'         => 'h-8 w-auto object-contain lg:h-10',
							'alt'           => get_bloginfo( 'name' ),
							'fetchpriority' => 'high',
						)
					);
					?>
				<?php else : ?>
					<span class="font-display text-label uppercase tracking-wide text-navy">
						<?php bloginfo( 'name' ); ?>
					</span>
				<?php endif; ?>
			</a>

			<nav class="hidden lg:block" aria-label="<?php echo esc_attr__( 'Primary', 'impact-one-million' ); ?>">
				<?php if ( $has_acf_nav ) : ?>
					<ul class="m-0 flex list-none items-center gap-8 p-0">
						<?php foreach ( $header_nav as $row ) : ?>
							<?php
							$link = isset( $row['link'] ) ? $row['link'] : null;
							if ( empty( $link['url'] ) ) {
								continue;
							}
							?>
							<li>
								<?php iom_render_link( $link, 'font-sans text-body text-ink no-underline transition-opacity hover:opacity-70' ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else : ?>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'm-0 flex list-none items-center gap-8 p-0',
							'fallback_cb'    => false,
						)
					);
					?>
				<?php endif; ?>
			</nav>

			<div class="hidden items-center gap-4 lg:flex">
				<?php
				if ( ! empty( $header_cta['url'] ) ) {
					iom_render_link(
						$header_cta,
						'inline-flex items-center rounded-btn bg-accent px-5 py-2.5 font-display text-sm uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90',
						__( 'Join', 'impact-one-million' )
					);
				}
				?>
			</div>

			<button
				type="button"
				class="inline-flex size-10 items-center justify-center lg:hidden"
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
								<?php iom_render_link( $link, 'font-sans text-body text-ink no-underline' ); ?>
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

			<?php if ( ! empty( $header_cta['url'] ) ) : ?>
				<div class="mt-6">
					<?php
					iom_render_link(
						$header_cta,
						'inline-flex items-center rounded-btn bg-accent px-5 py-2.5 font-display text-sm uppercase tracking-[2px] text-white no-underline',
						__( 'Join', 'impact-one-million' )
					);
					?>
				</div>
			<?php endif; ?>
		</div>
	</header>
