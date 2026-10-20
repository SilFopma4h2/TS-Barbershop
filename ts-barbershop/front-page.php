<?php
get_header();
$img      = get_template_directory_uri() . '/assets/img/';
$diensten  = tsb_diensten();
$verzonden = isset( $_GET['verzonden'] ) ? sanitize_key( $_GET['verzonden'] ) : '';

$reviews = array(
	array( 'Harry', 'Heel goede kapper.En voordelig.' ),
	array( 'Floris', 'Erg goede kapper, houdt rekening met de wens van de klant.' ),
	array( 'Google-recensie', 'Goeie zaak mooie prijs en doe wat er gevraagt word in een woord top tent' ),
	array( 'Google-recensie', 'Fijne zaak snel geholpen goede prijs/kwaliteit' ),
	array( 'Google-recensie', 'Altijd top, knipt super goed en goede prijs. Mooie fade ook.' ),
);

$producten = array(
	array( 'Nish Man Wax Rugby', '6', 'product-nish-man-wax-rugby.png', 'Haarwax', 'Haarwax om je kapsel te stylen en in model te houden.' ),
	array( 'Nish Man Wax Keratine', '6', 'product-nish-man-wax-keratine.png', 'Haarwax', 'Haarwax met keratine om je kapsel te stylen en in model te houden.' ),
	array( 'Nish Man Gel Mystic Gummy', '6', 'product-nish-man-gel-mystic-gummy.png', 'Haargel', 'Stylinggel voor een strak gestyled kapsel.' ),
	array( 'Nish Man Shampoo', '6', 'product-nish-man-shampoo.png', 'Shampoo', 'Shampoo voor heren om je haar te wassen.' ),
	array( 'Mr Rebel Black', '10', 'product-mr-rebel-black.png', 'Verzorging', 'Verzorgingsproduct van Mr Rebel, uitvoering Black.' ),
	array( 'Mr Rebel Red', '10', 'product-mr-rebel-red.png', 'Verzorging', 'Verzorgingsproduct van Mr Rebel, uitvoering Red.' ),
	array( 'Cologne', '6', 'product-cologne.jpg', 'Cologne', 'Cologne voor een frisse geur na het knippen of scheren.' ),
	array( 'Shaving gel', '10', 'product-shaving-gel.png', 'Scheren', 'Scheergel voor een soepele, gladde scheerbeurt.' ),
);
?>
<section class="hero">
	<div class="wrap hero-inner">
		<div>
			<span class="status" role="status">Openingstijden laden…</span>
			<span class="eyebrow">Oosterbeek</span>
			<h1>Barbershop Oosterbeek</h1>
			<p>Knippen en baard scheren voor dames, heren en kinderen. Kom langs of reserveer online.</p>
			<a class="btn" href="<?php echo esc_url( tsb_afspraak_url() ); ?>">Reserveer nu online</a><a class="btn btn-ghost" href="#prijzen">Bekijk prijzen</a>
			<div class="hero-facts">
				<div><strong>Di t/m za</strong>09:30 - 18:00</div>
				<div><strong><?php echo esc_html( strtok( tsb_get( 'adres' ), "\n" ) ); ?></strong><?php echo esc_html( trim( substr( tsb_get( 'adres' ), strpos( tsb_get( 'adres' ) . "\n", "\n" ) ) ) ); ?></div>
				<div><strong><?php echo esc_html( tsb_get( 'telefoon' ) ); ?></strong>Bel gerust</div>
			</div>
		</div>
	</div>
</section>

