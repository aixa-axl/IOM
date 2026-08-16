<?php
/**
 * Layout: get_involved
 *
 * Partner category cards (Buyers / Foundations / Factories).
 *
 * Figma desktop: 673:41044 — Figma mobile: 671:40703
 */

$heading = get_sub_field( 'heading' );
$intro   = get_sub_field( 'intro' );
$cards   = get_sub_field( 'cards' );

if ( ! $heading ) {
	$heading = __( 'Get involved', 'impact-one-million' );
}

if ( ! $intro ) {
	$intro = __( 'Join our network of organizations committed to safer migration.', 'impact-one-million' );
}

if ( ! is_array( $cards ) || empty( $cards ) ) {
	$cards = array(
		array(
			'title'        => __( 'For Buyers', 'impact-one-million' ),
			'body'         => __( 'Build stronger, more resilient supply chains by investing in the people behind them.', 'impact-one-million' ),
			'button_style' => 'accent',
			'link'         => array(
				'url'    => '#',
				'title'  => __( 'Partner With Us', 'impact-one-million' ),
				'target' => '',
			),
		),
		array(
			'title'        => __( 'For Foundations', 'impact-one-million' ),
			'body'         => __( 'Practical programmes that support your workforce and strengthen your business.', 'impact-one-million' ),
			'button_style' => 'blue',
			'link'         => array(
				'url'    => '#',
				'title'  => __( 'Partner With Us', 'impact-one-million' ),
				'target' => '',
			),
		),
		array(
			'title'        => __( 'For Factories', 'impact-one-million' ),
			'body'         => __( 'Describe the specific benefits and engagement model for this partner category.', 'impact-one-million' ),
			'button_style' => 'accent_blue',
			'link'         => array(
				'url'    => '#',
				'title'  => __( 'Partner With Us', 'impact-one-million' ),
				'target' => '',
			),
		),
	);
}

$btn_base = 'inline-flex items-center justify-center rounded-btn px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$btn_styles = array(
	'accent'      => 'bg-accent',
	'blue'        => 'bg-blue',
	'accent_blue' => 'bg-accent-blue',
);
?>

<section class="bg-white px-0 py-section lg:px-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10">
		<div class="flex w-full max-w-[40rem] flex-col items-center gap-2 px-10 text-center lg:px-0">
			<?php if ( $heading ) : ?>
				<h2 class="m-0 font-display text-headline leading-[1.2] text-blue lg:text-ink">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( $intro ) : ?>
				<p class="m-0 font-sans text-label leading-[1.5] text-ink">
					<?php echo esc_html( $intro ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $cards ) ) : ?>
			<ul
				class="m-0 flex w-full list-none gap-8 overflow-x-auto scroll-smooth px-10 pb-2 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory lg:grid lg:grid-cols-3 lg:gap-8 lg:overflow-visible lg:px-0 lg:pb-0 [&::-webkit-scrollbar]:hidden"
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
					<li
						class="flex w-[min(100%,20.3125rem)] shrink-0 snap-center flex-col justify-between gap-10 rounded-card bg-off-white p-10 lg:h-[26.25rem] lg:w-auto lg:snap-align-none lg:gap-0"
					>
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
		<?php endif; ?>
	</div>
</section>
