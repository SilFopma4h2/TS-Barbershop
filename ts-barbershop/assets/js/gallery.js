( function () {
	var links = document.querySelectorAll( '.galerij a, .galerij-inhoud .wp-block-gallery a, .galerij-inhoud .gallery a' );
	if ( ! links.length || typeof HTMLDialogElement === 'undefined' ) {
		return;
	}
	var dlg = document.createElement( 'dialog' );
	dlg.className = 'lightbox';
	dlg.setAttribute( 'aria-label', 'Foto groot bekijken' );
	dlg.innerHTML = '<button type="button" class="lb-close" aria-label="Sluiten">&times;</button>' +
		'<button type="button" class="lb-nav lb-prev" aria-label="Vorige foto">&lsaquo;</button>' +
		'<img alt=""><button type="button" class="lb-nav lb-next" aria-label="Volgende foto">&rsaquo;</button>';
	document.body.appendChild( dlg );
	var img = dlg.querySelector( 'img' );
	var cur = 0;

	function show( i ) {
		cur = ( i + links.length ) % links.length;
		var a = links[ cur ], thumb = a.querySelector( 'img' );
		img.src = a.getAttribute( 'href' );
		img.alt = thumb ? thumb.alt : '';
	}
	links.forEach( function ( a, i ) {
		a.addEventListener( 'click', function ( e ) {
			if ( ! /\.(jpe?g|png|webp|gif)(\?|$)/i.test( a.getAttribute( 'href' ) ) ) { return; }
			e.preventDefault();
			show( i );
			dlg.showModal();
		} );
	} );
	dlg.querySelector( '.lb-close' ).addEventListener( 'click', function () { dlg.close(); } );
	dlg.querySelector( '.lb-prev' ).addEventListener( 'click', function () { show( cur - 1 ); } );
	dlg.querySelector( '.lb-next' ).addEventListener( 'click', function () { show( cur + 1 ); } );
	dlg.addEventListener( 'click', function ( e ) { if ( e.target === dlg ) { dlg.close(); } } );
	dlg.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'ArrowLeft' ) { show( cur - 1 ); }
		if ( e.key === 'ArrowRight' ) { show( cur + 1 ); }
	} );
} )();
