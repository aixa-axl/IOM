<?php
/**
 * Layout: other_pillars
 *
 * "Explore Our Other Pillars" — icon cards linking to programme pillars.
 * Desktop: wrapping grid. Mobile: horizontal snap carousel.
 *
 * Figma desktop: 606:11757 — Figma mobile: 677:41512
 */

$heading = get_sub_field( 'heading' );
$cards   = get_sub_field( 'cards' );

$theme_uri = get_stylesheet_directory_uri();
$icon_map  = array(
	'family'     => $theme_uri . '/assets/images/icons/pillar-family.svg',
	'gender'     => $theme_uri . '/assets/images/icons/pillar-gender.svg',
	'education'  => $theme_uri . '/assets/images/icons/pillar-education.svg',
	'financial'  => $theme_uri . '/assets/images/icons/pillar-financial.svg',
	'healthcare' => $theme_uri . '/assets/images/icons/pillar-healthcare.svg',
);

if ( ! $heading ) {
	$heading = __( 'Explore Our Other Pillars', 'impact-one-million' );
}

$default_body = __( 'We help workers and their families build literacy, vocational skills and leadership — breaking cycles of poverty through learning.', 'impact-one-million' );

if ( ! is_array( $cards ) || empty( $cards ) ) {
	$cards = array(
		array(
			'icon'        => null,
			'icon_preset' => 'family',
			'title'       => __( 'Family & Early Childhood Development', 'impact-one-million' ),
			'body'        => $default_body,
			'link'        => array( 'url' => '#', 'title' => __( 'Learn more >', 'impact-one-million' ), 'target' => '' ),
		),
		array(
			'icon'        => null,
			'icon_preset' => 'gender',
			'title'       => __( 'Gender equality', 'impact-one-million' ),
			'body'        => $default_body,
			'link'        => array( 'url' => '#', 'title' => __( 'Learn more >', 'impact-one-million' ), 'target' => '' ),
		),
		array(
			'icon'        => null,
			'icon_preset' => 'education',
			'title'       => __( 'Education & skills', 'impact-one-million' ),
			'body'        => $default_body,
			'link'        => array( 'url' => '#', 'title' => __( 'Learn more >', 'impact-one-million' ), 'target' => '' ),
		),
		array(
			'icon'        => null,
			'icon_preset' => 'financial',
			'title'       => __( 'Financial Well-Being', 'impact-one-million' ),
			'body'        => $default_body,
			'link'        => array( 'url' => '#', 'title' => __( 'Learn more >', 'impact-one-million' ), 'target' => '' ),
		),
		array(
			'icon'        => null,
			'icon_preset' => 'healthcare',
			'title'       => __( 'Healthcare', 'impact-one-million' ),
			'body'        => $default_body,
			'link'        => array( 'url' => '#', 'title' => __( 'Learn more >', 'impact-one-million' ), 'target' => '' ),
		),
	);
}

$link_class = 'inline-flex border-b-2 border-solid border-navy py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-70';
?>

<section class="bg-white px-0 py-[100px] lg:px-10 lg:py-[100px]">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10 lg:gap-6">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 px-10 text-center font-display text-headline leading-[1.2] text-blue lg:px-0">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( ! empty( $cards ) ) : ?>
			<ul
				class="m-0 flex w-full list-none gap-4 overflow-x-auto scroll-smooth px-10 pb-2 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory lg:grid lg:grid-cols-5 lg:overflow-visible lg:px-0 lg:pb-0 lg:snap-none [&::-webkit-scrollbar]:hidden"
			>
				<?php foreach ( $cards as $card ) : ?>
					<?php
					$icon_id  = isset( $card['icon'] ) ? $card['icon'] : null;
					$preset   = isset( $card['icon_preset'] ) ? $card['icon_preset'] : '';
					$title    = isset( $card['title'] ) ? $card['title'] : '';
					$body     = isset( $card['body'] ) ? $card['body'] : '';
					$link     = isset( $card['link'] ) && is_array( $card['link'] ) ? $card['link'] : array();
					$icon_uri = ( $preset && isset( $icon_map[ $preset ] ) ) ? $icon_map[ $preset ] : '';
					?>
					<li
						class="flex w-[min(100%,25rem)] shrink-0 snap-center flex-col justify-between gap-4 rounded-card border border-solid border-[#dfe8ff] bg-off-white p-6 lg:h-[22.2rem] lg:w-auto lg:min-w-0 lg:snap-align-none"
					>
						<div class="flex flex-col gap-4">
							<div class="flex flex-col gap-4">
								<div class="flex h-[2.8rem] w-11 items-center justify-start" aria-hidden="true">
									<?php if ( $icon_id ) : ?>
										<?php
										echo wp_get_attachment_image(
											$icon_id,
											'thumbnail',
											false,
											array(
												'class'   => 'h-11 w-11 object-contain',
												'alt'     => '',
												'loading' => 'lazy',
											)
										);
										?>
									<?php elseif ( $icon_uri ) : ?>
										<img
											src="<?php echo esc_url( $icon_uri ); ?>"
											alt=""
											width="44"
											height="45"
											class="h-11 w-11 object-contain"
											loading="lazy"
										/>
									<?php endif; ?>
								</div>

								<?php if ( $title ) : ?>
									<h3 class="m-0 font-display text-card-title leading-none text-blue">
										<?php echo esc_html( $title ); ?>
									</h3>
								<?php endif; ?>
							</div>

							<?php if ( $body ) : ?>
								<p class="m-0 line-clamp-2 font-sans text-body leading-[1.2] text-muted">
									<?php echo esc_html( $body ); ?>
								</p>
							<?php endif; ?>
						</div>

						<?php
						if ( ! empty( $link['url'] ) ) {
							iom_render_link(
								$link,
								$link_class . ' self-start',
								__( 'Learn more >', 'impact-one-million' )
							);
						}
						?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
