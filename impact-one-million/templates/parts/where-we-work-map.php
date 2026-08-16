<?php
/**
 * Interactive Asia map for Where We Work.
 * Simplified SVG paths — clickable countries sync with the detail panel.
 */
?>
<svg
	class="h-full w-full"
	viewBox="0 0 1000 560"
	xmlns="http://www.w3.org/2000/svg"
	role="img"
	aria-label="<?php echo esc_attr__( 'Map of countries where we work', 'impact-one-million' ); ?>"
	data-work-map-svg
>
	<style>
		.iom-map-land { fill: #002460; stroke: #dfe8ff; stroke-width: 1; }
		.iom-map-country { fill: #002460; stroke: #dfe8ff; stroke-width: 1.25; cursor: pointer; transition: fill 0.2s ease; }
		.iom-map-country:hover,
		.iom-map-country:focus { fill: #153a81; outline: none; }
		.iom-map-country.is-active { fill: #e7492e; stroke: #e7492e; }
		.iom-map-pin { fill: #002460; pointer-events: none; }
		.iom-map-country.is-active + .iom-map-pin,
		.iom-map-country.is-active ~ .iom-map-pin[data-for] { fill: #e7492e; }
	</style>

	<!-- Context land (non-interactive) -->
	<path class="iom-map-land" d="M520 40 L780 55 L820 120 L790 180 L700 160 L640 90 Z" />
	<path class="iom-map-land" d="M780 200 L900 220 L920 280 L860 300 L800 260 Z" />
	<path class="iom-map-land" d="M400 80 L480 70 L510 140 L450 160 Z" />
	<path class="iom-map-land" d="M560 220 L620 210 L650 280 L600 300 L560 270 Z" />
	<path class="iom-map-land" d="M620 300 L680 290 L700 360 L650 380 L610 340 Z" />
	<path class="iom-map-land" d="M680 250 L740 240 L760 310 L710 330 Z" />

	<!-- China -->
	<path
		id="map-china"
		class="iom-map-country"
		data-country="china"
		tabindex="0"
		role="button"
		aria-label="<?php echo esc_attr__( 'China', 'impact-one-million' ); ?>"
		d="M560 50 L760 40 L810 100 L800 170 L720 200 L640 190 L580 140 L545 90 Z"
	/>
	<circle class="iom-map-pin" data-for="china" cx="680" cy="120" r="4" />

	<!-- India -->
	<path
		id="map-india"
		class="iom-map-country"
		data-country="india"
		tabindex="0"
		role="button"
		aria-label="<?php echo esc_attr__( 'India', 'impact-one-million' ); ?>"
		d="M430 160 L520 150 L545 220 L530 310 L490 380 L450 400 L420 350 L400 280 L410 210 Z"
	/>
	<circle class="iom-map-pin" data-for="india" cx="470" cy="270" r="4" />

	<!-- Bangladesh -->
	<path
		id="map-bangladesh"
		class="iom-map-country"
		data-country="bangladesh"
		tabindex="0"
		role="button"
		aria-label="<?php echo esc_attr__( 'Bangladesh', 'impact-one-million' ); ?>"
		d="M530 250 L565 245 L575 280 L555 300 L530 285 Z"
	/>
	<circle class="iom-map-pin" data-for="bangladesh" cx="550" cy="270" r="3.5" />

	<!-- Sri Lanka -->
	<path
		id="map-sri-lanka"
		class="iom-map-country"
		data-country="sri-lanka"
		tabindex="0"
		role="button"
		aria-label="<?php echo esc_attr__( 'Sri Lanka', 'impact-one-million' ); ?>"
		d="M485 410 L510 405 L518 445 L500 470 L480 450 Z"
	/>
	<circle class="iom-map-pin" data-for="sri-lanka" cx="498" cy="435" r="3.5" />

	<!-- Vietnam -->
	<path
		id="map-vietnam"
		class="iom-map-country"
		data-country="vietnam"
		tabindex="0"
		role="button"
		aria-label="<?php echo esc_attr__( 'Vietnam', 'impact-one-million' ); ?>"
		d="M680 250 L710 245 L725 290 L740 350 L730 400 L705 415 L690 370 L675 310 Z"
	/>
	<circle class="iom-map-pin" data-for="vietnam" cx="705" cy="330" r="4" />

	<!-- Indonesia (simplified archipelago) -->
	<path
		id="map-indonesia"
		class="iom-map-country"
		data-country="indonesia"
		tabindex="0"
		role="button"
		aria-label="<?php echo esc_attr__( 'Indonesia', 'impact-one-million' ); ?>"
		d="M620 430 L720 420 L800 435 L860 450 L900 470 L870 495 L780 485 L700 475 L640 465 L610 450 Z
		   M740 500 L820 495 L850 520 L780 530 Z"
	/>
	<circle class="iom-map-pin" data-for="indonesia" cx="760" cy="460" r="4" />
</svg>
