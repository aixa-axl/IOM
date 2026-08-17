<?php
/**
 * Layout: ambassadors
 *
 * "Meet Our Ambassadors" — heading + profile card grid.
 * Desktop: 3 columns. Mobile: stacked single column.
 *
 * Figma desktop: 663:31810 (no mobile frame — stacked adaptation)
 */

$heading      = get_sub_field( 'heading' );
$ambassadors  = get_sub_field( 'ambassadors' );

if ( ! $heading ) {
	$heading = __( 'Meet Our Ambassadors', 'impact-one-million' );
}

if ( ! is_array( $ambassadors ) ) {
	$ambassadors = array();
}

$img_attrs = array(
	'class'   => 'absolute inset-0 size-full object-cover',
	'loading' => 'lazy',
	'alt'     => '',
);
?>

<section class="bg-white px-10 py-[100px] lg:px-16">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-12">
		<?php if ( $heading ) : ?>
			<h2 class="m-0 font-display text-headline leading-[1.2] text-navy">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( ! empty( $ambassadors ) ) : ?>
			<ul class="m-0 grid w-full list-none grid-cols-1 gap-8 p-0 sm:grid-cols-2 lg:grid-cols-3">
				<?php foreach ( $ambassadors as $person ) : ?>
					<?php
					$image_id = isset( $person['image'] ) ? $person['image'] : null;
					$name     = isset( $person['name'] ) ? $person['name'] : '';
					$role     = isset( $person['role'] ) ? $person['role'] : '';
					$bio      = isset( $person['bio'] ) ? $person['bio'] : '';

					if ( ! $name && ! $role && ! $bio && ! $image_id ) {
						continue;
					}

					$img_attrs['alt'] = $name ? $name : '';
					?>
					<li class="flex flex-col gap-5 rounded-card border border-solid border-[#dfe8ff] bg-white p-6">
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

						<?php if ( $name || $role || $bio ) : ?>
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
							</div>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
