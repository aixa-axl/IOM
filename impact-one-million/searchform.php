<?php
/**
 * Search Form
 *
 * Used by get_search_form() (e.g. search results page).
 */

$iom_search_id = wp_unique_id( 'iom-search-' );
?>
<form
	role="search"
	method="get"
	class="iom-search-form flex w-full flex-col gap-3 sm:flex-row sm:items-center"
	action="<?php echo esc_url( home_url( '/' ) ); ?>"
	data-search-form
>
	<label class="sr-only" for="<?php echo esc_attr( $iom_search_id ); ?>">
		<?php echo esc_html_x( 'Search for:', 'label', 'impact-one-million' ); ?>
	</label>
	<input
		type="search"
		id="<?php echo esc_attr( $iom_search_id ); ?>"
		class="min-h-12 w-full flex-1 rounded-btn border-[1.5px] border-solid border-blue bg-white px-4 py-3 font-sans text-body text-ink placeholder:text-muted focus:outline-none focus:ring-2 focus:ring-accent-blue"
		placeholder="<?php echo esc_attr_x( 'Search the site…', 'placeholder', 'impact-one-million' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s"
		data-search-input
	/>
	<button
		type="submit"
		class="inline-flex shrink-0 items-center justify-center rounded-btn bg-accent px-6 py-3.5 font-display text-card-title uppercase tracking-[2px] text-white transition-opacity hover:opacity-90"
	>
		<?php echo esc_html_x( 'Search', 'submit button', 'impact-one-million' ); ?>
	</button>
</form>
