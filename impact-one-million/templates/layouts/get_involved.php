<?php
/**
 * Layout: get_involved
 *
 * Partner category cards (Buyers / Foundations / Factories).
 *
 * Light: white band, off-white cards, mobile snap scroll.
 * Dark: ink band, white centered cards, stacked on mobile.
 *
 * Figma desktop (light): 673:41044 — mobile: 671:40703
 * Figma desktop (dark / Become a Partner): 669:38435
 */

$variant = get_sub_field( 'variant' );
$heading = get_sub_field( 'heading' );
$intro   = get_sub_field( 'intro' );
$cards   = get_sub_field( 'cards' );

if ( ! in_array( $variant, array( 'light', 'dark' ), true ) ) {
	$variant = 'light';
}

$is_dark = ( 'dark' === $variant );

if ( ! $heading ) {
	$heading = $is_dark
		? __( 'Become a Partner', 'impact-one-million' )
		: __( 'Get involved', 'impact-one-million' );
}

if ( ! $intro ) {
	$intro = __( 'Join our network of organizations committed to safer migration.', 'impact-one-million' );
}

if ( ! is_array( $cards ) || empty( $cards ) ) {
	$cards = array(
		array(
			'title'        => __( 'For Buyers', 'impact-one-million' ),
			'body'         => $is_dark
				? __( 'Describe the specific benefits and engagement model for this partner category.', 'impact-one-million' )
				: __( 'Build stronger, more resilient supply chains by investing in the people behind them.', 'impact-one-million' ),
			'button_style' => $is_dark ? 'navy' : 'accent',
			'link'         => array(
				'url'    => '#',
				'title'  => __( 'Partner With Us', 'impact-one-million' ),
				'target' => '',
			),
		),
		array(
			'title'        => __( 'For Foundations', 'impact-one-million' ),
			'body'         => $is_dark
				? __( 'Describe the specific benefits and engagement model for this partner category.', 'impact-one-million' )
				: __( 'Practical programmes that support your workforce and strengthen your business.', 'impact-one-million' ),
			'button_style' => $is_dark ? 'navy' : 'blue',
			'link'         => array(
				'url'    => '#',
				'title'  => __( 'Partner With Us', 'impact-one-million' ),
				'target' => '',
			),
		),
		array(
			'title'        => __( 'For Factories', 'impact-one-million' ),
			'body'         => __( 'Describe the specific benefits and engagement model for this partner category.', 'impact-one-million' ),
			'button_style' => $is_dark ? 'navy' : 'accent_blue',
			'link'         => array(
				'url'    => '#',
				'title'  => __( 'Partner With Us', 'impact-one-million' ),
				'target' => '',
			),
		),
	);
}

$btn_base = 'inline-flex items-center justify-center whitespace-nowrap rounded-btn border-[1.5px] border-solid border-transparent px-4 py-3.5 font-display text-card-title uppercase tracking-[1.5px] text-white no-underline transition-opacity hover:opacity-90 xl:px-6 xl:tracking-[2px]';

$btn_styles = array(
	'accent'      => 'bg-accent',
	'blue'        => 'bg-blue',
	'accent_blue' => 'bg-accent-blue',
	'navy'        => 'bg-navy',
);

$section_class = $is_dark
	? 'overflow-x-hidden bg-ink px-page py-section xl:px-section'
	: 'overflow-x-hidden bg-white px-0 py-section xl:px-gutter';

$heading_class = $is_dark
	? 'm-0 font-display text-headline leading-[1.2] text-white'
	: 'm-0 font-display text-headline leading-[1.2] text-navy';

$intro_class = $is_dark
	? 'm-0 font-sans text-body leading-[1.2] text-white'
	: 'm-0 font-sans text-label leading-[1.5] text-navy';

$list_class = $is_dark
	? 'm-0 grid w-full list-none grid-cols-1 gap-8 p-0 lg:grid-cols-3'
	: 'm-0 flex w-full list-none gap-8 overflow-x-auto scroll-smooth px-page pb-2 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory lg:grid lg:grid-cols-3 lg:gap-8 lg:overflow-visible xl:px-0 lg:pb-0 [&::-webkit-scrollbar]:hidden';

$card_class = $is_dark
	? 'flex w-full flex-col items-center gap-6 rounded-card bg-white p-[14px] text-center lg:p-10'
	: 'flex w-[min(100%,20.3125rem)] shrink-0 snap-center flex-col justify-between gap-10 rounded-card bg-off-white p-[14px] lg:h-[26.25rem] lg:w-auto lg:snap-align-none lg:gap-0 lg:p-10';

