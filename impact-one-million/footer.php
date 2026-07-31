<?php
/**
 * Footer Template
 */
?>

	<footer id="site-footer" class="site-footer mt-auto bg-blue px-5 py-10 text-white lg:px-gutter lg:py-16">
		<div class="mx-auto flex w-full max-w-site flex-col gap-8 lg:flex-row lg:items-start lg:justify-between">
			<div>
				<p class="font-display text-label uppercase tracking-wide"><?php bloginfo( 'name' ); ?></p>
				<p class="mt-2 font-sans text-sm text-white/70">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
					<?php esc_html_e( 'All rights reserved.', 'impact-one-million' ); ?>
				</p>
			</div>

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => 'nav',
					'menu_class'     => 'm-0 flex list-none flex-col gap-3 p-0 font-sans text-body text-white/80',
					'fallback_cb'    => false,
				)
			);
			?>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
