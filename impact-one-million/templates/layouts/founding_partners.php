<?php
/**
 * Layout: founding_partners
 *
 * Off-white band — heading + partner cards (logo, title, body, website link).
 * Desktop: 2-column grid. Mobile: stacked.
 *
 * Figma desktop: 634:19389 (no mobile frame — stacked adaptation)
 */

$heading     = get_sub_field( 'heading' );
$intro       = get_sub_field( 'intro' );
$cards_title = get_sub_field( 'cards_title' );
$partners    = get_sub_field( 'partners' );

if ( ! $heading ) {
	$heading = __( 'Founding Partners', 'impact-one-million' );
}

if ( ! is_array( $partners ) ) {
	$partners = array();
}

$link_class = 'inline-flex border-b-2 border-solid border-navy py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-70';
?>

<section class="border-b border-solid border-[#e5e7eb] bg-off-white px-page py-10 xl:px-section lg:py-24">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-12">
		<?php if ( $heading || $intro ) : ?>
			<div class="flex w-full max-w-[50rem] flex-col items-start gap-4">
				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $intro ) : ?>
					<?php echo iom_format_multiline_text( $intro, 'm-0 font-sans text-body leading-[1.2] text-muted' ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $cards_title || ! empty( $partners ) ) : ?>
			<div class="flex w-full flex-col items-start gap-6">
				<?php if ( $cards_title ) : ?>
					<p class="m-0 font-display text-card-title leading-none text-blue">
						<?php echo esc_html( $cards_title ); ?>
					</p>
				<?php endif; ?>

				<?php if ( ! empty( $partners ) ) : ?>
					<ul class="m-0 grid w-full list-none grid-cols-1 gap-6 p-0 lg:grid-cols-2">
						<?php foreach ( $partners as $partner ) : ?>
							<?php
							$logo_id = isset( $partner['logo'] ) ? $partner['logo'] : null;
							$title   = isset( $partner['title'] ) ? $partner['title'] : '';
							$body    = isset( $partner['body'] ) ? $partner['body'] : '';
							$link    = isset( $partner['link'] ) && is_array( $partner['link'] ) ? $partner['link'] : array();

							if ( ! $logo_id && ! $title && ! $body && empty( $link['url'] ) ) {
								continue;
							}
							?>
							<li class="flex flex-col items-start gap-4 rounded-card border border-solid border-[#dfe8ff] bg-white p-6">
								<?php if ( $logo_id ) : ?>
									<div class="h-[4.116rem] w-[10.1875rem] shrink-0">
										<?php
										echo wp_get_attachment_image(
											$logo_id,
											'medium',
											false,
											array(
												'class'   => 'size-full object-contain object-left',
												'loading' => 'lazy',
												'alt'     => $title ? $title : '',
											)
										);
										?>
									</div>
								<?php endif; ?>

								<?php if ( $title || $body ) : ?>
									<div class="flex w-full flex-col gap-2">
										<?php if ( $title ) : ?>
											<h3 class="m-0 font-display text-card-title leading-none text-blue">
												<?php echo esc_html( $title ); ?>
											</h3>
										<?php endif; ?>

										<?php if ( $body ) : ?>
											<?php echo iom_format_multiline_text( $body, 'm-0 font-sans text-sm leading-normal text-muted' ); ?>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<?php if ( ! empty( $link['url'] ) ) : ?>
									<div class="mt-auto">
										<?php
										iom_render_link(
											$link,
											$link_class,
											__( 'Visit website', 'impact-one-million' )
										);
										?>
									</div>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
