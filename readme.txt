=== Trac Ticket Shortcode ===
Contributors: frederick.ding, freddyware
Tags: Trac, shortcode, ticket, bug, link
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Links directly to a ticket ("bug") on a Trac site.

== Description ==

Links directly to a ticket ("bug") on a Trac site using simple notation such as `[bug 12345]`. By default, this plugin is coded to link to the WordPress core Trac.

Generates output such as 
`<a href="http://core.trac.wordpress.org/ticket/100" title="WordPress Trac: Ticket #100: Support for a &quot;keywords&quot; field">#100</a>`

The plugin will fetch the ticket title when a shortcode is first displayed; the ticket title is displayed in the `title` attribute of the link. The plugin caches titles in custom fields with the posts in which shortcodes are used, to minimize unnecessary computation.

Constants can also be set in `wp-config.php` to change the shortcode name and to switch to a different Trac site. See _Installation_.

== Installation ==

Self-explanatory, like most plugins.

This plugin can also be used as a must-use plugin by placing `trac-ticket-shortcode.php` into the `wp-content/mu-plugins` directory.

= How to use constants =

The Trac site that the plugin links to can be overridden by defining `TRAC_TICKET_URL` as the absolute URL to the root of the Trac site. Put a line like this into `wp-config.php`:
`define('TRAC_TICKET_URL', 'http://plugins.trac.wordpress.org/');`
to use the plugin site.

The name of the shortcode can be customized (within reason -- i.e. lowercase alphabetical characters and underscores) by defining `TRAC_TICKET_SHORTCODE`. The default shortcode is `[bug]` but other reasonable names might include `[ticket]`:
`define('TRAC_TICKET_SHORTCODE', 'ticket');`
(Whatever string is supplied will be lowercased. Only alphanumeric characters and the underscore will remain. For example, if you define `TRAC_TICKET_SHORTCODE` as `ticket-#`, the shortcode will actually be hooked for `ticket`.)

Note that changing either of these constants will affect **all** shortcodes.

== Changelog ==

= 0.1 =
* Initial release
* Customizable shortcode name and Trac location
