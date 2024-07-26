"use strict";

(function ($) {
  $(document).ready(function () {
    var resourceArchive = $('.module--resource-archive');
    resourceArchive.find('.js-autosubmit span').click(function () {
      var val = $(this).attr('value');
      var parentName = $(this).parent().siblings('.filter-archive__label').attr('name');
      var inputArchive = $('.js-input-archive[name="' + parentName + '"]');
      inputArchive.attr('value', val);
      $(this).parents('form').submit();
    });
    resourceArchive.find('.js-ajax').submit(function (e) {
      e.preventDefault();
      var url = $(this).data('ajax'),
        target = resourceArchive.find($(this).data('target')),
        submitData = $(this).serializeArray(),
        submitString = $(this).serialize();
      submitData[submitData.length] = {
        name: 'archive',
        value: $(this).data('archive')
      };
      $.post(url, submitData, function (data) {
        target.html(data);
        anime({
          targets: resourceArchive[0].querySelectorAll('.resource-archive-query, .pagination, .title, .button, .card'),
          translateY: [100, 0],
          opacity: [0, 1],
          easing: 'easeOutQuad',
          duration: 500,
          delay: anime.stagger(100)
        });
        if (history.pushState) {
          var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + submitString;
          window.history.pushState({
            path: newurl
          }, '', newurl);
        }
      });
    });
  });
})(jQuery);
"use strict";

(function ($) {
  $(function () {
    $('.js-case-study-slider').slick({
      infinite: true,
      adaptiveHeight: true,
      fade: true,
      speed: 10
    });
  });
})(jQuery);
"use strict";

(function ($) {
  $(function () {
    $('.image-slider').slick({
      infinite: true,
      variableWidth: true,
      centerMode: true
    });
  });
})(jQuery);
"use strict";

(function ($) {
  $(function () {
    $('.js-logo-slider').slick({
      infinite: true,
      adaptiveHeight: true,
      fade: true,
      speed: 10
    });
  });
})(jQuery);
"use strict";

/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function () {
  var container, button, menu, links, i, len;
  container = document.getElementById('site-navigation');
  if (!container) {
    return;
  }
  button = container.getElementsByTagName('button')[0];
  if ('undefined' === typeof button) {
    return;
  }
  menu = container.getElementsByTagName('ul')[0];

  // Hide menu toggle button if menu is empty and return early.
  if ('undefined' === typeof menu) {
    button.style.display = 'none';
    return;
  }
  if (-1 === menu.className.indexOf('nav-menu')) {
    menu.className += ' nav-menu';
  }
  button.onclick = function () {
    if (-1 !== container.className.indexOf('toggled')) {
      container.className = container.className.replace(' toggled', '');
      button.setAttribute('aria-expanded', 'false');
    } else {
      container.className += ' toggled';
      button.setAttribute('aria-expanded', 'true');
    }
  };

  // Close small menu when user clicks outside
  document.addEventListener('click', function (event) {
    var isClickInside = container.contains(event.target);
    if (!isClickInside) {
      container.className = container.className.replace(' toggled', '');
      button.setAttribute('aria-expanded', 'false');
    }
  });

  // Get all the link elements within the menu.
  links = menu.getElementsByTagName('a');

  // Each time a menu link is focused or blurred, toggle focus.
  for (i = 0, len = links.length; i < len; i++) {
    links[i].addEventListener('focus', toggleFocus, true);
    links[i].addEventListener('blur', toggleFocus, true);
  }

  /**
   * Sets or removes .focus class on an element.
   */
  function toggleFocus() {
    var self = this;

    // Move up through the ancestors of the current link until we hit .nav-menu.
    while (-1 === self.className.indexOf('nav-menu')) {
      // On li elements toggle the class .focus.
      if ('li' === self.tagName.toLowerCase()) {
        if (-1 !== self.className.indexOf('focus')) {
          self.className = self.className.replace(' focus', '');
        } else {
          self.className += ' focus';
        }
      }
      self = self.parentElement;
    }
  }

  /**
   * Toggles `focus` class to allow submenu access on tablets.
   */
  (function () {
    var touchStartFn,
      parentLink = container.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');
    if ('ontouchstart' in window) {
      touchStartFn = function touchStartFn(e) {
        var menuItem = this.parentNode;
        if (!menuItem.classList.contains('focus')) {
          e.preventDefault();
          for (i = 0; i < menuItem.parentNode.children.length; ++i) {
            if (menuItem === menuItem.parentNode.children[i]) {
              continue;
            }
            menuItem.parentNode.children[i].classList.remove('focus');
          }
          menuItem.classList.add('focus');
        } else {
          menuItem.classList.remove('focus');
        }
      };
      for (i = 0; i < parentLink.length; ++i) {
        parentLink[i].addEventListener('touchstart', touchStartFn, false);
      }
    }
  })(container);
})();
"use strict";

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }
function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
(function () {
  var sideScrollers = document.querySelectorAll('[data-side-scroller]');
  sideScrollers.forEach(function (scroller, index) {
    var viewportHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    var lastKnownScrollPosition = 0,
      ticking = false,
      sections = scroller.querySelectorAll('[data-side-scroller-section-index]'),
      active = false,
      variance = 25,
      offsetHeight = viewportHeight / 2 - variance;

    //attach scroll listener for each module
    document.addEventListener('scroll', function (e) {
      lastKnownScrollPosition = window.scrollY;
      if (!ticking) {
        window.requestAnimationFrame(function () {
          addActiveToSideScroller();
          ticking = false;
        });
        ticking = true;
      }
    }, {
      passive: true
    });

    //loop through sections and determine which one is "current"
    var addActiveToSideScroller = function addActiveToSideScroller() {
      var offsetVal = offsetHeight ? offsetHeight : 0;
      _toConsumableArray(sections).some(function (section, index) {
        var itemTop = section.getBoundingClientRect().top - offsetVal;
        var itemBottom = section.getBoundingClientRect().bottom - offsetVal;
        var isActive = !(itemTop > variance || itemBottom < -variance);
        if (isActive) {
          changeActive(index);
          return true;
        }
      });
    };

    //determine if we need to change the active value
    var changeActive = function changeActive(newActive) {
      if (newActive === active) {
        return;
      }
      if (false !== active) {
        clearActive(active);
      }
      setActive(newActive);
      active = newActive;
    };

    //deactive old index
    var clearActive = function clearActive(index) {
      scroller.querySelector('[data-side-scroller-nav-index="' + index + '"]').classList.remove('active');
      scroller.querySelector('[data-side-scroller-section-index="' + index + '"]').classList.remove('active');
    };

    //activate new index
    var setActive = function setActive(index) {
      scroller.querySelector('[data-side-scroller-nav-index="' + index + '"]').classList.add('active');
      scroller.querySelector('[data-side-scroller-section-index="' + index + '"]').classList.add('active');
      scroller.querySelector('[data-side-scroller-section-index="' + index + '"]').classList.add('activated');
    };

    //set initial value
    addActiveToSideScroller();
  });
})();
"use strict";

/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
(function () {
  var isIe = /(trident|msie)/i.test(navigator.userAgent);
  if (isIe && document.getElementById && window.addEventListener) {
    window.addEventListener('hashchange', function () {
      var id = location.hash.substring(1),
        element;
      if (!/^[A-z0-9_-]+$/.test(id)) {
        return;
      }
      element = document.getElementById(id);
      if (element) {
        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
          element.tabIndex = -1;
        }
        element.focus();
      }
    }, false);
  }
})();
"use strict";

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
/**
 * Normalize svg spacing within it's viewbox
 */
var svgs = document.getElementsByClassName("js-svg-center-path"),
  measurement = 1024;
var _iterator = _createForOfIteratorHelper(svgs),
  _step;
try {
  for (_iterator.s(); !(_step = _iterator.n()).done;) {
    var svg = _step.value;
    var paths = svg.getElementsByTagName('path');
    var _iterator2 = _createForOfIteratorHelper(paths),
      _step2;
    try {
      for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
        var path = _step2.value;
        var bbox = path.getBBox(),
          transformx = (measurement - bbox.width) / 2 - bbox.x,
          transformy = (measurement - bbox.height) / 2 - bbox.y;
        path.setAttribute('style', 'transform:translateX(' + transformx + 'px) translateY(' + transformy + 'px);');
      }
    } catch (err) {
      _iterator2.e(err);
    } finally {
      _iterator2.f();
    }
  }
} catch (err) {
  _iterator.e(err);
} finally {
  _iterator.f();
}
"use strict";

(function () {
  /**
   * example for controlling other items using custom events
   */
  var tablist = document.querySelectorAll('[data-tabber]');
  tablist.forEach(function (item, i) {
    var underline = item.querySelector('.button-underline');
    if (underline) {
      item.addEventListener('tabber:duringActivation', function (e) {
        var tab = e.detail.tab;
        underline.style.left = tab.offsetLeft + 'px';
        underline.style.width = tab.offsetWidth + 'px';
      });
    }
  });
})();

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
  tablist.forEach(function (item, j) {
    var self = item,
      tabs = item.querySelectorAll('[role="tab"]'),
      panels = item.querySelectorAll('[role="tabpanel"]'),
      vertical = item.getAttribute('aria-orientation') === 'vertical',
      automatic = item.getAttribute('data-tabber-automatic'),
      timing = item.getAttribute('data-tabber-timing') || 200,
      currentTab = null;
    item.classList.add('js-active');
    tabs.forEach(function (tab, i) {
      tab.addEventListener('click', clickEventListener);
      tab.addEventListener('keydown', keydownEventListener);

      //this is used for keypress direction determination
      tab.index = i;
    });
    panels.forEach(function (panel) {
      panel.setAttribute('hidden', 'hidden');
    });

    // When a tab is clicked, activateTab is fired to activate it
    function clickEventListener(event) {
      var tab = event.target;
      activateTab(tab, true);
    }
    ;

    //navigate to a particular tab, if automatic change is active, also activate tab
    function navigateTab(tab) {
      tab.focus();
      if (automatic) {
        activateTab(tab, true);
      }
    }

    //deactivate last tab
    function deactivateTab(tab) {
      tab.setAttribute('tabindex', '-1');
      tab.setAttribute('aria-selected', 'false');
      var panel = document.getElementById(tab.getAttribute('aria-controls'));
      panel.classList.remove('active');
      panel.classList.add('transition--out');
      panel.setAttribute('tabindex', -1);
      setTimeout(function () {
        panel.setAttribute('hidden', 'hidden');
        panel.classList.remove('transition--out');
      }, timing);
    }

    //activate new tab
    function activateTab(tab, setFocus) {
      setFocus = setFocus || false;
      self.dispatchEvent(new CustomEvent('tabber:beforeActivation', {
        bubbles: true,
        detail: {
          tabber: self,
          tab: tab
        }
      }));

      //prevent action if tab is already current
      if (tab === currentTab) {
        return;
      }
      if (currentTab) {
        deactivateTab(currentTab);
      }
      currentTab = tab;

      // Get the value of aria-controls (which is an ID)
      var controls = tab.getAttribute('aria-controls');

      //set tab attributes
      tab.setAttribute('tabindex', 0);
      tab.setAttribute('aria-selected', 'true');

      //set panel attributes
      var panel = document.getElementById(controls);
      panel.removeAttribute('hidden');
      panel.setAttribute('tabindex', 0);
      panel.classList.add('transition--in');
      self.dispatchEvent(new CustomEvent('tabber:duringActivation', {
        bubbles: true,
        detail: {
          tabber: self,
          tab: tab
        }
      }));
      setTimeout(function () {
        panel.classList.add('active');
        panel.classList.remove('transition--in');
        self.dispatchEvent(new CustomEvent('tabber:afterActivation', {
          bubbles: true,
          detail: {
            tabber: self,
            tab: tab
          }
        }));
      }, timing);

      // Set focus when required
      if (setFocus) {
        tab.focus();
      }
      ;
    }
    ;
    var hash = window.location.hash.substr(1);
    if ('' !== hash && document.getElementById(hash).getAttribute('role') === 'tab') {
      activateTab(document.getElementById(hash), false);
    } else {
      activateTab(tabs[0], false);
    }

    // Handle keydown on tabs
    function keydownEventListener(event) {
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
          if (false === automatic) {
            e.preventDefault();
            activateTab(event.target);
          }
          break;
      }
      ;
    }
    ;

    // When a tablist's aria-orientation is set to vertical,
    // only up and down arrow should function.
    // In all other cases only left and right arrow function.
    function determineOrientation(event) {
      var event = event || window.event,
        key = event.keyCode || event.which,
        proceed = false;
      if (vertical) {
        if (key === keys.up || key === keys.down) {
          event.preventDefault();
          proceed = true;
        }
        ;
      } else {
        if (key === keys.left || key === keys.right) {
          proceed = true;
        }
        ;
      }
      ;
      if (proceed) {
        switchTabOnArrowPress(event);
      }
      ;
    }
    ;

    // Either focus the next, previous, first, or last tab
    // depending on key pressed
    function switchTabOnArrowPress(event) {
      var event = event || window.event,
        key = event.keyCode || event.which;
      if (direction[key]) {
        var target = event.target;
        if (target.index !== undefined) {
          if (tabs[target.index + direction[key]]) {
            navigateTab(tabs[target.index + direction[key]]);
          } else if (key === keys.left || key === keys.up) {
            focusLastTab();
          } else if (key === keys.right || key == keys.down) {
            focusFirstTab();
          }
          ;
        }
        ;
      }
      ;
    }
    ;

    // Make a guess
    function focusFirstTab() {
      navigateTab(tabs[0]);
    }
    ;

    // Make a guess
    function focusLastTab() {
      navigateTab(tabs[tabs.length - 1]);
    }
    ;
  });
})();
"use strict";

