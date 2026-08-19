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

$btn_base = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$btn_styles = array(
	'accent'      => 'bg-accent',
	'blue'        => 'bg-blue',
	'accent_blue' => 'bg-accent-blue',
	'navy'        => 'bg-navy',
);

$section_class = $is_dark
	? 'bg-ink px-page py-section lg:px-section'
	: 'bg-white px-0 py-section lg:px-gutter';

$heading_class = $is_dark
	? 'm-0 font-display text-headline leading-[1.2] text-white'
	: 'm-0 font-display text-headline leading-[1.2] text-navy';

$intro_class = $is_dark
	? 'm-0 font-sans text-body leading-[1.2] text-white'
	: 'm-0 font-sans text-label leading-[1.5] text-navy';

$list_class = $is_dark
	? 'm-0 grid w-full list-none grid-cols-1 gap-8 p-0 lg:grid-cols-3'
	: 'm-0 flex w-full list-none gap-8 overflow-x-auto scroll-smooth px-page pb-2 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory lg:grid lg:grid-cols-3 lg:gap-8 lg:overflow-visible lg:px-0 lg:pb-0 [&::-webkit-scrollbar]:hidden';

$card_class = $is_dark
	? 'flex w-full flex-col items-center gap-6 rounded-card bg-white p-10 text-center'
	: 'flex w-[min(100%,20.3125rem)] shrink-0 snap-center flex-col justify-between gap-10 rounded-card bg-off-white p-10 lg:h-[26.25rem] lg:w-auto lg:snap-align-none lg:gap-0';
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10">
		<div class="flex w-full max-w-[40rem] flex-col items-center gap-4 text-center">
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
			<ul
				class="<?php echo esc_attr( $list_class ); ?>"
				<?php echo $is_dark ? '' : 'data-get-involved-track'; ?>
			>
				<?php foreach ( $cards as $card ) : ?>
					<?php
					$title = isset( $card['title'] ) ? $card['title'] : '';
					$body  = isset( $card['body'] ) ? $card['body'] : '';
					$link  = isset( $card['link'] ) && is_array( $card['link'] ) ? $card['link'] : array();
					$style = isset( $card['button_style'] ) ? $card['button_style'] : ( $is_dark ? 'navy' : 'accent' );
					if ( ! isset( $btn_styles[ $style ] ) ) {
						$style = $is_dark ? 'navy' : 'accent';
					}

					$link_url    = ! empty( $link['url'] ) ? $link['url'] : '';
					$link_title  = ! empty( $link['title'] ) ? $link['title'] : __( 'Partner With Us', 'impact-one-million' );
					$link_target = ! empty( $link['target'] ) ? $link['target'] : '';
					$btn_class   = $btn_base . ' ' . $btn_styles[ $style ];
					?>
					<li class="<?php echo esc_attr( $card_class ); ?>">
						<div class="flex flex-col <?php echo $is_dark ? 'items-center gap-3' : 'gap-3'; ?>">
							<?php if ( $title ) : ?>
								<h3 class="m-0 font-display text-card-title <?php echo $is_dark ? 'text-blue' : 'text-navy'; ?>">
									<?php echo esc_html( $title ); ?>
								</h3>
							<?php endif; ?>

							<?php if ( $body ) : ?>
								<p class="m-0 font-sans <?php echo $is_dark ? 'text-sm leading-normal text-ink' : 'text-body leading-[1.2] text-muted'; ?>">
									<?php echo esc_html( $body ); ?>
								</p>
							<?php endif; ?>
						</div>

						<?php if ( $link_url ) : ?>
							<a
								class="<?php echo esc_attr( $btn_class ); ?><?php echo $is_dark ? '' : ' self-start'; ?>"
								href="<?php echo esc_url( $link_url ); ?>"
								<?php echo $link_target ? 'target="' . esc_attr( $link_target ) . '" rel="noopener noreferrer"' : ''; ?>
							>
								<?php echo esc_html( $link_title ); ?>
							</a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
