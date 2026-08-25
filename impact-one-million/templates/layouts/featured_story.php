<?php
/**
 * Layout: featured_story
 *
 * Quote/message card + video thumbnail with play control.
 *
 * Figma desktop: 606:14449 — Figma mobile: 671:40667
 */

$heading      = get_sub_field( 'heading' );
$role         = get_sub_field( 'role' );
$body         = get_sub_field( 'body' );
$cta          = get_sub_field( 'cta' );
$image_id     = get_sub_field( 'image' );
$video_source = get_sub_field( 'video_source' );
$video_url    = get_sub_field( 'video_url' );
$video_file   = get_sub_field( 'video_file' );

$theme_uri = get_stylesheet_directory_uri();
$play_uri  = $theme_uri . '/assets/images/icons/play.svg';
$fallback  = $theme_uri . '/assets/images/featured-story/ida-hyllested.jpg';
$fallback_abs = get_stylesheet_directory() . '/assets/images/featured-story/ida-hyllested.jpg';

if ( ! $heading ) {
	$heading = __( 'A message from Ida Hyllested,', 'impact-one-million' );
}

if ( ! $role ) {
	$role = __( 'Senior Adviser - UNICEF', 'impact-one-million' );
}

if ( ! $body ) {
	$body = __( 'Ida is part of Impact One Million’s steering committee, responsible for shaping strategy and ensuring programs are developed and implemented appropriately.', 'impact-one-million' );
}

if ( ! is_array( $cta ) || empty( $cta['url'] ) ) {
	$cta = array(
		'url'    => '#',
		'title'  => __( 'Learn more', 'impact-one-million' ),
		'target' => '',
	);
}

$cta_label  = ! empty( $cta['title'] ) ? $cta['title'] : __( 'Learn more', 'impact-one-million' );
$cta_url    = ! empty( $cta['url'] ) ? $cta['url'] : '#';
$cta_target = ! empty( $cta['target'] ) ? $cta['target'] : '';

$btn_class = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$play_label = __( 'Play video', 'impact-one-million' );

if ( ! $video_source ) {
	$video_source = 'external';
}

/**
 * Build an inline-playable embed (YouTube / Vimeo iframe) or HTML5 video src.
 *
 * @return array{type:string,src:string}|null
 */
$iom_fs_embed = null;

if ( 'upload' === $video_source && $video_file ) {
	$file_url = wp_get_attachment_url( (int) $video_file );
	if ( $file_url ) {
		$iom_fs_embed = array(
			'type' => 'video',
			'src'  => $file_url,
		);
	}
} elseif ( $video_url ) {
	$video_url = trim( (string) $video_url );
	if ( preg_match( '#(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{6,})#', $video_url, $m ) ) {
		$iom_fs_embed = array(
			'type' => 'iframe',
			'src'  => 'https://www.youtube.com/embed/' . rawurlencode( $m[1] ) . '?autoplay=1&rel=0',
		);
	} elseif ( preg_match( '#vimeo\.com/(?:video/)?(\d+)#', $video_url, $m ) ) {
		$iom_fs_embed = array(
			'type' => 'iframe',
			'src'  => 'https://player.vimeo.com/video/' . rawurlencode( $m[1] ) . '?autoplay=1',
		);
	} elseif ( preg_match( '#\.(mp4|webm|ogg|m4v)(\?|$)#i', $video_url ) ) {
		$iom_fs_embed = array(
			'type' => 'video',
			'src'  => $video_url,
		);
	} else {
		// Unknown host — still try iframe embed of the given URL.
		$iom_fs_embed = array(
			'type' => 'iframe',
			'src'  => $video_url,
		);
	}
}
?>

