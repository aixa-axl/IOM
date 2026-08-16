<?php
/**
 * Inline header search — expands in place within the utility bar.
 *
 * Expects in scope: $search_label, $icon_search_uri, $util_link_class
 */

$iom_inline_id = wp_unique_id( 'iom-inline-search-' );
?>
<div class="inline-flex min-w-0 max-w-full items-center" data-inline-search>
	<button
		type="button"
		class="inline-flex items-center gap-2 border-0 bg-transparent p-0 <?php echo esc_attr( $util_link_class ); ?>"
		data-search-toggle
		aria-expanded="false"
		aria-controls="<?php echo esc_attr( $iom_inline_id ); ?>"
	>
		<img
			src="<?php echo esc_url( $icon_search_uri ); ?>"
			alt=""
			width="14"
			height="14"
			class="size-[13.5px] shrink-0"
			aria-hidden="true"
		/>
		<span><?php echo esc_html( $search_label ); ?></span>
	</button>

	<form
		id="<?php echo esc_attr( $iom_inline_id ); ?>"
		role="search"
		method="get"
		class="flex w-[min(100%,16rem)] items-center gap-2"
		action="<?php echo esc_url( home_url( '/' ) ); ?>"
		data-search-form
		hidden
	>
		<img
			src="<?php echo esc_url( $icon_search_uri ); ?>"
			alt=""
			width="14"
			height="14"
			class="size-[13.5px] shrink-0"
			aria-hidden="true"
		/>
		<label class="sr-only" for="<?php echo esc_attr( $iom_inline_id ); ?>-input">
			<?php echo esc_html_x( 'Search for:', 'label', 'impact-one-million' ); ?>
		</label>
		<div class="flex min-w-0 flex-1 items-center rounded-btn bg-white/15 ring-1 ring-inset ring-white/40 focus-within:bg-white/25 focus-within:ring-white">
			<input
				type="search"
				id="<?php echo esc_attr( $iom_inline_id ); ?>-input"
				class="min-w-0 flex-1 appearance-none border-0 bg-transparent px-2 py-1 font-sans text-sm text-white placeholder:text-white/60 focus:outline-none focus:ring-0 [&::-webkit-search-cancel-button]:hidden"
				placeholder="<?php echo esc_attr_x( 'Search…', 'placeholder', 'impact-one-million' ); ?>"
				value="<?php echo esc_attr( get_search_query() ); ?>"
				name="s"
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
