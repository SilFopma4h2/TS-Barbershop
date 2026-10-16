<?php
/**
 * TS Barbershop – thema-instellingen.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TSB_VERSION', '0.1.0' );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 120, 'width' => 160, 'flex-width' => true, 'flex-height' => true ) );
	register_nav_menus( array( 'primary' => __( 'Hoofdmenu', 'ts-barbershop' ) ) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'tsb-fonts',
		'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'tsb-style', get_stylesheet_uri(), array(), TSB_VERSION );
	wp_enqueue_style( 'tsb-main', get_template_directory_uri() . '/assets/css/main.css', array( 'tsb-style', 'tsb-fonts' ), TSB_VERSION );
	wp_enqueue_script( 'tsb-menu', get_template_directory_uri() . '/assets/js/menu.js', array(), TSB_VERSION, true );
} );

/**
 * Bewerkbare gegevens (Weergave > Customizer > Barbershop gegevens).
 * Standaardwaarden komen van de huidige website.
 */
function tsb_defaults() {
	return array(
		'adres'    => "Weverstraat 17a\n6862 DJ Oosterbeek",
		'telefoon' => '026-2201708',
		'email'    => 'info@barbershop-oosterbeek.nl',
		'facebook' => 'https://www.facebook.com/robertskapsalon/',
		'tijden'   => "Maandag|Gesloten\nDinsdag|09:30 - 18:00\nWoensdag|09:30 - 18:00\nDonderdag|09:30 - 18:00\nVrijdag|09:30 - 18:00\nZaterdag|09:30 - 18:00\nZondag|Gesloten",
		'prijzen'  => "Knippen dames & heren|20,00\nKnippen tot en met 14 jaar|17,00\nBaard scheren/modelleren|13,00\nKnippen & baard|33,00\nTondeuse|14,00\nExtra haar wassen|4,00\nExtra oren of neus waxen|3,00",
		'prijsnoot' => 'Elektronische betaling: € 1,00 verwerkingskosten extra.',
		'annulering' => 'Bij annulering minder dan 8 uur van tevoren wordt 50% van de kosten van de afspraak in rekening gebracht. Annuleren kan via de website of telefonisch.',
	);
}

function tsb_get( $key ) {
	$defaults = tsb_defaults();
	return get_theme_mod( 'tsb_' . $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
}

/** "Label|Waarde" per regel omzetten naar een array van paren. */
function tsb_pairs( $text ) {
	$rows = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $text ) as $line ) {
		if ( '' === trim( $line ) ) {
			continue;
		}
		$parts  = array_map( 'trim', explode( '|', $line, 2 ) );
		$rows[] = array( $parts[0], isset( $parts[1] ) ? $parts[1] : '' );
	}
	return $rows;
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section( 'tsb_gegevens', array(
		'title'    => __( 'Barbershop gegevens', 'ts-barbershop' ),
		'priority' => 30,
	) );

	$fields = array(
		'adres'      => array( 'Adres', 'textarea' ),
		'telefoon'   => array( 'Telefoon', 'text' ),
		'email'      => array( 'E-mail', 'text' ),
		'facebook'   => array( 'Facebook-link', 'url' ),
		'tijden'     => array( 'Openingstijden (één per regel: Dag|Tijd)', 'textarea' ),
		'prijzen'    => array( 'Prijslijst (één per regel: Dienst|Prijs)', 'textarea' ),
		'prijsnoot'  => array( 'Opmerking onder prijslijst', 'text' ),
		'annulering' => array( 'Annuleringsbeleid', 'textarea' ),
	);
	$defaults = tsb_defaults();

	foreach ( $fields as $key => $field ) {
		$wp_customize->add_setting( 'tsb_' . $key, array(
			'default'           => $defaults[ $key ],
			'sanitize_callback' => 'url' === $field[1] ? 'esc_url_raw' : 'sanitize_textarea_field',
		) );
		$wp_customize->add_control( 'tsb_' . $key, array(
			'label'   => $field[0],
			'section' => 'tsb_gegevens',
			'type'    => $field[1],
		) );
	}
} );

/**
 * Contactformulier: verstuurt een mail naar het adres uit de Customizer.
 */
function tsb_handle_contact() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( 'verzonden', $back );

	if ( ! isset( $_POST['tsb_nonce'] ) || ! wp_verify_nonce( $_POST['tsb_nonce'], 'tsb_contact' ) || ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'verzonden', 'fout', $back ) . '#contactformulier' );
		exit;
	}

	$naam    = sanitize_text_field( wp_unslash( $_POST['naam'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$bericht = sanitize_textarea_field( wp_unslash( $_POST['bericht'] ?? '' ) );

	if ( '' === $naam || ! is_email( $email ) || '' === $bericht ) {
		wp_safe_redirect( add_query_arg( 'verzonden', 'fout', $back ) . '#contactformulier' );
		exit;
	}

	$ok = wp_mail(
		tsb_get( 'email' ),
		sprintf( 'Bericht via de website van %s', $naam ),
		"Naam: $naam\nE-mail: $email\n\n$bericht",
		array( 'Reply-To: ' . $naam . ' <' . $email . '>' )
	);

	wp_safe_redirect( add_query_arg( 'verzonden', $ok ? 'ja' : 'fout', $back ) . '#contactformulier' );
	exit;
}
add_action( 'admin_post_nopriv_tsb_contact', 'tsb_handle_contact' );
add_action( 'admin_post_tsb_contact', 'tsb_handle_contact' );
