( function () {
	var dlg = document.getElementById( 'product-dialog' );
	if ( ! dlg || typeof dlg.showModal !== 'function' ) {
		return;
	}
	var $ = function ( id ) { return document.getElementById( id ); };

	document.querySelectorAll( '.product-open' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			$( 'pd-img' ).src = btn.dataset.img;
			$( 'pd-img' ).alt = btn.dataset.naam;
			$( 'pd-cat' ).textContent = btn.dataset.cat;
			$( 'pd-naam' ).textContent = btn.dataset.naam;
			$( 'pd-prijs' ).textContent = '\u20ac ' + btn.dataset.prijs;
			$( 'pd-info' ).textContent = btn.dataset.info;
			dlg.showModal();
		} );
	} );

	// Klik buiten het venster sluit het.
	dlg.addEventListener( 'click', function ( e ) {
		if ( e.target === dlg ) { dlg.close(); }
	} );
} )();
