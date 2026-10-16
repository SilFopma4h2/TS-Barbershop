<?php
/**
 * Afspraakpagina (pagina met slug "afspraak"). Toont de gekozen behandeling en de agenda van Salon Booking System.
 */
get_header();
$img  = get_template_directory_uri() . '/assets/img/';
$keuze = null;
$gevraagd = isset( $_GET['dienst'] ) ? sanitize_key( wp_unslash( $_GET['dienst'] ) ) : '';

// Heeft de bezoeker al een dienst gekozen in Salon Booking System? Dan tonen we die.
if ( class_exists( 'SLN_Plugin' ) ) {
	$gekozen = SLN_Plugin::getInstance()->getBookingBuilder()->getServices();
	if ( count( $gekozen ) === 1 ) {
		$eerste   = reset( $gekozen );
		$gevraagd = get_post_field( 'post_name', $eerste->getId() );
	}
}
foreach ( tsb_diensten() as $d ) {
	if ( $gevraagd && $d['slug'] === $gevraagd ) {
		$keuze = $d;
	}
}
?>
<section class="section section-licht afspraak-pagina">
	<div class="wrap narrow">
		<a class="terug" href="<?php echo esc_url( home_url( '/#diensten' ) ); ?>">&larr; Terug naar behandelingen</a>
		<span class="eyebrow">Afspraak maken</span>
		<h1 class="pagina-titel"><?php echo $keuze ? esc_html( $keuze['naam'] ) : 'Kies je behandeling en tijd'; ?></h1>

		<?php if ( $keuze ) : ?>
			<div class="dienst-samenvatting">
				<img src="<?php echo esc_url( $img . $keuze['img'] ); ?>" alt="" width="150" height="150">
				<div>
					<strong>&euro; <?php echo esc_html( $keuze['prijs'] ); ?> &middot; 30 minuten</strong>
					<p><?php echo esc_html( $keuze['tekst'] ); ?></p>
					<p class="note">Je kunt hieronder een andere behandeling kiezen of er een bij nemen.</p>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( shortcode_exists( 'salon' ) ) : ?>
			<?php echo do_shortcode( '[salon]' ); ?>
		<?php else : ?>
			<p class="note">De online agenda is nog niet actief. Installeer en activeer de plugin <em>Salon Booking System</em>, of bel <?php echo esc_html( tsb_get( 'telefoon' ) ); ?>.</p>
		<?php endif; ?>

		<p class="note"><?php echo esc_html( tsb_get( 'annulering' ) ); ?></p>
	</div>
</section>
<?php get_footer(); ?>
