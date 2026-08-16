<?php
/**
 * Layout: featured_story
 *
 * Quote/message card + video thumbnail with play control.
 *
 * Figma desktop: 606:14449 — Figma mobile: 671:40667
 */

$heading   = get_sub_field( 'heading' );
$role      = get_sub_field( 'role' );
$body      = get_sub_field( 'body' );
$cta       = get_sub_field( 'cta' );
$image_id  = get_sub_field( 'image' );
$video_url = get_sub_field( 'video_url' );

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

$btn_class = 'inline-flex items-center justify-center rounded-btn bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$play_label = __( 'Play video', 'impact-one-million' );
?>

<section class="bg-blue px-10 py-20 lg:px-gutter lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col overflow-hidden rounded-card border-2 border-solid border-[#dfe8ff] lg:flex-row lg:items-stretch lg:gap-20 lg:overflow-visible lg:border-0">
		<!-- Copy card -->
		<div class="flex w-full flex-col items-start justify-center gap-8 rounded-t-card bg-white p-6 lg:flex-1 lg:gap-8 lg:rounded-card lg:p-6">
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
		<div class="relative aspect-[560/550] w-full shrink-0 overflow-hidden rounded-b-card lg:aspect-auto lg:h-[34.375rem] lg:w-[35rem] lg:rounded-card">
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

			<?php if ( $video_url ) : ?>
				<a
					class="absolute inset-0 z-10 flex items-center justify-center no-underline"
					href="<?php echo esc_url( $video_url ); ?>"
					target="_blank"
					rel="noopener noreferrer"
					aria-label="<?php echo esc_attr( $play_label ); ?>"
				>
			<?php else : ?>
				<div class="absolute inset-0 z-10 flex items-center justify-center" aria-hidden="true">
			<?php endif; ?>

				<span
					class="flex size-[4.75rem] items-center justify-center rounded-full border-2 border-solid border-[#dfe8ff] bg-accent shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)] lg:size-24 lg:border-0 lg:bg-blue"
				>
					<img
						src="<?php echo esc_url( $play_uri ); ?>"
						alt=""
						width="22"
						height="28"
						class="ml-0.5 h-7 w-[1.375rem]"
						aria-hidden="true"
					/>
				</span>

			<?php if ( $video_url ) : ?>
				</a>
			<?php else : ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
