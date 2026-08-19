<?php
/**
 * Layout: how_it_works
 *
 * ACF layout name: how_it_works
 * Fields: heading, steps (repeater text), pillars_heading, pillars (repeater)
 *
 * Figma desktop: 606:11511 — Figma mobile: 671:40616
 */

$heading         = get_sub_field( 'heading' );
$steps           = get_sub_field( 'steps' );
$pillars_heading = get_sub_field( 'pillars_heading' );
$pillars         = get_sub_field( 'pillars' );

$theme_uri = get_stylesheet_directory_uri();
$icon_map  = array(
	'family'     => $theme_uri . '/assets/images/icons/pillar-family.svg',
	'gender'     => $theme_uri . '/assets/images/icons/pillar-gender.svg',
	'education'  => $theme_uri . '/assets/images/icons/pillar-education.svg',
	'financial'  => $theme_uri . '/assets/images/icons/pillar-financial.svg',
	'healthcare' => $theme_uri . '/assets/images/icons/pillar-healthcare.svg',
);

if ( ! $heading ) {
	$heading = __( 'How Impact On Million works', 'impact-one-million' );
}

if ( ! $pillars_heading ) {
	$pillars_heading = __( 'Our Programme Pillars', 'impact-one-million' );
}

if ( ! is_array( $steps ) || empty( $steps ) ) {
	$steps = array(
		array( 'text' => __( 'Investment received', 'impact-one-million' ) ),
		array( 'text' => __( 'We deliver through local teams & proven programmes', 'impact-one-million' ) ),
		array( 'text' => __( 'Impact is measured & reported back', 'impact-one-million' ) ),
	);
}

$default_body = __( 'We help workers and their families build literacy, vocational skills and leadership — breaking cycles of poverty through learning.', 'impact-one-million' );

if ( ! is_array( $pillars ) || empty( $pillars ) ) {
	$pillars = array(
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
			'title'       => __( 'Gender Equality', 'impact-one-million' ),
			'body'        => $default_body,
			'link'        => array( 'url' => '#', 'title' => __( 'Learn more >', 'impact-one-million' ), 'target' => '' ),
		),
		array(
			'icon'        => null,
			'icon_preset' => 'education',
			'title'       => __( 'Education & Skills', 'impact-one-million' ),
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

$pillar_count = count( $pillars );
$link_class   = 'inline-flex border-b-2 border-solid border-navy py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-70';
?>

<section class="bg-blue px-page py-section text-white lg:px-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col gap-20">
		<div class="flex flex-col gap-20 lg:flex-row lg:items-start lg:gap-gutter">
			<?php if ( $heading ) : ?>
				<h2 class="m-0 flex-1 font-display text-headline text-white lg:max-w-none">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( ! empty( $steps ) ) : ?>
				<ul class="m-0 flex w-full list-none flex-col gap-3 p-0 lg:w-auto lg:max-w-xl lg:shrink-0">
					<?php foreach ( $steps as $step ) : ?>
						<?php
						$text = isset( $step['text'] ) ? $step['text'] : '';
						if ( ! $text ) {
							continue;
						}
						?>
						<li class="rounded-btn border-[1.5px] border-solid border-transparent bg-white px-6 py-4">
							<p class="m-0 font-display text-header text-blue">
								<?php echo esc_html( $text ); ?>
							</p>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<div class="flex flex-col items-center gap-8">
			<?php if ( $pillars_heading ) : ?>
				<h3 class="m-0 text-center font-display text-header text-white">
					<?php echo esc_html( $pillars_heading ); ?>
				</h3>
			<?php endif; ?>

			<?php if ( ! empty( $pillars ) ) : ?>
				<div class="w-full" data-pillars-carousel>
					<ul
						class="m-0 flex list-none gap-10 overflow-x-auto scroll-smooth px-[10%] pb-2 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory lg:grid lg:grid-cols-3 lg:gap-10 lg:overflow-visible lg:px-0 lg:pb-0 lg:snap-none [&::-webkit-scrollbar]:hidden"
						data-pillars-track
					>
						<?php foreach ( $pillars as $index => $pillar ) : ?>
							<?php
							$icon_id  = isset( $pillar['icon'] ) ? $pillar['icon'] : null;
							$preset   = isset( $pillar['icon_preset'] ) ? $pillar['icon_preset'] : '';
							$title    = isset( $pillar['title'] ) ? $pillar['title'] : '';
							$body     = isset( $pillar['body'] ) ? $pillar['body'] : '';
							$link     = isset( $pillar['link'] ) ? $pillar['link'] : null;
							$icon_uri = ( $preset && isset( $icon_map[ $preset ] ) ) ? $icon_map[ $preset ] : '';
							?>
							<li
								class="flex w-[min(280px,80vw)] shrink-0 snap-center flex-col justify-between rounded-card bg-off-white p-6 text-blue lg:h-[22.2rem] lg:w-auto lg:min-w-0"
								data-pillars-slide
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
											<h4 class="m-0 font-display text-stat-label uppercase tracking-[2px] text-blue">
												<?php echo esc_html( $title ); ?>
											</h4>
										<?php endif; ?>
									</div>

									<?php if ( $body ) : ?>
										<p class="m-0 font-sans text-body text-muted">
											<?php echo esc_html( $body ); ?>
										</p>
									<?php endif; ?>
								</div>

								<?php
								if ( ! empty( $link['url'] ) ) {
									echo '<div class="mt-4">';
									iom_render_link(
										$link,
										$link_class,
										__( 'Learn more >', 'impact-one-million' )
									);
									echo '</div>';
								}
								?>
							</li>
						<?php endforeach; ?>
					</ul>

					<?php if ( $pillar_count > 1 ) : ?>
						<div
							class="mt-6 flex items-center justify-center gap-2 lg:hidden"
							data-pillars-dots
							aria-hidden="true"
						>
							<?php for ( $i = 0; $i < $pillar_count; $i++ ) : ?>
								<span
									class="size-1.5 rounded-full bg-white/30 transition-colors data-[active=true]:bg-white"
									data-pillars-dot
									<?php echo 0 === $i ? 'data-active="true"' : ''; ?>
								></span>
							<?php endfor; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
