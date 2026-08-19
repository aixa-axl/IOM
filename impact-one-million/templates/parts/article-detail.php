<?php
/**
 * Shared article detail markup (News + Press Release).
 *
 * Expects in scope (already resolved with defaults):
 * $post_id, $breadcrumb_label, $breadcrumb_title, $display_title, $intro,
 * $overview, $meta_rows, $has_meta, $body, $gal_head, $gallery,
 * $quote, $quote_name, $quote_role, $rel_head, $rel_see_all, $related,
 * $link_label, $partner_head, $partner_intro, $partner_cards, $has_partner,
 * $show_newsletter, $nl_heading, $nl_body, $nl_placeholder, $nl_button,
 * $nl_privacy, $nl_action, $nl_image, $email_id
 *
 * Figma: 634:21026
 *
 * @package Impact_One_Million
 */

$btn_blue = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-accent-blue px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';
$btn_navy = 'inline-flex items-center justify-center rounded-btn border-[1.5px] border-solid border-transparent bg-navy px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white no-underline transition-opacity hover:opacity-90';

if ( empty( $email_id ) ) {
	$email_id = 'iom-article-newsletter-email';
}
?>

<article id="post-<?php echo esc_attr( (string) $post_id ); ?>" <?php post_class(); ?>>

	<!-- Hero -->
	<header class="bg-blue px-page py-16 lg:px-section lg:py-gutter">
		<div class="mx-auto flex w-full max-w-site flex-col gap-8">
			<div class="flex w-full max-w-[50rem] flex-col gap-8">
				<nav class="font-display text-body uppercase tracking-[1px] text-white/80" aria-label="<?php echo esc_attr__( 'Breadcrumb', 'impact-one-million' ); ?>">
					<?php if ( $breadcrumb_label ) : ?>
						<span><?php echo esc_html( $breadcrumb_label ); ?></span>
					<?php endif; ?>
					<?php if ( $breadcrumb_title ) : ?>
						<?php if ( $breadcrumb_label ) : ?>
							<span aria-hidden="true"> / </span>
						<?php endif; ?>
						<span class="text-white"><?php echo esc_html( $breadcrumb_title ); ?></span>
					<?php endif; ?>
				</nav>

				<?php if ( $display_title ) : ?>
					<h1 class="m-0 font-display text-title leading-[1.1] text-white">
						<?php echo esc_html( $display_title ); ?>
					</h1>
				<?php endif; ?>

				<?php if ( $intro ) : ?>
					<p class="m-0 font-sans text-label leading-[1.5] text-white">
						<?php echo esc_html( $intro ); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</header>

	<!-- Overview + body -->
	<?php if ( $overview || $has_meta || $body ) : ?>
		<section class="border-t border-solid border-[#dfe8ff] bg-white px-page py-20 lg:px-section lg:py-gutter">
			<div class="mx-auto flex w-full max-w-site flex-col items-start gap-20 lg:gap-[6.25rem]">
				<?php if ( $overview || $has_meta ) : ?>
					<div class="flex w-full flex-col items-start gap-12 lg:flex-row lg:gap-[6.25rem]">
						<?php if ( $overview ) : ?>
							<div class="flex w-full max-w-[43.75rem] flex-col gap-8">
								<p class="m-0 font-display text-label uppercase tracking-[1px] text-accent">
									<?php echo esc_html__( 'Project Overview', 'impact-one-million' ); ?>
								</p>
								<div class="font-sans text-label leading-[1.5] text-ink [&_p]:m-0 [&_p+p]:mt-8 [&_p+p]:text-body [&_p+p]:leading-[1.2]">
									<?php echo wp_kses_post( $overview ); ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( $has_meta ) : ?>
							<dl class="m-0 flex w-full max-w-[25rem] shrink-0 flex-col divide-y divide-solid divide-[#dfe8ff] rounded-card border border-solid border-[#dfe8ff] bg-off-white p-8">
								<?php foreach ( $meta_rows as $row ) : ?>
									<?php if ( empty( $row['value'] ) ) { continue; } ?>
									<div class="flex flex-col gap-2 py-4 first:pt-0 last:pb-0">
										<dt class="font-display text-body uppercase tracking-[1px] text-blue">
											<?php echo esc_html( $row['label'] ); ?>
										</dt>
										<dd class="m-0 font-sans text-body leading-[1.2] text-ink">
											<?php echo esc_html( $row['value'] ); ?>
										</dd>
									</div>
								<?php endforeach; ?>
							</dl>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( $body ) : ?>
					<div class="w-full font-sans text-[17px] leading-normal text-ink [&_p]:m-0 [&_p+p]:mt-6">
						<?php echo wp_kses_post( $body ); ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Gallery -->
	<?php if ( ! empty( $gallery ) ) : ?>
		<section class="bg-white px-page py-20 lg:px-section lg:py-gutter">
			<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10">
				<?php if ( $gal_head ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-navy">
						<?php echo esc_html( $gal_head ); ?>
					</h2>
				<?php endif; ?>
				<ul class="m-0 grid w-full list-none grid-cols-1 gap-8 p-0 sm:grid-cols-2 lg:grid-cols-3">
					<?php foreach ( $gallery as $image_id ) : ?>
						<li class="relative aspect-[378/297] overflow-hidden rounded-card">
							<?php
							echo wp_get_attachment_image(
								(int) $image_id,
								'large',
								false,
								array(
									'class'   => 'absolute inset-0 size-full object-cover',
									'loading' => 'lazy',
									'alt'     => '',
								)
							);
							?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<!-- Quote -->
	<?php if ( $quote || $quote_name || $quote_role ) : ?>
		<section class="bg-navy px-page py-20 lg:px-section lg:py-[7.5rem]">
			<div class="mx-auto flex w-full max-w-[62.5rem] flex-col items-center gap-8 text-center">
				<?php if ( $quote ) : ?>
					<blockquote class="m-0 font-sans text-quote font-extrabold text-white">
						<?php echo esc_html( $quote ); ?>
					</blockquote>
				<?php endif; ?>
				<?php if ( $quote_name || $quote_role ) : ?>
					<footer class="flex flex-col items-center gap-1">
						<?php if ( $quote_name ) : ?>
							<cite class="not-italic font-sans text-label leading-[1.5] text-white"><?php echo esc_html( $quote_name ); ?></cite>
						<?php endif; ?>
						<?php if ( $quote_role ) : ?>
							<p class="m-0 font-display text-body uppercase tracking-[1px] text-[#dfe8ff]"><?php echo esc_html( $quote_role ); ?></p>
						<?php endif; ?>
					</footer>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Related -->
	<?php if ( ! empty( $related ) ) : ?>
		<section class="bg-white px-page py-20 lg:px-gutter lg:py-gutter">
			<div class="mx-auto flex w-full max-w-site flex-col items-stretch gap-11">
				<div class="flex w-full flex-col items-start gap-6 lg:flex-row lg:items-center lg:justify-between">
					<?php if ( $rel_head ) : ?>
						<h2 class="m-0 font-display text-headline leading-[1.2] text-navy">
							<?php echo esc_html( $rel_head ); ?>
						</h2>
					<?php endif; ?>
					<?php
					if ( ! empty( $rel_see_all['url'] ) ) {
						iom_render_link( $rel_see_all, $btn_blue, __( 'See all news', 'impact-one-million' ) );
					}
					?>
				</div>
				<ul class="m-0 grid w-full list-none grid-cols-1 gap-6 p-0 lg:grid-cols-3">
					<?php
					$current_post_id = $post_id;
					foreach ( $related as $related_id ) {
						$post_id = (int) $related_id;
						require locate_template( 'templates/parts/case-study-card.php' );
					}
					$post_id = $current_post_id;
					?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<!-- Become a Partner -->
	<?php if ( $has_partner ) : ?>
		<section class="bg-ink px-page py-section lg:px-section">
			<div class="mx-auto flex w-full max-w-site flex-col items-center gap-10">
				<div class="flex w-full max-w-[40rem] flex-col items-center gap-4 text-center">
					<?php if ( $partner_head ) : ?>
						<h2 class="m-0 font-display text-headline leading-[1.2] text-white">
							<?php echo esc_html( $partner_head ); ?>
						</h2>
					<?php endif; ?>
					<?php if ( $partner_intro ) : ?>
						<p class="m-0 font-sans text-body leading-[1.2] text-white">
							<?php echo esc_html( $partner_intro ); ?>
						</p>
					<?php endif; ?>
				</div>

				<ul class="m-0 grid w-full list-none grid-cols-1 gap-8 p-0 lg:grid-cols-3">
					<?php foreach ( $partner_cards as $card ) : ?>
						<?php
						$c_title = isset( $card['title'] ) ? $card['title'] : '';
						$c_body  = isset( $card['body'] ) ? $card['body'] : '';
						$c_link  = isset( $card['link'] ) && is_array( $card['link'] ) ? $card['link'] : array();
						if ( ! $c_title && ! $c_body && empty( $c_link['url'] ) ) {
							continue;
						}
						?>
						<li class="flex w-full flex-col items-center gap-6 rounded-card bg-white p-10 text-center">
							<div class="flex flex-col items-center gap-3">
								<?php if ( $c_title ) : ?>
									<h3 class="m-0 font-display text-card-title text-blue">
										<?php echo esc_html( $c_title ); ?>
									</h3>
								<?php endif; ?>
								<?php if ( $c_body ) : ?>
									<p class="m-0 font-sans text-sm leading-normal text-ink">
										<?php echo esc_html( $c_body ); ?>
									</p>
								<?php endif; ?>
							</div>
							<?php
							if ( ! empty( $c_link['url'] ) ) {
								iom_render_link( $c_link, $btn_navy, __( 'Partner With Us', 'impact-one-million' ) );
							}
							?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<!-- Newsletter -->
	<?php if ( $show_newsletter ) : ?>
		<?php
		$heading      = $nl_heading;
		$body         = $nl_body;
		$placeholder  = $nl_placeholder;
		$button_label = $nl_button;
		$privacy_note = $nl_privacy;
		$form_action  = $nl_action;
		$image        = $nl_image;
		require locate_template( 'templates/parts/newsletter-signup.php' );
		?>
	<?php endif; ?>

</article>
