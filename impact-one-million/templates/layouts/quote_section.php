<?php
/**
 * Layout: quote_section
 *
 * Full-width navy band — centered quote + name + role.
 *
 * Fields: quote, name, role
 *
 * Figma desktop: 634:20686 (no mobile frame — stacked / wrap adaptation)
 */

$quote = get_sub_field( 'quote' );
$name  = get_sub_field( 'name' );
$role  = get_sub_field( 'role' );

if ( ! $quote && ! $name && ! $role ) {
	return;
}
?>

<section class="bg-navy px-10 py-20 lg:p-section">
	<div class="mx-auto flex w-full max-w-[62.5rem] flex-col items-center gap-8 text-center">
		<?php if ( $quote ) : ?>
			<blockquote class="m-0 font-sans text-quote font-extrabold text-white">
				<?php echo esc_html( $quote ); ?>
			</blockquote>
		<?php endif; ?>

		<?php if ( $name || $role ) : ?>
			<footer class="flex flex-col items-center gap-1">
				<?php if ( $name ) : ?>
					<cite class="not-italic font-sans text-label leading-[1.5] text-white">
						<?php echo esc_html( $name ); ?>
					</cite>
				<?php endif; ?>

				<?php if ( $role ) : ?>
					<p class="m-0 font-display text-body uppercase tracking-[1px] text-[#dfe8ff]">
						<?php echo esc_html( $role ); ?>
					</p>
				<?php endif; ?>
			</footer>
		<?php endif; ?>
	</div>
</section>