$card_count = is_array( $cards ) ? count( $cards ) : 0;
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10">
		<div class="flex w-full max-w-[40rem] flex-col items-center gap-4 text-center <?php echo $is_dark ? '' : 'px-page xl:px-0'; ?>">
			<?php if ( $heading ) : ?>
				<h2 class="<?php echo esc_attr( $heading_class ); ?>">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( $intro ) : ?>
				<p class="<?php echo esc_attr( $intro_class ); ?>">
					<?php echo esc_html( $intro ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $cards ) ) : ?>
			<?php if ( $is_dark ) : ?>
				<ul class="<?php echo esc_attr( $list_class ); ?>">
					<?php foreach ( $cards as $card ) : ?>
						<?php
						$title = isset( $card['title'] ) ? $card['title'] : '';
						$body  = isset( $card['body'] ) ? $card['body'] : '';
						$link  = isset( $card['link'] ) && is_array( $card['link'] ) ? $card['link'] : array();
						$style = isset( $card['button_style'] ) ? $card['button_style'] : 'navy';
						if ( ! isset( $btn_styles[ $style ] ) ) {
							$style = 'navy';
						}

						$link_url    = ! empty( $link['url'] ) ? $link['url'] : '';
						$link_title  = ! empty( $link['title'] ) ? $link['title'] : __( 'Partner With Us', 'impact-one-million' );
						$link_target = ! empty( $link['target'] ) ? $link['target'] : '';
						$btn_class   = $btn_base . ' ' . $btn_styles[ $style ];
						?>
						<li class="<?php echo esc_attr( $card_class ); ?>">
							<div class="flex flex-col items-center gap-3">
								<?php if ( $title ) : ?>
									<h3 class="m-0 font-display text-card-title text-blue">
										<?php echo esc_html( $title ); ?>
									</h3>
								<?php endif; ?>

								<?php if ( $body ) : ?>
									<p class="m-0 font-sans text-sm leading-normal text-ink">
										<?php echo esc_html( $body ); ?>
									</p>
								<?php endif; ?>
							</div>

							<?php if ( $link_url ) : ?>
								<a
									class="<?php echo esc_attr( $btn_class ); ?>"
									href="<?php echo esc_url( $link_url ); ?>"
									<?php echo $link_target ? 'target="' . esc_attr( $link_target ) . '" rel="noopener noreferrer"' : ''; ?>
								>
									<?php echo esc_html( $link_title ); ?>
								</a>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<div class="w-full min-w-0" data-get-involved-carousel>
					<ul
						class="<?php echo esc_attr( $list_class ); ?>"
						data-get-involved-track
					>
						<?php foreach ( $cards as $card ) : ?>
							<?php
							$title = isset( $card['title'] ) ? $card['title'] : '';
							$body  = isset( $card['body'] ) ? $card['body'] : '';
							$link  = isset( $card['link'] ) && is_array( $card['link'] ) ? $card['link'] : array();
							$style = isset( $card['button_style'] ) ? $card['button_style'] : 'accent';
							if ( ! isset( $btn_styles[ $style ] ) ) {
								$style = 'accent';
							}

							$link_url    = ! empty( $link['url'] ) ? $link['url'] : '';
							$link_title  = ! empty( $link['title'] ) ? $link['title'] : __( 'Partner With Us', 'impact-one-million' );
							$link_target = ! empty( $link['target'] ) ? $link['target'] : '';
							$btn_class   = $btn_base . ' ' . $btn_styles[ $style ];
							?>
							<li class="<?php echo esc_attr( $card_class ); ?>" data-get-involved-slide>
								<div class="flex flex-col gap-3">
									<?php if ( $title ) : ?>
										<h3 class="m-0 font-display text-card-title text-navy">
											<?php echo esc_html( $title ); ?>
										</h3>
									<?php endif; ?>

									<?php if ( $body ) : ?>
										<p class="m-0 font-sans text-body leading-[1.2] text-muted">
											<?php echo esc_html( $body ); ?>
										</p>
									<?php endif; ?>
								</div>

								<?php if ( $link_url ) : ?>
									<a
										class="<?php echo esc_attr( $btn_class ); ?> self-start"
										href="<?php echo esc_url( $link_url ); ?>"
										<?php echo $link_target ? 'target="' . esc_attr( $link_target ) . '" rel="noopener noreferrer"' : ''; ?>
									>
										<?php echo esc_html( $link_title ); ?>
									</a>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>

					<?php if ( $card_count > 1 ) : ?>
						<div
							class="mt-6 flex items-center justify-center gap-2 lg:hidden"
							data-get-involved-dots
							aria-hidden="true"
						>
							<?php for ( $i = 0; $i < $card_count; $i++ ) : ?>
								<span
									class="size-1.5 rounded-full bg-accent-blue/25 transition-colors data-[active=true]:bg-accent-blue"
									data-get-involved-dot
									<?php echo 0 === $i ? 'data-active="true"' : ''; ?>
								></span>
							<?php endfor; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>
