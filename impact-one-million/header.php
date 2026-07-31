<?php
/**
 * Header Template
 */
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
		<div class="mx-auto flex w-full max-w-site items-center justify-between px-5 py-4 lg:px-gutter lg:py-5">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="font-display text-label uppercase tracking-wide text-navy no-underline">
				<?php bloginfo( 'name' ); ?>
			</a>

			<nav class="hidden lg:block" aria-label="<?php echo esc_attr__( 'Primary', 'impact-one-million' ); ?>">
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
			</nav>

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
		</div>
	</header>
