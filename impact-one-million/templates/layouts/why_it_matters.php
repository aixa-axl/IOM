<?php
/**
 * Layout: why_it_matters
 *
 * Full-bleed stat callout — eyebrow + big number + supporting line.
 * Multiple stats fade between slides (carousel).
 * Reused on pillar pages (Family & ECD, etc.).
 *
 * Figma desktop: 606:11694 — Figma mobile: 677:41472
 */

$eyebrow = get_sub_field( 'eyebrow' );
$stats   = get_sub_field( 'stats' );
$stat    = get_sub_field( 'stat' );
$body    = get_sub_field( 'body' );

if ( ! $eyebrow ) {
	$eyebrow = __( 'Why it matters', 'impact-one-million' );
}

if ( ! is_array( $stats ) ) {
	$stats = array();
}

// Legacy single-stat fields → one slide when the repeater is empty.
if ( empty( $stats ) && ( $stat || $body ) ) {
	$stats = array(
		array(
			'stat' => $stat,
			'body' => $body,
		),
	);
}

if ( empty( $stats ) ) {
	$stats = array(
		array(
			'stat' => __( '1 in 5', 'impact-one-million' ),
			'body' => __( 'children in low- and middle-income countries face severe deprivation in essential areas like nutrition, healthcare and education. (UNICEF)', 'impact-one-million' ),
		),
	);
}

// Drop empty rows.
$stats = array_values(
	array_filter(
		$stats,
		function ( $row ) {
			$s = isset( $row['stat'] ) ? $row['stat'] : '';
			$b = isset( $row['body'] ) ? $row['body'] : '';
			return (bool) $s || (bool) $b;
		}
	)
);

$slide_count = count( $stats );
$use_carousel = ( $slide_count > 1 );
?>

<section
	class="bg-accent px-page py-[60px] xl:px-gutter xl:py-20"
	<?php echo $use_carousel ? 'data-why-it-matters' : ''; ?>
>
	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10 text-center text-white">
		<?php if ( $eyebrow ) : ?>
			<p class="m-0 font-display text-label uppercase tracking-[1px]">
				<?php echo esc_html( $eyebrow ); ?>
			</p>
		<?php endif; ?>

		<?php if ( ! empty( $stats ) ) : ?>
			<div
				class="iom-wim-slides relative w-full max-w-[56.25rem]"
				<?php echo $use_carousel ? 'data-wim-slides' : ''; ?>
				aria-live="polite"
			>
				<?php foreach ( $stats as $index => $row ) : ?>
					<?php
					$row_stat = isset( $row['stat'] ) ? $row['stat'] : '';
					$row_body = isset( $row['body'] ) ? $row['body'] : '';
					$is_first = ( 0 === (int) $index );
					$slide_class = $use_carousel
						? 'iom-wim-slide flex w-full flex-col items-center gap-10 ' . ( $is_first ? 'is-active' : '' )
						: 'flex w-full flex-col items-center gap-10';
					?>
					<div
						class="<?php echo esc_attr( $slide_class ); ?>"
						<?php echo $use_carousel ? 'data-wim-slide' : ''; ?>
						<?php echo $use_carousel ? 'data-active="' . ( $is_first ? 'true' : 'false' ) . '"' : ''; ?>
						<?php echo $use_carousel ? 'aria-hidden="' . ( $is_first ? 'false' : 'true' ) . '"' : ''; ?>
					>
						<?php if ( $row_stat ) : ?>
							<p
								class="m-0 font-display text-title leading-[1.1] tracking-[0.02em] lg:text-[clamp(3.5rem,8vw,7.5rem)] lg:leading-none lg:tracking-normal"
								data-wim-stat
							>
								<?php echo esc_html( $row_stat ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $row_body ) : ?>
							<?php echo iom_format_multiline_text( $row_body, 'm-0 max-w-[56.25rem] font-display text-stat-label leading-[1.2]' ); ?>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $use_carousel ) : ?>
				<div
					class="flex items-center justify-center gap-2"
					data-wim-dots
					role="tablist"
					aria-label="<?php echo esc_attr__( 'Why it matters stats', 'impact-one-million' ); ?>"
				>
					<?php for ( $i = 0; $i < $slide_count; $i++ ) : ?>
						<button
							type="button"
							class="size-2 rounded-full border-0 bg-white/30 p-0 transition-colors data-[active=true]:bg-white"
							data-wim-dot
							data-active="<?php echo 0 === $i ? 'true' : 'false'; ?>"
							aria-label="<?php echo esc_attr( sprintf( __( 'Show stat %d', 'impact-one-million' ), $i + 1 ) ); ?>"
							aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
							role="tab"
						></button>
					<?php endfor; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>
