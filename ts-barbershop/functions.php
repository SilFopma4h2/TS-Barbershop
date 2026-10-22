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
	wp_enqueue_script( 'tsb-feedback', get_template_directory_uri() . '/assets/js/feedback.js', array(), TSB_VERSION, true );
	wp_enqueue_script( 'tsb-products', get_template_directory_uri() . '/assets/js/products.js', array(), TSB_VERSION, true );
	wp_enqueue_script( 'tsb-gallery', get_template_directory_uri() . '/assets/js/gallery.js', array(), TSB_VERSION, true );
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

/**
 * Openingstijden uit de Customizer als JSON voor feedback.js (0 = zondag).
 * Herkent "09:30 - 18:00"; alles anders (bv. "Gesloten") telt als dicht.
 */
function tsb_hours_json() {
	$map   = array( 'zondag' => 0, 'maandag' => 1, 'dinsdag' => 2, 'woensdag' => 3, 'donderdag' => 4, 'vrijdag' => 5, 'zaterdag' => 6 );
	$hours = array_fill( 0, 7, null );
	foreach ( tsb_pairs( tsb_get( 'tijden' ) ) as $row ) {
		$day = strtolower( $row[0] );
		if ( isset( $map[ $day ] ) && preg_match( '/(\d{1,2}:\d{2})\s*[-–—]\s*(\d{1,2}:\d{2})/', $row[1], $m ) ) {
			$hours[ $map[ $day ] ] = array( $m[1], $m[2] );
		}
	}
	return wp_json_encode( $hours );
}

/** Behandelingen: naam, foto, prijs en korte uitleg (voor homepage en afspraakpagina). */
function tsb_diensten() {
	return array(
		array( 'slug' => 'heren', 'naam' => 'Knippen heren', 'img' => 'behandeling-heren-knippen.jpg', 'prijs' => '20,00', 'tekst' => 'Een nette herenknipbeurt, met of zonder afspraak.' ),
		array( 'slug' => 'dames', 'naam' => 'Knippen dames', 'img' => 'behandeling-dames-knippen.jpg', 'prijs' => '20,00', 'tekst' => 'Knippen voor dames. Wassen kan er als extra bij.' ),
		array( 'slug' => 'kinderen', 'naam' => 'Knippen kinderen', 'img' => 'behandeling-kinderen.jpg', 'prijs' => '17,00', 'tekst' => 'Knippen voor kinderen tot en met 14 jaar.' ),
		array( 'slug' => 'baard', 'naam' => 'Baard scheren/modelleren', 'img' => 'behandeling-scheren.jpg', 'prijs' => '13,00', 'tekst' => 'Je baard netjes scheren of in model brengen.' ),
		array( 'slug' => 'knippen-baard', 'naam' => 'Knippen & baard', 'img' => 'behandeling-knippen-en-baard.jpg', 'prijs' => '33,00', 'tekst' => 'Knippen en baard in één afspraak.' ),
		array( 'slug' => 'tondeuse', 'naam' => 'Tondeuse', 'img' => 'behandeling-tondeuze.jpg', 'prijs' => '14,00', 'tekst' => 'Met de tondeuse, in één lengte of met een nette overgang.' ),
	);
}

/** De afspraakpagina (slug "afspraak"), of null als die ontbreekt. */
function tsb_afspraak_page() {
	return get_page_by_path( 'afspraak' );
}

/** Salon Booking System-dienst (post) die bij onze behandeling hoort, op basis van de slug. */
function tsb_sln_service( $slug ) {
	if ( ! post_type_exists( 'sln_service' ) ) {
		return null;
	}
	$post = get_page_by_path( $slug, OBJECT, 'sln_service' );
	if ( $post ) {
		return $post;
	}
	// Diensten van de oude site hebben een andere slug: zoek dan op naam.
	foreach ( tsb_diensten() as $d ) {
		if ( $d['slug'] === $slug ) {
			foreach ( get_posts( array( 'post_type' => 'sln_service', 'numberposts' => -1 ) ) as $p ) {
				if ( 0 === strcasecmp( trim( $p->post_title ), $d['naam'] ) ) {
					return $p;
				}
			}
		}
	}
	return null;
}

/**
 * URL naar de afspraakpagina. Met een behandeling gebruikt dit de eigen "boek nu"-route van
 * Salon Booking System, zodat die dienst al is aangevinkt op de afspraakpagina. Zonder plugin of
 * dienst valt het terug op ?dienst=slug (dan toont de pagina alleen de samenvatting).
 */
function tsb_afspraak_url( $dienst = '' ) {
	$page = tsb_afspraak_page();
	$url  = $page ? get_permalink( $page ) : home_url( '/afspraak/' );
	if ( ! $dienst ) {
		return $url;
	}
	$service = tsb_sln_service( $dienst );
	if ( $service && class_exists( 'SLN_Shortcode_SalonServices' ) ) {
		return add_query_arg( array(
			'action'  => SLN_Shortcode_SalonServices::BOOK_NOW_REDIRECT_ACTION,
			'service' => $service->ID,
		), $url );
	}
	return add_query_arg( 'dienst', $dienst, $url );
}

