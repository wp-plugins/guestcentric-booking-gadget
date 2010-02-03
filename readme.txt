=== Plugin Name ===
Contributors: pedro.a
Tags: guestcentric, hotel, booking gadget, booking engine, widget
Requires at least: 2.3
Tested up to: 2.9.1
Stable tag: trunk

This plugin enables you to add your GuestCentric booking gadget to your wordpress blog without actually having to edit your templates.

== Description ==

With this plugin, inserting your GuestCentric booking gadget is made easy, via an easy widget interface.

All that is required is that you insert you Api Key, select the type of widget, and you're done! Anyone can now book from your Wordpress page, right in the sidebar.

== Installation ==

You should be able to install from the WordPress plugins area. Optionally:

1. Upload `guestcentric-booking-gadget.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the "Booking Gadget" widget in the widgets area
1. Select the options you want

== Frequently Asked Questions ==

= Where can I find my Api Key =

The ApiKey for a language can be found in your GuestCentric back office, in the external booking gadget area.

= How can use multi language? =

Multi Language is supported via the WPML plugin. If you wish to use more than 1 language, install this plugin.

= Can I use languages other the GuestCentric default ones? =

Yes. The widget creates diffrent versions of the booking gadget for each WPML language. Thus, an Italian website can have a German booking gadget. Since the Api Key is responsible for language, make sure to select the correct key for the wordpress language you wish it to be in.

== Changelog ==

= 1.0b =
* Re-wrote code to be more efficient and have better readability.
* First GA version.

= 1.0 =
* First working version. Supported multi-language with some issues.

= 0.5 =
* First tests, not GA.

== Upgrade Notice ==

= 1.0b =
* GA version, no known issues.
