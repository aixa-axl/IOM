<?php
/**
 * Header language switcher — globe + current language + dropdown.
 *
 * Expects in scope (optional overrides):
 * - $language_link   ACF link (current label / URL)
 * - $languages       ACF repeater of link rows
 * - $icon_globe_uri
 * - $iom_lang_variant 'desktop' | 'mobile'
 *
 * @package Impact_One_Million
 */

if ( ! isset( $iom_lang_variant ) ) {
	$iom_lang_variant = 'desktop';
}

if ( ! isset( $languages ) || ! is_array( $languages ) ) {
	$languages = function_exists( 'get_field' ) ? get_field( 'header_languages', 'option' ) : array();
}
if ( ! is_array( $languages ) ) {
	$languages = array();
}

$lang_options = array();
foreach ( $languages as $row ) {
	$opt = isset( $row['link'] ) ? $row['link'] : null;
	if ( empty( $opt['url'] ) || empty( $opt['title'] ) ) {
		continue;
	}
	$lang_options[] = $opt;
}

// Preview defaults until Language Options are filled in Theme Settings.
if ( empty( $lang_options ) ) {
	$lang_options = array(
		array(
			'url'    => '#',
			'title'  => __( 'Deutsch', 'impact-one-million' ),
			'target' => '',
		),
		array(
			'url'    => '#',
			'title'  => __( 'English', 'impact-one-million' ),
			'target' => '',
		),
		array(
			'url'    => '#',
			'title'  => __( 'Español', 'impact-one-million' ),
			'target' => '',
		),
		array(
			'url'    => '#',
			'title'  => __( 'Français', 'impact-one-million' ),
			'target' => '',
		),
	);
}

$current_label = ! empty( $language_link['title'] ) ? $language_link['title'] : '';
if ( ! $current_label ) {
	$current_label = __( 'English', 'impact-one-million' );
}

$is_mobile = ( 'mobile' === $iom_lang_variant );

$trigger_class = $is_mobile
	? 'inline-flex items-center gap-2 font-display text-body uppercase tracking-[1px] text-white'
	: 'inline-flex items-center gap-2 font-display text-label uppercase tracking-[1px] text-white';

$menu_class = $is_mobile
	? 'absolute left-0 top-full z-[70] m-0 mt-2 min-w-[10rem] list-none overflow-hidden rounded-btn border border-solid border-white/20 bg-navy p-0 shadow-lg'
	: 'absolute right-0 top-full z-[70] m-0 mt-2 min-w-[10rem] list-none overflow-hidden rounded-btn border border-solid border-[#dfe8ff] bg-white p-0 shadow-lg';

$item_class = $is_mobile
	? 'block whitespace-nowrap px-4 py-2.5 font-display text-body uppercase tracking-[1px] text-white no-underline transition-colors hover:bg-white/10'
	: 'block whitespace-nowrap px-4 py-2.5 font-sans text-sm leading-[1.5] text-navy no-underline transition-colors hover:bg-off-white';
?>

<div class="relative shrink-0" data-language-switcher>
	<button
		type="button"
		class="<?php echo esc_attr( $trigger_class ); ?> cursor-pointer border-0 bg-transparent p-0"
		data-language-switcher-toggle
		aria-expanded="false"
		aria-haspopup="listbox"
		aria-label="<?php echo esc_attr__( 'Select language', 'impact-one-million' ); ?>"
	>
		<img
			src="<?php echo esc_url( $icon_globe_uri ); ?>"
			alt=""
			width="18"
			height="18"
			class="size-[18px] shrink-0"
			aria-hidden="true"
		/>
		<span data-language-switcher-label><?php echo esc_html( $current_label ); ?></span>
		<svg class="size-2.5 shrink-0" viewBox="0 0 10 6" fill="none" aria-hidden="true">
			<path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</button>

	<ul
		class="<?php echo esc_attr( $menu_class ); ?> invisible opacity-0 transition-[opacity,visibility] duration-150"
		data-language-switcher-menu
		role="listbox"
		hidden
	>
		<?php foreach ( $lang_options as $opt ) : ?>
			<?php
			$is_current = ( 0 === strcasecmp( (string) $opt['title'], (string) $current_label ) );
			?>
			<li class="m-0" role="none">
				<a
					href="<?php echo esc_url( $opt['url'] ); ?>"
					class="<?php echo esc_attr( $item_class ); ?><?php echo $is_current ? ' font-semibold' : ''; ?>"
					role="option"
					<?php echo $is_current ? 'aria-selected="true"' : 'aria-selected="false"'; ?>
					<?php echo ! empty( $opt['target'] ) ? 'target="' . esc_attr( $opt['target'] ) . '" rel="noopener noreferrer"' : ''; ?>
				>
					<?php echo esc_html( $opt['title'] ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