(function ($) {
  $(function () {
    $('.js-testimonial-slider').slick({
      infinite: true,
      adaptiveHeight: true,
      fade: true,
      speed: 10
    });
  });
})(jQuery);
"use strict";

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
  embedVideos.forEach(function (video, i) {
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
        video_url = "https://fast.wistia.net/embed/iframe/".concat(id, "?autoplay=1");
      }
      iframe.src = video_url;
      anime({
        targets: button,
        opacity: [1, 0],
        easing: 'easeInOutQuad',
        duration: 500,
        complete: function complete(anim) {
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
        playerVars: {
          'controls': 0,
          'showinfo': 0,
          'rel': 0,
          'enablejsapi': 1,
          'autoplay': 1,
          'loop': 1,
          'wmode': 'transparent'
        },
        events: {
          'onReady': function onReady(e) {
            e.target.playVideo();
            e.target.mute();
            e.target.setPlaybackQuality('hd720');
          },
          onStateChange: function onStateChange(e) {
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
            playerVars: {
              'controls': 1,
              'showinfo': 0,
              'rel': 0,
              'enablejsapi': 1,
              'autoplay': 1,
              'wmode': 'transparent'
            },
            events: {
              'onReady': function onReady(e) {
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
          vimeoPlayer = new Vimeo.Player(id, {
            id: video
          });
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
          markup: '<div class="mfp-iframe-scaler">' + '<div class="mfp-close"></div>' + '<iframe class="mfp-iframe wistia_embed" src="//about:blank" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" frameborder="0" allowfullscreen allowautoplay></iframe>' + '</div>',
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
              id: function id(url) {
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
              id: function id(url) {
                var m = url.match(/^.+wistia.net\/embed\/iframe\/([^_]+)/);
                if (m !== null) {
                  return m[1];
                }
                return null;
              },
              src: '//fast.wistia.net/embed/iframe/%id%?autoPlay=1' // https://wistia.com/doc/embed-options#options_list
            }
          }
        }
      });
    });
  });
})(jQuery);
"use strict";

/**
 * Animations are last to make sure other effects or movement happen first as height calculations can affect this
 */

