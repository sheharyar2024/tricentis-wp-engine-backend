/**
 * Normalize svg spacing within it's viewbox
 */
var svgs = document.getElementsByClassName("js-svg-center-path"),
	measurement = 1024;

for ( let svg of svgs ) {
	var paths = svg.getElementsByTagName( 'path' );
	for( let path of paths ){
		var bbox = path.getBBox(),
			transformx = ( ( measurement - bbox.width ) / 2 ) - bbox.x,
			transformy = ( ( measurement - bbox.height ) / 2 ) - bbox.y;
		path.setAttribute( 'style', 'transform:translateX('+transformx+'px) translateY('+transformy+'px);' );
	}
}
