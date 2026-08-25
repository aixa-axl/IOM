<?php
/**
 * Layout: benefits
 *
 * Eyebrow + heading + icon cards + CTAs.
 * Desktop: wrapping grid. Mobile: snap carousel with dots.
 *
 * Figma desktop: 606:11698 — Figma mobile: 677:41476
 */

$eyebrow       = get_sub_field( 'eyebrow' );
$heading       = get_sub_field( 'heading' );
$intro         = get_sub_field( 'intro' );
$cards         = get_sub_field( 'cards' );
$primary_cta   = get_sub_field( 'primary_cta' );
$secondary_cta = get_sub_field( 'secondary_cta' );

$theme_uri = get_stylesheet_directory_uri();
$icon_map  = array(
	'health'     => $theme_uri . '/assets/images/icons/benefit-health.svg',
	'nutrition'  => $theme_uri . '/assets/images/icons/benefit-nutrition.svg',
	'parents'    => $theme_uri . '/assets/images/icons/benefit-parents.svg',
	'stress'     => $theme_uri . '/assets/images/icons/benefit-stress.svg',
	'education'  => $theme_uri . '/assets/images/icons/benefit-education.svg',
);

if ( ! is_array( $cards ) ) {
	$cards = array();
}

if ( ! is_array( $primary_cta ) ) {
	$primary_cta = array();
}

if ( ! is_array( $secondary_cta ) ) {
	$secondary_cta = array();
}

$card_count  = count( $cards );
$btn_primary = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90 lg:w-auto';
$btn_outline = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-navy px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-80 lg:w-auto';
?>

<section class="overflow-x-hidden bg-white px-0 py-section xl:px-gutter" data-benefits>
	<div class="mx-auto flex w-full max-w-site flex-col gap-20 lg:gap-10">
		<div class="flex flex-col gap-6 px-page xl:px-0">
			<?php if ( $eyebrow ) : ?>
				<p class="m-0 font-display text-label uppercase tracking-[1px] text-accent">
					<?php echo esc_html( $eyebrow ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( $intro ) : ?>
				<?php echo iom_format_multiline_text( $intro, 'm-0 max-w-[40rem] font-sans text-body leading-[1.2] text-navy' ); ?>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $cards ) ) : ?>
			<div class="w-full min-w-0" data-benefits-carousel>
				<ul
					class="m-0 flex list-none gap-6 overflow-x-auto scroll-smooth px-page pb-2 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory lg:grid lg:grid-cols-3 lg:gap-6 lg:overflow-visible xl:px-0 lg:pb-0 lg:snap-none [&::-webkit-scrollbar]:hidden"
					data-benefits-track
				>
					<?php foreach ( $cards as $card ) : ?>
						<?php
						$icon_id  = isset( $card['icon'] ) ? $card['icon'] : null;
						$preset   = isset( $card['icon_preset'] ) ? $card['icon_preset'] : '';
						$title    = isset( $card['title'] ) ? $card['title'] : '';
						$body     = isset( $card['body'] ) ? $card['body'] : '';
						$icon_uri = ( $preset && isset( $icon_map[ $preset ] ) ) ? $icon_map[ $preset ] : '';
						?>
						<li
							class="flex w-[min(100%,20rem)] shrink-0 snap-center flex-col items-center justify-center gap-4 rounded-card bg-off-white p-3 text-center lg:w-auto lg:min-h-[11.3rem] lg:min-w-0 lg:snap-align-none"
							data-benefits-slide
						>
							<div class="flex h-[2.8rem] w-11 items-center justify-center" aria-hidden="true">
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

							<?php if ( $title || $body ) : ?>
								<div class="flex w-full flex-col items-center gap-2">
									<?php if ( $title ) : ?>
										<p class="m-0 font-display text-card-title leading-none text-blue">
											<?php echo esc_html( $title ); ?>
										</p>
									<?php endif; ?>

									<?php if ( $body ) : ?>
										<?php echo iom_format_multiline_text( $body, 'm-0 font-sans text-body leading-[1.2] text-muted' ); ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>

				<?php if ( $card_count > 1 ) : ?>
					<div
						class="mt-3.5 flex items-center justify-center gap-2 lg:hidden"
						data-benefits-dots
						aria-hidden="true"
					>
						<?php for ( $i = 0; $i < $card_count; $i++ ) : ?>
							<span
								class="size-1.5 rounded-full bg-accent-blue/25 transition-colors data-[active=true]:bg-accent-blue"
								data-benefits-dot
								<?php echo 0 === $i ? 'data-active="true"' : ''; ?>
							></span>
						<?php endfor; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $primary_cta['url'] ) || ! empty( $secondary_cta['url'] ) ) : ?>
			<div class="flex w-full flex-col items-stretch gap-4 px-page lg:flex-row lg:items-start xl:px-0 lg:whitespace-nowrap">
				<?php
				if ( ! empty( $primary_cta['url'] ) ) {
					iom_render_link(
						$primary_cta,
						$btn_primary,
						''
					);
				}
				if ( ! empty( $secondary_cta['url'] ) ) {
					iom_render_link(
						$secondary_cta,
						$btn_outline,
						''
					);
				}
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
