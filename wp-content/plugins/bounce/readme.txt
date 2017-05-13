=== bouncyyyyye ===
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
