<?php
/**
 * Foto galerij (pagina met slug "foto-galerij").
 * Staat er inhoud in de pagina (bijvoorbeeld een Galerij-blok), dan tonen we die. Anders tonen we alle
 * foto's uit assets/img/galerij/ (nieuwe foto's daar neerzetten is genoeg).
 */
get_header();
$map   = get_template_directory() . '/assets/img/galerij/';
$url   = get_template_directory_uri() . '/assets/img/galerij/';
$fotos = glob( $map . '*.{jpg,jpeg,png,webp}', GLOB_BRACE );
sort( $fotos );
?>
<section class="section section-licht">
	<div class="wrap">
		<a class="terug" href="<?php echo esc_url( home_url( '/' ) ); ?>">&larr; Terug naar home</a>
		<span class="eyebrow">Foto&rsquo;s</span>
		<h1 class="pagina-titel">Foto galerij</h1>
		<?php if ( have_posts() ) : the_post(); endif; ?>
		<?php if ( trim( get_the_content() ) ) : ?>
			<div class="galerij-inhoud"><?php the_content(); ?></div>
		<?php elseif ( $fotos ) : ?>
			<ul class="galerij">
				<?php foreach ( $fotos as $i => $pad ) : ?>
					<li><a href="<?php echo esc_url( $url . basename( $pad ) ); ?>"><img src="<?php echo esc_url( $url . basename( $pad ) ); ?>" alt="Foto <?php echo (int) ( $i + 1 ); ?> uit Barbershop Oosterbeek" loading="lazy"></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
