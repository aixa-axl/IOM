<?php
/**
 * Layout: challenge
 *
 * ACF layout name: challenge
 * Fields: heading, cards (repeater: style, icon, icon_preset, title, body, link)
 *
 * Figma desktop: 606:11498 — Figma mobile: 671:40583
 */

$heading = get_sub_field( 'heading' );
$cards   = get_sub_field( 'cards' );

$theme_uri = get_stylesheet_directory_uri();
$icon_map  = array(
	'people'       => $theme_uri . '/assets/images/icons/challenge-people.svg',
	'coins'        => $theme_uri . '/assets/images/icons/challenge-coins.svg',
	'people_group' => $theme_uri . '/assets/images/icons/challenge-people-group.svg',
	'arrows'       => $theme_uri . '/assets/images/icons/challenge-arrows.svg',
);

if ( ! $heading ) {
	$heading = __( 'The challenge we are solving', 'impact-one-million' );
}

if ( ! is_array( $cards ) || empty( $cards ) ) {
	$cards = array(
		array(
			'style'       => 'fact',
			'icon'        => null,
			'icon_preset' => 'people',
			'title'       => __( '650 million women', 'impact-one-million' ),
			'body'        => __( 'Millions of women globally lack access to adequate maternity protection at work.', 'impact-one-million' ),
			'link'        => null,
		),
		array(
			'style'       => 'fact',
			'icon'        => null,
			'icon_preset' => 'coins',
			'title'       => __( '$2.15 daily wage', 'impact-one-million' ),
			'body'        => __( '241 million workers earn no more than $2 a day - defined as extreme working poverty.', 'impact-one-million' ),
			'link'        => null,
		),
		array(
			'style'       => 'fact',
			'icon'        => null,
			'icon_preset' => 'people_group',
			'title'       => __( '8% working poor', 'impact-one-million' ),
			'body'        => __( 'Nearly a tenth of the world’s workers are classified as ‘working poor’ by the ILO', 'impact-one-million' ),
			'link'        => null,
		),
		array(
			'style'       => 'cta',
			'icon'        => null,
			'icon_preset' => 'arrows',
			'title'       => __( 'Find out more', 'impact-one-million' ),
			'body'        => __( 'Learn more about the needs identified and support programs available', 'impact-one-million' ),
			'link'        => array(
				'url'    => '#',
				'title'  => __( 'the need', 'impact-one-million' ),
				'target' => '',
			),
		),
	);
}

$btn_cta = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-white px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-90';
?>

<section class="bg-white px-page pt-5 pb-10 lg:px-gutter lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 max-w-full text-center font-display text-headline text-navy">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( ! empty( $cards ) ) : ?>
			<ul
				class="m-0 grid w-full list-none grid-cols-1 gap-0 space-y-[28px] p-0 lg:grid-cols-2 lg:gap-10 lg:space-y-0"
				data-challenge-cards
			>
				<?php foreach ( $cards as $card ) : ?>
					<?php
					$style  = isset( $card['style'] ) ? $card['style'] : 'fact';
					$is_cta = ( 'cta' === $style );
					$icon_id = isset( $card['icon'] ) ? $card['icon'] : null;
					$preset  = isset( $card['icon_preset'] ) ? $card['icon_preset'] : '';
					$title   = isset( $card['title'] ) ? $card['title'] : '';
					$body    = isset( $card['body'] ) ? $card['body'] : '';
					$link    = isset( $card['link'] ) ? $card['link'] : null;
					$icon_uri = ( $preset && isset( $icon_map[ $preset ] ) ) ? $icon_map[ $preset ] : '';

					$card_class = $is_cta
						? 'flex flex-col items-center gap-3 rounded-card bg-accent p-[14px] text-center lg:flex-row lg:items-center lg:gap-10 lg:px-10 lg:py-10 lg:text-left'
						: 'flex flex-col items-center gap-3 rounded-card bg-white p-0 text-center lg:flex-row lg:items-center lg:gap-10 lg:p-10 lg:text-left';

					$title_class = $is_cta
						? 'm-0 font-display text-[32px] leading-[1.2] text-white lg:text-feature-title lg:leading-[39px]'
						: 'm-0 font-display text-[32px] leading-[1.2] text-blue lg:text-feature-title lg:leading-[39px]';

					$body_class = $is_cta
						? 'm-0 font-sans text-[20px] font-normal leading-[1.5] text-white lg:text-label lg:font-semibold lg:leading-6'
						: 'm-0 font-sans text-[20px] font-normal leading-[1.5] text-blue lg:text-label lg:font-semibold lg:leading-6';

					$text_wrap_class = $is_cta
						? 'flex w-full flex-col items-center gap-4 lg:items-start'
						: 'flex w-full flex-col items-center gap-4 lg:min-w-0 lg:flex-1 lg:items-start';

					$icon_wrap_class = 'flex h-auto w-20 shrink-0 items-center justify-center lg:size-[6.25rem]';
					?>
					<li class="<?php echo esc_attr( $card_class ); ?>">
						<div class="<?php echo esc_attr( $icon_wrap_class ); ?>" aria-hidden="true">
							<?php if ( $icon_id ) : ?>
								<?php
								echo wp_get_attachment_image(
									$icon_id,
									'thumbnail',
									false,
									array(
										'class'   => 'max-h-full w-auto max-w-full object-contain',
										'alt'     => '',
										'loading' => 'lazy',
									)
								);
								?>
							<?php elseif ( $icon_uri ) : ?>
								<img
									src="<?php echo esc_url( $icon_uri ); ?>"
									alt=""
									width="100"
									height="100"
									class="max-h-full w-auto max-w-full object-contain"
									loading="lazy"
								/>
							<?php endif; ?>
						</div>

						<div class="<?php echo esc_attr( $text_wrap_class ); ?>">
							<?php if ( $title ) : ?>
								<h3 class="<?php echo esc_attr( $title_class ); ?>">
									<?php echo esc_html( $title ); ?>
								</h3>
							<?php endif; ?>

							<?php if ( $body ) : ?>
								<p class="<?php echo esc_attr( $body_class ); ?>">
									<?php echo esc_html( $body ); ?>
								</p>
							<?php endif; ?>

							<?php
							if ( $is_cta && ! empty( $link['url'] ) ) {
								iom_render_link(
									$link,
									$btn_cta,
									__( 'the need', 'impact-one-million' )
								);
							}
							?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
