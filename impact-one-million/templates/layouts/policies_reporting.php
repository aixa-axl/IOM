<?php
/**
 * Layout: policies_reporting
 *
 * Heading + download cards in one equal-width row on desktop (no clip).
 * Mobile: stacked.
 *
 * Fields: heading, cards (repeater: icon, title, download link)
 *
 * Figma desktop: 669:37709 (no mobile frame — stacked adaptation)
 */

$heading = get_sub_field( 'heading' );
$cards   = get_sub_field( 'cards' );

$download_icon = get_stylesheet_directory_uri() . '/assets/images/icons/download.svg';

$link_class = 'inline-flex border-b-2 border-solid border-navy py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-70';

if ( ! is_array( $cards ) ) {
	$cards = array();
}
?>

<section class="bg-white px-page py-10 lg:px-gutter lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-6">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( ! empty( $cards ) ) : ?>
			<ul class="m-0 grid w-full list-none grid-cols-1 gap-4 p-0 sm:grid-cols-2 lg:grid-cols-4">
				<?php foreach ( $cards as $card ) : ?>
					<?php
					$icon_id  = isset( $card['icon'] ) ? $card['icon'] : null;
					$title    = isset( $card['title'] ) ? $card['title'] : '';
					$download = isset( $card['download'] ) && is_array( $card['download'] ) ? $card['download'] : array();

					if ( ! $title && empty( $download['url'] ) ) {
						continue;
					}
					?>
					<li class="flex min-w-0 flex-col items-start gap-4 rounded-card border border-solid border-[#dfe8ff] bg-off-white p-6">
						<div class="flex w-full flex-col items-start gap-4">
							<div class="flex h-[2.8125rem] w-11 shrink-0 items-center justify-start" aria-hidden="true">
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
								<?php else : ?>
									<img
										src="<?php echo esc_url( $download_icon ); ?>"
										alt=""
										width="31"
										height="36"
										class="h-9 w-[1.925rem] object-contain"
										loading="lazy"
										decoding="async"
									>
								<?php endif; ?>
							</div>

							<?php if ( $title ) : ?>
								<h3 class="m-0 font-display text-card-title leading-none text-blue">
									<?php echo esc_html( $title ); ?>
								</h3>
							<?php endif; ?>
						</div>

						<?php
						if ( ! empty( $download['url'] ) ) {
							iom_render_link(
								$download,
								$link_class . ' self-start',
								__( 'Download PDF', 'impact-one-million' )
							);
						}
						?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