<section class="bg-blue px-[11px] py-[26px] md:px-[30px] md:py-10 xl:px-gutter xl:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col overflow-hidden rounded-card border-2 border-solid border-[#dfe8ff] xl:flex-row xl:items-center xl:gap-20 xl:overflow-visible xl:border-0">
		<!-- Copy card -->
		<div class="order-1 flex w-full flex-col items-start gap-8 rounded-t-card bg-white px-6 py-4 md:order-2 md:gap-8 md:rounded-t-none md:rounded-b-card md:px-8 md:py-6 xl:order-1 xl:flex-1 xl:min-w-0 xl:rounded-card xl:px-6 xl:py-5">
			<div class="flex w-full flex-col gap-4">
				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $role ) : ?>
					<p class="m-0 font-display text-header leading-none text-accent-blue">
						<?php echo esc_html( $role ); ?>
					</p>
				<?php endif; ?>
			</div>

			<?php if ( $body ) : ?>
				<p class="m-0 font-sans text-body leading-[1.2] text-blue">
					<?php echo esc_html( $body ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $cta_url ) : ?>
				<a
					class="<?php echo esc_attr( $btn_class ); ?>"
					href="<?php echo esc_url( $cta_url ); ?>"
					<?php echo $cta_target ? 'target="' . esc_attr( $cta_target ) . '" rel="noopener noreferrer"' : ''; ?>
				>
					<?php echo esc_html( $cta_label ); ?>
				</a>
			<?php endif; ?>
		</div>

		<!-- Media / video -->
		<div
			class="relative order-2 aspect-[560/550] w-full shrink-0 overflow-hidden rounded-b-card bg-navy md:order-1 md:aspect-[16/10] md:rounded-b-none md:rounded-t-card xl:order-2 xl:aspect-auto xl:h-[34.375rem] xl:w-[35rem] xl:rounded-card"
			data-featured-story-media
			<?php if ( $iom_fs_embed ) : ?>
				data-video-type="<?php echo esc_attr( $iom_fs_embed['type'] ); ?>"
				data-video-src="<?php echo esc_url( $iom_fs_embed['src'] ); ?>"
			<?php endif; ?>
		>
			<div class="absolute inset-0" data-featured-story-poster>
				<?php if ( $image_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$image_id,
						'large',
						false,
						array(
							'class'   => 'absolute inset-0 h-full w-full object-cover',
							'loading' => 'lazy',
							'alt'     => '',
						)
					);
					?>
				<?php elseif ( file_exists( $fallback_abs ) ) : ?>
					<img
						class="absolute inset-0 h-full w-full object-cover"
						src="<?php echo esc_url( $fallback ); ?>"
						alt=""
						width="560"
						height="550"
						loading="lazy"
						decoding="async"
					/>
				<?php else : ?>
					<div class="absolute inset-0 bg-navy" aria-hidden="true"></div>
				<?php endif; ?>

				<div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-40" aria-hidden="true"></div>
			</div>

			<div class="absolute inset-0 z-10 hidden" data-featured-story-player></div>

			<?php if ( $iom_fs_embed ) : ?>
				<button
					type="button"
					class="absolute inset-0 z-20 flex cursor-pointer items-center justify-center border-0 bg-transparent p-0"
					data-featured-story-play
					aria-label="<?php echo esc_attr( $play_label ); ?>"
				>
					<span
						class="flex size-[4.75rem] items-center justify-center rounded-full border-2 border-solid border-[#dfe8ff] bg-accent shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)] md:size-[5.5rem] xl:size-24 xl:border-0 xl:bg-blue"
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
			<?php else : ?>
				<div class="absolute inset-0 z-10 flex items-center justify-center" aria-hidden="true">
					<span
						class="flex size-[4.75rem] items-center justify-center rounded-full border-2 border-solid border-[#dfe8ff] bg-accent shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)] md:size-[5.5rem] xl:size-24 xl:border-0 xl:bg-blue"
					>
						<img
							src="<?php echo esc_url( $play_uri ); ?>"
							alt=""
							width="22"
							height="28"
							class="ml-0.5 h-7 w-[1.375rem]"
						/>
					</span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
