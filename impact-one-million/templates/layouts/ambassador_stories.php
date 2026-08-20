<?php
/**
 * Layout: ambassador_stories
 *
 * Featured quote + image. Optional inline stats + body (case-study style),
 * and/or full-width highlight columns below.
 *
 * Desktop: quote | image. Mobile: stacked.
 *
 * Figma desktop (blue): 663:31935 — Figma desktop (accent blue): 668:36104
 * Figma with stats + body: 669:38415
 */

$background_color = get_sub_field( 'background_color' );
$quote            = get_sub_field( 'quote' );
$featured         = get_sub_field( 'featured' );
$campaign         = get_sub_field( 'campaign' );
$body             = get_sub_field( 'body' );
$image_id         = get_sub_field( 'image' );
$stats            = get_sub_field( 'stats' );
$highlights       = get_sub_field( 'highlights' );

$theme_uri    = get_stylesheet_directory_uri();
$fallback     = $theme_uri . '/assets/images/ambassador-stories/story.jpg';
$fallback_abs = get_stylesheet_directory() . '/assets/images/ambassador-stories/story.jpg';

if ( ! in_array( $background_color, array( 'blue', 'accent_blue' ), true ) ) {
	$background_color = 'blue';
}

if ( ! $quote ) {
	$quote = __( "Seeing the impact of IOM's work first-hand has been a life-changing experience. Every migrant has a story of resilience, and it's our honor to tell it.", 'impact-one-million' );
}

if ( ! is_array( $stats ) ) {
	$stats = array();
}

if ( ! is_array( $highlights ) ) {
	$highlights = array();
}

$has_stats = ! empty( $stats );
$has_body  = (bool) $body;

// Classic attribution defaults only when not using the stats/body case-study variant.
if ( ! $has_stats && ! $has_body ) {
	if ( ! $featured ) {
		$featured = __( 'Featured: Ambassador Three', 'impact-one-million' );
	}
	if ( ! $campaign ) {
		$campaign = __( 'Campaign: Voices of Migration', 'impact-one-million' );
	}
}

$img_attrs = array(
	'class'   => 'absolute inset-0 size-full rounded-card object-cover',
	'loading' => 'lazy',
	'alt'     => $featured ? $featured : ( $quote ? wp_trim_words( $quote, 8, '' ) : '' ),
);

$has_image = $image_id || file_exists( $fallback_abs );
$bg_class  = ( 'accent_blue' === $background_color ) ? 'bg-accent-blue' : 'bg-blue';
?>

<section class="<?php echo esc_attr( $bg_class ); ?> px-page py-section text-white xl:px-16">
	<div class="mx-auto flex w-full max-w-site flex-col gap-16">
		<div class="flex w-full flex-col items-stretch gap-8 lg:flex-row lg:items-center lg:gap-8">
			<div class="flex min-w-0 flex-1 flex-col items-start gap-10">
				<div class="flex w-full flex-col items-start gap-4">
					<span class="font-display text-headline leading-[1.2] text-[#dfe8ff]" aria-hidden="true">&ldquo;</span>

					<?php if ( $quote ) : ?>
						<blockquote class="m-0 font-sans text-label font-semibold leading-[1.2] lg:text-stat-label">
							<?php echo esc_html( $quote ); ?>
						</blockquote>
					<?php endif; ?>
				</div>

				<?php if ( $has_stats ) : ?>
					<ul class="m-0 flex w-full list-none flex-col items-start gap-8 p-0 sm:flex-row sm:flex-wrap sm:gap-12">
						<?php foreach ( $stats as $stat ) : ?>
							<?php
							$value = isset( $stat['value'] ) ? $stat['value'] : '';
							$label = isset( $stat['label'] ) ? $stat['label'] : '';
							if ( ! $value && ! $label ) {
								continue;
							}
							?>
							<li class="flex flex-col items-start gap-1">
								<?php if ( $value ) : ?>
									<p class="m-0 font-display text-number leading-none">
										<?php echo esc_html( $value ); ?>
									</p>
								<?php endif; ?>
								<?php if ( $label ) : ?>
									<p class="m-0 font-display text-body uppercase tracking-[1px]">
										<?php echo esc_html( $label ); ?>
									</p>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $has_body ) : ?>
					<p class="m-0 max-w-[41.5625rem] font-sans text-label leading-normal">
						<?php echo esc_html( $body ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $featured || $campaign ) : ?>
					<footer class="flex flex-col gap-2">
						<?php if ( $featured ) : ?>
							<p class="m-0 font-display text-label leading-[1.2] uppercase tracking-[1px]">
								<?php echo esc_html( $featured ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $campaign ) : ?>
							<p class="m-0 font-sans text-label leading-[1.5]">
								<?php echo esc_html( $campaign ); ?>
							</p>
						<?php endif; ?>
					</footer>
				<?php endif; ?>
			</div>

			<?php if ( $has_image ) : ?>
				<div class="relative h-[16rem] w-full shrink-0 overflow-hidden rounded-card lg:h-[26rem] lg:w-[39.0625rem]">
					<?php if ( $image_id ) : ?>
						<?php echo wp_get_attachment_image( (int) $image_id, 'large', false, $img_attrs ); ?>
					<?php else : ?>
						<img
							src="<?php echo esc_url( $fallback ); ?>"
							alt="<?php echo esc_attr( $img_attrs['alt'] ); ?>"
							class="<?php echo esc_attr( $img_attrs['class'] ); ?>"
							loading="lazy"
							decoding="async"
						>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $highlights ) ) : ?>
			<ul class="m-0 grid w-full list-none grid-cols-1 gap-8 p-0 lg:grid-cols-3">
				<?php foreach ( $highlights as $item ) : ?>
					<?php
					$label = isset( $item['label'] ) ? $item['label'] : '';
					$hbody = isset( $item['body'] ) ? $item['body'] : '';
					if ( ! $label && ! $hbody ) {
						continue;
					}
					?>
					<li class="flex flex-col gap-3">
						<?php if ( $label ) : ?>
							<p class="m-0 font-display text-label leading-[1.2] uppercase tracking-[1px]">
								<?php echo esc_html( $label ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $hbody ) : ?>
							<p class="m-0 font-sans text-body leading-[1.2]">
								<?php echo esc_html( $hbody ); ?>
							</p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
