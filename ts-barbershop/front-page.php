<?php
get_header();
$img      = get_template_directory_uri() . '/assets/img/';
$verzonden = isset( $_GET['verzonden'] ) ? sanitize_key( $_GET['verzonden'] ) : '';

$diensten = array(
	array( 'behandeling-heren-knippen.jpg', 'Knippen heren' ),
	array( 'behandeling-dames-knippen.jpg', 'Knippen dames' ),
	array( 'behandeling-kinderen.jpg', 'Knippen kinderen' ),
	array( 'behandeling-scheren.jpg', 'Baard scheren/modelleren' ),
	array( 'behandeling-knippen-en-baard.jpg', 'Knippen & baard' ),
	array( 'behandeling-tondeuze.jpg', 'Tondeuse' ),
);

$producten = array(
	array( 'Nish Man Wax Rugby', '6' ),
	array( 'Nish Man Wax Keratine', '6' ),
	array( 'Nish Man Gel Mystic Gummy', '6' ),
	array( 'Nish Man Shampoo', '6' ),
	array( 'Mr Rebel Black', '10' ),
	array( 'Mr Rebel Red', '10' ),
	array( 'Cologne', '6' ),
	array( 'Shaving gel', '10' ),
);
?>
<section class="hero" style="background-image:url('<?php echo esc_url( $img . 'sfeer.jpg' ); ?>')">
	<div class="hero-overlay">
		<div class="wrap">
			<h1><?php bloginfo( 'name' ); ?></h1>
			<p>Knippen en baard scheren in Oosterbeek</p>
			<a class="btn" href="#afspraak">Reserveer nu online</a>
		</div>
	</div>
</section>

<section class="section" id="diensten">
	<div class="wrap">
		<h2>Wat we doen</h2>
		<ul class="cards">
			<?php foreach ( $diensten as $d ) : ?>
				<li>
					<img src="<?php echo esc_url( $img . $d[0] ); ?>" alt="" width="150" height="150" loading="lazy">
					<span><?php echo esc_html( $d[1] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section section-licht" id="prijzen">
	<div class="wrap narrow">
		<h2>Wat het kost</h2>
		<table class="price-table">
			<?php foreach ( tsb_pairs( tsb_get( 'prijzen' ) ) as $row ) : ?>
				<tr><th scope="row"><?php echo esc_html( $row[0] ); ?></th><td>&euro; <?php echo esc_html( $row[1] ); ?></td></tr>
			<?php endforeach; ?>
		</table>
		<p class="note"><?php echo esc_html( tsb_get( 'prijsnoot' ) ); ?></p>

		<h3>Producten</h3>
		<table class="price-table">
			<?php foreach ( $producten as $p ) : ?>
				<tr><th scope="row"><?php echo esc_html( $p[0] ); ?></th><td>&euro; <?php echo esc_html( $p[1] ); ?></td></tr>
			<?php endforeach; ?>
		</table>
	</div>
</section>

<section class="section" id="afspraak">
	<div class="wrap narrow">
		<h2>Afspraak maken</h2>
		<?php if ( shortcode_exists( 'salon' ) ) : ?>
			<?php echo do_shortcode( '[salon]' ); ?>
		<?php else : ?>
			<p class="note">De online agenda is nog niet actief. Installeer en activeer de plugin <em>Salon Booking System</em>, of bel <?php echo esc_html( tsb_get( 'telefoon' ) ); ?>.</p>
		<?php endif; ?>
		<p class="note"><?php echo esc_html( tsb_get( 'annulering' ) ); ?></p>
	</div>
</section>

<section class="section section-donker" id="openingstijden">
	<div class="wrap narrow">
		<h2>Openingstijden</h2>
		<table class="price-table price-table-donker">
			<?php foreach ( tsb_pairs( tsb_get( 'tijden' ) ) as $row ) : ?>
				<tr><th scope="row"><?php echo esc_html( $row[0] ); ?></th><td><?php echo esc_html( $row[1] ); ?></td></tr>
			<?php endforeach; ?>
		</table>
	</div>
</section>

<section class="section" id="adres">
	<div class="wrap two-col">
		<div>
			<h2>Adres</h2>
			<p><?php echo nl2br( esc_html( tsb_get( 'adres' ) ) ); ?></p>
			<p>Tel. <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', tsb_get( 'telefoon' ) ) ); ?>"><?php echo esc_html( tsb_get( 'telefoon' ) ); ?></a><br>
			<a href="mailto:<?php echo esc_attr( tsb_get( 'email' ) ); ?>"><?php echo esc_html( tsb_get( 'email' ) ); ?></a></p>
		</div>
		<iframe class="map" title="Kaart" loading="lazy"
			src="https://www.openstreetmap.org/export/embed.html?bbox=5.8300%2C51.9830%2C5.8600%2C52.0000&amp;layer=mapnik&amp;marker=51.9915%2C5.8450"></iframe>
	</div>
</section>

<section class="section section-licht" id="contactformulier">
	<div class="wrap narrow">
		<h2>Contact</h2>
		<?php if ( 'ja' === $verzonden ) : ?>
			<p class="alert alert-ok">Bedankt, je bericht is verzonden.</p>
		<?php elseif ( 'fout' === $verzonden ) : ?>
			<p class="alert alert-fout">Het versturen is niet gelukt. Controleer de velden en probeer het opnieuw.</p>
		<?php endif; ?>
		<form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="tsb_contact">
			<?php wp_nonce_field( 'tsb_contact', 'tsb_nonce' ); ?>
			<input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
			<label>Naam <input type="text" name="naam" required></label>
			<label>E-mail <input type="email" name="email" required></label>
			<label>Bericht <textarea name="bericht" rows="5" required></textarea></label>
			<button class="btn" type="submit">Verzenden</button>
		</form>
	</div>
</section>
<?php get_footer(); ?>
