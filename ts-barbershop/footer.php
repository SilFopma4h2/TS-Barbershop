</main>
<footer class="site-footer">
	<div class="wrap footer-inner">
		<div>
			<strong><?php bloginfo( 'name' ); ?></strong><br>
			<?php echo nl2br( esc_html( tsb_get( 'adres' ) ) ); ?>
		</div>
		<div>
			<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', tsb_get( 'telefoon' ) ) ); ?>"><?php echo esc_html( tsb_get( 'telefoon' ) ); ?></a><br>
			<a href="mailto:<?php echo esc_attr( tsb_get( 'email' ) ); ?>"><?php echo esc_html( tsb_get( 'email' ) ); ?></a>
		</div>
		<div>
			<?php if ( tsb_get( 'facebook' ) ) : ?>
				<a href="<?php echo esc_url( tsb_get( 'facebook' ) ); ?>" target="_blank" rel="noopener">Facebook</a><br>
			<?php endif; ?>
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
