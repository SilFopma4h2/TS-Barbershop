( function () {
	// Uren: data-hours op #openingstijden, bv. {"1":null,"2":["09:30","18:00"],...} (0 = zondag).
	var section = document.getElementById( 'openingstijden' );
	var badge = document.querySelector( '.status' );
	var hours = {};
	try { hours = JSON.parse( section.getAttribute( 'data-hours' ) ); } catch ( e ) { hours = {}; }

	function mins( t ) { var p = t.split( ':' ); return parseInt( p[0], 10 ) * 60 + parseInt( p[1], 10 ); }
	var days = [ 'zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag' ];

	var now = new Date();
	var today = hours[ now.getDay() ];
	var cur = now.getHours() * 60 + now.getMinutes();

	if ( badge && Object.keys( hours ).length ) {
		if ( today && cur >= mins( today[0] ) && cur < mins( today[1] ) ) {
			badge.className = 'status is-open';
			badge.textContent = 'Nu open \u00b7 tot ' + today[1];
		} else {
			var text = 'Nu gesloten';
			for ( var i = 0; i < 8; i++ ) {
				var d = ( now.getDay() + i ) % 7, h = hours[ d ];
				if ( h && ( i > 0 || cur < mins( h[0] ) ) ) {
					text += ' \u00b7 open ' + ( i === 0 ? 'vandaag' : i === 1 ? 'morgen' : days[ d ] ) + ' om ' + h[0];
					break;
				}
			}
			badge.className = 'status is-closed';
			badge.textContent = text;
		}
	}

	// Vandaag markeren in de openingstijden.
	var rows = section ? section.querySelectorAll( 'tr' ) : [];
	for ( var r = 0; r < rows.length; r++ ) {
		var th = rows[r].querySelector( 'th' );
		if ( th && th.textContent.trim().toLowerCase() === days[ now.getDay() ] ) { rows[r].className = 'is-today'; }
	}

	// Actieve sectie in het menu.
	var links = document.querySelectorAll( '.site-nav a[href*="#"]' );
	if ( 'IntersectionObserver' in window && links.length ) {
		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( e ) {
				if ( ! e.isIntersecting ) { return; }
				links.forEach( function ( a ) { a.classList.toggle( 'is-active', a.getAttribute( 'href' ).slice( -( e.target.id.length + 1 ) ) === '#' + e.target.id ); } );
			} );
		}, { rootMargin: '-40% 0px -55% 0px' } );
		document.querySelectorAll( 'main section[id]' ).forEach( function ( s ) { io.observe( s ); } );
	}

	// Formulier: knop toont dat er iets gebeurt.
	var form = document.querySelector( '.contact-form' );
	if ( form ) {
		form.addEventListener( 'submit', function ( e ) {
			var btn = form.querySelector( 'button[type="submit"]' );
			if ( form.hasAttribute( 'data-demo' ) ) {
				e.preventDefault();
				btn.disabled = true; btn.textContent = 'Versturen\u2026';
				setTimeout( function () {
					btn.disabled = false; btn.textContent = 'Verzenden'; form.reset();
					var msg = document.createElement( 'p' );
					msg.className = 'alert alert-ok'; msg.setAttribute( 'role', 'status' );
					msg.textContent = 'Bedankt, je bericht is verzonden.';
					form.parentNode.insertBefore( msg, form );
					setTimeout( function () { msg.remove(); }, 5000 );
				}, 900 );
				return;
			}
			btn.disabled = true; btn.textContent = 'Versturen\u2026';
		} );
	}
} )();
