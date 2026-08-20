<?php
/**
 * Layout: ambassadors
 *
 * Profile card grid — photo, name, role, bio, optional LinkedIn.
 * Desktop: 3 columns. Mobile: stacked. Optional JS pagination.
 *
 * Figma desktop: 663:31810 — Figma with LinkedIn + pagination: 668:36136
 */

$heading      = get_sub_field( 'heading' );
$ambassadors  = get_sub_field( 'ambassadors' );
$background   = get_sub_field( 'background' );
$per_page     = (int) get_sub_field( 'per_page' );
$linkedin_lbl = get_sub_field( 'linkedin_label' );

$theme_uri = get_stylesheet_directory_uri();
$li_uri    = $theme_uri . '/assets/images/icons/linkedin.svg';

if ( ! in_array( $background, array( 'white', 'off_white' ), true ) ) {
	$background = 'white';
}

if ( ! is_array( $ambassadors ) ) {
	$ambassadors = array();
}

if ( ! $linkedin_lbl ) {
	$linkedin_lbl = __( 'View LinkedIn', 'impact-one-million' );
}

// 0 = show all (no pagination).
if ( $per_page < 0 ) {
	$per_page = 0;
}

$total       = count( $ambassadors );
$use_paging  = ( $per_page > 0 && $total > $per_page );
$page_count  = $use_paging ? (int) ceil( $total / $per_page ) : 1;
$section_bg  = ( 'off_white' === $background ) ? 'bg-off-white' : 'bg-white';

$img_attrs = array(
	'class'   => 'absolute inset-0 size-full object-cover',
	'loading' => 'lazy',
	'alt'     => '',
);
?>

<section
	class="<?php echo esc_attr( $section_bg ); ?> px-page py-10 xl:p-gutter"
	<?php echo $use_paging ? 'data-ambassadors-grid data-per-page="' . esc_attr( (string) $per_page ) . '"' : ''; ?>
>
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-12">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 font-display text-headline leading-[1.2] text-navy">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( ! empty( $ambassadors ) ) : ?>
			<div class="w-full" <?php echo $use_paging ? 'data-ambassadors-grid-wrap' : ''; ?>>
			<ul class="m-0 grid w-full list-none grid-cols-1 content-start gap-8 p-0 sm:grid-cols-2 lg:grid-cols-3">
				<?php foreach ( $ambassadors as $index => $person ) : ?>
					<?php
					$image_id     = isset( $person['image'] ) ? $person['image'] : null;
					$name         = isset( $person['name'] ) ? $person['name'] : '';
					$role         = isset( $person['role'] ) ? $person['role'] : '';
					$bio          = isset( $person['bio'] ) ? $person['bio'] : '';
					$linkedin_url = isset( $person['linkedin_url'] ) ? $person['linkedin_url'] : '';

					if ( ! $name && ! $role && ! $bio && ! $image_id && ! $linkedin_url ) {
						continue;
					}

					$img_attrs['alt'] = $name ? $name : '';
					$hidden           = ( $use_paging && $index >= $per_page );
					?>
					<li
						class="flex flex-col gap-5 self-start rounded-card border border-solid border-[#dfe8ff] bg-white p-6<?php echo $hidden ? ' hidden' : ''; ?>"
						<?php echo $use_paging ? 'data-ambassadors-card' : ''; ?>
					>
						<div class="relative h-[15rem] w-full overflow-hidden rounded-card bg-off-white">
							<?php if ( $image_id ) : ?>
								<?php
								echo wp_get_attachment_image(
									(int) $image_id,
									'large',
									false,
									$img_attrs
								);
								?>
							<?php endif; ?>
						</div>

						<div class="flex flex-col gap-2">
							<?php if ( $name ) : ?>
								<h3 class="m-0 font-display text-card-title leading-none text-blue">
									<?php echo esc_html( $name ); ?>
								</h3>
							<?php endif; ?>

							<?php if ( $role ) : ?>
								<p class="m-0 font-display text-label leading-[1.2] uppercase tracking-[1px] text-accent-blue">
									<?php echo esc_html( $role ); ?>
								</p>
							<?php endif; ?>

							<?php if ( $bio ) : ?>
								<p class="m-0 font-sans text-sm leading-[1.5] text-navy">
									<?php echo esc_html( $bio ); ?>
								</p>
							<?php endif; ?>

							<?php if ( $linkedin_url ) : ?>
								<a
									href="<?php echo esc_url( $linkedin_url ); ?>"
									class="mt-0 inline-flex items-start gap-2 font-sans text-sm leading-[1.5] text-navy no-underline transition-opacity hover:opacity-70"
									target="_blank"
									rel="noopener noreferrer"
								>
									<img
										src="<?php echo esc_url( $li_uri ); ?>"
										alt=""
										width="22"
										height="22"
										class="size-[22px] shrink-0"
										loading="lazy"
										decoding="async"
										aria-hidden="true"
									>
									<span><?php echo esc_html( $linkedin_lbl ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
			</div>

			<?php if ( $use_paging ) : ?>
				<nav class="flex flex-wrap items-center gap-2" data-ambassadors-pagination aria-label="<?php echo esc_attr__( 'Ambassadors pagination', 'impact-one-million' ); ?>">
					<?php for ( $i = 1; $i <= $page_count; $i++ ) : ?>
						<button
							type="button"
							class="inline-flex items-center justify-center rounded-btn px-3 py-2 font-display text-card-title uppercase tracking-[2px] transition-colors <?php echo 1 === $i ? 'bg-blue text-white' : 'border border-solid border-[#dfe8ff] bg-white text-blue'; ?>"
							data-ambassadors-page="<?php echo esc_attr( (string) $i ); ?>"
							<?php echo 1 === $i ? 'aria-current="page"' : ''; ?>
						>
							<?php echo esc_html( (string) $i ); ?>
						</button>
					<?php endfor; ?>
				</nav>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>
