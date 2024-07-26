(function(){
	/**
	 * example for controlling other items using custom events
	 */
	var tablist = document.querySelectorAll('[data-tabber]');
	tablist.forEach((item,i) => {
		var underline = item.querySelector( '.button-underline' );
		if( underline ){
			item.addEventListener('tabber:duringActivation',function(e){
				var tab = e.detail.tab;
				underline.style.left = tab.offsetLeft + 'px';
				underline.style.width = tab.offsetWidth + 'px';
			});
		}
	});
}());

/*
*   This content is licensed according to the W3C Software License at
*   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
*/
(function () {
	var tablist = document.querySelectorAll('[data-tabber]'),
		keys = {
			end: 35,
			home: 36,
			left: 37,
			up: 38,
			right: 39,
			down: 40,
			enter: 13,
			space: 32
		},
		direction = {
			37: -1,
			38: -1,
			39: 1,
			40: 1
		};

	tablist.forEach((item, j) => {
		var self = item,
			tabs = item.querySelectorAll('[role="tab"]'),
			panels = item.querySelectorAll('[role="tabpanel"]'),
			vertical = item.getAttribute('aria-orientation') === 'vertical',
			automatic = item.getAttribute( 'data-tabber-automatic' ),
			timing = item.getAttribute( 'data-tabber-timing' ) || 200,
			currentTab = null;

		item.classList.add( 'js-active' );

		tabs.forEach((tab, i) => {
			tab.addEventListener('click', clickEventListener);
			tab.addEventListener('keydown', keydownEventListener);

			//this is used for keypress direction determination
			tab.index = i;
		});

		panels.forEach((panel) => {
			panel.setAttribute( 'hidden', 'hidden' );
		});

		// When a tab is clicked, activateTab is fired to activate it
		function clickEventListener (event) {
			var tab = event.target;
			activateTab( tab, true );
		};

		//navigate to a particular tab, if automatic change is active, also activate tab
		function navigateTab( tab ){
			tab.focus();
			if( automatic ){
				activateTab( tab, true );
			}
		}

		//deactivate last tab
		function deactivateTab( tab ){
			tab.setAttribute('tabindex', '-1');
			tab.setAttribute('aria-selected', 'false');

			var panel = document.getElementById( tab.getAttribute('aria-controls') );
			panel.classList.remove( 'active' );
			panel.classList.add( 'transition--out' );
			panel.setAttribute( 'tabindex', -1 );
			setTimeout( function(){
				panel.setAttribute( 'hidden', 'hidden' );
				panel.classList.remove( 'transition--out' );
			}, timing );
		}

		//activate new tab
		function activateTab (tab, setFocus ) {
			setFocus = setFocus || false;

			self.dispatchEvent(new CustomEvent('tabber:beforeActivation', { bubbles: true, detail: { tabber: self, tab: tab }}));

			//prevent action if tab is already current
			if( tab === currentTab ){
				return;
			}

			if( currentTab ){
				deactivateTab( currentTab );
			}
			currentTab = tab;

			// Get the value of aria-controls (which is an ID)
			var controls = tab.getAttribute('aria-controls');

			//set tab attributes
			tab.setAttribute('tabindex', 0 );
			tab.setAttribute('aria-selected', 'true');

			//set panel attributes
			var panel = document.getElementById(controls);
			panel.removeAttribute( 'hidden' );
			panel.setAttribute( 'tabindex', 0 );
			panel.classList.add('transition--in')
			self.dispatchEvent(new CustomEvent('tabber:duringActivation', { bubbles: true, detail: { tabber: self, tab: tab }}));
			setTimeout( function(){
				panel.classList.add( 'active' );
				panel.classList.remove( 'transition--in' );
				self.dispatchEvent(new CustomEvent('tabber:afterActivation', { bubbles: true, detail: { tabber: self, tab: tab }}));
			}, timing );

			// Set focus when required
			if (setFocus) {
				tab.focus();
			};
		};

		var hash = window.location.hash.substr(1);
		if( '' !== hash && document.getElementById( hash ).getAttribute( 'role' ) === 'tab' ){
			activateTab( document.getElementById( hash ), false );
		}else{
			activateTab( tabs[0], false );
		}

		// Handle keydown on tabs
		function keydownEventListener (event) {
			var event = event || window.event,
				key = event.keyCode || event.which;

			switch (key) {
				case keys.end:
					event.preventDefault();
					// Activate last tab
					focusLastTab();
				break;
				case keys.home:
					event.preventDefault();
					// Activate first tab
					focusFirstTab();
				break;

				//handle navigation based on orientation
				case keys.up:
				case keys.down:
				case keys.left:
				case keys.right:
					determineOrientation(event);
				break;
				case keys.enter:
				case keys.space:
					if( false === automatic ){
						e.preventDefault();
						activateTab(event.target);
					}
				break;
			};
		};

		// When a tablist's aria-orientation is set to vertical,
		// only up and down arrow should function.
		// In all other cases only left and right arrow function.
		function determineOrientation (event) {
			var event = event || window.event,
				key = event.keyCode || event.which,
				proceed = false;

			if (vertical) {
				if (key === keys.up || key === keys.down) {
					event.preventDefault();
					proceed = true;
				};
			}
			else {
				if (key === keys.left || key === keys.right) {
					proceed = true;
				};
			};

			if (proceed) {
				switchTabOnArrowPress(event);
			};
		};

		// Either focus the next, previous, first, or last tab
		// depending on key pressed
		function switchTabOnArrowPress (event) {
			var event = event || window.event,
				key = event.keyCode || event.which;

			if (direction[key]) {
				var target = event.target;
				if (target.index !== undefined) {
					if (tabs[target.index + direction[key]]) {
						navigateTab( tabs[target.index + direction[key]] );
					}
					else if (key === keys.left || key === keys.up) {
						focusLastTab();
					}
					else if (key === keys.right || key == keys.down) {
						focusFirstTab();
					};
				};
			};
		};

		// Make a guess
		function focusFirstTab () {
			navigateTab( tabs[0] );
		};

		// Make a guess
		function focusLastTab () {
			navigateTab( tabs[tabs.length - 1] );
		};
	});
}());