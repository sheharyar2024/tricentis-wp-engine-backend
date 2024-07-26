(function($){

	$(document).ready(function(){
		var resourceArchive = $('.module--resource-archive');

		resourceArchive.find('.js-autosubmit span').click(function(){
			var val = $(this).attr('value');
			var parentName = $(this).parent().siblings('.filter-archive__label').attr('name');
			var inputArchive = $('.js-input-archive[name="' + parentName + '"]');
			inputArchive.attr('value', val);

			$(this).parents( 'form' ).submit();
		});

		resourceArchive.find('.js-ajax').submit(function( e ){
			e.preventDefault();
			var url = $(this).data( 'ajax' ),
				target = resourceArchive.find( $(this).data( 'target' ) ),
				submitData = $(this).serializeArray(),
				submitString = $(this).serialize();
				submitData[submitData.length] = { name: 'archive', value: $(this).data( 'archive' ) };

			$.post( url, submitData, function( data ){
				target.html( data );
				anime({
					targets: resourceArchive[0].querySelectorAll('.resource-archive-query, .pagination, .title, .button, .card'),
					translateY: [100,0],
					opacity: [0,1],
					easing: 'easeOutQuad',
					duration: 500,
					delay:anime.stagger(100),
				});
				if (history.pushState) {
					var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + submitString;
					window.history.pushState({path:newurl},'',newurl);
				}
			});
		});
	});
})(jQuery);