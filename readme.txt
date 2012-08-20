=== Github Contributors ===
Author URI: http://pippinsplugins.com
Plugin URI: http://pippinsplugins.com/github-contributors-plugin/
Contributors: mordauk
Donate link: http://pippinsplugins.com/support-the-site
Tags: github, contributors, mordauk, Pippin Williamson, pippinsplugins
Requires at least: 3.2
Tested up to: 3.4.1
Stable Tag: 1.0.1

Provides a simple short code for displaying a list of contributors from any Github repository.

== Description ==

This plugin provides a short code that you can use for showing a photo grid of all users that have contributed code to any Github repository.

It's a great way to show off the people that have helped with your project.

You can see this live on the Contributors page for [Easy Digital Downloads](http://easydigitaldownloads.com/contributors/).

Based on the code by [Konstantin Kovshenin](http://kovshenin.com/2012/how-to-get-a-list-of-contributors-from-a-github-project/).

== Installation ==

1. Upload to wp-content/plugins/
2. Activate the plugin
3. Place [github-contributors username="{YOUR USERNAME}" repo="{NAME OF YOUR REPO}"] on any page


== Screenshots ==

1. Screenshot 1

== Changelog ==

= 1.0.1 =

* Updated the transient key to use an MD5 to avoid it breaking if the repo / username is too long
* Escaped a couple of possibly unsafe values
* Updated some formatting with indention, whitespace, double quotes
* Failed responses are now cached

= 1.0 =

* First offical release!

== Upgrade Notice ==

= 1.0.1 =

* Updated the transient key to use an MD5 to avoid it breaking if the repo / username is too long
* Escaped a couple of possibly unsafe values
* Updated some formatting with indention, whitespace, double quotes
* Failed responses are now cached

= 1.0 =

* First offical release!