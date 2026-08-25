<?php
/**
 * Layout: why_partnerships
 *
 * Split — heading + body left, red-arrow uppercase list right.
 * Desktop: two columns. Mobile: stacked.
 *
 * Figma desktop: 634:19369 (no mobile frame — stacked adaptation)
 */

$heading  = get_sub_field( 'heading' );
$subtitle = get_sub_field( 'subtitle' );
$body     = get_sub_field( 'body' );
$items    = get_sub_field( 'items' );

$theme_uri = get_stylesheet_directory_uri();
$arrow_uri = $theme_uri . '/assets/images/icons/why-join-arrow.svg';

if ( ! $heading ) {
	$heading = __( 'Why Partnerships Matter', 'impact-one-million' );
}

if ( ! $body ) {
	$body = __( 'IOM works through collaboration to ensure that we are not just delivering aid, but creating sustainable systems for migration management. Our partners bring the local knowledge and technical expertise required to solve complex global challenges.', 'impact-one-million' );
}

if ( ! is_array( $items ) ) {
	$items = array();
}
?>

<section class="border-b border-solid border-[#e5e7eb] bg-white px-page py-10 xl:px-section lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10 lg:flex-row lg:gap-20">
		<div class="flex w-full shrink-0 flex-col gap-6 text-blue lg:w-[33rem]">
			<?php if ( $heading ) : ?>
				<h2 class="m-0 font-display text-headline leading-[1.2]">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( $subtitle ) : ?>
				<p class="m-0 font-sans text-body font-semibold leading-[1.2]">
					<?php echo esc_html( $subtitle ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $body ) : ?>
				<p class="m-0 font-sans text-body leading-[1.2]">
					<?php echo esc_html( $body ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $items ) ) : ?>
			<ul class="m-0 flex min-w-0 flex-1 list-none flex-col items-start gap-4 p-0">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$label = isset( $item['label'] ) ? $item['label'] : '';
					$text  = isset( $item['text'] ) ? $item['text'] : '';
					if ( ! $label && ! $text ) {
						continue;
					}
					?>
					<li class="flex w-full items-start gap-4">
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
						<div class="flex min-w-0 flex-col gap-2">
							<?php if ( $label ) : ?>
								<span class="font-display text-label uppercase leading-[1.2] tracking-[1px] text-blue">
									<?php echo esc_html( $label ); ?>
								</span>
							<?php endif; ?>

							<?php if ( $text ) : ?>
								<p class="m-0 font-sans text-body leading-[1.2] text-muted">
									<?php echo esc_html( $text ); ?>
								</p>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