/**
 * Zet de behandelingen als diensten in Salon Booking System (alleen wat nog ontbreekt, bestaande
 * diensten blijven ongemoeid) en stelt de afspraakpagina in als boekingspagina. Draait één keer
 * nadat de plugin actief is, en kan ook met `wp eval 'tsb_sync_services();'` worden gestart.
 */
function tsb_sync_services() {
	if ( ! post_type_exists( 'sln_service' ) || ! class_exists( 'SLN_Plugin' ) ) {
		return false;
	}
	// Bestaat er al een dienst (bijvoorbeeld van de oude site), dan voegen we er geen dubbele aan toe.
	$bestaand = get_posts( array( 'post_type' => 'sln_service', 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) );
	$order    = 0;
	foreach ( $bestaand ? array() : tsb_diensten() as $d ) {
		$order++;
		if ( tsb_sln_service( $d['slug'] ) ) {
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'   => 'sln_service',
			'post_status' => 'publish',
			'post_title'  => $d['naam'],
			'post_name'   => $d['slug'],
		) );
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		update_post_meta( $id, '_sln_service_price', str_replace( ',', '.', $d['prijs'] ) );
		update_post_meta( $id, '_sln_service_duration', '00:30' );
		update_post_meta( $id, '_sln_service_exec_order', $order );
	}

	$settings = get_option( 'salon_settings', array() );
	$page     = tsb_afspraak_page();
	if ( $page ) {
		$settings['pay'] = $page->ID;
	}
	$settings['pay_currency'] = 'EUR';
	update_option( 'salon_settings', $settings );
	update_option( 'tsb_services_synced', TSB_VERSION );
	return true;
}

add_action( 'admin_init', function () {
	if ( get_option( 'tsb_services_synced' ) || ! post_type_exists( 'sln_service' ) ) {
		return;
	}
	tsb_ensure_afspraak_page();
	tsb_sync_services();
} );

/** Maakt een pagina aan als die nog niet bestaat. */
function tsb_ensure_page( $slug, $title ) {
	if ( get_page_by_path( $slug ) ) {
		return;
	}
	wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => '',
	) );
}

/** De pagina's die het thema nodig heeft (bij activeren van het thema). */
function tsb_ensure_afspraak_page() {
	tsb_ensure_page( 'afspraak', 'Afspraak maken' );
	tsb_ensure_page( 'foto-galerij', 'Foto galerij' );
}
add_action( 'after_switch_theme', 'tsb_ensure_afspraak_page' );

/**
 * Meta description, Open Graph en LocalBusiness-gegevens (JSON-LD) in de <head>.
 * Alles komt uit de Customizer, zodat het meebeweegt met adres en openingstijden.
 */
add_action( 'wp_head', function () {
	$desc  = 'Barbershop Oosterbeek: knippen en baard scheren voor dames, heren en kinderen aan de Weverstraat in Oosterbeek. Reserveer online of loop binnen.';
	$image = get_template_directory_uri() . '/assets/img/salon.jpg';
	echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:locale" content="nl_NL">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( wp_get_document_title() ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( home_url( '/' ) ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";

	if ( ! is_front_page() ) {
		return;
	}
	$lines  = preg_split( '/\r\n|\r|\n/', trim( tsb_get( 'adres' ) ) );
	$postal = isset( $lines[1] ) ? $lines[1] : '';
	$days   = array( 'maandag' => 'Monday', 'dinsdag' => 'Tuesday', 'woensdag' => 'Wednesday', 'donderdag' => 'Thursday', 'vrijdag' => 'Friday', 'zaterdag' => 'Saturday', 'zondag' => 'Sunday' );
	$hours  = array();
	foreach ( tsb_pairs( tsb_get( 'tijden' ) ) as $row ) {
		$day = strtolower( $row[0] );
		if ( isset( $days[ $day ] ) && preg_match( '/(\d{1,2}:\d{2})\s*[-–—]\s*(\d{1,2}:\d{2})/', $row[1], $m ) ) {
			$hours[] = array( '@type' => 'OpeningHoursSpecification', 'dayOfWeek' => $days[ $day ], 'opens' => $m[1], 'closes' => $m[2] );
		}
	}
	$data = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'HairSalon',
		'name'        => 'Barbershop Oosterbeek',
		'url'         => home_url( '/' ),
		'image'       => $image,
		'telephone'   => tsb_get( 'telefoon' ),
		'email'       => tsb_get( 'email' ),
		'priceRange'  => '€',
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $lines[0],
			'postalCode'      => substr( $postal, 0, 7 ),
			'addressLocality' => trim( substr( $postal, 7 ) ),
			'addressCountry'  => 'NL',
		),
		'openingHoursSpecification' => $hours,
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 5 );

/**
 * Pagina's van de oude site (Divi) bevatten shortcodes als [et_pb_section ...] die zonder Divi als
 * kale tekst op de pagina komen. Code-modules halen we weg, bij de rest houden we alleen de tekst.
 */
add_filter( 'the_content', function ( $content ) {
	if ( false === strpos( $content, '[et_pb_' ) ) {
		return $content;
	}
	$content = preg_replace( '/\[et_pb_code[^\]]*\].*?\[\/et_pb_code\]/s', '', $content );
	return preg_replace( '/\[\/?et_pb_[a-z_0-9]+[^\]]*\]/', '', $content );
}, 5 );