//this removes our fallback css animations - each module should have a fallback animation to set its opacity to 1
var body = document.querySelector('body');
body.classList.remove('no-js');
(function () {
  //this is the most basic animation example, but please make more specific ones per module and remove this one.
  //https://animejs.com/documentation/
  var modules = document.querySelectorAll('.module');
  modules.forEach(function (module, i) {
    module.waypoint = new Waypoint({
      element: module,
      handler: function handler(direction) {
        anime({
          targets: module,
          opacity: [0, 1],
          translateY: [200, 0],
          delay: anime.stagger(100)
        });
        this.destroy();
      },
      offset: "90%"
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
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImFyY2hpdmUuanMiLCJjYXNlLXN0dWR5LXNsaWRlci5qcyIsImltYWdlLWdhbGxlcnkuanMiLCJsb2dvLXNsaWRlci5qcyIsIm5hdmlnYXRpb24uanMiLCJzaWRlLXNjcm9sbGVyLmpzIiwic2tpcC1saW5rLWZvY3VzLWZpeC5qcyIsInN2Zy5qcyIsInRhYmJlci5qcyIsInRlc3RpbW9uaWFsLXNsaWRlci5qcyIsInZpZGVvLmpzIiwiei1hbmltYXRpb25zLmpzIl0sIm5hbWVzIjpbIiQiLCJkb2N1bWVudCIsInJlYWR5IiwicmVzb3VyY2VBcmNoaXZlIiwiZmluZCIsImNsaWNrIiwidmFsIiwiYXR0ciIsInBhcmVudE5hbWUiLCJwYXJlbnQiLCJzaWJsaW5ncyIsImlucHV0QXJjaGl2ZSIsInBhcmVudHMiLCJzdWJtaXQiLCJlIiwicHJldmVudERlZmF1bHQiLCJ1cmwiLCJkYXRhIiwidGFyZ2V0Iiwic3VibWl0RGF0YSIsInNlcmlhbGl6ZUFycmF5Iiwic3VibWl0U3RyaW5nIiwic2VyaWFsaXplIiwibGVuZ3RoIiwibmFtZSIsInZhbHVlIiwicG9zdCIsImh0bWwiLCJhbmltZSIsInRhcmdldHMiLCJxdWVyeVNlbGVjdG9yQWxsIiwidHJhbnNsYXRlWSIsIm9wYWNpdHkiLCJlYXNpbmciLCJkdXJhdGlvbiIsImRlbGF5Iiwic3RhZ2dlciIsImhpc3RvcnkiLCJwdXNoU3RhdGUiLCJuZXd1cmwiLCJ3aW5kb3ciLCJsb2NhdGlvbiIsInByb3RvY29sIiwiaG9zdCIsInBhdGhuYW1lIiwicGF0aCIsImpRdWVyeSIsInNsaWNrIiwiaW5maW5pdGUiLCJhZGFwdGl2ZUhlaWdodCIsImZhZGUiLCJzcGVlZCIsInZhcmlhYmxlV2lkdGgiLCJjZW50ZXJNb2RlIiwiY29udGFpbmVyIiwiYnV0dG9uIiwibWVudSIsImxpbmtzIiwiaSIsImxlbiIsImdldEVsZW1lbnRCeUlkIiwiZ2V0RWxlbWVudHNCeVRhZ05hbWUiLCJzdHlsZSIsImRpc3BsYXkiLCJjbGFzc05hbWUiLCJpbmRleE9mIiwib25jbGljayIsInJlcGxhY2UiLCJzZXRBdHRyaWJ1dGUiLCJhZGRFdmVudExpc3RlbmVyIiwiZXZlbnQiLCJpc0NsaWNrSW5zaWRlIiwiY29udGFpbnMiLCJ0b2dnbGVGb2N1cyIsInNlbGYiLCJ0YWdOYW1lIiwidG9Mb3dlckNhc2UiLCJwYXJlbnRFbGVtZW50IiwidG91Y2hTdGFydEZuIiwicGFyZW50TGluayIsIm1lbnVJdGVtIiwicGFyZW50Tm9kZSIsImNsYXNzTGlzdCIsImNoaWxkcmVuIiwicmVtb3ZlIiwiYWRkIiwic2lkZVNjcm9sbGVycyIsImZvckVhY2giLCJzY3JvbGxlciIsImluZGV4Iiwidmlld3BvcnRIZWlnaHQiLCJpbm5lckhlaWdodCIsImRvY3VtZW50RWxlbWVudCIsImNsaWVudEhlaWdodCIsImJvZHkiLCJsYXN0S25vd25TY3JvbGxQb3NpdGlvbiIsInRpY2tpbmciLCJzZWN0aW9ucyIsImFjdGl2ZSIsInZhcmlhbmNlIiwib2Zmc2V0SGVpZ2h0Iiwic2Nyb2xsWSIsInJlcXVlc3RBbmltYXRpb25GcmFtZSIsImFkZEFjdGl2ZVRvU2lkZVNjcm9sbGVyIiwicGFzc2l2ZSIsIm9mZnNldFZhbCIsIl90b0NvbnN1bWFibGVBcnJheSIsInNvbWUiLCJzZWN0aW9uIiwiaXRlbVRvcCIsImdldEJvdW5kaW5nQ2xpZW50UmVjdCIsInRvcCIsIml0ZW1Cb3R0b20iLCJib3R0b20iLCJpc0FjdGl2ZSIsImNoYW5nZUFjdGl2ZSIsIm5ld0FjdGl2ZSIsImNsZWFyQWN0aXZlIiwic2V0QWN0aXZlIiwicXVlcnlTZWxlY3RvciIsImlzSWUiLCJ0ZXN0IiwibmF2aWdhdG9yIiwidXNlckFnZW50IiwiaWQiLCJoYXNoIiwic3Vic3RyaW5nIiwiZWxlbWVudCIsInRhYkluZGV4IiwiZm9jdXMiLCJzdmdzIiwiZ2V0RWxlbWVudHNCeUNsYXNzTmFtZSIsIm1lYXN1cmVtZW50IiwiX2l0ZXJhdG9yIiwiX2NyZWF0ZUZvck9mSXRlcmF0b3JIZWxwZXIiLCJfc3RlcCIsInMiLCJuIiwiZG9uZSIsInN2ZyIsInBhdGhzIiwiX2l0ZXJhdG9yMiIsIl9zdGVwMiIsImJib3giLCJnZXRCQm94IiwidHJhbnNmb3JteCIsIndpZHRoIiwieCIsInRyYW5zZm9ybXkiLCJoZWlnaHQiLCJ5IiwiZXJyIiwiZiIsInRhYmxpc3QiLCJpdGVtIiwidW5kZXJsaW5lIiwidGFiIiwiZGV0YWlsIiwibGVmdCIsIm9mZnNldExlZnQiLCJvZmZzZXRXaWR0aCIsImtleXMiLCJlbmQiLCJob21lIiwidXAiLCJyaWdodCIsImRvd24iLCJlbnRlciIsInNwYWNlIiwiZGlyZWN0aW9uIiwiaiIsInRhYnMiLCJwYW5lbHMiLCJ2ZXJ0aWNhbCIsImdldEF0dHJpYnV0ZSIsImF1dG9tYXRpYyIsInRpbWluZyIsImN1cnJlbnRUYWIiLCJjbGlja0V2ZW50TGlzdGVuZXIiLCJrZXlkb3duRXZlbnRMaXN0ZW5lciIsInBhbmVsIiwiYWN0aXZhdGVUYWIiLCJuYXZpZ2F0ZVRhYiIsImRlYWN0aXZhdGVUYWIiLCJzZXRUaW1lb3V0Iiwic2V0Rm9jdXMiLCJkaXNwYXRjaEV2ZW50IiwiQ3VzdG9tRXZlbnQiLCJidWJibGVzIiwidGFiYmVyIiwiY29udHJvbHMiLCJyZW1vdmVBdHRyaWJ1dGUiLCJzdWJzdHIiLCJrZXkiLCJrZXlDb2RlIiwid2hpY2giLCJmb2N1c0xhc3RUYWIiLCJmb2N1c0ZpcnN0VGFiIiwiZGV0ZXJtaW5lT3JpZW50YXRpb24iLCJwcm9jZWVkIiwic3dpdGNoVGFiT25BcnJvd1ByZXNzIiwidW5kZWZpbmVkIiwieW91dHViZVZpZGVvcyIsInRhZyIsImNyZWF0ZUVsZW1lbnQiLCJzcmMiLCJmaXJzdFNjcmlwdFRhZyIsImluc2VydEJlZm9yZSIsInZpbWVvVmlkZW9zIiwid2lzdGlhVmlkZW9zIiwiZW1iZWRWaWRlb3MiLCJ2aWRlbyIsInNlcnZpY2UiLCJpZnJhbWUiLCJwbGF5VmlkZW8iLCJ2aWRlb191cmwiLCJkYXRhc2V0IiwiY29uY2F0IiwiY29tcGxldGUiLCJhbmltIiwib25Zb3VUdWJlSWZyYW1lQVBJUmVhZHkiLCJlYWNoIiwicGxheWVyIiwiWVQiLCJQbGF5ZXIiLCJ2aWRlb0lkIiwicGxheWVyVmFycyIsImV2ZW50cyIsIm9uUmVhZHkiLCJtdXRlIiwic2V0UGxheWJhY2tRdWFsaXR5Iiwib25TdGF0ZUNoYW5nZSIsIlBsYXllclN0YXRlIiwiRU5ERUQiLCJvbiIsInZpbWVvUGxheWVyIiwiVmltZW8iLCJwbGF5IiwicmVtb3ZlQ2xhc3MiLCJhZGRDbGFzcyIsIndpc3RpYVBsYXllciIsIldpc3RpYSIsImFwaSIsIm1hZ25pZmljUG9wdXAiLCJ0eXBlIiwibWFya3VwIiwicGF0dGVybnMiLCJ5b3V0dWJlIiwidmltZW8iLCJ3aXN0aWFjb20iLCJtIiwibWF0Y2giLCJ3aXN0aWFuZXQiLCJtb2R1bGVzIiwibW9kdWxlIiwid2F5cG9pbnQiLCJXYXlwb2ludCIsImhhbmRsZXIiLCJkZXN0cm95Iiwib2Zmc2V0Il0sIm1hcHBpbmdzIjoiOztBQUFBLENBQUMsVUFBU0EsQ0FBQyxFQUFDO0VBRVhBLENBQUMsQ0FBQ0MsUUFBUSxDQUFDLENBQUNDLEtBQUssQ0FBQyxZQUFVO0lBQzNCLElBQUlDLGVBQWUsR0FBR0gsQ0FBQyxDQUFDLDJCQUEyQixDQUFDO0lBRXBERyxlQUFlLENBQUNDLElBQUksQ0FBQyxxQkFBcUIsQ0FBQyxDQUFDQyxLQUFLLENBQUMsWUFBVTtNQUMzRCxJQUFJQyxHQUFHLEdBQUdOLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ08sSUFBSSxDQUFDLE9BQU8sQ0FBQztNQUMvQixJQUFJQyxVQUFVLEdBQUdSLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ1MsTUFBTSxDQUFDLENBQUMsQ0FBQ0MsUUFBUSxDQUFDLHdCQUF3QixDQUFDLENBQUNILElBQUksQ0FBQyxNQUFNLENBQUM7TUFDakYsSUFBSUksWUFBWSxHQUFHWCxDQUFDLENBQUMsMEJBQTBCLEdBQUdRLFVBQVUsR0FBRyxJQUFJLENBQUM7TUFDcEVHLFlBQVksQ0FBQ0osSUFBSSxDQUFDLE9BQU8sRUFBRUQs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QUFPLEVBQUUsU0FBQUEsUUFBU3hGLFNBQVMsRUFBRTtRQUM1QjdJLEtBQUssQ0FBQztVQUNMQyxPQUFPLEVBQUVpTyxNQUFNO1VBQ2Y5TixPQUFPLEVBQUUsQ0FBRSxDQUFDLEVBQUUsQ0FBQyxDQUFFO1VBQ2pCRCxVQUFVLEVBQUUsQ0FBRSxHQUFHLEVBQUUsQ0FBQyxDQUFDO1VBQ3JCSSxLQUFLLEVBQUVQLEtBQUssQ0FBQ1EsT0FBTyxDQUFFLEdBQUk7UUFDM0IsQ0FBQyxDQUFDO1FBQ0YsSUFBSSxDQUFDOE4sT0FBTyxDQUFDLENBQUM7TUFDZixDQUFDO01BQ0RDLE1BQU0sRUFBRTtJQUNULENBQUMsQ0FBQztFQUNILENBQUMsQ0FBQzs7RUFFRjtBQUNEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQSxDQUFDLEVBQUUsQ0FBQyIsImZpbGUiOiJhcHBfc2NyaXB0cy5qcyIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbigkKXtcblxuXHQkKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpe1xuXHRcdHZhciByZXNvdXJjZUFyY2hpdmUgPSAkKCcubW9kdWxlLS1yZXNvdXJjZS1hcmNoaXZlJyk7XG5cblx0XHRyZXNvdXJjZUFyY2hpdmUuZmluZCgnLmpzLWF1dG9zdWJtaXQgc3BhbicpLmNsaWNrKGZ1bmN0aW9uKCl7XG5cdFx0XHR2YXIgdmFsID0gJCh0aGlzKS5hdHRyKCd2YWx1ZScpO1xuXHRcdFx0dmFyIHBhcmVudE5hbWUgPSAkKHRoaXMpLnBhcmVudCgpLnNpYmxpbmdzKCcuZmlsdGVyLWFyY2hpdmVfX2xhYmVsJykuYXR0cignbmFtZScpO1xuXHRcdFx0dmFyIGlucHV0QXJjaGl2ZSA9ICQoJy5qcy1pbnB1dC1hcmNoaXZlW25hbWU9XCInICsgcGFyZW50TmFtZSArICdcIl0nKTtcblx0XHRcdGlucHV0QXJjaGl2ZS5hdHRyKCd2YWx1ZScsIHZhbCk7XG5cblx0XHRcdCQodGhpcykucGFyZW50cyggJ2Zvcm0nICkuc3VibWl0KCk7XG5cdFx0fSk7XG5cblx0XHRyZXNvdXJjZUFyY2hpdmUuZmluZCgnLmpzLWFqYXgnKS5zdWJtaXQoZnVuY3Rpb24oIGUgKXtcblx0XHRcdGUucHJldmVudERlZmF1bHQoKTtcblx0XHRcdHZhciB1cmwgPSAkKHRoaXMpLmRhdGEoICdhamF4JyApLFxuXHRcdFx0XHR0YXJnZXQgPSByZXNvdXJjZUFyY2hpdmUuZmluZCggJCh0aGlzKS5kYXRhKCAndGFyZ2V0JyApICksXG5cdFx0XHRcdHN1Ym1pdERhdGEgPSAkKHRoaXMpLnNlcmlhbGl6ZUFycmF5KCksXG5cdFx0XHRcdHN1Ym1pdFN0cmluZyA9ICQodGhpcykuc2VyaWFsaXplKCk7XG5cdFx0XHRcdHN1Ym1pdERhdGFbc3VibWl0RGF0YS5sZW5ndGhdID0geyBuYW1lOiAnYXJjaGl2ZScsIHZhbHVlOiAkKHRoaXMpLmRhdGEoICdhcmNoaXZlJyApIH07XG5cblx0XHRcdCQucG9zdCggdXJsLCBzdWJtaXREYXRhLCBmdW5jdGlvbiggZGF0YSApe1xuXHRcdFx0XHR0YXJnZXQuaHRtbCggZGF0YSApO1xuXHRcdFx0XHRhbmltZSh7XG5cdFx0XHRcdFx0dGFyZ2V0czogcmVzb3VyY2VBcmNoaXZlWzBdLnF1ZXJ5U2VsZWN0b3JBbGwoJy5yZXNvdXJjZS1hcmNoaXZlLXF1ZXJ5LCAucGFnaW5hdGlvbiwgLnRpdGxlLCAuYnV0dG9uLCAuY2FyZCcpLFxuXHRcdFx0XHRcdHRyYW5zbGF0ZVk6IFsxMDAsMF0sXG5cdFx0XHRcdFx0b3BhY2l0eTogWzAsMV0sXG5cdFx0XHRcdFx0ZWFzaW5nOiAnZWFzZU91dFF1YWQnLFxuXHRcdFx0XHRcdGR1cmF0aW9uOiA1MDAsXG5cdFx0XHRcdFx0ZGVsYXk6YW5pbWUuc3RhZ2dlcigxMDApLFxuXHRcdFx0XHR9KTtcblx0XHRcdFx0aWYgKGhpc3RvcnkucHVzaFN0YXRlKSB7XG5cdFx0XHRcdFx0dmFyIG5ld3VybCA9IHdpbmRvdy5sb2NhdGlvbi5wcm90b2NvbCArIFwiLy9cIiArIHdpbmRvdy5sb2NhdGlvbi5ob3N0ICsgd2luZG93LmxvY2F0aW9uLnBhdGhuYW1lICsgJz8nICsgc3VibWl0U3RyaW5nO1xuXHRcdFx0XHRcdHdpbmRvdy5oaXN0b3J5LnB1c2hTdGF0ZSh7cGF0aDpuZXd1cmx9LCcnLG5ld3VybCk7XG5cdFx0XHRcdH1cblx0XHRcdH0pO1xuXHRcdH0pO1xuXHR9KTtcbn0pKGpRdWVyeSk7IiwiKGZ1bmN0aW9uKCQpe1xuXHQkKGZ1bmN0aW9uKCl7XG5cdFx0JCgnLmpzLWNhc2Utc3R1ZHktc2xpZGVyJykuc2xpY2soe1xuXHRcdFx0aW5maW5pdGU6IHRydWUsXG5cdFx0XHRhZGFwdGl2ZUhlaWdodDogdHJ1ZSxcblx0XHRcdGZhZGU6IHRydWUsXG5cdFx0XHRzcGVlZDogMTAsXG5cdFx0fSk7XG5cdH0pO1xufSkoalF1ZXJ5KTsiLCIoZnVuY3Rpb24oJCl7XG5cdCQoZnVuY3Rpb24oKXtcblx0XHQkKCcuaW1hZ2Utc2xpZGVyJykuc2xpY2soe1xuXHRcdFx0aW5maW5pdGU6IHRydWUsXG5cdFx0XHR2YXJpYWJsZVdpZHRoOiB0cnVlLFxuXHRcdFx0Y2VudGVyTW9kZTogdHJ1ZVxuXHRcdH0pO1xuXHR9KTtcbn0pKGpRdWVyeSk7XG4iLCIoZnVuY3Rpb24oJCl7XG5cdCQoZnVuY3Rpb24oKXtcblx0XHQkKCcuanMtbG9nby1zbGlkZXInKS5zbGljayh7XG5cdFx0XHRpbmZpbml0ZTogdHJ1ZSxcblx0XHRcdGFkYXB0aXZlSGVpZ2h0OiB0cnVlLFxuXHRcdFx0ZmFkZTogdHJ1ZSxcblx0XHRcdHNwZWVkOiAxMCxcblx0XHR9KTtcblx0fSk7XG59KShqUXVlcnkpOyIsIi8qKlxuICogRmlsZSBuYXZpZ2F0aW9uLmpzLlxuICpcbiAqIEhhbmRsZXMgdG9nZ2xpbmcgdGhlIG5hdmlnYXRpb24gbWVudSBmb3Igc21hbGwgc2NyZWVucyBhbmQgZW5hYmxlcyBUQUIga2V5XG4gKiBuYXZpZ2F0aW9uIHN1cHBvcnQgZm9yIGRyb3Bkb3duIG1lbnVzLlxuICovXG4oIGZ1bmN0aW9uKCkge1xuXHR2YXIgY29udGFpbmVyLCBidXR0b24sIG1lbnUsIGxpbmtzLCBpLCBsZW47XG5cblx0Y29udGFpbmVyID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoICdzaXRlLW5hdmlnYXRpb24nICk7XG5cdGlmICggISBjb250YWluZXIgKSB7XG5cdFx0cmV0dXJuO1xuXHR9XG5cblx0YnV0dG9uID0gY29udGFpbmVyLmdldEVsZW1lbnRzQnlUYWdOYW1lKCAnYnV0dG9uJyApWzBdO1xuXHRpZiAoICd1bmRlZmluZWQnID09PSB0eXBlb2YgYnV0dG9uICkge1xuXHRcdHJldHVybjtcblx0fVxuXG5cdG1lbnUgPSBjb250YWluZXIuZ2V0RWxlbWVudHNCeVRhZ05hbWUoICd1bCcgKVswXTtcblxuXHQvLyBIaWRlIG1lbnUgdG9nZ2xlIGJ1dHRvbiBpZiBtZW51IGlzIGVtcHR5IGFuZCByZXR1cm4gZWFybHkuXG5cdGlmICggJ3VuZGVmaW5lZCcgPT09IHR5cGVvZiBtZW51ICkge1xuXHRcdGJ1dHRvbi5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuXHRcdHJldHVybjtcblx0fVxuXG5cdGlmICggLTEgPT09IG1lbnUuY2xhc3NOYW1lLmluZGV4T2YoICduYXYtbWVudScgKSApIHtcblx0XHRtZW51LmNsYXNzTmFtZSArPSAnIG5hdi1tZW51Jztcblx0fVxuXG5cdGJ1dHRvbi5vbmNsaWNrID0gZnVuY3Rpb24oKSB7XG5cdFx0aWYgKCAtMSAhPT0gY29udGFpbmVyLmNsYXNzTmFtZS5pbmRleE9mKCAndG9nZ2xlZCcgKSApIHtcblx0XHRcdGNvbnRhaW5lci5jbGFzc05hbWUgPSBjb250YWluZXIuY2xhc3NOYW1lLnJlcGxhY2UoICcgdG9nZ2xlZCcsICcnICk7XG5cdFx0XHRidXR0b24uc2V0QXR0cmlidXRlKCAnYXJpYS1leHBhbmRlZCcsICdmYWxzZScgKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0Y29udGFpbmVyLmNsYXNzTmFtZSArPSAnIHRvZ2dsZWQnO1xuXHRcdFx0YnV0dG9uLnNldEF0dHJpYnV0ZSggJ2FyaWEtZXhwYW5kZWQnLCAndHJ1ZScgKTtcblx0XHR9XG5cdH07XG5cblx0Ly8gQ2xvc2Ugc21hbGwgbWVudSB3aGVuIHVzZXIgY2xpY2tzIG91dHNpZGVcblx0ZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lciggJ2NsaWNrJywgZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdHZhciBpc0NsaWNrSW5zaWRlID0gY29udGFpbmVyLmNvbnRhaW5zKCBldmVudC50YXJnZXQgKTtcblxuXHRcdGlmICggISBpc0NsaWNrSW5zaWRlICkge1xuXHRcdFx0Y29udGFpbmVyLmNsYXNzTmFtZSA9IGNvbnRhaW5lci5jbGFzc05hbWUucmVwbGFjZSggJyB0b2dnbGVkJywgJycgKTtcblx0XHRcdGJ1dHRvbi5zZXRBdHRyaWJ1dGUoICdhcmlhLWV4cGFuZGVkJywgJ2ZhbHNlJyApO1xuXHRcdH1cblx0fSApO1xuXG5cdC8vIEdldCBhbGwgdGhlIGxpbmsgZWxlbWVudHMgd2l0aGluIHRoZSBtZW51LlxuXHRsaW5rcyA9IG1lbnUuZ2V0RWxlbWVudHNCeVRhZ05hbWUoICdhJyApO1xuXG5cdC8vIEVhY2ggdGltZSBhIG1lbnUgbGluayBpcyBmb2N1c2VkIG9yIGJsdXJyZWQsIHRvZ2dsZSBmb2N1cy5cblx0Zm9yICggaSA9IDAsIGxlbiA9IGxpbmtzLmxlbmd0aDsgaSA8IGxlbjsgaSsrICkge1xuXHRcdGxpbmtzW2ldLmFkZEV2ZW50TGlzdGVuZXIoICdmb2N1cycsIHRvZ2dsZUZvY3VzLCB0cnVlICk7XG5cdFx0bGlua3NbaV0uYWRkRXZlbnRMaXN0ZW5lciggJ2JsdXInLCB0b2dnbGVGb2N1cywgdHJ1ZSApO1xuXHR9XG5cblx0LyoqXG5cdCAqIFNldHMgb3IgcmVtb3ZlcyAuZm9jdXMgY2xhc3Mgb24gYW4gZWxlbWVudC5cblx0ICovXG5cdGZ1bmN0aW9uIHRvZ2dsZUZvY3VzKCkge1xuXHRcdHZhciBzZWxmID0gdGhpcztcblxuXHRcdC8vIE1vdmUgdXAgdGhyb3VnaCB0aGUgYW5jZXN0b3JzIG9mIHRoZSBjdXJyZW50IGxpbmsgdW50aWwgd2UgaGl0IC5uYXYtbWVudS5cblx0XHR3aGlsZSAoIC0xID09PSBzZWxmLmNsYXNzTmFtZS5pbmRleE9mKCAnbmF2LW1lbnUnICkgKSB7XG5cdFx0XHQvLyBPbiBsaSBlbGVtZW50cyB0b2dnbGUgdGhlIGNsYXNzIC5mb2N1cy5cblx0XHRcdGlmICggJ2xpJyA9PT0gc2VsZi50YWdOYW1lLnRvTG93ZXJDYXNlKCkgKSB7XG5cdFx0XHRcdGlmICggLTEgIT09IHNlbGYuY2xhc3NOYW1lLmluZGV4T2YoICdmb2N1cycgKSApIHtcblx0XHRcdFx0XHRzZWxmLmNsYXNzTmFtZSA9IHNlbGYuY2xhc3NOYW1lLnJlcGxhY2UoICcgZm9jdXMnLCAnJyApO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdHNlbGYuY2xhc3NOYW1lICs9ICcgZm9jdXMnO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHRcdHNlbGYgPSBzZWxmLnBhcmVudEVsZW1lbnQ7XG5cdFx0fVxuXHR9XG5cblx0LyoqXG5cdCAqIFRvZ2dsZXMgYGZvY3VzYCBjbGFzcyB0byBhbGxvdyBzdWJtZW51IGFjY2VzcyBvbiB0YWJsZXRzLlxuXHQgKi9cblx0KCBmdW5jdGlvbigpIHtcblx0XHR2YXIgdG91Y2hTdGFydEZuLFxuXHRcdFx0cGFyZW50TGluayA9IGNvbnRhaW5lci5xdWVyeVNlbGVjdG9yQWxsKCAnLm1lbnUtaXRlbS1oYXMtY2hpbGRyZW4gPiBhLCAucGFnZV9pdGVtX2hhc19jaGlsZHJlbiA+IGEnICk7XG5cblx0XHRpZiAoICdvbnRvdWNoc3RhcnQnIGluIHdpbmRvdyApIHtcblx0XHRcdHRvdWNoU3RhcnRGbiA9IGZ1bmN0aW9uKCBlICkge1xuXHRcdFx0XHR2YXIgbWVudUl0ZW0gPSB0aGlzLnBhcmVudE5vZGU7XG5cblx0XHRcdFx0aWYgKCAhIG1lbnVJdGVtLmNsYXNzTGlzdC5jb250YWlucyggJ2ZvY3VzJyApICkge1xuXHRcdFx0XHRcdGUucHJldmVudERlZmF1bHQoKTtcblx0XHRcdFx0XHRmb3IgKCBpID0gMDsgaSA8IG1lbnVJdGVtLnBhcmVudE5vZGUuY2hpbGRyZW4ubGVuZ3RoOyArK2kgKSB7XG5cdFx0XHRcdFx0XHRpZiAoIG1lbnVJdGVtID09PSBtZW51SXRlbS5wYXJlbnROb2RlLmNoaWxkcmVuW2ldICkge1xuXHRcdFx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdG1lbnVJdGVtLnBhcmVudE5vZGUuY2hpbGRyZW5baV0uY2xhc3NMaXN0LnJlbW92ZSggJ2ZvY3VzJyApO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0XHRtZW51SXRlbS5jbGFzc0xpc3QuYWRkKCAnZm9jdXMnICk7XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0bWVudUl0ZW0uY2xhc3NMaXN0LnJlbW92ZSggJ2ZvY3VzJyApO1xuXHRcdFx0XHR9XG5cdFx0XHR9O1xuXG5cdFx0XHRmb3IgKCBpID0gMDsgaSA8IHBhcmVudExpbmsubGVuZ3RoOyArK2kgKSB7XG5cdFx0XHRcdHBhcmVudExpbmtbaV0uYWRkRXZlbnRMaXN0ZW5lciggJ3RvdWNoc3RhcnQnLCB0b3VjaFN0YXJ0Rm4sIGZhbHNlICk7XG5cdFx0XHR9XG5cdFx0fVxuXHR9KCBjb250YWluZXIgKSApO1xufSgpICk7XG4iLCIoZnVuY3Rpb24oKXtcblx0dmFyIHNpZGVTY3JvbGxlcnMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCAnW2RhdGEtc2lkZS1zY3JvbGxlcl0nICk7XG5cdHNpZGVTY3JvbGxlcnMuZm9yRWFjaCgoIHNjcm9sbGVyLCBpbmRleCApID0+IHtcblx0XHRjb25zdCB2aWV3cG9ydEhlaWdodCA9IHdpbmRvdy5pbm5lckhlaWdodCB8fCBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuY2xpZW50SGVpZ2h0IHx8IGRvY3VtZW50LmJvZHkuY2xpZW50SGVpZ2h0O1xuXHRcdGxldCBsYXN0S25vd25TY3JvbGxQb3NpdGlvbiA9IDAsXG5cdFx0XHR0aWNraW5nID0gZmFsc2UsXG5cdFx0XHRzZWN0aW9ucyA9IHNjcm9sbGVyLnF1ZXJ5U2VsZWN0b3JBbGwoICdbZGF0YS1zaWRlLXNjcm9sbGVyLXNlY3Rpb24taW5kZXhdJyApLFxuXHRcdFx0YWN0aXZlID0gZmFsc2UsXG5cdFx0XHR2YXJpYW5jZSA9IDI1LFxuXHRcdFx0b2Zmc2V0SGVpZ2h0ID0gKHZpZXdwb3J0SGVpZ2h0IC8gMikgLSB2YXJpYW5jZTtcblxuXHRcdC8vYXR0YWNoIHNjcm9sbCBsaXN0ZW5lciBmb3IgZWFjaCBtb2R1bGVcblx0XHRkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdzY3JvbGwnLCBmdW5jdGlvbihlKSB7XG5cdFx0XHRsYXN0S25vd25TY3JvbGxQb3NpdGlvbiA9IHdpbmRvdy5zY3JvbGxZO1xuXG5cdFx0XHRpZiAoIXRpY2tpbmcpIHtcblx0XHRcdFx0d2luZG93LnJlcXVlc3RBbmltYXRpb25GcmFtZShmdW5jdGlvbigpIHtcblx0XHRcdFx0XHRhZGRBY3RpdmVUb1NpZGVTY3JvbGxlcigpO1xuXHRcdFx0XHRcdHRpY2tpbmcgPSBmYWxzZTtcblx0XHRcdFx0fSk7XG5cblx0XHRcdFx0dGlja2luZyA9IHRydWU7XG5cdFx0XHR9XG5cdFx0fSx7IHBhc3NpdmU6IHRydWUgfSk7XG5cblx0XHQvL2xvb3AgdGhyb3VnaCBzZWN0aW9ucyBhbmQgZGV0ZXJtaW5lIHdoaWNoIG9uZSBpcyBcImN1cnJlbnRcIlxuXHRcdGNvbnN0IGFkZEFjdGl2ZVRvU2lkZVNjcm9sbGVyID0gKCkgPT4ge1xuXHRcdFx0Y29uc3Qgb2Zmc2V0VmFsID0gb2Zmc2V0SGVpZ2h0ID8gb2Zmc2V0SGVpZ2h0IDogMDtcblx0XHRcdFsuLi5zZWN0aW9uc10uc29tZSggZnVuY3Rpb24oc2VjdGlvbiwgaW5kZXgpIHtcblx0XHRcdFx0Y29uc3QgaXRlbVRvcCA9IHNlY3Rpb24uZ2V0Qm91bmRpbmdDbGllbnRSZWN0KCkudG9wIC0gb2Zmc2V0VmFsO1xuXHRcdFx0XHRjb25zdCBpdGVtQm90dG9tID0gc2VjdGlvbi5nZXRCb3VuZGluZ0NsaWVudFJlY3QoKS5ib3R0b20gLSBvZmZzZXRWYWw7XG5cdFx0XHRcdGxldCBpc0FjdGl2ZSA9ICEoKGl0ZW1Ub3AgPiB2YXJpYW5jZSkgfHwgKGl0ZW1Cb3R0b20gPCAtdmFyaWFuY2UpKTtcblxuXHRcdFx0XHRpZiggaXNBY3RpdmUgKXtcblx0XHRcdFx0XHRjaGFuZ2VBY3RpdmUoIGluZGV4ICk7XG5cdFx0XHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0XHRcdH1cblx0XHRcdH0pO1xuXHRcdH07XG5cblx0XHQvL2RldGVybWluZSBpZiB3ZSBuZWVkIHRvIGNoYW5nZSB0aGUgYWN0aXZlIHZhbHVlXG5cdFx0Y29uc3QgY2hhbmdlQWN0aXZlID0gKG5ld0FjdGl2ZSkgPT4ge1xuXHRcdFx0aWYoIG5ld0FjdGl2ZSA9PT0gYWN0aXZlICl7XG5cdFx0XHRcdHJldHVybjtcblx0XHRcdH1cblxuXHRcdFx0aWYoIGZhbHNlICE9PSBhY3RpdmUgKXtcblx0XHRcdFx0Y2xlYXJBY3RpdmUoIGFjdGl2ZSApO1xuXHRcdFx0fVxuXHRcdFx0c2V0QWN0aXZlKCBuZXdBY3RpdmUgKTtcblx0XHRcdGFjdGl2ZSA9IG5ld0FjdGl2ZTtcblx0XHR9XG5cblx0XHQvL2RlYWN0aXZlIG9sZCBpbmRleFxuXHRcdGNvbnN0IGNsZWFyQWN0aXZlID0gKGluZGV4KSA9PiB7XG5cdFx0XHRzY3JvbGxlci5xdWVyeVNlbGVjdG9yKCAnW2RhdGEtc2lkZS1zY3JvbGxlci1uYXYtaW5kZXg9XCInK2luZGV4KydcIl0nICkuY2xhc3NMaXN0LnJlbW92ZSggJ2FjdGl2ZScgKTtcblx0XHRcdHNjcm9sbGVyLnF1ZXJ5U2VsZWN0b3IoICdbZGF0YS1zaWRlLXNjcm9sbGVyLXNlY3Rpb24taW5kZXg9XCInK2luZGV4KydcIl0nICkuY2xhc3NMaXN0LnJlbW92ZSggJ2FjdGl2ZScgKTtcblx0XHR9XG5cblx0XHQvL2FjdGl2YXRlIG5ldyBpbmRleFxuXHRcdGNvbnN0IHNldEFjdGl2ZSA9IChpbmRleCkgPT4ge1xuXHRcdFx0c2Nyb2xsZXIucXVlcnlTZWxlY3RvciggJ1tkYXRhLXNpZGUtc2Nyb2xsZXItbmF2LWluZGV4PVwiJytpbmRleCsnXCJdJyApLmNsYXNzTGlzdC5hZGQoICdhY3RpdmUnICk7XG5cdFx0XHRzY3JvbGxlci5xdWVyeVNlbGVjdG9yKCAnW2RhdGEtc2lkZS1zY3JvbGxlci1zZWN0aW9uLWluZGV4PVwiJytpbmRleCsnXCJdJyApLmNsYXNzTGlzdC5hZGQoICdhY3RpdmUnICk7XG5cdFx0XHRzY3JvbGxlci5xdWVyeVNlbGVjdG9yKCAnW2RhdGEtc2lkZS1zY3JvbGxlci1zZWN0aW9uLWluZGV4PVwiJytpbmRleCsnXCJdJyApLmNsYXNzTGlzdC5hZGQoICdhY3RpdmF0ZWQnICk7XG5cdFx0fVxuXG5cdFx0Ly9zZXQgaW5pdGlhbCB2YWx1ZVxuXHRcdGFkZEFjdGl2ZVRvU2lkZVNjcm9sbGVyKCk7XG5cdH0pO1xufSkoKTsiLCIvKipcbiAqIEZpbGUgc2tpcC1saW5rLWZvY3VzLWZpeC5qcy5cbiAqXG4gKiBIZWxwcyB3aXRoIGFjY2Vzc2liaWxpdHkgZm9yIGtleWJvYXJkIG9ubHkgdXNlcnMuXG4gKlxuICogTGVhcm4gbW9yZTogaHR0cHM6Ly9naXQuaW8vdldkcjJcbiAqL1xuKCBmdW5jdGlvbigpIHtcblx0dmFyIGlzSWUgPSAvKHRyaWRlbnR8bXNpZSkvaS50ZXN0KCBuYXZpZ2F0b3IudXNlckFnZW50ICk7XG5cblx0aWYgKCBpc0llICYmIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkICYmIHdpbmRvdy5hZGRFdmVudExpc3RlbmVyICkge1xuXHRcdHdpbmRvdy5hZGRFdmVudExpc3RlbmVyKCAnaGFzaGNoYW5nZScsIGZ1bmN0aW9uKCkge1xuXHRcdFx0dmFyIGlkID0gbG9jYXRpb24uaGFzaC5zdWJzdHJpbmcoIDEgKSxcblx0XHRcdFx0ZWxlbWVudDtcblxuXHRcdFx0aWYgKCAhICggL15bQS16MC05Xy1dKyQvLnRlc3QoIGlkICkgKSApIHtcblx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0fVxuXG5cdFx0XHRlbGVtZW50ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoIGlkICk7XG5cblx0XHRcdGlmICggZWxlbWVudCApIHtcblx0XHRcdFx0aWYgKCAhICggL14oPzphfHNlbGVjdHxpbnB1dHxidXR0b258dGV4dGFyZWEpJC9pLnRlc3QoIGVsZW1lbnQudGFnTmFtZSApICkgKSB7XG5cdFx0XHRcdFx0ZWxlbWVudC50YWJJbmRleCA9IC0xO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0ZWxlbWVudC5mb2N1cygpO1xuXHRcdFx0fVxuXHRcdH0sIGZhbHNlICk7XG5cdH1cbn0oKSApO1xuIiwiLyoqXG4gKiBOb3JtYWxpemUgc3ZnIHNwYWNpbmcgd2l0aGluIGl0J3Mgdmlld2JveFxuICovXG52YXIgc3ZncyA9IGRvY3VtZW50LmdldEVsZW1lbnRzQnlDbGFzc05hbWUoXCJqcy1zdmctY2VudGVyLXBhdGhcIiksXG5cdG1lYXN1cmVtZW50ID0gMTAyNDtcblxuZm9yICggbGV0IHN2ZyBvZiBzdmdzICkge1xuXHR2YXIgcGF0aHMgPSBzdmcuZ2V0RWxlbWVudHNCeVRhZ05hbWUoICdwYXRoJyApO1xuXHRmb3IoIGxldCBwYXRoIG9mIHBhdGhzICl7XG5cdFx0dmFyIGJib3ggPSBwYXRoLmdldEJCb3goKSxcblx0XHRcdHRyYW5zZm9ybXggPSAoICggbWVhc3VyZW1lbnQgLSBiYm94LndpZHRoICkgLyAyICkgLSBiYm94LngsXG5cdFx0XHR0cmFuc2Zvcm15ID0gKCAoIG1lYXN1cmVtZW50IC0gYmJveC5oZWlnaHQgKSAvIDIgKSAtIGJib3gueTtcblx0XHRwYXRoLnNldEF0dHJpYnV0ZSggJ3N0eWxlJywgJ3RyYW5zZm9ybTp0cmFuc2xhdGVYKCcrdHJhbnNmb3JteCsncHgpIHRyYW5zbGF0ZVkoJyt0cmFuc2Zvcm15KydweCk7JyApO1xuXHR9XG59XG4iLCIoZnVuY3Rpb24oKXtcblx0LyoqXG5cdCAqIGV4YW1wbGUgZm9yIGNvbnRyb2xsaW5nIG90aGVyIGl0ZW1zIHVzaW5nIGN1c3RvbSBldmVudHNcblx0ICovXG5cdHZhciB0YWJsaXN0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnW2RhdGEtdGFiYmVyXScpO1xuXHR0YWJsaXN0LmZvckVhY2goKGl0ZW0saSkgPT4ge1xuXHRcdHZhciB1bmRlcmxpbmUgPSBpdGVtLnF1ZXJ5U2VsZWN0b3IoICcuYnV0dG9uLXVuZGVybGluZScgKTtcblx0XHRpZiggdW5kZXJsaW5lICl7XG5cdFx0XHRpdGVtLmFkZEV2ZW50TGlzdGVuZXIoJ3RhYmJlcjpkdXJpbmdBY3RpdmF0aW9uJyxmdW5jdGlvbihlKXtcblx0XHRcdFx0dmFyIHRhYiA9IGUuZGV0YWlsLnRhYjtcblx0XHRcdFx0dW5kZXJsaW5lLnN0eWxlLmxlZnQgPSB0YWIub2Zmc2V0TGVmdCArICdweCc7XG5cdFx0XHRcdHVuZGVybGluZS5zdHlsZS53aWR0aCA9IHRhYi5vZmZzZXRXaWR0aCArICdweCc7XG5cdFx0XHR9KTtcblx0XHR9XG5cdH0pO1xufSgpKTtcblxuLypcbiogICBUaGlzIGNvbnRlbnQgaXMgbGljZW5zZWQgYWNjb3JkaW5nIHRvIHRoZSBXM0MgU29mdHdhcmUgTGljZW5zZSBhdFxuKiAgIGh0dHBzOi8vd3d3LnczLm9yZy9Db25zb3J0aXVtL0xlZ2FsLzIwMTUvY29weXJpZ2h0LXNvZnR3YXJlLWFuZC1kb2N1bWVudFxuKi9cbihmdW5jdGlvbiAoKSB7XG5cdHZhciB0YWJsaXN0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnW2RhdGEtdGFiYmVyXScpLFxuXHRcdGtleXMgPSB7XG5cdFx0XHRlbmQ6IDM1LFxuXHRcdFx0aG9tZTogMzYsXG5cdFx0XHRsZWZ0OiAzNyxcblx0XHRcdHVwOiAzOCxcblx0XHRcdHJpZ2h0OiAzOSxcblx0XHRcdGRvd246IDQwLFxuXHRcdFx0ZW50ZXI6IDEzLFxuXHRcdFx0c3BhY2U6IDMyXG5cdFx0fSxcblx0XHRkaXJlY3Rpb24gPSB7XG5cdFx0XHQzNzogLTEsXG5cdFx0XHQzODogLTEsXG5cdFx0XHQzOTogMSxcblx0XHRcdDQwOiAxXG5cdFx0fTtcblxuXHR0YWJsaXN0LmZvckVhY2goKGl0ZW0sIGopID0+IHtcblx0XHR2YXIgc2VsZiA9IGl0ZW0sXG5cdFx0XHR0YWJzID0gaXRlbS5xdWVyeVNlbGVjdG9yQWxsKCdbcm9sZT1cInRhYlwiXScpLFxuXHRcdFx0cGFuZWxzID0gaXRlbS5xdWVyeVNlbGVjdG9yQWxsKCdbcm9sZT1cInRhYnBhbmVsXCJdJyksXG5cdFx0XHR2ZXJ0aWNhbCA9IGl0ZW0uZ2V0QXR0cmlidXRlKCdhcmlhLW9yaWVudGF0aW9uJykgPT09ICd2ZXJ0aWNhbCcsXG5cdFx0XHRhdXRvbWF0aWMgPSBpdGVtLmdldEF0dHJpYnV0ZSggJ2RhdGEtdGFiYmVyLWF1dG9tYXRpYycgKSxcblx0XHRcdHRpbWluZyA9IGl0ZW0uZ2V0QXR0cmlidXRlKCAnZGF0YS10YWJiZXItdGltaW5nJyApIHx8IDIwMCxcblx0XHRcdGN1cnJlbnRUYWIgPSBudWxsO1xuXG5cdFx0aXRlbS5jbGFzc0xpc3QuYWRkKCAnanMtYWN0aXZlJyApO1xuXG5cdFx0dGFicy5mb3JFYWNoKCh0YWIsIGkpID0+IHtcblx0XHRcdHRhYi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGNsaWNrRXZlbnRMaXN0ZW5lcik7XG5cdFx0XHR0YWIuYWRkRXZlbnRMaXN0ZW5lcigna2V5ZG93bicsIGtleWRvd25FdmVudExpc3RlbmVyKTtcblxuXHRcdFx0Ly90aGlzIGlzIHVzZWQgZm9yIGtleXByZXNzIGRpcmVjdGlvbiBkZXRlcm1pbmF0aW9uXG5cdFx0XHR0YWIuaW5kZXggPSBpO1xuXHRcdH0pO1xuXG5cdFx0cGFuZWxzLmZvckVhY2goKHBhbmVsKSA9PiB7XG5cdFx0XHRwYW5lbC5zZXRBdHRyaWJ1dGUoICdoaWRkZW4nLCAnaGlkZGVuJyApO1xuXHRcdH0pO1xuXG5cdFx0Ly8gV2hlbiBhIHRhYiBpcyBjbGlja2VkLCBhY3RpdmF0ZVRhYiBpcyBmaXJlZCB0byBhY3RpdmF0ZSBpdFxuXHRcdGZ1bmN0aW9uIGNsaWNrRXZlbnRMaXN0ZW5lciAoZXZlbnQpIHtcblx0XHRcdHZhciB0YWIgPSBldmVudC50YXJnZXQ7XG5cdFx0XHRhY3RpdmF0ZVRhYiggdGFiLCB0cnVlICk7XG5cdFx0fTtcblxuXHRcdC8vbmF2aWdhdGUgdG8gYSBwYXJ0aWN1bGFyIHRhYiwgaWYgYXV0b21hdGljIGNoYW5nZSBpcyBhY3RpdmUsIGFsc28gYWN0aXZhdGUgdGFiXG5cdFx0ZnVuY3Rpb24gbmF2aWdhdGVUYWIoIHRhYiApe1xuXHRcdFx0dGFiLmZvY3VzKCk7XG5cdFx0XHRpZiggYXV0b21hdGljICl7XG5cdFx0XHRcdGFjdGl2YXRlVGFiKCB0YWIsIHRydWUgKTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHQvL2RlYWN0aXZhdGUgbGFzdCB0YWJcblx0XHRmdW5jdGlvbiBkZWFjdGl2YXRlVGFiKCB0YWIgKXtcblx0XHRcdHRhYi5zZXRBdHRyaWJ1dGUoJ3RhYmluZGV4JywgJy0xJyk7XG5cdFx0XHR0YWIuc2V0QXR0cmlidXRlKCdhcmlhLXNlbGVjdGVkJywgJ2ZhbHNlJyk7XG5cblx0XHRcdHZhciBwYW5lbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCB0YWIuZ2V0QXR0cmlidXRlKCdhcmlhLWNvbnRyb2xzJykgKTtcblx0XHRcdHBhbmVsLmNsYXNzTGlzdC5yZW1vdmUoICdhY3RpdmUnICk7XG5cdFx0XHRwYW5lbC5jbGFzc0xpc3QuYWRkKCAndHJhbnNpdGlvbi0tb3V0JyApO1xuXHRcdFx0cGFuZWwuc2V0QXR0cmlidXRlKCAndGFiaW5kZXgnLCAtMSApO1xuXHRcdFx0c2V0VGltZW91dCggZnVuY3Rpb24oKXtcblx0XHRcdFx0cGFuZWwuc2V0QXR0cmlidXRlKCAnaGlkZGVuJywgJ2hpZGRlbicgKTtcblx0XHRcdFx0cGFuZWwuY2xhc3NMaXN0LnJlbW92ZSggJ3RyYW5zaXRpb24tLW91dCcgKTtcblx0XHRcdH0sIHRpbWluZyApO1xuXHRcdH1cblxuXHRcdC8vYWN0aXZhdGUgbmV3IHRhYlxuXHRcdGZ1bmN0aW9uIGFjdGl2YXRlVGFiICh0YWIsIHNldEZvY3VzICkge1xuXHRcdFx0c2V0Rm9jdXMgPSBzZXRGb2N1cyB8fCBmYWxzZTtcblxuXHRcdFx0c2VsZi5kaXNwYXRjaEV2ZW50KG5ldyBDdXN0b21FdmVudCgndGFiYmVyOmJlZm9yZUFjdGl2YXRpb24nLCB7IGJ1YmJsZXM6IHRydWUsIGRldGFpbDogeyB0YWJiZXI6IHNlbGYsIHRhYjogdGFiIH19KSk7XG5cblx0XHRcdC8vcHJldmVudCBhY3Rpb24gaWYgdGFiIGlzIGFscmVhZHkgY3VycmVudFxuXHRcdFx0aWYoIHRhYiA9PT0gY3VycmVudFRhYiApe1xuXHRcdFx0XHRyZXR1cm47XG5cdFx0XHR9XG5cblx0XHRcdGlmKCBjdXJyZW50VGFiICl7XG5cdFx0XHRcdGRlYWN0aXZhdGVUYWIoIGN1cnJlbnRUYWIgKTtcblx0XHRcdH1cblx0XHRcdGN1cnJlbnRUYWIgPSB0YWI7XG5cblx0XHRcdC8vIEdldCB0aGUgdmFsdWUgb2YgYXJpYS1jb250cm9scyAod2hpY2ggaXMgYW4gSUQpXG5cdFx0XHR2YXIgY29udHJvbHMgPSB0YWIuZ2V0QXR0cmlidXRlKCdhcmlhLWNvbnRyb2xzJyk7XG5cblx0XHRcdC8vc2V0IHRhYiBhdHRyaWJ1dGVzXG5cdFx0XHR0YWIuc2V0QXR0cmlidXRlKCd0YWJpbmRleCcsIDAgKTtcblx0XHRcdHRhYi5zZXRBdHRyaWJ1dGUoJ2FyaWEtc2VsZWN0ZWQnLCAndHJ1ZScpO1xuXG5cdFx0XHQvL3NldCBwYW5lbCBhdHRyaWJ1dGVzXG5cdFx0XHR2YXIgcGFuZWwgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChjb250cm9scyk7XG5cdFx0XHRwYW5lbC5yZW1vdmVBdHRyaWJ1dGUoICdoaWRkZW4nICk7XG5cdFx0XHRwYW5lbC5zZXRBdHRyaWJ1dGUoICd0YWJpbmRleCcsIDAgKTtcblx0XHRcdHBhbmVsLmNsYXNzTGlzdC5hZGQoJ3RyYW5zaXRpb24tLWluJylcblx0XHRcdHNlbGYuZGlzcGF0Y2hFdmVudChuZXcgQ3VzdG9tRXZlbnQoJ3RhYmJlcjpkdXJpbmdBY3RpdmF0aW9uJywgeyBidWJibGVzOiB0cnVlLCBkZXRhaWw6IHsgdGFiYmVyOiBzZWxmLCB0YWI6IHRhYiB9fSkpO1xuXHRcdFx0c2V0VGltZW91dCggZnVuY3Rpb24oKXtcblx0XHRcdFx0cGFuZWwuY2xhc3NMaXN0LmFkZCggJ2FjdGl2ZScgKTtcblx0XHRcdFx0cGFuZWwuY2xhc3NMaXN0LnJlbW92ZSggJ3RyYW5zaXRpb24tLWluJyApO1xuXHRcdFx0XHRzZWxmLmRpc3BhdGNoRXZlbnQobmV3IEN1c3RvbUV2ZW50KCd0YWJiZXI6YWZ0ZXJBY3RpdmF0aW9uJywgeyBidWJibGVzOiB0cnVlLCBkZXRhaWw6IHsgdGFiYmVyOiBzZWxmLCB0YWI6IHRhYiB9fSkpO1xuXHRcdFx0fSwgdGltaW5nICk7XG5cblx0XHRcdC8vIFNldCBmb2N1cyB3aGVuIHJlcXVpcmVkXG5cdFx0XHRpZiAoc2V0Rm9jdXMpIHtcblx0XHRcdFx0dGFiLmZvY3VzKCk7XG5cdFx0XHR9O1xuXHRcdH07XG5cblx0XHR2YXIgaGFzaCA9IHdpbmRvdy5sb2NhdGlvbi5oYXNoLnN1YnN0cigxKTtcblx0XHRpZiggJycgIT09IGhhc2ggJiYgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoIGhhc2ggKS5nZXRBdHRyaWJ1dGUoICdyb2xlJyApID09PSAndGFiJyApe1xuXHRcdFx0YWN0aXZhdGVUYWIoIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCBoYXNoICksIGZhbHNlICk7XG5cdFx0fWVsc2V7XG5cdFx0XHRhY3RpdmF0ZVRhYiggdGFic1swXSwgZmFsc2UgKTtcblx0XHR9XG5cblx0XHQvLyBIYW5kbGUga2V5ZG93biBvbiB0YWJzXG5cdFx0ZnVuY3Rpb24ga2V5ZG93bkV2ZW50TGlzdGVuZXIgKGV2ZW50KSB7XG5cdFx0XHR2YXIgZXZlbnQgPSBldmVudCB8fCB3aW5kb3cuZXZlbnQsXG5cdFx0XHRcdGtleSA9IGV2ZW50LmtleUNvZGUgfHwgZXZlbnQud2hpY2g7XG5cblx0XHRcdHN3aXRjaCAoa2V5KSB7XG5cdFx0XHRcdGNhc2Uga2V5cy5lbmQ6XG5cdFx0XHRcdFx0ZXZlbnQucHJldmVudERlZmF1bHQoKTtcblx0XHRcdFx0XHQvLyBBY3RpdmF0ZSBsYXN0IHRhYlxuXHRcdFx0XHRcdGZvY3VzTGFzdFRhYigpO1xuXHRcdFx0XHRicmVhaztcblx0XHRcdFx0Y2FzZSBrZXlzLmhvbWU6XG5cdFx0XHRcdFx0ZXZlbnQucHJldmVudERlZmF1bHQoKTtcblx0XHRcdFx0XHQvLyBBY3RpdmF0ZSBmaXJzdCB0YWJcblx0XHRcdFx0XHRmb2N1c0ZpcnN0VGFiKCk7XG5cdFx0XHRcdGJyZWFrO1xuXG5cdFx0XHRcdC8vaGFuZGxlIG5hdmlnYXRpb24gYmFzZWQgb24gb3JpZW50YXRpb25cblx0XHRcdFx0Y2FzZSBrZXlzLnVwOlxuXHRcdFx0XHRjYXNlIGtleXMuZG93bjpcblx0XHRcdFx0Y2FzZSBrZXlzLmxlZnQ6XG5cdFx0XHRcdGNhc2Uga2V5cy5yaWdodDpcblx0XHRcdFx0XHRkZXRlcm1pbmVPcmllbnRhdGlvbihldmVudCk7XG5cdFx0XHRcdGJyZWFrO1xuXHRcdFx0XHRjYXNlIGtleXMuZW50ZXI6XG5cdFx0XHRcdGNhc2Uga2V5cy5zcGFjZTpcblx0XHRcdFx0XHRpZiggZmFsc2UgPT09IGF1dG9tYXRpYyApe1xuXHRcdFx0XHRcdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdFx0XHRcdFx0YWN0aXZhdGVUYWIoZXZlbnQudGFyZ2V0KTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdGJyZWFrO1xuXHRcdFx0fTtcblx0XHR9O1xuXG5cdFx0Ly8gV2hlbiBhIHRhYmxpc3QncyBhcmlhLW9yaWVudGF0aW9uIGlzIHNldCB0byB2ZXJ0aWNhbCxcblx0XHQvLyBvbmx5IHVwIGFuZCBkb3duIGFycm93IHNob3VsZCBmdW5jdGlvbi5cblx0XHQvLyBJbiBhbGwgb3RoZXIgY2FzZXMgb25seSBsZWZ0IGFuZCByaWdodCBhcnJvdyBmdW5jdGlvbi5cblx0XHRmdW5jdGlvbiBkZXRlcm1pbmVPcmllbnRhdGlvbiAoZXZlbnQpIHtcblx0XHRcdHZhciBldmVudCA9IGV2ZW50IHx8IHdpbmRvdy5ldmVudCxcblx0XHRcdFx0a2V5ID0gZXZlbnQua2V5Q29kZSB8fCBldmVudC53aGljaCxcblx0XHRcdFx0cHJvY2VlZCA9IGZhbHNlO1xuXG5cdFx0XHRpZiAodmVydGljYWwpIHtcblx0XHRcdFx0aWYgKGtleSA9PT0ga2V5cy51cCB8fCBrZXkgPT09IGtleXMuZG93bikge1xuXHRcdFx0XHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cdFx0XHRcdFx0cHJvY2VlZCA9IHRydWU7XG5cdFx0XHRcdH07XG5cdFx0XHR9XG5cdFx0XHRlbHNlIHtcblx0XHRcdFx0aWYgKGtleSA9PT0ga2V5cy5sZWZ0IHx8IGtleSA9PT0ga2V5cy5yaWdodCkge1xuXHRcdFx0XHRcdHByb2NlZWQgPSB0cnVlO1xuXHRcdFx0XHR9O1xuXHRcdFx0fTtcblxuXHRcdFx0aWYgKHByb2NlZWQpIHtcblx0XHRcdFx0c3dpdGNoVGFiT25BcnJvd1ByZXNzKGV2ZW50KTtcblx0XHRcdH07XG5cdFx0fTtcblxuXHRcdC8vIEVpdGhlciBmb2N1cyB0aGUgbmV4dCwgcHJldmlvdXMsIGZpcnN0LCBvciBsYXN0IHRhYlxuXHRcdC8vIGRlcGVuZGluZyBvbiBrZXkgcHJlc3NlZFxuXHRcdGZ1bmN0aW9uIHN3aXRjaFRhYk9uQXJyb3dQcmVzcyAoZXZlbnQpIHtcblx0XHRcdHZhciBldmVudCA9IGV2ZW50IHx8IHdpbmRvdy5ldmVudCxcblx0XHRcdFx0a2V5ID0gZXZlbnQua2V5Q29kZSB8fCBldmVudC53aGljaDtcblxuXHRcdFx0aWYgKGRpcmVjdGlvbltrZXldKSB7XG5cdFx0XHRcdHZhciB0YXJnZXQgPSBldmVudC50YXJnZXQ7XG5cdFx0XHRcdGlmICh0YXJnZXQuaW5kZXggIT09IHVuZGVmaW5lZCkge1xuXHRcdFx0XHRcdGlmICh0YWJzW3RhcmdldC5pbmRleCArIGRpcmVjdGlvbltrZXldXSkge1xuXHRcdFx0XHRcdFx0bmF2aWdhdGVUYWIoIHRhYnNbdGFyZ2V0LmluZGV4ICsgZGlyZWN0aW9uW2tleV1dICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdGVsc2UgaWYgKGtleSA9PT0ga2V5cy5sZWZ0IHx8IGtleSA9PT0ga2V5cy51cCkge1xuXHRcdFx0XHRcdFx0Zm9jdXNMYXN0VGFiKCk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdGVsc2UgaWYgKGtleSA9PT0ga2V5cy5yaWdodCB8fCBrZXkgPT0ga2V5cy5kb3duKSB7XG5cdFx0XHRcdFx0XHRmb2N1c0ZpcnN0VGFiKCk7XG5cdFx0XHRcdFx0fTtcblx0XHRcdFx0fTtcblx0XHRcdH07XG5cdFx0fTtcblxuXHRcdC8vIE1ha2UgYSBndWVzc1xuXHRcdGZ1bmN0aW9uIGZvY3VzRmlyc3RUYWIgKCkge1xuXHRcdFx0bmF2aWdhdGVUYWIoIHRhYnNbMF0gKTtcblx0XHR9O1xuXG5cdFx0Ly8gTWFrZSBhIGd1ZXNzXG5cdFx0ZnVuY3Rpb24gZm9jdXNMYXN0VGFiICgpIHtcblx0XHRcdG5hdmlnYXRlVGFiKCB0YWJzW3RhYnMubGVuZ3RoIC0gMV0gKTtcblx0XHR9O1xuXHR9KTtcbn0oKSk7IiwiKGZ1bmN0aW9uKCQpe1xuXHQkKGZ1bmN0aW9uKCl7XG5cdFx0JCgnLmpzLXRlc3RpbW9uaWFsLXNsaWRlcicpLnNsaWNrKHtcblx0XHRcdGluZmluaXRlOiB0cnVlLFxuXHRcdFx0YWRhcHRpdmVIZWlnaHQ6IHRydWUsXG5cdFx0XHRmYWRlOiB0cnVlLFxuXHRcdFx0c3BlZWQ6IDEwLFxuXHRcdH0pO1xuXHR9KTtcbn0pKGpRdWVyeSk7IiwiKGZ1bmN0aW9uICgpIHtcblx0dmFyIHlvdXR1YmVWaWRlb3MgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuanMteW91dHViZS12aWRlbycpO1xuXHRpZiAoeW91dHViZVZpZGVvcy5sZW5ndGggPiAwKSB7XG5cdFx0dmFyIHRhZyA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ3NjcmlwdCcpO1xuXHRcdHRhZy5zcmMgPSBcImh0dHBzOi8vd3d3LnlvdXR1YmUuY29tL2lmcmFtZV9hcGlcIjtcblx0XHR2YXIgZmlyc3RTY3JpcHRUYWcgPSBkb2N1bWVudC5nZXRFbGVtZW50c0J5VGFnTmFtZSgnc2NyaXB0JylbMF07XG5cdFx0Zmlyc3RTY3JpcHRUYWcucGFyZW50Tm9kZS5pbnNlcnRCZWZvcmUodGFnLCBmaXJzdFNjcmlwdFRhZyk7XG5cdH1cblxuXHR2YXIgdmltZW9WaWRlb3MgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuanMtdmltZW8tdmlkZW8nKTtcblx0aWYgKHZpbWVvVmlkZW9zLmxlbmd0aCA+IDApIHtcblx0XHR2YXIgdGFnID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnc2NyaXB0Jyk7XG5cdFx0dGFnLnNyYyA9IFwiaHR0cHM6Ly9wbGF5ZXIudmltZW8uY29tL2FwaS9wbGF5ZXIuanNcIjtcblx0XHR2YXIgZmlyc3RTY3JpcHRUYWcgPSBkb2N1bWVudC5nZXRFbGVtZW50c0J5VGFnTmFtZSgnc2NyaXB0JylbMF07XG5cdFx0Zmlyc3RTY3JpcHRUYWcucGFyZW50Tm9kZS5pbnNlcnRCZWZvcmUodGFnLCBmaXJzdFNjcmlwdFRhZyk7XG5cdH1cblxuXHR2YXIgd2lzdGlhVmlkZW9zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmpzLXdpc3RpYS12aWRlbycpO1xuXHRpZiAod2lzdGlhVmlkZW9zLmxlbmd0aCA+IDApIHtcblx0XHR2YXIgdGFnID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnc2NyaXB0Jyk7XG5cdFx0dGFnLnNyYyA9IFwiaHR0cHM6Ly9mYXN0Lndpc3RpYS5jb20vYXNzZXRzL2V4dGVybmFsL0UtdjEuanNcIjtcblx0XHR2YXIgZmlyc3RTY3JpcHRUYWcgPSBkb2N1bWVudC5nZXRFbGVtZW50c0J5VGFnTmFtZSgnc2NyaXB0JylbMF07XG5cdFx0Zmlyc3RTY3JpcHRUYWcucGFyZW50Tm9kZS5pbnNlcnRCZWZvcmUodGFnLCBmaXJzdFNjcmlwdFRhZyk7XG5cdH1cblxuXHR2YXIgZW1iZWRWaWRlb3MgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuanMtZW1iZWQnKTtcblx0ZW1iZWRWaWRlb3MuZm9yRWFjaCgodmlkZW8sIGkpID0+IHtcblx0XHR2YXIgc2VydmljZSA9IHZpZGVvLmdldEF0dHJpYnV0ZSgnZGF0YS12aWRlby1zZXJ2aWNlJyksXG5cdFx0XHRpZCA9IHZpZGVvLmdldEF0dHJpYnV0ZSgnZGF0YS12aWRlby1pZCcpLFxuXHRcdFx0aWZyYW1lID0gdmlkZW8ucXVlcnlTZWxlY3RvcignaWZyYW1lJyksXG5cdFx0XHRidXR0b24gPSB2aWRlby5xdWVyeVNlbGVjdG9yKCdidXR0b24nKTtcblx0XHRidXR0b24uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBwbGF5VmlkZW8pO1xuXG5cdFx0Ly9zZXQgaWZyYW1lIHNyYyBzbyBpdCB3aWxsIGxvYWQgd2hpbGUgZmFkaW5nIG91dCAtPiByZW1vdmluZyBidXR0b25cblx0XHRmdW5jdGlvbiBwbGF5VmlkZW8oZSkge1xuXHRcdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdFx0dmFyIHZpZGVvX3VybCA9IGlmcmFtZS5kYXRhc2V0LnNyYztcblx0XHRcdGlmICgnd2lzdGlhJyAhPSBzZXJ2aWNlKSB7XG5cdFx0XHRcdHZpZGVvX3VybCArPSAnJmF1dG9wbGF5PTEmcmVsPTAmd21vZGU9dHJhbnNwYXJlbnQnO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0dmlkZW9fdXJsID0gYGh0dHBzOi8vZmFzdC53aXN0aWEubmV0L2VtYmVkL2lmcmFtZS8ke2lkfT9hdXRvcGxheT0xYDtcblx0XHRcdH1cblx0XHRcdGlmcmFtZS5zcmMgPSB2aWRlb191cmw7XG5cdFx0XHRhbmltZSh7XG5cdFx0XHRcdHRhcmdldHM6IGJ1dHRvbixcblx0XHRcdFx0b3BhY2l0eTogWzEsIDBdLFxuXHRcdFx0XHRlYXNpbmc6ICdlYXNlSW5PdXRRdWFkJyxcblx0XHRcdFx0ZHVyYXRpb246IDUwMCxcblx0XHRcdFx0Y29tcGxldGU6IGZ1bmN0aW9uIChhbmltKSB7XG5cdFx0XHRcdFx0YnV0dG9uLnJlbW92ZSgpO1xuXHRcdFx0XHR9XG5cdFx0XHR9KTtcblx0XHR9XG5cdH0pO1xuXG59KSgpO1xuXG5mdW5jdGlvbiBvbllvdVR1YmVJZnJhbWVBUElSZWFkeSgpIHtcblx0alF1ZXJ5KCcueW91dHViZS1iYWNrZ3JvdW5kLXZpZGVvJykuZWFjaChmdW5jdGlvbiAoKSB7XG5cdFx0dmFyIHZpZGVvID0galF1ZXJ5KHRoaXMpLmRhdGEoJ3ZpZGVvJyksXG5cdFx0XHRpZCA9IGpRdWVyeSh0aGlzKS5hdHRyKCdpZCcpLFxuXHRcdFx0cGxheWVyID0gbmV3IFlULlBsYXllcihpZCwge1xuXHRcdFx0XHRoZWlnaHQ6ICczNjAnLFxuXHRcdFx0XHR3aWR0aDogJzY0MCcsXG5cdFx0XHRcdHZpZGVvSWQ6IHZpZGVvLFxuXHRcdFx0XHRwbGF5ZXJWYXJzOiB7ICdjb250cm9scyc6IDAsICdzaG93aW5mbyc6IDAsICdyZWwnOiAwLCAnZW5hYmxlanNhcGknOiAxLCAnYXV0b3BsYXknOiAxLCAnbG9vcCc6IDEsICd3bW9kZSc6ICd0cmFuc3BhcmVudCcgfSxcblx0XHRcdFx0ZXZlbnRzOiB7XG5cdFx0XHRcdFx0J29uUmVhZHknOiBmdW5jdGlvbiAoZSkge1xuXHRcdFx0XHRcdFx0ZS50YXJnZXQucGxheVZpZGVvKCk7XG5cdFx0XHRcdFx0XHRlLnRhcmdldC5tdXRlKCk7XG5cdFx0XHRcdFx0XHRlLnRhcmdldC5zZXRQbGF5YmFja1F1YWxpdHkoJ2hkNzIwJyk7XG5cdFx0XHRcdFx0fSxcblx0XHRcdFx0XHRvblN0YXRlQ2hhbmdlOiBmdW5jdGlvbiAoZSkge1xuXHRcdFx0XHRcdFx0aWYgKGUuZGF0YSA9PT0gWVQuUGxheWVyU3RhdGUuRU5ERUQpIHtcblx0XHRcdFx0XHRcdFx0ZS50YXJnZXQucGxheVZpZGVvKCk7XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9KTtcblx0fSk7XG59XG5cbihmdW5jdGlvbiAoJCkge1xuXHQkKGZ1bmN0aW9uICgpIHtcblx0XHQkKFwiLmpzLXlvdXR1YmUtdmlkZW9cIikuZWFjaChmdW5jdGlvbiAoKSB7XG5cdFx0XHR2YXIgYnV0dG9uID0gJCh0aGlzKTtcblx0XHRcdCQodGhpcykub24oJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuXHRcdFx0XHR2YXIgdmlkZW8gPSBidXR0b24uZGF0YSgndmlkZW8nKSxcblx0XHRcdFx0XHRpZCA9ICQodGhpcykuYXR0cignaWQnKSxcblx0XHRcdFx0XHRwbGF5ZXIgPSBuZXcgWVQuUGxheWVyKGlkLCB7XG5cdFx0XHRcdFx0XHRoZWlnaHQ6ICczNjAnLFxuXHRcdFx0XHRcdFx0d2lkdGg6ICc2NDAnLFxuXHRcdFx0XHRcdFx0dmlkZW9JZDogdmlkZW8sXG5cdFx0XHRcdFx0XHRwbGF5ZXJWYXJzOiB7ICdjb250cm9scyc6IDEsICdzaG93aW5mbyc6IDAsICdyZWwnOiAwLCAnZW5hYmxlanNhcGknOiAxLCAnYXV0b3BsYXknOiAxLCAnd21vZGUnOiAndHJhbnNwYXJlbnQnIH0sXG5cdFx0XHRcdFx0XHRldmVudHM6IHtcblx0XHRcdFx0XHRcdFx0J29uUmVhZHknOiBmdW5jdGlvbiAoZSkge1xuXHRcdFx0XHRcdFx0XHRcdGUudGFyZ2V0LnBsYXlWaWRlbygpO1xuXHRcdFx0XHRcdFx0XHRcdGUudGFyZ2V0LnNldFBsYXliYWNrUXVhbGl0eSgnaGQ3MjAnKTtcblx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH0pO1xuXHRcdFx0fSk7XG5cdFx0fSk7XG5cdFx0JChcIi5qcy12aW1lby12aWRlb1wiKS5lYWNoKGZ1bmN0aW9uICgpIHtcblx0XHRcdHZhciBidXR0b24gPSAkKHRoaXMpO1xuXHRcdFx0JCh0aGlzKS5vbignY2xpY2snLCBmdW5jdGlvbiAoKSB7XG5cdFx0XHRcdHZhciB2aWRlbyA9IGJ1dHRvbi5kYXRhKCd2aWRlbycpLFxuXHRcdFx0XHRcdGlkID0gJCh0aGlzKS5wYXJlbnQoJ2RpdicpLFxuXHRcdFx0XHRcdHZpbWVvUGxheWVyID0gbmV3IFZpbWVvLlBsYXllcihpZCwgeyBpZDogdmlkZW8gfSk7XG5cdFx0XHRcdHZpbWVvUGxheWVyLnBsYXkoKTtcblx0XHRcdH0pO1xuXHRcdH0pO1xuXHRcdCQoXCIuanMtd2lzdGlhLXZpZGVvXCIpLmVhY2goZnVuY3Rpb24gKCkge1xuXHRcdFx0dmFyIGJ1dHRvbiA9ICQodGhpcyk7XG5cdFx0XHQkKHRoaXMpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcblx0XHRcdFx0dmFyIHZpZGVvID0gYnV0dG9uLmRhdGEoJ3ZpZGVvJyksXG5cdFx0XHRcdFx0aWQgPSAkKHRoaXMpLnBhcmVudCgnZGl2Jyk7XG5cdFx0XHRcdGlkLnJlbW92ZUNsYXNzKCkuYXR0cignaWQnLCBcIndpc3RpYS1cIiArIHZpZGVvICsgXCItMVwiKS5hZGRDbGFzcygnd2lzdGlhX2VtYmVkIGF1dG9QbGF5PXRydWUgd2lzdGlhX2FzeW5jXycgKyB2aWRlbyk7XG5cdFx0XHRcdHZhciB3aXN0aWFQbGF5ZXIgPSBXaXN0aWEuYXBpKHZpZGVvKTtcblx0XHRcdH0pO1xuXHRcdH0pO1xuXHRcdCQoXCIudmlkZW8tYnV0dG9uXCIpLmVhY2goZnVuY3Rpb24gKCkge1xuXHRcdFx0dmFyIGJ1dHRvbiA9ICQodGhpcyk7XG5cdFx0XHQkKHRoaXMpLm1hZ25pZmljUG9wdXAoe1xuXHRcdFx0XHR0eXBlOiAnaWZyYW1lJyxcblx0XHRcdFx0aWZyYW1lOiB7XG5cdFx0XHRcdFx0Ly90ZWxsIGlmcmFtZSB0aGF0IGl0IGNhbiBhdXRvcGxheSBhbmQgZnVsbHNjcmVlbiAtLSBjaHJvbWUgbmVlZHMgdGhpcyB0byBoZWxwIG1lZXQgYXV0cGxheSBjb25kaXRpb25zXG5cdFx0XHRcdFx0bWFya3VwOiAnPGRpdiBjbGFzcz1cIm1mcC1pZnJhbWUtc2NhbGVyXCI+JyArXG5cdFx0XHRcdFx0XHQnPGRpdiBjbGFzcz1cIm1mcC1jbG9zZVwiPjwvZGl2PicgK1xuXHRcdFx0XHRcdFx0JzxpZnJhbWUgY2xhc3M9XCJtZnAtaWZyYW1lIHdpc3RpYV9lbWJlZFwiIHNyYz1cIi8vYWJvdXQ6YmxhbmtcIiBhbGxvdz1cImFjY2VsZXJvbWV0ZXI7IGF1dG9wbGF5OyBjbGlwYm9hcmQtd3JpdGU7IGVuY3J5cHRlZC1tZWRpYTsgZ3lyb3Njb3BlOyBwaWN0dXJlLWluLXBpY3R1cmVcIiBmcmFtZWJvcmRlcj1cIjBcIiBhbGxvd2Z1bGxzY3JlZW4gYWxsb3dhdXRvcGxheT48L2lmcmFtZT4nICtcblx0XHRcdFx0XHRcdCc8L2Rpdj4nLFxuXHRcdFx0XHRcdHBhdHRlcm5zOiB7XG5cdFx0XHRcdFx0XHQvL3dlIG92ZXJyaWRlIGRlZmF1bHQgbWFnbmlmaWMgc2luY2Ugb3VyIG1vZHVsZSBzcGl0cyBvdXQgdGhlIGVtYmVkIHBsYXllciBhbHJlYWR5XG5cdFx0XHRcdFx0XHR5b3V0dWJlOiB7XG5cdFx0XHRcdFx0XHRcdGluZGV4OiAneW91dHViZS5jb20nLFxuXHRcdFx0XHRcdFx0XHRpZDogJy8nLFxuXHRcdFx0XHRcdFx0XHRzcmM6ICcvL3d3dy55b3V0dWJlLmNvbS9lbWJlZC8laWQlP2F1dG9wbGF5PTEmcmVsPTAmd21vZGU9dHJhbnNwYXJlbnQnXG5cdFx0XHRcdFx0XHR9LFxuXHRcdFx0XHRcdFx0dmltZW86IHtcblx0XHRcdFx0XHRcdFx0aW5kZXg6ICd2aW1lby5jb20nLFxuXHRcdFx0XHRcdFx0XHRpZDogJy8nLFxuXHRcdFx0XHRcdFx0XHRzcmM6ICcvL3BsYXllci52aW1lby5jb20vdmlkZW8vJWlkJT9hdXRvcGxheT0xJnJlbD0wJndtb2RlPXRyYW5zcGFyZW50J1xuXHRcdFx0XHRcdFx0fSxcblx0XHRcdFx0XHRcdC8vaWYgY2xpZW50IGlzIG5vdCB1c2luZyB3aXN0aWEsIHlvdSBjYW4gY29tbWVudCB0aGVzZSBvdXRcblx0XHRcdFx0XHRcdHdpc3RpYWNvbToge1xuXHRcdFx0XHRcdFx0XHRpbmRleDogJ3dpc3RpYS5jb20nLFxuXHRcdFx0XHRcdFx0XHRpZDogZnVuY3Rpb24gKHVybCkge1xuXHRcdFx0XHRcdFx0XHRcdHZhciBtID0gdXJsLm1hdGNoKC9eLit3aXN0aWEuY29tXFwvKG1lZGlhcylcXC8oW15fXSspW14jXSooI21lZGlhcz0oW15fJl0rKSk/Lyk7XG5cdFx0XHRcdFx0XHRcdFx0aWYgKG0gIT09IG51bGwpIHtcblx0XHRcdFx0XHRcdFx0XHRcdGlmIChtWzRdICE9PSB1bmRlZmluZWQpIHtcblx0XHRcdFx0XHRcdFx0XHRcdFx0cmV0dXJuIG1bNF07XG5cdFx0XHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdFx0XHRyZXR1cm4gbVsyXTtcblx0XHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdFx0cmV0dXJuIG51bGw7XG5cdFx0XHRcdFx0XHRcdH0sXG5cdFx0XHRcdFx0XHRcdHNyYzogJy8vZmFzdC53aXN0aWEubmV0L2VtYmVkL2lmcmFtZS8laWQlP2F1dG9QbGF5PTEnIC8vIGh0dHBzOi8vd2lzdGlhLmNvbS9kb2MvZW1iZWQtb3B0aW9ucyNvcHRpb25zX2xpc3Rcblx0XHRcdFx0XHRcdH0sXG5cdFx0XHRcdFx0XHR3aXN0aWFuZXQ6IHtcblx0XHRcdFx0XHRcdFx0aW5kZXg6ICd3aXN0aWEubmV0Jyxcblx0XHRcdFx0XHRcdFx0aWQ6IGZ1bmN0aW9uICh1cmwpIHtcblx0XHRcdFx0XHRcdFx0XHR2YXIgbSA9IHVybC5tYXRjaCgvXi4rd2lzdGlhLm5ldFxcL2VtYmVkXFwvaWZyYW1lXFwvKFteX10rKS8pO1xuXHRcdFx0XHRcdFx0XHRcdGlmIChtICE9PSBudWxsKSB7XG5cdFx0XHRcdFx0XHRcdFx0XHRyZXR1cm4gbVsxXTtcblx0XHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdFx0cmV0dXJuIG51bGw7XG5cdFx0XHRcdFx0XHRcdH0sXG5cdFx0XHRcdFx0XHRcdHNyYzogJy8vZmFzdC53aXN0aWEubmV0L2VtYmVkL2lmcmFtZS8laWQlP2F1dG9QbGF5PTEnIC8vIGh0dHBzOi8vd2lzdGlhLmNvbS9kb2MvZW1iZWQtb3B0aW9ucyNvcHRpb25zX2xpc3Rcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9LFxuXHRcdFx0XHR9XG5cdFx0XHR9KTtcblx0XHR9KTtcblx0fSk7XG59KShqUXVlcnkpOyIsIi8qKlxuICogQW5pbWF0aW9ucyBhcmUgbGFzdCB0byBtYWtlIHN1cmUgb3RoZXIgZWZmZWN0cyBvciBtb3ZlbWVudCBoYXBwZW4gZmlyc3QgYXMgaGVpZ2h0IGNhbGN1bGF0aW9ucyBjYW4gYWZmZWN0IHRoaXNcbiAqL1xuXG4vL3RoaXMgcmVtb3ZlcyBvdXIgZmFsbGJhY2sgY3NzIGFuaW1hdGlvbnMgLSBlYWNoIG1vZHVsZSBzaG91bGQgaGF2ZSBhIGZhbGxiYWNrIGFuaW1hdGlvbiB0byBzZXQgaXRzIG9wYWNpdHkgdG8gMVxudmFyIGJvZHkgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCAnYm9keScgKTtcbmJvZHkuY2xhc3NMaXN0LnJlbW92ZSgnbm8tanMnKTtcblxuKGZ1bmN0aW9uKCl7XG5cblx0Ly90aGlzIGlzIHRoZSBtb3N0IGJhc2ljIGFuaW1hdGlvbiBleGFtcGxlLCBidXQgcGxlYXNlIG1ha2UgbW9yZSBzcGVjaWZpYyBvbmVzIHBlciBtb2R1bGUgYW5kIHJlbW92ZSB0aGlzIG9uZS5cblx0Ly9odHRwczovL2FuaW1lanMuY29tL2RvY3VtZW50YXRpb24vXG5cdGNvbnN0IG1vZHVsZXMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcubW9kdWxlJyk7XG5cdG1vZHVsZXMuZm9yRWFjaCgobW9kdWxlLGkpID0+IHtcblx0XHRtb2R1bGUud2F5cG9pbnQgPSBuZXcgV2F5cG9pbnQoe1xuXHRcdFx0ZWxlbWVudDogbW9kdWxlLFxuXHRcdFx0aGFuZGxlcjogZnVuY3Rpb24oZGlyZWN0aW9uKSB7XG5cdFx0XHRcdGFuaW1lKHtcblx0XHRcdFx0XHR0YXJnZXRzOiBtb2R1bGUsXG5cdFx0XHRcdFx0b3BhY2l0eTogWyAwLCAxIF0sXG5cdFx0XHRcdFx0dHJhbnNsYXRlWTogWyAyMDAsIDBdLFxuXHRcdFx0XHRcdGRlbGF5OiBhbmltZS5zdGFnZ2VyKCAxMDAgKVxuXHRcdFx0XHR9KTtcblx0XHRcdFx0dGhpcy5kZXN0cm95KCk7XG5cdFx0XHR9LFxuXHRcdFx0b2Zmc2V0OiBcIjkwJVwiLFxuXHRcdH0pO1xuXHR9KTtcblxuXHQvKlxuXHRjb25zdCBiYXNpY190ZXh0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLm1vZHVsZS0tYmFzaWNfdGV4dCcpO1xuXHRiYXNpY190ZXh0LmZvckVhY2goKG1vZHVsZSxpKSA9PiB7XG5cdFx0bW9kdWxlLndheXBvaW50ID0gbmV3IFdheXBvaW50KHtcblx0XHRcdGVsZW1lbnQ6IG1vZHVsZSxcblx0XHRcdGhhbmRsZXI6IGZ1bmN0aW9uKGRpcmVjdGlvbikge1xuXHRcdFx0XHRhbmltZSh7XG5cdFx0XHRcdFx0dGFyZ2V0czogbW9kdWxlLnF1ZXJ5U2VsZWN0b3JBbGwoJy50aXRsZSwgcCwgLmJ1dHRvbicpLFxuXHRcdFx0XHRcdHRyYW5zbGF0ZVk6IFsxMDAsMF0sXG5cdFx0XHRcdFx0b3BhY2l0eTogWzAsMV0sXG5cdFx0XHRcdFx0ZGVsYXk6IGFuaW1lLnN0YWdnZXIoMTAwKSAvLyBkZWxheSBzdGFydHMgYXQgNTAwbXMgdGhlbiBpbmNyZWFzZSBieSAxMDBtcyBmb3IgZWFjaCBlbGVtZW50cy5cblx0XHRcdFx0fSk7XG5cdFx0XHRcdHRoaXMuZGVzdHJveSgpO1xuXHRcdFx0fSxcblx0XHRcdG9mZnNldDogXCI5MCVcIixcblx0XHR9KTtcblx0fSk7XG5cdCovXG5cbn0pKCk7XG4iXX0=
