<?php
/**
 * Layout: why_join
 *
 * Icon cards with heading — Why Join, Why Ambassadors Matter, Impact We Want to Create.
 * Desktop: 3-col grid (classic) or 3+2 rows when Heading Align = Left with 5+ cards.
 * Mobile: snap carousel with dots.
 *
 * Figma desktop: 606:11808 — Figma mobile: 677:41984
 * Figma with intro: 663:31781
 * Figma left heading + 5 cards (3+2): 634:20435
 */

$heading       = get_sub_field( 'heading' );
$intro         = get_sub_field( 'intro' );
$heading_align = get_sub_field( 'heading_align' );
$cards         = get_sub_field( 'cards' );
$cta           = get_sub_field( 'cta' );

$theme_uri = get_stylesheet_directory_uri();
$arrow_uri = $theme_uri . '/assets/images/icons/why-join-arrow.svg';

$has_intro = (bool) $intro;

if ( ! in_array( $heading_align, array( 'center', 'left' ), true ) ) {
	// Legacy: intro forces left; otherwise centre.
	$heading_align = $has_intro ? 'left' : 'center';
}

$is_left = ( 'left' === $heading_align );

if ( ! $heading ) {
	$heading = __( 'Why Buyers Join', 'impact-one-million' );
}

if ( ! is_array( $cards ) || empty( $cards ) ) {
	$cards = array(
		array(
			'icon'  => null,
			'title' => __( 'Better Outcomes for Workers', 'impact-one-million' ),
			'body'  => __( 'Support fair wages, safe conditions, and dignified work across your supply chain.', 'impact-one-million' ),
		),
		array(
			'icon'  => null,
			'title' => __( 'Stronger Suppliers', 'impact-one-million' ),
			'body'  => __( 'Help suppliers build the resilience and compliance capacity you need from them.', 'impact-one-million' ),
		),
		array(
			'icon'  => null,
			'title' => __( 'Greater Impact for You', 'impact-one-million' ),
			'body'  => __( 'Turn supply chain investment into verifiable ESG progress you can report with confidence.', 'impact-one-million' ),
		),
	);
}

if ( ! is_array( $cta ) ) {
	$cta = array();
}

$card_count = count( $cards );
$btn_class  = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$outer_gap = ( $has_intro || $is_left ) ? 'gap-12 lg:gap-16' : 'gap-20 lg:gap-10';

// Impact layout: left heading + 5 cards → 3 on top, 2 below (desktop only).
$use_impact_rows = ( $is_left && $card_count >= 5 );

/**
 * Render one impact / why-join card.
 *
 * @param array  $card      Card row.
 * @param string $arrow_uri Fallback arrow URL.
 * @param bool   $carousel  Whether this is a mobile carousel slide.
 */
$iom_render_why_join_card = function ( $card, $arrow_uri, $carousel = false ) {
	$icon_id = isset( $card['icon'] ) ? $card['icon'] : null;
	$title   = isset( $card['title'] ) ? $card['title'] : '';
	$body    = isset( $card['body'] ) ? $card['body'] : '';

	$li_class = $carousel
		? 'flex w-[min(100%,25rem)] shrink-0 snap-center flex-col gap-4 rounded-card border border-solid border-[#dfe8ff] bg-off-white p-6'
		: 'flex flex-col gap-4 rounded-card border border-solid border-[#dfe8ff] bg-off-white p-6';
	?>
	<li class="<?php echo esc_attr( $li_class ); ?>" <?php echo $carousel ? 'data-why-join-slide' : ''; ?>>
		<div class="flex h-[2.8125rem] w-11 items-center justify-start" aria-hidden="true">
			<?php if ( $icon_id ) : ?>
				<?php
				echo wp_get_attachment_image(
					$icon_id,
					'thumbnail',
					false,
					array(
						'class'   => 'h-[2.8125rem] w-11 object-contain',
						'alt'     => '',
						'loading' => 'lazy',
					)
				);
				?>
			<?php else : ?>
				<img
					src="<?php echo esc_url( $arrow_uri ); ?>"
					alt=""
					width="44"
					height="45"
					class="h-[2.8125rem] w-11 object-contain"
					loading="lazy"
				/>
			<?php endif; ?>
		</div>

		<?php if ( $title ) : ?>
			<h3 class="m-0 font-display text-card-title leading-none text-blue">
				<?php echo esc_html( $title ); ?>
			</h3>
		<?php endif; ?>

		<?php if ( $body ) : ?>
			<p class="m-0 line-clamp-2 font-sans text-body leading-[1.2] text-muted">
				<?php echo esc_html( $body ); ?>
			</p>
		<?php endif; ?>
	</li>
	<?php
};
?>

