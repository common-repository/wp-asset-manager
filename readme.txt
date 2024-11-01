=== WP Asset Manager ===
Contributors: johnburns87
Tags: performance, plugins, styles, scripts, speed, SEO, ecommerce, contact 7, slow, load
Requires at least: 3.0.1
Tested up to: 3.8.3
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A wordpress plugin that deactivates individual or all wp plugin styles and scripts per page to decrease load time.

== Description ==

A wordpress plugin that deactivates individual or all wp plugin styles and scripts per page to decrease load time. Please leave a review or suggested improvements and spread the word!

= Common uses =

* Contact Form 7 - CF7 will load its stylesheet and script into everypage, this plugin will restrict it to load into pages you need it for.
* Prevent jQuery loading into every page.
* Add/remove custom Stylesheets per page.
* Add/remove custom JS per page.

= Setup =

* Add folder to wp-content/plugins/ directory
* Login to wp-admin
* Go to plugins
* Activate plugin
* Put the following code into your themes header and footer.
* All plugin scripts and stylesheets will be disabled by default
* When editing a page, a new widget will appear below the MCE editor where you can enable / disable scripts.

= Code =

Add the following code to your themes header and footer

header.php 

	<?php
	wp_reset_query();
	global $post;
	$styles_query = get_post_meta( $post->ID, '_active_styles', true );
	$styles_array = unserialize($styles_query);
	?>

	<?php if (!empty($styles_array[0])) { foreach($styles_array as $style): ?>
	<link rel="stylesheet" href="<?php echo $style; ?>">
	<?php endforeach; } ?>

footer.php

	<?php
	wp_reset_query();
	global $post;
	$scripts_query = get_post_meta( $post->ID, '_active_scripts', true );
	$scripts_array = unserialize($scripts_query);
	?>

	<?php if (!empty($scripts_array[0])) { foreach($scripts_array as $script): ?>
	<script src="<?php echo $script; ?>"></script>
	<?php endforeach; } ?>

= Live Examples =

* www.thetomorrowlab.com
* www.johnburns87.com

= Future Releases =

* Ability to assign custom styles and scripts to custom post types.
* Automatically save active themes stylesheets and scripts.

= Useful Links =

* 	[Support](https://www.twitter.com/WPAssetManager)
* 	[Author](https://www.twitter.com/johnburns87)

== Installation ==

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 1.0 =
* first release

= 1.0.1 =
* fixed bugs
* added ability to delete custom stylesheets and scripts

= 1.0.2 =
* Updated brand icons

= 1.0.3 =
* Updated admin area
* Added twitter handlers

= 1.0.4 =
* Removed wp jquery from wp_head and wp_footer

= 1.0.5 =
* Cleaned up code
* Added more / updated info in README

= 1.0.6 =
* Updated README

= 1.0.7 =
* Added drag and drop to reorder styles and scripts

= 1.0.8 =
* Fixed reorder bugs
* Added validation styling

= 1.0.9 =
* Fixed multiple activate issue.

= 1.1.0 =
* Fixed array bug

= 1.1.1 =
* Fixed multiple activate issue.

== Arbitrary section ==

== A brief Markdown Example ==

Add the following code to your themes header and footer

header.php 

	<?php
	wp_reset_query();
	global $post;
	$styles_query = get_post_meta( $post->ID, '_active_styles', true );
	$styles_array = unserialize($styles_query);
	?>

	<?php if (!empty($styles_array[0])) { foreach($styles_array as $style): ?>
	<link rel="stylesheet" href="<?php echo $style; ?>">
	<?php endforeach; } ?>

footer.php

	<?php
	wp_reset_query();
	global $post;
	$scripts_query = get_post_meta( $post->ID, '_active_scripts', true );
	$scripts_array = unserialize($scripts_query);
	?>

	<?php if (!empty($scripts_array[0])) { foreach($scripts_array as $script): ?>
	<script src="<?php echo $script; ?>"></script>
	<?php endforeach; } ?>