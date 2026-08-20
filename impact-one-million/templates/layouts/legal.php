<?php
/**
 * Layout: legal
 *
 * Simple legal page block — title + rich text body.
 * Use for Privacy Policy, Terms & Conditions, and similar pages.
 *
 * Fields: heading, body
 */

$heading = get_sub_field( 'heading' );
$body    = get_sub_field( 'body' );
?>

<section class="bg-white px-page py-10 xl:px-gutter lg:py-gutter">
	<div class="mx-auto flex w-full max-w-site flex-col items-start">
		<div class="flex w-full max-w-[50rem] flex-col items-start gap-8">
			<?php if ( $heading ) : ?>
				<h1 class="m-0 font-display text-headline leading-[1.2] text-blue lg:text-title lg:leading-[1.1] lg:tracking-[0.02em]">
					<?php echo esc_html( $heading ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( $body ) : ?>
				<div
					class="iom-legal-body m-0 w-full font-sans text-body leading-[1.5] text-ink [&_a]:text-blue [&_a]:underline [&_a]:transition-opacity hover:[&_a]:opacity-70 [&_h2]:mb-4 [&_h2]:mt-10 [&_h2]:font-display [&_h2]:text-header [&_h2]:leading-none [&_h2]:text-blue [&_h2:first-child]:mt-0 [&_h3]:mb-3 [&_h3]:mt-8 [&_h3]:font-display [&_h3]:text-card-title [&_h3]:leading-none [&_h3]:text-blue [&_li]:mt-2 [&_ol]:mt-6 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:m-0 [&_p+p]:mt-6 [&_ul]:mt-6 [&_ul]:list-disc [&_ul]:pl-6"
				>
					<?php echo wp_kses_post( $body ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
