<?php
/**
 * Layout: stories_of_change
 *
 * Off-white band — heading, two alternating image/quote cards, dual CTAs.
 * Desktop: side-by-side cards. Mobile: stacked cards + stacked CTAs.
 *
 * Figma desktop: 670:39575 (no mobile frame — stacked adaptation)
 */

$heading       = get_sub_field( 'heading' );
$stories       = get_sub_field( 'stories' );
$primary_cta   = get_sub_field( 'primary_cta' );
$secondary_cta = get_sub_field( 'secondary_cta' );

$theme_uri    = get_stylesheet_directory_uri();
$fallback     = $theme_uri . '/assets/images/stories-of-change/story.jpg';
$fallback_abs = get_stylesheet_directory() . '/assets/images/stories-of-change/story.jpg';

if ( ! $heading ) {
	$heading = __( 'Stories of change', 'impact-one-million' );
}

$default_quote = __( '"Partnering with Impact One Million let us reach families we could never have reached alone." — [Foundation partner, fictional placeholder]', 'impact-one-million' );

if ( ! is_array( $stories ) || empty( $stories ) ) {
	$stories = array(
		array(
			'image'       => null,
			'quote'       => $default_quote,
			'quote_first' => 0,
		),
		array(
			'image'       => null,
			'quote'       => $default_quote,
			'quote_first' => 1,
		),
	);
}

if ( ! is_array( $primary_cta ) || empty( $primary_cta['url'] ) ) {
	$primary_cta = array(
		'url'    => '#',
		'title'  => __( 'Conversion CTA', 'impact-one-million' ),
		'target' => '',
	);
}

if ( ! is_array( $secondary_cta ) ) {
	$secondary_cta = array();
}

$btn_primary   = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-navy px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90 lg:w-auto';
$btn_secondary = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-ink bg-transparent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-ink no-underline transition-opacity hover:opacity-80 lg:w-auto';

$img_attrs = array(
	'class'   => 'absolute inset-0 size-full object-cover',
	'loading' => 'lazy',
	'alt'     => '',
);

// Partners page only: less bottom padding when How It Works follows (set in page.php).
$section_class = ! empty( $iom_tighten_stories_of_change_bottom )
	? 'iom-stories-of-change bg-off-white px-page py-10 lg:pt-[100px] lg:pb-10 xl:px-16'
	: 'iom-stories-of-change bg-off-white px-page py-10 lg:py-[100px] xl:px-16';
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-12">
		<div class="flex w-full flex-col gap-11">
			<?php if ( $heading ) : ?>
				<h2 class="m-0 text-center font-display text-headline leading-[1.2] text-navy">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( ! empty( $stories ) ) : ?>
				<ul class="m-0 grid w-full list-none grid-cols-1 gap-6 p-0 lg:grid-cols-2">
					<?php foreach ( $stories as $index => $story ) : ?>
						<?php
						$image_id    = isset( $story['image'] ) ? $story['image'] : null;
						$quote       = isset( $story['quote'] ) ? $story['quote'] : '';
						$body        = isset( $story['body'] ) ? $story['body'] : '';
						$quote_first = ! empty( $story['quote_first'] );
						// Fall back to alternating layout when the field is unset on older rows.
						if ( ! array_key_exists( 'quote_first', $story ) ) {
							$quote_first = ( 1 === ( (int) $index % 2 ) );
						}
						$card_class = $quote_first
							? 'flex flex-col-reverse overflow-hidden rounded-card border border-solid border-[#dfe8ff] bg-white'
							: 'flex flex-col overflow-hidden rounded-card border border-solid border-[#dfe8ff] bg-white';
						?>
						<li class="<?php echo esc_attr( $card_class ); ?>">
							<div class="relative aspect-[5/3] w-full shrink-0 overflow-hidden border border-solid border-[#e5e7eb]">
								<?php if ( $image_id ) : ?>
									<?php
									echo wp_get_attachment_image(
										(int) $image_id,
										'large',
										false,
										$img_attrs
									);
									?>
								<?php elseif ( file_exists( $fallback_abs ) ) : ?>
									<img
										src="<?php echo esc_url( $fallback ); ?>"
										alt=""
										class="<?php echo esc_attr( $img_attrs['class'] ); ?>"
										loading="lazy"
										decoding="async"
									>
								<?php endif; ?>
							</div>

							<?php if ( $quote || $body ) : ?>
								<div class="flex w-full flex-col items-start gap-4 px-3 py-6">
									<?php if ( $quote ) : ?>
										<blockquote class="m-0 font-display text-card-title leading-[1.2] text-blue">
											<?php echo esc_html( $quote ); ?>
										</blockquote>
									<?php endif; ?>

									<?php if ( $body ) : ?>
										<p class="m-0 font-sans text-body leading-[1.2] text-muted">
											<?php echo esc_html( $body ); ?>
										</p>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $primary_cta['url'] ) || ! empty( $secondary_cta['url'] ) ) : ?>
			<div class="flex w-full flex-col items-stretch gap-6 lg:w-auto lg:flex-row lg:items-start">
				<?php
				if ( ! empty( $primary_cta['url'] ) ) {
					iom_render_link(
						$primary_cta,
						$btn_primary,
						__( 'Conversion CTA', 'impact-one-million' )
					);
				}
				if ( ! empty( $secondary_cta['url'] ) ) {
					iom_render_link(
						$secondary_cta,
						$btn_secondary,
						__( 'Secondary - view more casestudies', 'impact-one-million' )
					);
				}
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
