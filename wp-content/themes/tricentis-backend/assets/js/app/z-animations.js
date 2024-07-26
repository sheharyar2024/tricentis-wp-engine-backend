/**
 * Animations are last to make sure other effects or movement happen first as height calculations can affect this
 */

//this removes our fallback css animations - each module should have a fallback animation to set its opacity to 1
var body = document.querySelector( 'body' );
body.classList.remove('no-js');

(function(){

	//this is the most basic animation example, but please make more specific ones per module and remove this one.
	//https://animejs.com/documentation/
	const modules = document.querySelectorAll('.module');
	modules.forEach((module,i) => {
		module.waypoint = new Waypoint({
			element: module,
			handler: function(direction) {
				anime({
					targets: module,
					opacity: [ 0, 1 ],
					translateY: [ 200, 0],
					delay: anime.stagger( 100 )
				});
				this.destroy();
			},
			offset: "90%",
		});
	});

	/*
	const basic_text = document.querySelectorAll('.module--basic_text');
	basic_text.forEach((module,i) => {
		module.waypoint = new Waypoint({
			element: module,
			handler: function(direction) {
				anime({
					targets: module.querySelectorAll('.title, p, .button'),
					translateY: [100,0],
					opacity: [0,1],
					delay: anime.stagger(100) // delay starts at 500ms then increase by 100ms for each elements.
				});
				this.destroy();
			},
			offset: "90%",
		});
	});
	*/

})();
