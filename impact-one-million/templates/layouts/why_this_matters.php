<?php
/**
 * Layout: why_this_matters
 *
 * Heading + intro, arrow stat cards (3+2 centered on desktop), footer body.
 * Desktop: wrapped / centered card rows. Mobile: stacked.
 *
 * Figma desktop: 634:20352 (no mobile frame — stacked adaptation)
 */

$heading = get_sub_field( 'heading' );
$intro   = get_sub_field( 'intro' );
$cards   = get_sub_field( 'cards' );
$footer  = get_sub_field( 'footer' );

$theme_uri = get_stylesheet_directory_uri();
$arrow_uri = $theme_uri . '/assets/images/icons/why-join-arrow.svg';

if ( ! $heading ) {
	$heading = __( 'Why This Matters', 'impact-one-million' );
}

if ( ! $intro ) {
	$intro = __( 'Supply chains are the backbone of global commerce, yet millions of workers remain trapped in cycles of poverty and instability.', 'impact-one-million' );
}

if ( ! $footer ) {
	$footer = __( 'These challenges are interconnected. Financial exclusion drives health risks; lack of early childhood support limits gender equality. We tackle these barriers simultaneously through collaborative, supply-chain-wide action.', 'impact-one-million' );
}

if ( ! is_array( $cards ) ) {
	$cards = array();
}
?>

<section class="bg-white px-page py-20 lg:px-section lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10">
		<?php if ( $heading || $intro ) : ?>
			<div class="flex w-full flex-col items-start gap-4">
				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $intro ) : ?>
					<p class="m-0 font-sans text-body leading-[1.2] text-muted">
						<?php echo esc_html( $intro ); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $cards ) ) : ?>
			<?php
			$valid_cards = array();
			foreach ( $cards as $card ) {
				$label = isset( $card['label'] ) ? $card['label'] : '';
				if ( $label ) {
					$valid_cards[] = $label;
				}
			}

			$row_one = array_slice( $valid_cards, 0, 3 );
			$row_two = array_slice( $valid_cards, 3 );
			?>
			<?php if ( ! empty( $valid_cards ) ) : ?>
				<div class="flex w-full flex-col gap-8">
					<?php if ( ! empty( $row_one ) ) : ?>
						<ul class="m-0 grid w-full list-none grid-cols-1 gap-8 p-0 lg:grid-cols-3">
							<?php foreach ( $row_one as $label ) : ?>
								<li class="flex flex-col items-start gap-4 rounded-card bg-off-white p-6">
									<img
										src="<?php echo esc_url( $arrow_uri ); ?>"
										alt=""
										width="44"
										height="45"
										class="h-[2.8125rem] w-11 shrink-0"
										loading="lazy"
										decoding="async"
										aria-hidden="true"
									>
									<p class="m-0 font-display text-[2rem] uppercase leading-none tracking-[2px] text-blue">
										<?php echo esc_html( $label ); ?>
									</p>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ( ! empty( $row_two ) ) : ?>
						<ul class="m-0 mx-auto grid w-full list-none grid-cols-1 gap-8 p-0 lg:w-[calc((200%-2rem)/3)] lg:grid-cols-2">
							<?php foreach ( $row_two as $label ) : ?>
								<li class="flex flex-col items-start gap-4 rounded-card bg-off-white p-6">
									<img
										src="<?php echo esc_url( $arrow_uri ); ?>"
										alt=""
										width="44"
										height="45"
										class="h-[2.8125rem] w-11 shrink-0"
										loading="lazy"
										decoding="async"
										aria-hidden="true"
									>
									<p class="m-0 font-display text-[2rem] uppercase leading-none tracking-[2px] text-blue">
										<?php echo esc_html( $label ); ?>
									</p>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( $footer ) : ?>
			<p class="m-0 max-w-[50rem] font-sans text-body leading-[1.2] text-muted">
				<?php echo esc_html( $footer ); ?>
			</p>
		<?php endif; ?>
	</div>
</section>
