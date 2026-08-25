<?php
/**
 * Inline header search — expands in place within the utility bar.
 *
 * Expects in scope: $search_label, $icon_search_uri, $util_link_class
 */

$iom_inline_id     = wp_unique_id( 'iom-inline-search-' );
$search_icon_class = isset( $search_icon_class ) ? $search_icon_class : 'size-[13.5px]';
$form_width_class  = isset( $search_form_class ) ? $search_form_class : 'w-[min(100%,16rem)]';
$show_search_icon  = ! isset( $show_search_icon ) || $show_search_icon;
?>
<div class="inline-flex min-w-0 max-w-full items-center" data-inline-search>
	<button
		type="button"
		class="inline-flex items-center gap-2 border-0 bg-transparent p-0 <?php echo esc_attr( $util_link_class ); ?>"
		data-search-toggle
		aria-expanded="false"
		aria-controls="<?php echo esc_attr( $iom_inline_id ); ?>"
	>
		<?php if ( $show_search_icon ) : ?>
			<img
				src="<?php echo esc_url( $icon_search_uri ); ?>"
				alt=""
				width="18"
				height="18"
				class="<?php echo esc_attr( $search_icon_class ); ?> shrink-0"
				aria-hidden="true"
			/>
		<?php endif; ?>
		<span><?php echo esc_html( $search_label ); ?></span>
	</button>

	<form
		id="<?php echo esc_attr( $iom_inline_id ); ?>"
		role="search"
		method="get"
		class="hidden <?php echo esc_attr( $form_width_class ); ?> items-center gap-2"
		action="<?php echo esc_url( home_url( '/' ) ); ?>"
		data-search-form
	>
		<?php if ( $show_search_icon ) : ?>
			<button
				type="submit"
				class="inline-flex shrink-0 items-center justify-center border-0 bg-transparent p-0"
				aria-label="<?php echo esc_attr__( 'Search', 'impact-one-million' ); ?>"
			>
				<img
					src="<?php echo esc_url( $icon_search_uri ); ?>"
					alt=""
					width="18"
					height="18"
					class="<?php echo esc_attr( $search_icon_class ); ?> shrink-0"
					aria-hidden="true"
				/>
			</button>
		<?php endif; ?>
		<label class="sr-only" for="<?php echo esc_attr( $iom_inline_id ); ?>-input">
			<?php echo esc_html_x( 'Search for:', 'label', 'impact-one-million' ); ?>
		</label>
		<div class="flex min-w-0 flex-1 items-center rounded-btn bg-white/15 ring-1 ring-inset ring-white/40 focus-within:bg-white/25 focus-within:ring-white">
			<input
				type="search"
				id="<?php echo esc_attr( $iom_inline_id ); ?>-input"
				class="min-w-0 flex-1 appearance-none border-0 bg-transparent px-2 py-1.5 font-sans text-base leading-normal text-white placeholder:text-white/60 focus:outline-none focus:ring-0 [&::-webkit-search-cancel-button]:hidden"
				placeholder="<?php echo esc_attr_x( 'Search…', 'placeholder', 'impact-one-million' ); ?>"
				value="<?php echo esc_attr( get_search_query() ); ?>"
				name="s"
				enterkeyhint="search"
				data-search-input
			/>
			<button
				type="button"
				class="inline-flex size-7 shrink-0 items-center justify-center border-0 bg-transparent text-white transition-opacity hover:opacity-70"
				data-search-close
				aria-label="<?php echo esc_attr__( 'Close search', 'impact-one-million' ); ?>"
			>
				<svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
					<path stroke-linecap="round" stroke-width="2" d="M6 6l12 12M18 6L6 18" />
				</svg>
			</button>
		</div>
	</form>
</div>