<section class="bg-white px-0 py-section lg:px-gutter lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col <?php echo $is_left ? 'items-start' : 'items-center'; ?> <?php echo esc_attr( $outer_gap ); ?>">
		<?php if ( $heading || $has_intro ) : ?>
			<div class="flex w-full flex-col gap-6 px-10 <?php echo $is_left ? 'items-start text-left' : 'items-center text-center'; ?> lg:px-0">
				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $has_intro ) : ?>
					<p class="m-0 font-sans text-body leading-[1.2] text-ink">
						<?php echo esc_html( $intro ); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $cards ) ) : ?>
			<?php if ( $use_impact_rows ) : ?>
				<?php
				$row_one = array_slice( $cards, 0, 3 );
				$row_two = array_slice( $cards, 3 );
				?>
				<!-- Mobile carousel -->
				<div class="w-full lg:hidden" data-why-join-carousel>
					<ul
						class="m-0 flex list-none gap-6 overflow-x-auto scroll-smooth px-10 pb-2 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory [&::-webkit-scrollbar]:hidden"
						data-why-join-track
					>
						<?php foreach ( $cards as $card ) : ?>
							<?php $iom_render_why_join_card( $card, $arrow_uri, true ); ?>
						<?php endforeach; ?>
					</ul>

					<?php if ( $card_count > 1 ) : ?>
						<div class="mt-6 flex items-center justify-center gap-2" data-why-join-dots aria-hidden="true">
							<?php for ( $i = 0; $i < $card_count; $i++ ) : ?>
								<span
									class="size-1.5 rounded-full bg-accent-blue/25 transition-colors data-[active=true]:bg-accent-blue"
									data-why-join-dot
									<?php echo 0 === $i ? 'data-active="true"' : ''; ?>
								></span>
							<?php endfor; ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Desktop: 3 + 2 -->
				<div class="hidden w-full flex-col gap-6 lg:flex">
					<ul class="m-0 grid w-full list-none grid-cols-3 gap-6 p-0">
						<?php foreach ( $row_one as $card ) : ?>
							<?php $iom_render_why_join_card( $card, $arrow_uri, false ); ?>
						<?php endforeach; ?>
					</ul>

					<?php if ( ! empty( $row_two ) ) : ?>
						<ul class="m-0 grid w-[calc((200%-1.5rem)/3)] list-none grid-cols-2 gap-6 self-start p-0">
							<?php foreach ( $row_two as $card ) : ?>
								<?php $iom_render_why_join_card( $card, $arrow_uri, false ); ?>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			<?php else : ?>
				<div class="w-full" data-why-join-carousel>
					<ul
						class="m-0 flex list-none gap-6 overflow-x-auto scroll-smooth px-10 pb-2 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory lg:grid lg:grid-cols-3 lg:gap-8 lg:overflow-visible lg:px-0 lg:pb-0 lg:snap-none [&::-webkit-scrollbar]:hidden"
						data-why-join-track
					>
						<?php foreach ( $cards as $card ) : ?>
							<?php $iom_render_why_join_card( $card, $arrow_uri, true ); ?>
						<?php endforeach; ?>
					</ul>

					<?php if ( $card_count > 1 ) : ?>
						<div
							class="mt-6 flex items-center justify-center gap-2 lg:hidden"
							data-why-join-dots
							aria-hidden="true"
						>
							<?php for ( $i = 0; $i < $card_count; $i++ ) : ?>
								<span
									class="size-1.5 rounded-full bg-accent-blue/25 transition-colors data-[active=true]:bg-accent-blue"
									data-why-join-dot
									<?php echo 0 === $i ? 'data-active="true"' : ''; ?>
								></span>
							<?php endfor; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( ! empty( $cta['url'] ) ) : ?>
			<div class="<?php echo $is_left ? 'w-full' : ''; ?>">
				<?php
				iom_render_link(
					$cta,
					$btn_class,
					__( 'Nominate a Supplier', 'impact-one-million' )
				);
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
