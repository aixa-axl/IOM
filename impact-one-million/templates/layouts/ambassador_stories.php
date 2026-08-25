<?php
/**
 * Layout: ambassador_stories
 *
 * Featured quote + image or video. Optional inline stats + body (case-study style),
 * and/or full-width highlight columns below.
 *
 * Desktop: quote | media. Mobile: stacked.
 *
 * Figma desktop (blue): 663:31935 — Figma desktop (accent blue): 668:36104
 * Figma with stats + body: 669:38415
 */

$background_color = get_sub_field( 'background_color' );
$heading          = get_sub_field( 'heading' );
$quote            = get_sub_field( 'quote' );
$featured         = get_sub_field( 'featured' );
$campaign         = get_sub_field( 'campaign' );
$body             = get_sub_field( 'body' );
$image_id         = get_sub_field( 'image' );
$media_type       = get_sub_field( 'media_type' );
$video_source     = get_sub_field( 'video_source' );
$video_url        = get_sub_field( 'video_url' );
$video_file       = get_sub_field( 'video_file' );
$stats            = get_sub_field( 'stats' );
$highlights       = get_sub_field( 'highlights' );

$theme_uri    = get_stylesheet_directory_uri();
$play_uri     = $theme_uri . '/assets/images/icons/play.svg';
$fallback     = $theme_uri . '/assets/images/ambassador-stories/story.jpg';
$fallback_abs = get_stylesheet_directory() . '/assets/images/ambassador-stories/story.jpg';

if ( ! in_array( $background_color, array( 'blue', 'accent_blue' ), true ) ) {
	$background_color = 'blue';
}

if ( ! $media_type ) {
	$media_type = 'image';
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

$iom_as_embed = null;
if ( 'video' === $media_type && function_exists( 'iom_build_video_embed' ) ) {
	$iom_as_embed = iom_build_video_embed( $video_source, $video_url, $video_file );
}

$has_poster = $image_id || file_exists( $fallback_abs );
$has_media  = (bool) $iom_as_embed || $has_poster;
$bg_class   = ( 'accent_blue' === $background_color ) ? 'bg-accent-blue' : 'bg-blue';
$play_label = __( 'Play video', 'impact-one-million' );
?>

<section class="<?php echo esc_attr( $bg_class ); ?> px-page py-section text-white xl:px-16">
	<div class="mx-auto flex w-full max-w-site flex-col gap-16">
		<div class="flex w-full flex-col items-stretch gap-8 xl:flex-row xl:items-center xl:gap-8">
			<div class="flex min-w-0 flex-1 flex-col items-start gap-10">
				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-white">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<div class="flex w-full flex-col items-start gap-4">
					<span class="font-display text-headline leading-[1.2] text-[#dfe8ff]" aria-hidden="true">&ldquo;</span>

					<?php if ( $quote ) : ?>
						<blockquote class="m-0 font-sans text-label font-semibold leading-[1.2] xl:text-stat-label">
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
					<?php echo iom_format_multiline_text( $body, 'm-0 max-w-[41.5625rem] font-sans text-label leading-normal' ); ?>
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

			<?php if ( $has_media ) : ?>
				<div
					class="relative h-[16rem] w-full shrink-0 overflow-hidden rounded-card bg-navy md:h-[22rem] xl:h-[26rem] xl:w-[39.0625rem]"
					<?php if ( $iom_as_embed ) : ?>
						data-featured-story-media
						data-video-type="<?php echo esc_attr( $iom_as_embed['type'] ); ?>"
						data-video-src="<?php echo esc_url( $iom_as_embed['src'] ); ?>"
					<?php endif; ?>
				>
					<?php if ( $iom_as_embed ) : ?>
						<div class="absolute inset-0" data-featured-story-poster>
							<?php if ( $image_id ) : ?>
								<?php echo wp_get_attachment_image( (int) $image_id, 'large', false, $img_attrs ); ?>
							<?php elseif ( file_exists( $fallback_abs ) ) : ?>
								<img
									src="<?php echo esc_url( $fallback ); ?>"
									alt="<?php echo esc_attr( $img_attrs['alt'] ); ?>"
									class="<?php echo esc_attr( $img_attrs['class'] ); ?>"
									loading="lazy"
									decoding="async"
								>
							<?php else : ?>
								<div class="absolute inset-0 bg-navy" aria-hidden="true"></div>
							<?php endif; ?>
							<div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-40" aria-hidden="true"></div>
						</div>

						<div class="absolute inset-0 z-10 hidden" data-featured-story-player></div>

						<button
							type="button"
							class="absolute inset-0 z-20 flex cursor-pointer items-center justify-center border-0 bg-transparent p-0"
							data-featured-story-play
							aria-label="<?php echo esc_attr( $play_label ); ?>"
						>
							<span
								class="flex size-[4.75rem] items-center justify-center rounded-full border-2 border-solid border-[#dfe8ff] bg-accent shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)] md:size-[5.5rem]"
								aria-hidden="true"
							>
								<img
									src="<?php echo esc_url( $play_uri ); ?>"
									alt=""
									width="22"
									height="28"
									class="ml-0.5 h-7 w-[1.375rem]"
								/>
							</span>
						</button>
					<?php elseif ( $image_id ) : ?>
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
