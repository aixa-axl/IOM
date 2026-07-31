<?php
/**
 * Footer Template
 *
 * Content from ACF Options (Theme Settings → Theme Footer).
 */

$footer_logo    = function_exists( 'get_field' ) ? get_field( 'footer_logo', 'option' ) : null;
$footer_tagline = function_exists( 'get_field' ) ? get_field( 'footer_tagline', 'option' ) : null;
$footer_copy    = function_exists( 'get_field' ) ? get_field( 'footer_copyright', 'option' ) : null;
$footer_nav     = function_exists( 'get_field' ) ? get_field( 'footer_nav_links', 'option' ) : null;
$footer_social  = function_exists( 'get_field' ) ? get_field( 'footer_social_links', 'option' ) : null;
$has_acf_nav    = is_array( $footer_nav ) && ! empty( $footer_nav );
$has_social     = is_array( $footer_social ) && ! empty( $footer_social );
?>

	<footer id="site-footer" class="site-footer mt-auto bg-blue px-5 py-10 text-white lg:px-gutter lg:py-16">
		<div class="mx-auto flex w-full max-w-site flex-col gap-8 lg:flex-row lg:items-start lg:justify-between">
			<div>
				<?php if ( $footer_logo ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block no-underline">
						<?php
						echo wp_get_attachment_image(
							$footer_logo,
							'medium',
							false,
							array(
								'class'   => 'h-8 w-auto object-contain brightness-0 invert',
								'alt'     => get_bloginfo( 'name' ),
								'loading' => 'lazy',
							)
						);
						?>
					</a>
				<?php else : ?>
					<p class="font-display text-label uppercase tracking-wide"><?php bloginfo( 'name' ); ?></p>
				<?php endif; ?>

				<?php if ( $footer_tagline ) : ?>
					<p class="mt-2 font-sans text-sm text-white/70">
						<?php echo esc_html( $footer_tagline ); ?>
					</p>
				<?php endif; ?>

				<p class="mt-2 font-sans text-sm text-white/70">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<?php
					if ( $footer_copy ) {
						echo ' ' . esc_html( $footer_copy );
					} else {
						echo ' ' . esc_html( get_bloginfo( 'name' ) ) . '. ';
						esc_html_e( 'All rights reserved.', 'impact-one-million' );
					}
					?>
				</p>
			</div>

			<?php if ( $has_acf_nav ) : ?>
				<nav aria-label="<?php echo esc_attr__( 'Footer', 'impact-one-million' ); ?>">
					<ul class="m-0 flex list-none flex-col gap-3 p-0 font-sans text-body text-white/80">
						<?php foreach ( $footer_nav as $row ) : ?>
							<?php
							$link = isset( $row['link'] ) ? $row['link'] : null;
							if ( empty( $link['url'] ) ) {
								continue;
							}
							?>
							<li>
								<?php iom_render_link( $link, 'text-white/80 no-underline transition-opacity hover:opacity-100' ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php else : ?>
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
			<?php endif; ?>

			<?php if ( $has_social ) : ?>
				<nav aria-label="<?php echo esc_attr__( 'Social', 'impact-one-million' ); ?>">
					<ul class="m-0 flex list-none flex-wrap gap-4 p-0">
						<?php foreach ( $footer_social as $row ) : ?>
							<?php
							$link = isset( $row['link'] ) ? $row['link'] : null;
							if ( empty( $link['url'] ) ) {
								continue;
							}
							?>
							<li>
								<?php iom_render_link( $link, 'font-sans text-sm text-white/80 no-underline transition-opacity hover:opacity-100' ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
