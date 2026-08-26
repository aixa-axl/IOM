<?php
/**
 * Layout: roi_calculator
 *
 * Interactive ROI calculator — audience tabs, investment slider, live metrics.
 *
 * Figma desktop: 667:34002 — Figma mobile: 677:41520
 */

$section_title   = get_sub_field( 'section_title' );
$section_intro   = get_sub_field( 'section_intro' );
$heading         = get_sub_field( 'heading' );
$audiences       = get_sub_field( 'audiences' );
$min_amount      = (int) get_sub_field( 'min_amount' );
$max_amount      = (int) get_sub_field( 'max_amount' );
$default_amount  = (int) get_sub_field( 'default_amount' );
$step_amount     = (int) get_sub_field( 'step_amount' );
$baseline_amount = (int) get_sub_field( 'baseline_amount' );
$metric_workers  = get_sub_field( 'metric_workers_label' );
$metric_families = get_sub_field( 'metric_families_label' );
$metric_factories = get_sub_field( 'metric_factories_label' );
$primary_cta     = get_sub_field( 'primary_cta' );
$secondary_cta   = get_sub_field( 'secondary_cta' );
$show_section    = get_sub_field( 'show_section' );

// Default: show. Only hide when explicitly turned off in ACF.
if ( null === $show_section || '' === $show_section ) {
	$show_section = true;
}
if ( ! $show_section ) {
	return;
}

if ( $min_amount <= 0 ) {
	$min_amount = 25000;
}

if ( $max_amount <= $min_amount ) {
	$max_amount = 500000;
}

if ( $default_amount < $min_amount || $default_amount > $max_amount ) {
	$default_amount = 100000;
}

if ( $step_amount <= 0 ) {
	$step_amount = 5000;
}

if ( $baseline_amount <= 0 ) {
	$baseline_amount = 100000;
}

if ( ! is_array( $audiences ) ) {
	$audiences = array();
}

if ( ! is_array( $primary_cta ) ) {
	$primary_cta = array();
}

if ( ! is_array( $secondary_cta ) ) {
	$secondary_cta = array();
}

$btn_primary = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90 lg:w-auto';
$btn_outline = 'inline-flex w-full items-center justify-center rounded-btn border-[1.5px] border-solid border-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-navy no-underline transition-opacity hover:opacity-80 lg:w-auto';

$tab_base    = 'flex flex-1 cursor-pointer items-center justify-center rounded-card border border-solid px-3 py-4 font-display text-[14px] uppercase tracking-[1px] transition-colors lg:px-8 lg:text-label';
$tab_active  = 'border-blue bg-blue text-white';
$tab_idle    = 'border-[#dfe8ff] bg-white text-navy hover:border-blue/40';

$first = ! empty( $audiences[0] ) && is_array( $audiences[0] ) ? $audiences[0] : array();
$scale = $baseline_amount > 0 ? ( $default_amount / $baseline_amount ) : 1;
$init_workers   = (int) round( ( isset( $first['workers'] ) ? (int) $first['workers'] : 0 ) * $scale );
$init_families  = (int) round( ( isset( $first['families'] ) ? (int) $first['families'] : 0 ) * $scale );
$init_factories = (int) round( ( isset( $first['factories'] ) ? (int) $first['factories'] : 0 ) * $scale );

$audiences_json = array();
foreach ( $audiences as $index => $audience ) {
	$audiences_json[] = array(
		'id'        => (string) $index,
		'label'     => isset( $audience['label'] ) ? $audience['label'] : '',
		'workers'   => isset( $audience['workers'] ) ? (int) $audience['workers'] : 0,
		'families'  => isset( $audience['families'] ) ? (int) $audience['families'] : 0,
		'factories' => isset( $audience['factories'] ) ? (int) $audience['factories'] : 0,
	);
}

$pct = ( ( $default_amount - $min_amount ) / max( 1, ( $max_amount - $min_amount ) ) ) * 100;
?>

<section
	class="bg-blue px-page py-10 xl:px-20 lg:py-20"
	data-roi-calculator
	data-min="<?php echo esc_attr( (string) $min_amount ); ?>"
	data-max="<?php echo esc_attr( (string) $max_amount ); ?>"
	data-step="<?php echo esc_attr( (string) $step_amount ); ?>"
	data-baseline="<?php echo esc_attr( (string) $baseline_amount ); ?>"
	data-default="<?php echo esc_attr( (string) $default_amount ); ?>"