<section class="section" id="diensten">
	<div class="wrap">
		<span class="eyebrow">Behandelingen</span>
		<h2>Wat we doen</h2>
		<p class="lead">Van een snelle knipbeurt tot een nette baard.</p>
		<ul class="cards">
			<?php foreach ( $diensten as $d ) : ?>
				<li>
					<a href="<?php echo esc_url( tsb_afspraak_url( $d['slug'] ) ); ?>">
						<img src="<?php echo esc_url( $img . $d['img'] ); ?>" alt="" width="150" height="150" loading="lazy">
						<span><?php echo esc_html( $d['naam'] ); ?></span>
						<em class="kaart-cta">Afspraak maken &rarr;</em>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section section-licht" id="prijzen">
	<div class="wrap">
		<span class="eyebrow">Prijzen</span>
		<h2>Wat het kost</h2>
		<div class="narrow" style="margin:2rem auto 0">
		<div class="panel"><table class="price-table">
			<?php foreach ( tsb_pairs( tsb_get( 'prijzen' ) ) as $row ) : ?>
				<tr><th scope="row"><?php echo esc_html( $row[0] ); ?></th><td>&euro; <?php echo esc_html( $row[1] ); ?></td></tr>
			<?php endforeach; ?>
		</table></div>
		<p class="note"><?php echo esc_html( tsb_get( 'prijsnoot' ) ); ?></p>
		</div>

		<h3 class="subtitle">Producten</h3>
		<p class="lead">Alle producten zijn te koop in de winkel. Klik op een product voor meer informatie.</p>
		<ul class="products">
			<?php foreach ( $producten as $p ) : ?>
				<li>
					<button type="button" class="product-open" data-naam="<?php echo esc_attr( $p[0] ); ?>" data-prijs="<?php echo esc_attr( $p[1] ); ?>" data-img="<?php echo esc_url( $img . $p[2] ); ?>" data-cat="<?php echo esc_attr( $p[3] ); ?>" data-info="<?php echo esc_attr( $p[4] ); ?>" aria-haspopup="dialog">
						<span class="thumb"><img src="<?php echo esc_url( $img . $p[2] ); ?>" alt="" loading="lazy"></span>
						<span class="info"><span class="naam"><?php echo esc_html( $p[0] ); ?></span><span class="prijs">&euro; <?php echo esc_html( $p[1] ); ?></span></span>
						<span class="meer">Meer info</span>
					</button>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section" id="reviews">
	<div class="wrap">
		<span class="eyebrow">Over ons</span>
		<h2>Wat onze klanten zeggen</h2>
		<ul class="reviews">
			<?php foreach ( $reviews as $r ) : ?>
				<li><blockquote class="review"><p><?php echo esc_html( $r[1] ); ?></p><footer><?php echo esc_html( $r[0] ); ?></footer></blockquote></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section" id="afspraak">
	<div class="wrap narrow cta-blok">
		<span class="eyebrow">Afspraak maken</span>
		<h2>Kies je behandeling en reserveer online</h2>
		<p class="lead">Klik op een behandeling hierboven, of ga direct naar de agenda.</p>
		<a class="btn" href="<?php echo esc_url( tsb_afspraak_url() ); ?>">Naar de agenda</a>
		<p class="note"><?php echo esc_html( tsb_get( 'annulering' ) ); ?></p>
	</div>
</section>

<section class="section section-donker" id="openingstijden" data-hours="<?php echo esc_attr( tsb_hours_json() ); ?>">
	<div class="wrap narrow">
		<span class="eyebrow">Wanneer</span>
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
			<p><a class="btn route-knop" href="<?php echo esc_url( 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( str_replace( "\n", ' ', tsb_get( 'adres' ) ) ) ); ?>" target="_blank" rel="noopener">Route plannen</a></p>
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
<dialog id="product-dialog" class="product-dialog" aria-labelledby="pd-naam">
	<form method="dialog"><button class="pd-close" aria-label="Sluiten">&times;</button></form>
	<div class="pd-img"><img id="pd-img" src="" alt=""></div>
	<div class="pd-body">
		<span class="pd-cat" id="pd-cat"></span>
		<h3 id="pd-naam"></h3>
		<p class="pd-prijs" id="pd-prijs"></p>
		<p id="pd-info"></p>
		<p class="pd-winkel">Te koop in de winkel · <?php echo esc_html( strtok( tsb_get( 'adres' ), "\n" ) ); ?>, Oosterbeek</p>
		<p class="note">Vraag gerust de barber om advies.</p>
	</div>
</dialog>
<?php get_footer(); ?>
