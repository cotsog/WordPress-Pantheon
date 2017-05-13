=== bounce ===
Contributors: strathcom
Donate link: http://strathcom.com
License: MIT
Tags: admin, newsletter, exit popup, exit popups, ab-testing, roi, conversion, conversion rate optimisation, free, plugin, wordpress, marketing, landing page
Requires at least: 3.5
Tested up to: 4.7.2
Stable tag: 1.6.3

Bounce improves bounce rate to boost conversions and sales

== Description ==
Bounce improves bounce rate to boost conversions and sales
= Features: =

* Display inline popup before the user leaves the site
* Alternatively display popup on enter or after a certain time period (self-acting fire)
* Set custom content via backend
* Define custom content for pages and posts individually using a flexible template engine which uses so-called "magic shortcodes"
* Lots of open/exit animation styles
* Shortcodes from other plugins are also supported
* Determine sensitivity, cookie expiration, hesitation, and more
* Add custom CSS
* Set default status: Define if Bounce should be fired on posts and/or pages by default. You can override the default setting on every post and page individually.
* Event tracking with Google Analytics


== Installation ==

1. Upload bounce into your plugin directory (/wp-content/plugins/) and activate it through the 'Plugins' menu in WordPress.
2. Configure the plugin via the admin backend and define your template. You can even insert shortcodes that are provided by your other plugins.
3. Optionally: Sign up to the bounce newsletter to get notified about major updates.

Important: bounce does not collect and store e-mail addresses itself. Therefore, you can insert any HTML. For example, you can copy the form code that's provided by MailChimp (or any other newsletter service) and the signups will be stored using your newsletter service.


== Frequently Asked Questions ==

= Does bounce work with MailChimp, aWeber, GetResponse? =
Yes! You can use any form from every newsletter service since you can insert HTML code into the "bounce content" text field. Simply copy the form code that's provided by MailChimp (or any other newsletter service) into the "bounce content" text field.

Additionally, you can add CSS using the "Custom CSS" text field.

= How to use MailPoet, SendPress Newsletters and other plugins with bounce? =
You can actually insert any shortcode that is provided by other plugins, such as GravityForms or SendPress Newsletters. For example, to use MailPoet with bounce, simply insert the provided shortcode that contains the form's ID, as follows:
`[wysija_form id="1"]`

