(function () {
	var youtubeVideos = document.querySelectorAll('.js-youtube-video');
	if (youtubeVideos.length > 0) {
		var tag = document.createElement('script');
		tag.src = "https://www.youtube.com/iframe_api";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	}

	var vimeoVideos = document.querySelectorAll('.js-vimeo-video');
	if (vimeoVideos.length > 0) {
		var tag = document.createElement('script');
		tag.src = "https://player.vimeo.com/api/player.js";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	}

	var wistiaVideos = document.querySelectorAll('.js-wistia-video');
	if (wistiaVideos.length > 0) {
		var tag = document.createElement('script');
		tag.src = "https://fast.wistia.com/assets/external/E-v1.js";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	}

	var embedVideos = document.querySelectorAll('.js-embed');
	embedVideos.forEach((video, i) => {
		var service = video.getAttribute('data-video-service'),
			id = video.getAttribute('data-video-id'),
			iframe = video.querySelector('iframe'),
			button = video.querySelector('button');
		button.addEventListener('click', playVideo);

		//set iframe src so it will load while fading out -> removing button
		function playVideo(e) {
			e.preventDefault();
			var video_url = iframe.dataset.src;
			if ('wistia' != service) {
				video_url += '&autoplay=1&rel=0&wmode=transparent';
			} else {
				video_url = `https://fast.wistia.net/embed/iframe/${id}?autoplay=1`;
			}
			iframe.src = video_url;
			anime({
				targets: button,
				opacity: [1, 0],
				easing: 'easeInOutQuad',
				duration: 500,
				complete: function (anim) {
					button.remove();
				}
			});
		}
	});

})();

function onYouTubeIframeAPIReady() {
	jQuery('.youtube-background-video').each(function () {
		var video = jQuery(this).data('video'),
			id = jQuery(this).attr('id'),
			player = new YT.Player(id, {
				height: '360',
				width: '640',
				videoId: video,
				playerVars: { 'controls': 0, 'showinfo': 0, 'rel': 0, 'enablejsapi': 1, 'autoplay': 1, 'loop': 1, 'wmode': 'transparent' },
				events: {
					'onReady': function (e) {
						e.target.playVideo();
						e.target.mute();
						e.target.setPlaybackQuality('hd720');
					},
					onStateChange: function (e) {
						if (e.data === YT.PlayerState.ENDED) {
							e.target.playVideo();
						}
					}
				}
			});
	});
}

(function ($) {
	$(function () {
		$(".js-youtube-video").each(function () {
			var button = $(this);
			$(this).on('click', function () {
				var video = button.data('video'),
					id = $(this).attr('id'),
					player = new YT.Player(id, {
						height: '360',
						width: '640',
						videoId: video,
						playerVars: { 'controls': 1, 'showinfo': 0, 'rel': 0, 'enablejsapi': 1, 'autoplay': 1, 'wmode': 'transparent' },
						events: {
							'onReady': function (e) {
								e.target.playVideo();
								e.target.setPlaybackQuality('hd720');
							}
						}
					});
			});
		});
		$(".js-vimeo-video").each(function () {
			var button = $(this);
			$(this).on('click', function () {
				var video = button.data('video'),
					id = $(this).parent('div'),
					vimeoPlayer = new Vimeo.Player(id, { id: video });
				vimeoPlayer.play();
			});
		});
		$(".js-wistia-video").each(function () {
			var button = $(this);
			$(this).on('click', function () {
				var video = button.data('video'),
					id = $(this).parent('div');
				id.removeClass().attr('id', "wistia-" + video + "-1").addClass('wistia_embed autoPlay=true wistia_async_' + video);
				var wistiaPlayer = Wistia.api(video);
			});
		});
		$(".video-button").each(function () {
			var button = $(this);
			$(this).magnificPopup({
				type: 'iframe',
				iframe: {
					//tell iframe that it can autoplay and fullscreen -- chrome needs this to help meet autplay conditions
					markup: '<div class="mfp-iframe-scaler">' +
						'<div class="mfp-close"></div>' +
						'<iframe class="mfp-iframe wistia_embed" src="//about:blank" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" frameborder="0" allowfullscreen allowautoplay></iframe>' +
						'</div>',
					patterns: {
						//we override default magnific since our module spits out the embed player already
						youtube: {
							index: 'youtube.com',
							id: '/',
							src: '//www.youtube.com/embed/%id%?autoplay=1&rel=0&wmode=transparent'
						},
						vimeo: {
							index: 'vimeo.com',
							id: '/',
							src: '//player.vimeo.com/video/%id%?autoplay=1&rel=0&wmode=transparent'
						},
						//if client is not using wistia, you can comment these out
						wistiacom: {
							index: 'wistia.com',
							id: function (url) {
								var m = url.match(/^.+wistia.com\/(medias)\/([^_]+)[^#]*(#medias=([^_&]+))?/);
								if (m !== null) {
									if (m[4] !== undefined) {
										return m[4];
									}
									return m[2];
								}
								return null;
							},
							src: '//fast.wistia.net/embed/iframe/%id%?autoPlay=1' // https://wistia.com/doc/embed-options#options_list
						},
						wistianet: {
							index: 'wistia.net',
							id: function (url) {
								var m = url.match(/^.+wistia.net\/embed\/iframe\/([^_]+)/);
								if (m !== null) {
									return m[1];
								}
								return null;
							},
							src: '//fast.wistia.net/embed/iframe/%id%?autoPlay=1' // https://wistia.com/doc/embed-options#options_list
						}
					},
				}
			});
		});
	});
})(jQuery);