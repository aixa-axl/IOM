<?php
/**
 * Layout: other_pillars
 *
 * Pillar icon cards — desktop row / mobile snap carousel.
 * Optional intro (“What This Programme Supports” + tags + body) and CTA.
 *
 * Figma (pillars only): 606:11757 / 677:41512
 * Figma (with supports intro): 606:11903 / 677:42020
 */

$intro_heading = get_sub_field( 'intro_heading' );
$tags          = get_sub_field( 'tags' );
$intro_body    = get_sub_field( 'intro_body' );
$heading       = get_sub_field( 'heading' );
$cards         = get_sub_field( 'cards' );
$cta           = get_sub_field( 'cta' );

$theme_uri = get_stylesheet_directory_uri();
$icon_map  = array(
	'family'     => $theme_uri . '/assets/images/icons/pillar-family.svg',
	'gender'     => $theme_uri . '/assets/images/icons/pillar-gender.svg',
	'education'  => $theme_uri . '/assets/images/icons/pillar-education.svg',
	'financial'  => $theme_uri . '/assets/images/icons/pillar-financial.svg',
	'healthcare' => $theme_uri . '/assets/images/icons/pillar-healthcare.svg',
);

$has_intro = (bool) $intro_heading
	|| ( is_array( $tags ) && ! empty( $tags ) )
	|| (bool) $intro_body;

if ( ! $heading ) {
	$heading = $has_intro
		? __( 'Our core pillars', 'impact-one-million' )
		: __( 'Explore Our Other Pillars', 'impact-one-million' );
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

if ( $has_intro && ( ! is_array( $tags ) || empty( $tags ) ) ) {
	$tags = array(
		array( 'label' => __( 'Human Rights', 'impact-one-million' ) ),
		array( 'label' => __( 'Due Diligence', 'impact-one-million' ) ),
		array( 'label' => __( 'Social Impact', 'impact-one-million' ) ),
		array( 'label' => __( 'Worker Wellbeing', 'impact-one-million' ) ),
	);
}

if ( $has_intro && ! $intro_heading ) {
	$intro_heading = __( 'What This Programme Supports', 'impact-one-million' );
}

if ( $has_intro && ! $intro_body ) {
	$intro_body = __( 'Designed to align with leading international standards and corporate sustainability frameworks.', 'impact-one-million' );
}

$link_class = 'inline-flex border-b-2 border-solid border-navy py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-70';
$btn_class  = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$section_pad = $has_intro
	? 'overflow-x-hidden bg-white px-0 py-section lg:px-gutter lg:py-24'
	: 'overflow-x-hidden bg-white px-0 py-[100px] lg:px-10 lg:py-[100px]';

$outer_gap = $has_intro
	? 'gap-section lg:gap-20'
	: 'gap-10 lg:gap-6';

$heading_class = $has_intro
	? 'm-0 px-page text-center font-display text-header leading-none text-navy lg:px-0'
	: 'm-0 px-page text-center font-display text-headline leading-[1.2] text-blue lg:px-0';
?>

<section class="<?php echo esc_attr( $section_pad ); ?>">
	<div class="mx-auto flex w-full max-w-site flex-col items-center <?php echo esc_attr( $outer_gap ); ?>">
		<?php if ( $has_intro ) : ?>
			<div class="flex w-full flex-col items-center gap-8 px-page lg:px-0">
				<?php if ( $intro_heading ) : ?>
					<h2 class="m-0 text-center font-display text-headline leading-[1.2] text-blue">
						<?php echo esc_html( $intro_heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( ! empty( $tags ) ) : ?>
					<ul class="m-0 flex w-full list-none flex-wrap content-center items-center justify-center gap-4 p-0">
						<?php foreach ( $tags as $tag ) : ?>
							<?php
							$label = isset( $tag['label'] ) ? $tag['label'] : '';
							if ( ! $label ) {
								continue;
							}
							?>
							<li class="flex min-w-[7.5rem] flex-1 items-center justify-center rounded-card bg-accent-blue px-6 py-3 lg:flex-none lg:shrink-0">
								<span class="font-display text-stat-label leading-[1.2] text-white">
									<?php echo esc_html( $label ); ?>
								</span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $intro_body ) : ?>
					<p class="m-0 max-w-[37.5rem] text-center font-sans text-label leading-[1.5] text-muted">
						<?php echo esc_html( $intro_body ); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="flex w-full flex-col items-center gap-10">
			<?php if ( $heading ) : ?>
				<?php if ( $has_intro ) : ?>
					<h3 class="<?php echo esc_attr( $heading_class ); ?>">
						<?php echo esc_html( $heading ); ?>
					</h3>
				<?php else : ?>
					<h2 class="<?php echo esc_attr( $heading_class ); ?>">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( ! empty( $cards ) ) : ?>
				<ul
					class="m-0 flex w-full list-none gap-4 overflow-x-auto scroll-smooth px-page pb-2 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory lg:grid lg:grid-cols-5 lg:overflow-visible lg:px-0 lg:pb-0 lg:snap-none [&::-webkit-scrollbar]:hidden"
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
										<?php if ( $has_intro ) : ?>
											<h4 class="m-0 font-display text-card-title leading-none text-blue">
												<?php echo esc_html( $title ); ?>
											</h4>
										<?php else : ?>
											<h3 class="m-0 font-display text-card-title leading-none text-blue">
												<?php echo esc_html( $title ); ?>
											</h3>
										<?php endif; ?>
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

			<?php if ( ! empty( $cta['url'] ) ) : ?>
				<?php
				iom_render_link(
					$cta,
					$btn_class,
					__( 'Join the Movement', 'impact-one-million' )
				);
				?>
			<?php endif; ?>
		</div>
	</div>
</section>
