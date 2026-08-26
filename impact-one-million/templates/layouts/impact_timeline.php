<?php
/**
 * Layout: impact_timeline
 *
 * Horizontal timeline carousel — "Timeline to One Million".
 *
 * Figma desktop: 606:14466 — Figma mobile: 671:40704
 */

$heading        = get_sub_field( 'heading' );
$heading_mobile = get_sub_field( 'heading_mobile' );
$cta            = get_sub_field( 'cta' );
$items          = get_sub_field( 'items' );

if ( ! is_array( $cta ) ) {
	$cta = array();
}

if ( ! is_array( $items ) ) {
	$items = array();
}

$cta_url    = ! empty( $cta['url'] ) ? $cta['url'] : '';
$cta_title  = ! empty( $cta['title'] ) ? $cta['title'] : '';
$cta_target = ! empty( $cta['target'] ) ? $cta['target'] : '';

$btn_class = 'inline-flex shrink-0 items-center justify-center whitespace-nowrap rounded-btn border-[1.5px] border-solid border-transparent bg-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

$nav_btn = 'inline-flex shrink-0 items-center justify-center border-0 bg-transparent p-0 text-accent-blue transition-colors hover:opacity-80 disabled:cursor-not-allowed disabled:opacity-40';

/**
 * Timeline chevron arrow (inherits currentColor).
 *
 * @param string $extra_class Extra classes on the svg.
 */
$iom_timeline_arrow = static function ( $extra_class = '' ) {
	?>
	<svg
		class="<?php echo esc_attr( $extra_class ); ?>"
		width="44"
		height="45"
		viewBox="0 0 44 45"
		fill="none"
		xmlns="http://www.w3.org/2000/svg"
		aria-hidden="true"
	>
		<path d="M0 30.99V15.787L24.64 13.449V0L44 21.635L24.64 45.023V30.99H0Z" fill="currentColor"/>
	</svg>
	<?php
};
?>

<section
	class="overflow-x-hidden bg-[#f9fcff] px-page py-section xl:px-20 lg:py-24"
	data-impact-timeline
>
	<div class="mx-auto flex w-full max-w-site flex-col gap-10 lg:gap-20">
		<div class="flex items-start justify-between gap-6 lg:items-center">
			<?php if ( $heading || $heading_mobile ) : ?>
				<h2 class="m-0 font-display text-[32px] leading-[1.2] text-blue lg:text-headline">
					<?php if ( $heading_mobile ) : ?>
						<span class="lg:hidden"><?php echo esc_html( $heading_mobile ); ?></span>
					<?php endif; ?>
					<?php if ( $heading ) : ?>
						<span class="hidden lg:inline"><?php echo esc_html( $heading ); ?></span>
					<?php elseif ( $heading_mobile ) : ?>
						<span class="hidden lg:inline"><?php echo esc_html( $heading_mobile ); ?></span>
					<?php endif; ?>
				</h2>
			<?php endif; ?>

			<div class="hidden shrink-0 items-center gap-2 lg:flex">
				<button
					type="button"
					class="<?php echo esc_attr( $nav_btn ); ?>"
					data-timeline-prev
					aria-label="<?php echo esc_attr__( 'Previous timeline item', 'impact-one-million' ); ?>"
					disabled
				>
					<?php $iom_timeline_arrow( 'h-[2.8rem] w-11 -scale-x-100' ); ?>
				</button>
				<button
					type="button"
					class="<?php echo esc_attr( $nav_btn ); ?> text-blue"
					data-timeline-next
					aria-label="<?php echo esc_attr__( 'Next timeline item', 'impact-one-million' ); ?>"
				>
					<?php $iom_timeline_arrow( 'h-[2.8rem] w-11' ); ?>
				</button>
			</div>
		</div>

		<div class="flex flex-col gap-6">
			<ul
				class="m-0 flex list-none gap-8 overflow-x-auto scroll-smooth pb-1 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory [&::-webkit-scrollbar]:hidden"
				data-timeline-track
			>
				<?php foreach ( $items as $index => $item ) : ?>
					<?php
					$year  = isset( $item['year'] ) ? $item['year'] : '';
					$title = isset( $item['title'] ) ? $item['title'] : '';
					$body  = isset( $item['body'] ) ? $item['body'] : '';
					?>
					<li
						class="flex w-full min-w-full shrink-0 snap-start flex-col gap-4 rounded-card border-l-4 border-solid border-accent-blue bg-white py-10 pl-11 pr-8 transition-[opacity,background-color,border-color] duration-300 lg:min-w-[25rem] lg:max-w-[25rem] lg:pr-14 data-[active=false]:border-blue data-[active=false]:bg-[#dfe8ff] data-[active=false]:opacity-60"
						data-timeline-slide
						data-active="<?php echo 0 === $index ? 'true' : 'false'; ?>"
					>
						<?php if ( $year ) : ?>
							<p class="m-0 font-display text-body uppercase tracking-[1px] text-navy">
								<?php echo esc_html( $year ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $title ) : ?>
							<h3 class="m-0 font-display text-card-title text-accent">
								<?php echo esc_html( $title ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( $body ) : ?>
							<?php echo iom_format_multiline_text( $body, 'm-0 max-w-[18.075rem] font-sans text-body leading-[1.2] text-muted lg:max-w-[18.7rem]' ); ?>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
				</ul>

			<?php
			$item_count = count( $items );
			if ( $item_count > 1 ) :
				?>
				<div
					class="flex items-center justify-center gap-2 lg:hidden"
					data-timeline-dots
					aria-hidden="true"
				>
					<?php for ( $i = 0; $i < $item_count; $i++ ) : ?>
						<span
							class="size-1.5 rounded-full bg-accent-blue/25 transition-colors data-[active=true]:bg-accent-blue"
							data-timeline-dot
							<?php echo 0 === $i ? 'data-active="true"' : ''; ?>
						></span>
					<?php endfor; ?>
				</div>
			<?php endif; ?>

			<div class="flex items-center justify-between gap-4">
				<?php if ( $cta_url ) : ?>
					<a
						class="<?php echo esc_attr( $btn_class ); ?>"
						href="<?php echo esc_url( $cta_url ); ?>"
						<?php echo $cta_target ? 'target="' . esc_attr( $cta_target ) . '" rel="noopener noreferrer"' : ''; ?>
					>
						<?php echo esc_html( $cta_title ); ?>
					</a>
				<?php else : ?>
					<span></span>
				<?php endif; ?>

				<div class="flex shrink-0 items-center gap-2 lg:hidden">
					<button
						type="button"
						class="<?php echo esc_attr( $nav_btn ); ?>"
						data-timeline-prev
						aria-label="<?php echo esc_attr__( 'Previous timeline item', 'impact-one-million' ); ?>"
						disabled
					>
						<?php $iom_timeline_arrow( 'h-12 w-6 -scale-x-100' ); ?>
					</button>
					<button
						type="button"
						class="<?php echo esc_attr( $nav_btn ); ?> text-blue"
						data-timeline-next
						aria-label="<?php echo esc_attr__( 'Next timeline item', 'impact-one-million' ); ?>"
					>
						<?php $iom_timeline_arrow( 'h-12 w-6' ); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
