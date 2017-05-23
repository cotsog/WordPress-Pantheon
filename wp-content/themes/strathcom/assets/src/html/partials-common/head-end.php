<script>
		(function() {
			var throttle = function(type, name, obj) {
				obj = obj || window;
				var running = false;
				var func = function() {
					if (running) { return; }
					running = true;
					 requestAnimationFrame(function() {
							obj.dispatchEvent(new CustomEvent(name));
							running = false;
					});
				};
				obj.addEventListener(type, func);
			};

			throttle("resize", "optimizedResize");
		})();

		(function() {

			var enqueueStyleOnResize = function() {
				var doc = document.documentElement,
					body = doc.getElementsByTagName('body')[0],
					linkTags = doc.getElementsByTagName('link'),
					i, linkTag,
					deferredLinkCount = 0,
					width = doc.clientWidth || body.clientWidth;

				for (i=0; i<linkTags.length; i++) {
					linkTag = linkTags[i];
					if (linkTag.hasAttribute('data-min-width') && linkTag.hasAttribute('data-href')) {
						deferredLinkCount++;
						if (width > Number(linkTag.getAttribute('data-min-width'))) {
							linkTag.href = linkTag.getAttribute('data-href');
							linkTag.removeAttribute('data-min-width');
							linkTag.removeAttribute('data-href');
							deferredLinkCount--;
						}
					}
				}

				if (deferredLinkCount === 0) {
					window.removeEventListener("optimizedResize", enqueueStyleOnResize);
					return true;
				}
				return false;
			};

			if (false === enqueueStyleOnResize()) {
				window.addEventListener("optimizedResize", enqueueStyleOnResize);
			}

		})();
	</script>

	<script type="text/javascript" src="../../../dist/js/modernizr.js"></script>
	<script>
		( function( global ) {
			if ( undefined !== global.Modernizr ) {
				global.Modernizr.addTest( 'flex', ( global.Modernizr.flexbox || global.Modernizr.flexboxtweener ) )
			}
		} )( window );
	</script>

	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>