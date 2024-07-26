(function(){
	var sideScrollers = document.querySelectorAll( '[data-side-scroller]' );
	sideScrollers.forEach(( scroller, index ) => {
		const viewportHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		let lastKnownScrollPosition = 0,
			ticking = false,
			sections = scroller.querySelectorAll( '[data-side-scroller-section-index]' ),
			active = false,
			variance = 25,
			offsetHeight = (viewportHeight / 2) - variance;

		//attach scroll listener for each module
		document.addEventListener('scroll', function(e) {
			lastKnownScrollPosition = window.scrollY;

			if (!ticking) {
				window.requestAnimationFrame(function() {
					addActiveToSideScroller();
					ticking = false;
				});

				ticking = true;
			}
		},{ passive: true });

		//loop through sections and determine which one is "current"
		const addActiveToSideScroller = () => {
			const offsetVal = offsetHeight ? offsetHeight : 0;
			[...sections].some( function(section, index) {
				const itemTop = section.getBoundingClientRect().top - offsetVal;
				const itemBottom = section.getBoundingClientRect().bottom - offsetVal;
				let isActive = !((itemTop > variance) || (itemBottom < -variance));

				if( isActive ){
					changeActive( index );
					return true;
				}
			});
		};

		//determine if we need to change the active value
		const changeActive = (newActive) => {
			if( newActive === active ){
				return;
			}

			if( false !== active ){
				clearActive( active );
			}
			setActive( newActive );
			active = newActive;
		}

		//deactive old index
		const clearActive = (index) => {
			scroller.querySelector( '[data-side-scroller-nav-index="'+index+'"]' ).classList.remove( 'active' );
			scroller.querySelector( '[data-side-scroller-section-index="'+index+'"]' ).classList.remove( 'active' );
		}

		//activate new index
		const setActive = (index) => {
			scroller.querySelector( '[data-side-scroller-nav-index="'+index+'"]' ).classList.add( 'active' );
			scroller.querySelector( '[data-side-scroller-section-index="'+index+'"]' ).classList.add( 'active' );
			scroller.querySelector( '[data-side-scroller-section-index="'+index+'"]' ).classList.add( 'activated' );
		}

		//set initial value
		addActiveToSideScroller();
	});
})();