By the way, [MailPoet](https://wordpress.org/plugins/wysija-newsletters/) allows to set up autoresponders, so give it a try.

Another well-known newsletter plugin, [SendPress](https://wordpress.org/plugins/sendpress/), offers shortcodes that look like this:
`[sp-form formid=18547]`

Notice: If a plugin or service doesn't offer such a shortcode, you can still insert any HTML code. I’m pretty sure that every useful newsletter service offers at least a piece of HTML code that works with bounce :-)

= bounce does not fire, scripts are not loaded or jQuery is loaded too late. What's wrong? =
Probably your theme does not implement the wp_footer() function in the appropriate position, if at all. Always have it just before the closing </body> tag of your theme. [#support](https://wordpress.org/support/topic/plugin-does-not-fire-the-popup?replies=3#post-6530865)

= How to translate popups (using WPML)? =
You must have installed WPML Translation Management. Then you can do the following in the menu:

1) Go to WPML > Translation Management > Multilingual Content Setup > Edit translatable admin strings
2) Context: admin_texts_plugin_bounce-master > Translate

As soon as you save, the popup will appear in the appropriate language.
(Thanks to Jan Sass for providing this answer.)

= How to use Jetpack's Subscriptions module with bounce? =
Use Jetpack's shortcode within the bounce content field:
`[jetpack_subscription_form]`
You can even extend the shortcode using modifiers as [explained by Jetpack](http://jetpack.me/support/subscriptions/).


== Changelog ==

= 1.6.3 =
* New: Disable demo CSS used for exemplary template. This reduces the file size and makes it easier to use custom popup styles.
* Fix: Never display scrollbars for popup underlay.

= 1.6.2.3 =
* Fix: Incorrect cookie expiration date.

= 1.6.2.2 =
* Fix: Change how array is created to work with PHP versions lower than 5.4.
* Fix: Solve JavaScript error that occurred when Google Analytics option was checked.

= 1.6.2 =
* Allow HTML and script tags to be used when using the "total overrides" feature for individual posts.
* Improvements for developers/contributors: Separation of PHP and JavaScript. (There was way to much JS located within one PHP file.) A package.json now defines a set of tools to build JS and SCSS. Use: "npm run watch" and "npm run build".

= 1.6.1.1 =
* Removed minified JavaScript file (which was used in WordPress backend only) because it caused (false) positives in several virus scanners.

= 1.6.1 =
* New: Users can close popup using ESC key.
* New analytics event 'hidden_escape': Triggered when user closes popup using ESC key.
* Fix: Popup triggered by self-acting timer and exit animation was closed immediately when user clicked somewhere before it showed up.
* Fix: 'hidden_outside' analytics event was triggered to often.

= 1.6 =
* New feature: Popup animations. You find them under your styling tab. Merged pull request from @rahilwazir on Github (https://github.com/kevinweber/bounce/pull/10).
* Allow shortcodes in "Template Total Override".

= 1.5.1.5 =
* Merged pull request from @dima-stefantsov on Github (https://github.com/kevinweber/bounce/pull/7): bounce can by default be disabled with post meta flag.

= 1.5.1.4 =
* Fix: Cookie storage didn't work correctly when user has no Google Analytics script on his site but GA event tracking (in plugin settings) is enabled.

= 1.5.1.3 =
* Updated exit popup script and improved self-acting fire.

= 1.5.1.1 =
* Fixed not working meta box besides page/post editor.

= 1.5 =
* HOT! New feature: Template engine to override templates on individual pages/posts. Introducing magic shortcodes.
* Made the plugin translatable. Great thanks to @senlin (https://github.com/senlin) for his contributions via bounce on Github (https://github.com/kevinweber/bounce).

= 1.4.0.1 =
* Improved CSS to hide scrollbars in some browsers. Note: To hide scrollbars in all browsers completely, use the following custom CSS: .bounce-modal .bounce-modal-sub { overflow: hidden; }

= 1.4 =
* New feature: Event tracking with Google Analytics.
* Extended "Default status" drop-down list with "Fire on posts and pages".
* Added 15% discount code for OptinMonster.

= 1.3.4.5 =
* Fixed not working cookieDomain.

= 1.3.4.4 =
* Fixed not working cookieExpire and cookieDomain.

= 1.3.4.3 =
* CSS fix.

= 1.3.4.2 =
* Fix: Make aggressive mode working as expected.

= 1.3.4 =
* Fix: Make cookie option work with self-acting fire.

= 1.3.3 =
* Fix: Improved self-acting fire. When self-acting fire fired, don't use exit popup again.
* Major CSS update: Removed fix height so that the content determines the modal's height. Default width is still 600px. When the modal's content requires more space than the screen is high, the modal is scrollable. Raised z-index from 1 to 21. Use CSS property "transform" to centre the modal vertically. Added margin to prevent the modal from being overlapped by the admin bar.
* New feature: Load script before footer. Normally, scripts are placed in <head> of the HTML document. If this parameter is true, the script is placed before the </body> end tag. This requires the theme to have the wp_footer() template tag in the appropriate place.
* Improvement: Use not minified JavaScript files when SCRIPT_DEBUG is true (defined in wp-config.php).
* Added version number to scripts.

= 1.3 =
* Renamed functions.php to bounce.php. (This will cause your WordPress site to automatically deactivate bounce. So you simply have to activate it again, that’s it.)
* New feature: Self-acting fire (timer). Automatically trigger the popup after a certain time period.
* New feature: Cookie domain.
* New: The cookie is stored for the whole site (and not only for specific pages/posts).
* New feature: Cookie per page. With this option enabled, every page/post gets its own cookie.
* Fix: Added CSS "box-sizing: border-box".
* Fix: Added CSS to make bounce work with themes that use Bootstrap 3.

= 1.2.1 =
* Fixed broken post view.

= 1.2 =
* Improvement: Added support for shortcodes that are inserted into the "bounce content" text area.
* New feature: Hesitation. bounce waits x milliseconds before showing the model when the user's cursor leaves the window.
* Improvement: Only load scripts and CSS when they are actually needed.
* Improvement: Merged CSS from two files into one.
* Fixed "unexpected T_PAAMAYIM_NEKUDOTAYIM".

= 1.1.1 =
* New feature: Deactivate bounce for pages and posts individually ("bounce status").
* New feature: Define if bounce should be fired on posts and/or pages by default.
* New feature: The bounce status can be seen in an additional column on the overview for posts and pages.
* New feature: Sensitivity.
* New feature: Cookie expiration. bounce sets a cookie by default to prevent the modal from appearing more than once per user. You can add a cookie expiration (in days) to adjust the time period before the modal will appear again for a user.
* bounce is ready for WordPress 4.0.

= 1.0 =
* Plugin goes public.
* First available features: Admin panel to customise settings. Insert content/code + example template. Test mode. Aggressive mode. Timer. Custom CSS.


== Upgrade Notice ==

= 1.2.2 =
* Renamed functions.php to bounce.php. This will cause your WordPress site to automatically deactivate bounce. So you simply have to activate it again, that’s it.

= 1.0 =
* Plugin goes public.


== Screenshots ==

1. Screenshot of a site that uses bounce.
2. Admin panel tab "content".
3. Admin panel tab "options".
4. Meta box besides post editor (v1.1).
5. Post column displays status (v1.1).