>
	<script type="application/json" data-roi-audiences><?php echo wp_json_encode( $audiences_json ); ?></script>

	<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10">
		<?php if ( $section_title || $section_intro ) : ?>
			<div class="flex w-full max-w-[50rem] flex-col items-center gap-4 text-center">
				<?php if ( $section_title ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-white">
						<?php echo esc_html( $section_title ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $section_intro ) : ?>
					<?php echo iom_format_multiline_text( $section_intro, 'm-0 font-sans text-body leading-[1.2] text-white/90' ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="flex w-full flex-col items-center gap-6 rounded-card border border-solid border-[#dfe8ff] bg-white p-4 lg:gap-6 lg:p-10">
		<?php if ( $heading ) : ?>
			<?php if ( $section_title ) : ?>
				<h3 class="m-0 text-center font-display text-headline leading-[1.2] text-blue">
					<?php echo esc_html( $heading ); ?>
				</h3>
			<?php else : ?>
				<h2 class="m-0 text-center font-display text-headline leading-[1.2] text-blue">
					<?php echo esc_html( $heading ); ?>
				</h2>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( ! empty( $audiences ) ) : ?>
			<div
				class="flex w-full gap-3 lg:gap-8"
				role="tablist"
				aria-label="<?php echo esc_attr__( 'Audience type', 'impact-one-million' ); ?>"
				data-roi-tabs
			>
				<?php foreach ( $audiences as $index => $audience ) : ?>
					<?php
					$label = isset( $audience['label'] ) ? $audience['label'] : '';
					if ( ! $label ) {
						continue;
					}
					$is_active = ( 0 === $index );
					?>
					<button
						type="button"
						role="tab"
						id="roi-tab-<?php echo esc_attr( (string) $index ); ?>"
						class="<?php echo esc_attr( $tab_base . ' ' . ( $is_active ? $tab_active : $tab_idle ) ); ?>"
						aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
						data-roi-tab="<?php echo esc_attr( (string) $index ); ?>"
						data-active="<?php echo $is_active ? 'true' : 'false'; ?>"
					>
						<?php echo esc_html( $label ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="flex w-full flex-col gap-2 lg:gap-6">
			<div class="flex items-center justify-between gap-4 lg:block">
				<p class="m-0 font-display text-[14px] uppercase tracking-[1px] text-navy lg:text-label">
					<?php echo esc_html__( 'Investment amount', 'impact-one-million' ); ?>
				</p>
				<p
					class="m-0 font-display text-label leading-[1.2] text-navy lg:hidden"
					data-roi-amount-mobile
				>
					$<?php echo esc_html( number_format_i18n( $default_amount ) ); ?>
				</p>
			</div>

			<div class="flex w-full items-center gap-0 lg:gap-10">
				<label class="sr-only" for="roi-investment-slider">
					<?php echo esc_html__( 'Investment amount', 'impact-one-million' ); ?>
				</label>
				<input
					id="roi-investment-slider"
					class="iom-roi-slider w-full min-w-0 flex-1"
					type="range"
					min="<?php echo esc_attr( (string) $min_amount ); ?>"
					max="<?php echo esc_attr( (string) $max_amount ); ?>"
					step="<?php echo esc_attr( (string) $step_amount ); ?>"
					value="<?php echo esc_attr( (string) $default_amount ); ?>"
					style="--roi-pct: <?php echo esc_attr( (string) round( $pct, 2 ) ); ?>%;"
					data-roi-slider
				>
				<p
					class="m-0 hidden shrink-0 font-display text-stat-label leading-[1.2] text-navy lg:block"
					data-roi-amount-desktop
				>
					$<?php echo esc_html( number_format_i18n( $default_amount ) ); ?>
				</p>
			</div>
		</div>

		<div class="flex w-full flex-col gap-3 lg:flex-row lg:gap-8">
			<div class="flex flex-1 flex-col items-center gap-2 rounded-card bg-white px-3 py-2 lg:px-8 lg:py-6">
				<p class="m-0 text-center font-display text-stat-label leading-[1.2] text-accent-blue">
					<?php echo esc_html( $metric_workers ); ?>
				</p>
				<p class="m-0 font-display text-number leading-none text-blue" data-roi-workers>
					<?php echo esc_html( number_format_i18n( $init_workers ) ); ?>
				</p>
			</div>
			<div class="flex flex-1 flex-col items-center gap-2 rounded-card bg-white px-3 py-2 lg:px-8 lg:py-6">
				<p class="m-0 text-center font-display text-stat-label leading-[1.2] text-accent-blue">
					<?php echo esc_html( $metric_families ); ?>
				</p>
				<p class="m-0 font-display text-number leading-none text-blue" data-roi-families>
					<?php echo esc_html( number_format_i18n( $init_families ) ); ?>
				</p>
			</div>
			<div class="flex flex-1 flex-col items-center gap-2 rounded-card bg-white px-3 py-2 lg:px-8 lg:py-6">
				<p class="m-0 text-center font-display text-stat-label leading-[1.2] text-accent-blue">
					<?php echo esc_html( $metric_factories ); ?>
				</p>
				<p class="m-0 font-display text-number leading-none text-blue" data-roi-factories>
					<?php echo esc_html( number_format_i18n( $init_factories ) ); ?>
				</p>
			</div>
		</div>

		<?php if ( ! empty( $primary_cta['url'] ) || ! empty( $secondary_cta['url'] ) ) : ?>
			<div class="flex w-full flex-col items-stretch gap-4 lg:w-auto lg:flex-row lg:items-start lg:whitespace-nowrap">
				<?php
				if ( ! empty( $primary_cta['url'] ) ) {
					iom_render_link(
						$primary_cta,
						$btn_primary,
						''
					);
				}
				if ( ! empty( $secondary_cta['url'] ) ) {
					iom_render_link(
						$secondary_cta,
						$btn_outline,
						''
					);
				}
				?>
			</div>
		<?php endif; ?>
		</div>
	</div>
</section>
