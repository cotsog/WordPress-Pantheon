(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
(function (global, factory) {
  if (typeof define === 'function' && define.amd) {
    define(['exports', 'module', './util'], factory);
  } else if (typeof exports !== 'undefined' && typeof module !== 'undefined') {
    factory(exports, module, require('./util'));
  } else {
    var mod = {
      exports: {}
    };
    factory(mod.exports, mod, global.Util);
    global.collapse = mod.exports;
  }
})(this, function (exports, module, _util) {
  'use strict';

  var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

  function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

  function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

  var _Util = _interopRequireDefault(_util);

  /**
   * --------------------------------------------------------------------------
   * Bootstrap (v4.0.0-alpha.2): collapse.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
   * --------------------------------------------------------------------------
   */

  var Collapse = (function ($) {

    /**
     * ------------------------------------------------------------------------
     * Constants
     * ------------------------------------------------------------------------
     */

    var NAME = 'collapse';
    var VERSION = '4.0.0-alpha';
    var DATA_KEY = 'bs.collapse';
    var EVENT_KEY = '.' + DATA_KEY;
    var DATA_API_KEY = '.data-api';
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var TRANSITION_DURATION = 600;

    var Default = {
      toggle: true,
      parent: ''
    };

    var DefaultType = {
      toggle: 'boolean',
      parent: 'string'
    };

    var Event = {
      SHOW: 'show' + EVENT_KEY,
      SHOWN: 'shown' + EVENT_KEY,
      HIDE: 'hide' + EVENT_KEY,
      HIDDEN: 'hidden' + EVENT_KEY,
      CLICK_DATA_API: 'click' + EVENT_KEY + DATA_API_KEY
    };

    var ClassName = {
      IN: 'in',
      COLLAPSE: 'collapse',
      COLLAPSING: 'collapsing',
      COLLAPSED: 'collapsed'
    };

    var Dimension = {
      WIDTH: 'width',
      HEIGHT: 'height'
    };

    var Selector = {
      ACTIVES: '.panel > .in, .panel > .collapsing',
      DATA_TOGGLE: '[data-toggle="collapse"]'
    };

    /**
     * ------------------------------------------------------------------------
     * Class Definition
     * ------------------------------------------------------------------------
     */

    var Collapse = (function () {
      function Collapse(element, config) {
        _classCallCheck(this, Collapse);

        this._isTransitioning = false;
        this._element = element;
        this._config = this._getConfig(config);
        this._triggerArray = $.makeArray($('[data-toggle="collapse"][href="#' + element.id + '"],' + ('[data-toggle="collapse"][data-target="#' + element.id + '"]')));

        this._parent = this._config.parent ? this._getParent() : null;

        if (!this._config.parent) {
          this._addAriaAndCollapsedClass(this._element, this._triggerArray);
        }

        if (this._config.toggle) {
          this.toggle();
        }
      }

      /**
       * ------------------------------------------------------------------------
       * Data Api implementation
       * ------------------------------------------------------------------------
       */

      // getters

      _createClass(Collapse, [{
        key: 'toggle',

        // public

        value: function toggle() {
          if ($(this._element).hasClass(ClassName.IN)) {
            this.hide();
          } else {
            this.show();
          }
        }
      }, {
        key: 'show',
        value: function show() {
          var _this = this;

          if (this._isTransitioning || $(this._element).hasClass(ClassName.IN)) {
            return;
          }

          var actives = undefined;
          var activesData = undefined;

          if (this._parent) {
            actives = $.makeArray($(Selector.ACTIVES));
            if (!actives.length) {
              actives = null;
            }
          }

          if (actives) {
            activesData = $(actives).data(DATA_KEY);
            if (activesData && activesData._isTransitioning) {
              return;
            }
          }

          var startEvent = $.Event(Event.SHOW);
          $(this._element).trigger(startEvent);
          if (startEvent.isDefaultPrevented()) {
            return;
          }

          if (actives) {
            Collapse._jQueryInterface.call($(actives), 'hide');
            if (!activesData) {
              $(actives).data(DATA_KEY, null);
            }
          }

          var dimension = this._getDimension();

          $(this._element).removeClass(ClassName.COLLAPSE).addClass(ClassName.COLLAPSING);

          this._element.style[dimension] = 0;
          this._element.setAttribute('aria-expanded', true);

          if (this._triggerArray.length) {
            $(this._triggerArray).removeClass(ClassName.COLLAPSED).attr('aria-expanded', true);
          }

          this.setTransitioning(true);

          var complete = function complete() {
            $(_this._element).removeClass(ClassName.COLLAPSING).addClass(ClassName.COLLAPSE).addClass(ClassName.IN);

            _this._element.style[dimension] = '';

            _this.setTransitioning(false);

            $(_this._element).trigger(Event.SHOWN);
          };

          if (!_Util['default'].supportsTransitionEnd()) {
            complete();
            return;
          }

          var capitalizedDimension = dimension[0].toUpperCase() + dimension.slice(1);
          var scrollSize = 'scroll' + capitalizedDimension;

          $(this._element).one(_Util['default'].TRANSITION_END, complete).emulateTransitionEnd(TRANSITION_DURATION);

          this._element.style[dimension] = this._element[scrollSize] + 'px';
        }
      }, {
        key: 'hide',
        value: function hide() {
          var _this2 = this;

          if (this._isTransitioning || !$(this._element).hasClass(ClassName.IN)) {
            return;
          }

          var startEvent = $.Event(Event.HIDE);
          $(this._element).trigger(startEvent);
          if (startEvent.isDefaultPrevented()) {
            return;
          }

          var dimension = this._getDimension();
          var offsetDimension = dimension === Dimension.WIDTH ? 'offsetWidth' : 'offsetHeight';

          this._element.style[dimension] = this._element[offsetDimension] + 'px';

          _Util['default'].reflow(this._element);

          $(this._element).addClass(ClassName.COLLAPSING).removeClass(ClassName.COLLAPSE).removeClass(ClassName.IN);

          this._element.setAttribute('aria-expanded', false);

          if (this._triggerArray.length) {
            $(this._triggerArray).addClass(ClassName.COLLAPSED).attr('aria-expanded', false);
          }

          this.setTransitioning(true);

          var complete = function complete() {
            _this2.setTransitioning(false);
            $(_this2._element).removeClass(ClassName.COLLAPSING).addClass(ClassName.COLLAPSE).trigger(Event.HIDDEN);
          };

          this._element.style[dimension] = 0;

          if (!_Util['default'].supportsTransitionEnd()) {
            complete();
            return;
          }

          $(this._element).one(_Util['default'].TRANSITION_END, complete).emulateTransitionEnd(TRANSITION_DURATION);
        }
      }, {
        key: 'setTransitioning',
        value: function setTransitioning(isTransitioning) {
          this._isTransitioning = isTransitioning;
        }
      }, {
        key: 'dispose',
        value: function dispose() {
          $.removeData(this._element, DATA_KEY);

          this._config = null;
          this._parent = null;
          this._element = null;
          this._triggerArray = null;
          this._isTransitioning = null;
        }

        // private

      }, {
        key: '_getConfig',
        value: function _getConfig(config) {
          config = $.extend({}, Default, config);
          config.toggle = Boolean(config.toggle); // coerce string values
          _Util['default'].typeCheckConfig(NAME, config, DefaultType);
          return config;
        }
      }, {
        key: '_getDimension',
        value: function _getDimension() {
          var hasWidth = $(this._element).hasClass(Dimension.WIDTH);
          return hasWidth ? Dimension.WIDTH : Dimension.HEIGHT;
        }
      }, {
        key: '_getParent',
        value: function _getParent() {
          var _this3 = this;

          var parent = $(this._config.parent)[0];
          var selector = '[data-toggle="collapse"][data-parent="' + this._config.parent + '"]';

          $(parent).find(selector).each(function (i, element) {
            _this3._addAriaAndCollapsedClass(Collapse._getTargetFromElement(element), [element]);
          });

          return parent;
        }
      }, {
        key: '_addAriaAndCollapsedClass',
        value: function _addAriaAndCollapsedClass(element, triggerArray) {
          if (element) {
            var isOpen = $(element).hasClass(ClassName.IN);
            element.setAttribute('aria-expanded', isOpen);

            if (triggerArray.length) {
              $(triggerArray).toggleClass(ClassName.COLLAPSED, !isOpen).attr('aria-expanded', isOpen);
            }
          }
        }

        // static

      }], [{
        key: '_getTargetFromElement',
        value: function _getTargetFromElement(element) {
          var selector = _Util['default'].getSelectorFromElement(element);
          return selector ? $(selector)[0] : null;
        }
      }, {
        key: '_jQueryInterface',
        value: function _jQueryInterface(config) {
          return this.each(function () {
            var $this = $(this);
            var data = $this.data(DATA_KEY);
            var _config = $.extend({}, Default, $this.data(), typeof config === 'object' && config);

            if (!data && _config.toggle && /show|hide/.test(config)) {
              _config.toggle = false;
            }

            if (!data) {
              data = new Collapse(this, _config);
              $this.data(DATA_KEY, data);
            }

            if (typeof config === 'string') {
              if (data[config] === undefined) {
                throw new Error('No method named "' + config + '"');
              }
              data[config]();
            }
          });
        }
      }, {
        key: 'VERSION',
        get: function get() {
          return VERSION;
        }
      }, {
        key: 'Default',
        get: function get() {
          return Default;
        }
      }]);

      return Collapse;
    })();

    $(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, function (event) {
      event.preventDefault();

      var target = Collapse._getTargetFromElement(this);
      var data = $(target).data(DATA_KEY);
      var config = data ? 'toggle' : $(this).data();

      Collapse._jQueryInterface.call($(target), config);
    });

    /**
     * ------------------------------------------------------------------------
     * jQuery
     * ------------------------------------------------------------------------
     */

    $.fn[NAME] = Collapse._jQueryInterface;
    $.fn[NAME].Constructor = Collapse;
    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return Collapse._jQueryInterface;
    };

    return Collapse;
  })(jQuery);

  module.exports = Collapse;
});

},{"./util":2}],2:[function(require,module,exports){
(function (global, factory) {
  if (typeof define === 'function' && define.amd) {
    define(['exports', 'module'], factory);
  } else if (typeof exports !== 'undefined' && typeof module !== 'undefined') {
    factory(exports, module);
  } else {
    var mod = {
      exports: {}
    };
    factory(mod.exports, mod);
    global.util = mod.exports;
  }
})(this, function (exports, module) {
  /**
   * --------------------------------------------------------------------------
   * Bootstrap (v4.0.0-alpha.2): util.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
   * --------------------------------------------------------------------------
   */

  'use strict';

  var Util = (function ($) {

    /**
     * ------------------------------------------------------------------------
     * Private TransitionEnd Helpers
     * ------------------------------------------------------------------------
     */

    var transition = false;

    var TransitionEndEvent = {
      WebkitTransition: 'webkitTransitionEnd',
      MozTransition: 'transitionend',
      OTransition: 'oTransitionEnd otransitionend',
      transition: 'transitionend'
    };

    // shoutout AngusCroll (https://goo.gl/pxwQGp)
    function toType(obj) {
      return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
    }

    function isElement(obj) {
      return (obj[0] || obj).nodeType;
    }

    function getSpecialTransitionEndEvent() {
      return {
        bindType: transition.end,
        delegateType: transition.end,
        handle: function handle(event) {
          if ($(event.target).is(this)) {
            return event.handleObj.handler.apply(this, arguments);
          }
        }
      };
    }

    function transitionEndTest() {
      if (window.QUnit) {
        return false;
      }

      var el = document.createElement('bootstrap');

      for (var _name in TransitionEndEvent) {
        if (el.style[_name] !== undefined) {
          return { end: TransitionEndEvent[_name] };
        }
      }

      return false;
    }

    function transitionEndEmulator(duration) {
      var _this = this;

      var called = false;

      $(this).one(Util.TRANSITION_END, function () {
        called = true;
      });

      setTimeout(function () {
        if (!called) {
          Util.triggerTransitionEnd(_this);
        }
      }, duration);

      return this;
    }

    function setTransitionEndSupport() {
      transition = transitionEndTest();

      $.fn.emulateTransitionEnd = transitionEndEmulator;

      if (Util.supportsTransitionEnd()) {
        $.event.special[Util.TRANSITION_END] = getSpecialTransitionEndEvent();
      }
    }

    /**
     * --------------------------------------------------------------------------
     * Public Util Api
     * --------------------------------------------------------------------------
     */

    var Util = {

      TRANSITION_END: 'bsTransitionEnd',

      getUID: function getUID(prefix) {
        do {
          prefix += ~ ~(Math.random() * 1000000); // "~~" acts like a faster Math.floor() here
        } while (document.getElementById(prefix));
        return prefix;
      },

      getSelectorFromElement: function getSelectorFromElement(element) {
        var selector = element.getAttribute('data-target');

        if (!selector) {
          selector = element.getAttribute('href') || '';
          selector = /^#[a-z]/i.test(selector) ? selector : null;
        }

        return selector;
      },

      reflow: function reflow(element) {
        new Function('bs', 'return bs')(element.offsetHeight);
      },

      triggerTransitionEnd: function triggerTransitionEnd(element) {
        $(element).trigger(transition.end);
      },

      supportsTransitionEnd: function supportsTransitionEnd() {
        return Boolean(transition);
      },

      typeCheckConfig: function typeCheckConfig(componentName, config, configTypes) {
        for (var property in configTypes) {
          if (configTypes.hasOwnProperty(property)) {
            var expectedTypes = configTypes[property];
            var value = config[property];
            var valueType = undefined;

            if (value && isElement(value)) {
              valueType = 'element';
            } else {
              valueType = toType(value);
            }

            if (!new RegExp(expectedTypes).test(valueType)) {
              throw new Error(componentName.toUpperCase() + ': ' + ('Option "' + property + '" provided type "' + valueType + '" ') + ('but expected type "' + expectedTypes + '".'));
            }
          }
        }
      }
    };

    setTransitionEndSupport();

    return Util;
  })(jQuery);

  module.exports = Util;
});

},{}],3:[function(require,module,exports){
/*global module*/
module.exports = ( function( $ ) {

	var init,
		toggle,
		clearMenus,
		menus = [],
		dropdown = '.dropdown-menu',
		triggerSelector = '[data-toggle="dropdown-nested"]';

	/**
	 * Init Function
	 */
	init = function() {
		var dropdownTrigger = $( '<button>', {
			'class': 'dropdown-trigger',
			'data-toggle': 'dropdown-nested'
		} );

		$.each( $( triggerSelector ), function() {
			menus.push( $( $( this ).data( 'target' ) ) );
		} );

		$.each( $( dropdown ), function() {
			$( this ).before( dropdownTrigger.clone() );
			menus.push( $( this ) );
		} );

		$( document )
			.on( 'click', triggerSelector, toggle )
			.on( 'click', clearMenus );
	};

	/**
	 * Toggle dropdown
	 */
	toggle = function( event ) {
		var trigger = $( event.currentTarget );
		var menu = trigger.siblings( 'ul' );
		if ( trigger.data( 'target' ) ) {
			menu = $( trigger.data( 'target' ) );
		}
		if ( menu.hasClass( 'open' ) ) {
			trigger.removeClass( 'active' );
			menu.removeClass( 'open' );
		} else {

			// Close the other 2nd level menus if we are opening a new 2nd level menu
			if ( menu.hasClass( 'dropdown-menu' ) ) {
				$( '> .dropdown-menu' ).removeClass( 'open' ).siblings( '.dropdown-trigger' ).removeClass( 'active' );
			}
			trigger.addClass( 'active' );
			menu.addClass( 'open' );
		}
	};

	/**
	 * Clear dropdowns
	 */
	clearMenus = function( event ) {
		var target = $( event.target );

		if ( target.is( triggerSelector ) ) {
			event.preventDefault();
			event.stopPropagation();
			return;
		}

		$( triggerSelector ).removeClass( 'active' );
		$.each( menus, function() {
			$( this ).removeClass( 'open' );
		} );
	};

	/**
	 * Initialise
	 */
	init();

	/**
	 * Return public API ( empty )
	 */
	return {};

} )( jQuery );

},{}],4:[function(require,module,exports){
/*jshint browserify: true, unused: false*/
/* globals noUiSlider */

(function( $, global, _ ) {

	'use strict';

	var App,
		DropdownNested = require( './dropdown-nested' ),
		Tabs = require( './tabs' );

	global.Util = require( '../../bower_components/bootstrap/dist/js/umd/util.js' );
	global.Collapse = require( '../../bower_components/bootstrap/dist/js/umd/collapse.js' );

	global.strat = global.strat || {

		/**
		 * Init Function
		 */
		init: function() {
			App.jsStart();
			App.initCollapsibleHeader();
			App.initRevealEffect();
			App.initImageSlider();
			App.initLightbox();
			App.initAccordions();
			App.initTogglers();
			App.initSplash();
			App.printStart();
			App.initDismissable();
			App.initRange();
			if ( 'undefined' !== typeof global.strathcomSearch ) {
				global.strathcomSearch.on( 'filters:render:after', App.initRange );
			}
		},

		/**
		 * Remove nojs fallbacks
		 */
		jsStart: function() {
			$( 'html' ).removeClass( 'nojs' );
		},

		/**
		 * Print
		 */
		printStart: function() {
			$( '._print' ).click( function( e ) {
				e.preventDefault();
				window.print();
			} );
		},

		/**
		 * Initialize range slider
		 */
		initRange: function() {
			var rangeSliderMin, rangeSliderMax, minValue, maxValue,
				rangeSlider = document.getElementById( 'range-slider' );

			if ( 'undefined' === typeof noUiSlider || ! rangeSlider  ) {
				return;
			}

			rangeSliderMin = $( '#price_range__gte' );
			rangeSliderMax = $( '#price_range__lte' );
			minValue = parseInt( rangeSliderMin.val(), 10 );
			maxValue = parseInt( rangeSliderMax.val(), 10 );

			noUiSlider.create( rangeSlider, {
				start:   [ minValue, maxValue ],
				connect: true,
				range:   {
					'min': minValue,
					'max': maxValue
				}
			} );

			rangeSlider.noUiSlider.on( 'update', function( values, handle ) {
				var value = values[ handle ];
				value     = Math.round( value / 1000 ) * 1000;
				if ( handle ) {
					if ( value < 1000 ) {
						value = 1000;
					}
					rangeSliderMax.val( value );
				} else {
					rangeSliderMin.val( value );
				}
			} );

			rangeSliderMin.on( 'change', function() {
				rangeSlider.noUiSlider.set( [ this.value, null ] );
			} );

			rangeSliderMax.on( 'change', function() {
				rangeSlider.noUiSlider.set( [ null, this.value ] );
			} );
		},

		/**
		 * Site header expand/collapse.
		 */
		initCollapsibleHeader: function() {
			var offset, scrollVal, container, isExpanded,
				expandedClass = 'expanded-header',
				addBackground = 'add-background',
				wnd = $( window );

			// Trigger feature only on homepage.
			if ( ! $( 'body' ).hasClass( 'home' ) || 0 === $( '.collapsible-header' ).length ) {
				return;
			}

			offset = ( $( '.splash' ).height() * 0.66 ) || 650;
			container = $( '.page-wrapper' );
			isExpanded = container.hasClass( expandedClass );

			// Throttle event handler function for better performance.
			wnd.on( 'scroll', _.throttle( function( event ) {
				scrollVal = wnd.scrollTop();

				if ( isExpanded && scrollVal > offset ) {
					isExpanded = false;
					container.removeClass( expandedClass );
					container.addClass( addBackground );
				} else if ( ! isExpanded && scrollVal < offset ) {
					isExpanded = true;
					container.addClass( expandedClass );
					container.removeClass( addBackground );
				}
			}, 100 ) );

			wnd.trigger( 'scroll' );
		},

		/**
		 * Reveal effect using 'jquery.visible'.
		 */
		initRevealEffect: function() {
			var scrollVal, show,
				wnd = $( window ),
				targets = [
					{
						container: $( '.container-slant' ),
						el: [
							{
								selector: '.content, figure',
								effect: 'fade-slide'
							}
						]
					}
				];

			show = function( target ) {
				_.each( target.el, function( el ) {
					target.container.find( el.selector ).addClass( el.effect );
				});
				target.shown = true;
			};

			if ( 'undefined' === typeof jQuery.fn.visible ) {
				_.each( targets, function( target ) {
					show( target );
				});
				return false;
			}

			// Throttle event handler function for better performance.
			wnd.on( 'scroll', _.throttle( function() {
				scrollVal = wnd.scrollTop();

				_.each( targets, function( target ) {
					if ( ! _.isUndefined( target.shown ) && true === target.shown ) {
						return;
					}
					if ( target.container.visible( true ) ) {
						show( target );
					}
				});
			}, 100 ) );

			wnd.trigger( 'scroll' );
		},

		/**
		 * Initialise image sliders and carousels
		 */
		initImageSlider: function() {
			$.each( $( '[data-toggle="product-carousel"]' ), function() {
				var commonConfig, carouselConfig, sliderConfig, size, getGridSize, setGridSize, refreshFlexslider,
					container   = $( this ),
					slider      = container.find( '.image-slider' ),
					carousel    = container.find( '.image-carousel' ),
					hasSlider   = ( 0 !== slider.length ),
					hasCarousel = ( 0 !== carousel.length );

				// Define common config.
				commonConfig = {
					namespace:     'carousel-',
					selector:      '.slides > li',
					animation:     'slide',
					controlNav:    false,
					animationLoop: false,
					slideshow:     false,
					touch:         true
				};

				// Extend common config with specific settings for each slider type.
				if ( hasCarousel ) {
					getGridSize = function() {
						var gridSize = Number( carousel.data( 'grid-size' ) );

						if ( 600 > carousel.width() ) {
							return Math.ceil( gridSize / 4 );
						} else if ( 900 > carousel.width() ) {
							return Math.ceil( gridSize / 2 );
						} else {
							return gridSize;
						}
					};

					setGridSize = function() {
						var gridSize = getGridSize();

						carousel.data( 'flexslider' ).vars.minItems = gridSize;
						carousel.data( 'flexslider' ).vars.maxItems = gridSize;
						carousel.flexslider( 0 );
					};

					size = getGridSize();
					carouselConfig = $.extend( {}, commonConfig, {
						itemWidth:  120,
						itemMargin: 0,
						minItems:   size,
						maxItems:   size
					} );
				}

				if ( hasSlider ) {
					sliderConfig = $.extend( {}, commonConfig, {} );
				}

				// Sync carousel and slider if they are both present.
				if ( hasCarousel && hasSlider ) {
					carouselConfig.asNavFor = slider;
					sliderConfig.sync = carousel;
				}

				refreshFlexslider = function( e ) {
					var instance = e.data.instance.data( 'flexslider' ),
						currentItem = instance.currentItem;

					instance.setup();
					instance.flexslider( currentItem );
				};

				// Initialise flexslider.
				if ( hasSlider ) {
					slider.flexslider( sliderConfig );
					slider.closest( '.tab-pane' ).one( 'pane:focus', { instance: slider }, refreshFlexslider );
				}

				if ( hasCarousel ) {
					carousel.flexslider( carouselConfig );
					carousel.closest( '.tab-pane' ).one( 'pane:focus', { instance: carousel }, refreshFlexslider );
					$( window ).on( 'resize', _.throttle( setGridSize, 100 ) );
				}
			});
		},

		/**
		 * Initialise lightbox
		 */
		initLightbox: function() {
			global.baguetteBox.run( '[data-lightbox]' );
		},

		/**
		 * Initialise accordions
		 */
		initAccordions: function() {
			var accordionTriggers = '.filters dt';
			var accordionWrapper = $( '.filters-panel' );
			accordionWrapper.on( 'click', accordionTriggers, function( e ) {
				e.preventDefault();
				$( this ).toggleClass( 'state-closed' );
			} );
		},

		/**
		 * Initialise togglers
		 */
		initTogglers: function() {
			var togglerTriggers = $( '[data-toggled]' );
			togglerTriggers.on( ' click', function( e ) {
				e.preventDefault();
				$( $( this ).data( 'toggled' ) ).toggleClass( 'state-toggled' );
			} );
		},

		/**
		 * Set splash height and control video playback and visibility on scroll.
		 */
		initSplash: function() {
			var offset, top, toggleVideo, setOffset, controlVideo,
				video = null,
				isPaused = false,
				splash = $( '.splash' ),
				isVideoSplash = false,
				wrapper = $( '.page-wrapper' ),
				header = $( '.site-header' ),
				wnd = $( window );

			// Trigger feature only for splash with video background.
			if ( 0 === splash.length ) {
				return;
			}

			isVideoSplash = splash.hasClass( 'splash-video' ) && 0 !== splash.find( 'iframe' ).length;

			// Control YouTube video using its API methods.
			controlVideo = function( cmd, args ) {
				if ( _.isUndefined( global.strathcomVideoSplashPlayer ) ) {
					return;
				}
				if ( _.isNull( video ) ) {
					video = global.strathcomVideoSplashPlayer;
				}
				if ( 'play' === cmd ) {
					video.playVideo();
				} else if ( 'pause' === cmd ) {
					video.pauseVideo();
				} else if ( 'setSize' === cmd ) {
					video.setSize( 16 / 9 * args.height, args.height );
				}
			};

			// Control video playback and visibility on page scroll.
			toggleVideo = function() {
				var scrollVal = wnd.scrollTop(),
					inViewport = ( scrollVal >= top && scrollVal <= top + offset ) || ( scrollVal <= top && scrollVal + offset >= top );

				if ( ! isPaused && ! inViewport ) {
					isPaused = true;
					controlVideo( 'pause' );
					splash.css( 'visibility', 'hidden' );
				} else if ( isPaused && inViewport ) {
					isPaused = false;
					controlVideo( 'play' );
					splash.css( 'visibility', '' );
				}
			};

			// Determine and set splash height (offset for scroll) on resize.
			setOffset = function() {
				offset = wnd.height();
				top = splash.offset().top;
				if ( ! wrapper.hasClass( 'expanded-header' ) ) {
					offset = offset - header.outerHeight();
				}

				//Splash.height( offset );
				if ( isVideoSplash ) {
					controlVideo( 'setSize', { height: offset } );
					toggleVideo();
				}
			};
			setOffset();

			// Throttle expensive functions for better performance.
			wnd.on( 'resize', _.throttle( setOffset, 100 ) );
			if ( isVideoSplash ) {
				wnd.on( 'scroll', _.throttle( toggleVideo, 100 ) );
			}
		},

		/**
		 * Initialise dismiss-able notifications.
		 */
		initDismissable: function() {
			_.each( $( '[data-trigger="dismiss"]' ), function( notification ) {
				var hideNotification,
					$el          = $( notification ),
					toggle       = $el.find( '[data-toggle="dismiss"]' ),
					dismissAfter = $el.data( 'dismiss-after' );

				/**
				 * Hide notification.
				 * @param {Event} e
				 */
				hideNotification = function( e ) {
					if ( ! _.isUndefined( e ) ) {
						e.preventDefault();
					}
					$el.fadeOut( 360 );
				};

				/**
				 * Listen for click event only once.
				 */
				toggle.one( 'click', hideNotification );

				/**
				 * If notification is to be dismissed automatically, add delay.
				 */
				if ( ! _.isUndefined( dismissAfter ) && 0 < dismissAfter ) {
					_.delay( hideNotification, dismissAfter );
				}
			}, this );
		}
	};

	App = global.strat;

	$(function() {
		App.init();
	});

})( jQuery, window, window._ );

},{"../../bower_components/bootstrap/dist/js/umd/collapse.js":1,"../../bower_components/bootstrap/dist/js/umd/util.js":2,"./dropdown-nested":3,"./tabs":5}],5:[function(require,module,exports){
/*global module*/
module.exports = ( function( $, global, _ ) {

	var activeClass = 'active',
		containerSelector = '[ data-toggle="tabs" ]',
		navSelector = '.tabs-nav a',
		contentSelector = '.tabs-content',
		paneSelector = '.tab-pane';

	/**
	 * Initialise tabs.
	 */
	function initialise( container ) {
		var activeTab, tabs = {};

		tabs.container = container;
		tabs.nav = container.find( navSelector ),
		tabs.content = container.find( contentSelector );
		tabs.panes = tabs.content.find( paneSelector );

		try {
			if ( _.isUndefined( tabs.nav ) || 0 === tabs.nav.length ) {
				throw new Error( 'Tabs: Could not initialise; there is no tabs navigation.' );
			}
			if ( _.isUndefined( tabs.panes ) || 0 === tabs.panes.length ) {
				throw new Error( 'Tabs: Could not initialise; there are no panes.' );
			}
		} catch ( e ) {
			window.console.error( e );
			return;
		}

		if ( '' !== document.location.hash ) {
			activeTab = tabs.nav.filter( '[href="' + document.location.hash + '"]' );
		}

		if ( 'undefined' === typeof activeTab || 0 === activeTab.length ) {
			activeTab = tabs.nav.filter( '.' + activeClass );
		}

		if ( 0 === activeTab.length ) {
			activeTab = tabs.nav;
		}
		activeTab = activeTab.first();
		toggle( activeTab, tabs );

		container.on( 'click', navSelector, function( e ) {
			e.preventDefault();
			window.location.hash = e.target.hash;
			toggle( $( e.target ), tabs );
		} );
	}

	/**
	 * Toggle tab.
	 */
	function toggle( tab, tabs ) {
		var pane = tabs.panes.filter( tab.attr( 'href' ) );

		tabs.nav.removeClass( activeClass );
		tab.addClass( activeClass );
		tab.trigger( 'tab:focus' );

		tabs.panes.removeClass( activeClass );
		pane.addClass( activeClass );
		pane.trigger( 'pane:focus' );
	}

	$.each( $( containerSelector ), function() {
		initialise( $( this ) );
	} );

	/**
	 * Return public API (empty).
	 */
	return {};

} )( jQuery, window, window._ );

},{}]},{},[4])

//# sourceMappingURL=main.js.map
