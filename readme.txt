=== OndrejdFirst ===
Contributors: Ondřej Doněk
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ondrejd%40gmail%2ecom&lc=CZ&item_name=ondrejd%2fodwp%2dwc%2dorderbyvisits&currency_code=CZK&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Requires at least: 4.4
Tested up to: 4.8.2
Stable tag: trunk
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html


== Installation ==

1. Upload the theme
2. Activate the theme

All theme specific options are handled through the WordPress Customizer.


== Resume Page Template ==

1. Create a new page, or edit an existing one
2. Click the dropdown beneath "Template" in "Page Attributes", and select Resume.

In the resume page template, all titles span the entire width of the content, whereas all other elements are aligned to the right. This enables you to create sections in the resume content by simple adding another title. For instance, adding a title called "Education" and adding a paragraph of text beneath it will automatically create a section with the "Education" title to the left and the paragraph of text to the right.



== Frequently Asked Questions ==

= How do I activate infinite scroll? =
Hamilton uses the Jetpack module for infinite scroll. To activate it, install the Jetpack plugin and activate the infinite scroll module in the Jetpack settings. The theme will take care of the rest.

= What do the Hamilton theme options in the WordPress customizer do? =
Show Primary Menu in the Header — Replaces the navigation toggle in the header with the Primary Menu on desktop.
Three Columns — Displays the post grid with up to three columns on desktop. The grid will still be displayed with two columns on tablets and mobile screen sizes.
Show Preview Titles — Always display the post titles on top of the images in post previews, rather than on hover which is the default behaviour.
Front Page Title – The title you want shown on the front page when the "Front page displays" setting is set to "Your latest posts" in Settings > Reading.
Dark Mode (displayed in the Colors tab) — Displays the site with white text and black background. If Background Color is set, only the text color will change. You can combine the background color with the dark mode to, for instance, display the site with a dark purple background color and white text color.


== Licenses ==

Libre Franklin font
License: SIL Open Font License, 1.1
Source: https://fonts.google.com/specimen/Libre+Franklin

Images in screenshot.png by Fancycrave, supplied through Pexels
License: Creative Commons Zero (CC0), https://creativecommons.org/publicdomain/zero/1.0/
Source: https://www.pexels.com/u/fancycrave-60738/


== Changelog ==

Version 1.12 (2017-09-15)
-------------------------
- Updated the site-nav to adjust the top padding depending on the dimensions of the custom logo, preventing an overflow issue

Version 1.11 (2017-07-20)
-------------------------
- Removed the included ImagesLoaded file, as it has been replaced by the bundled WP one

Version 1.10 (2017-07-20)
-------------------------
- Added a demo URL to the theme description

Version 1.09 (2017-07-18)
-------------------------
- Replaced imagesloaded with bundled WordPress version
- Added escaping of home_url() and get_theme_mod()
- Added prefixes to image sizes
- Changed sanitize callback for hamilton_home_title customizer option
- Added a wp_list_pages fallback to the primary menu

Version 1.08 (2017-07-12)
-------------------------
- Mentioned the resume page template in the theme description

Version 1.07 (2017-07-10)
-------------------------
- Added the resume page template

Version 1.06 (2017-07-10)
-------------------------
- Various visual tweaks, improvements and adjustments
- Added a smooth scroll to anchor links

Version 1.05 (2017-07-10)
-------------------------
- Typography tweaks, CSS only

Version 1.04 (2017-07-10)
-------------------------
- Replaced the Unsplash images in screenshot.png, and updated the Licenses section of the readme accordingly
- Updated the style.css TOC to match the section names in the CSS

Version 1.03 (2017-07-10)
-------------------------
- Added the fade-in on visible effect to post previews in the related posts section on single posts as well

Version 1.02 (2017-07-09)
-------------------------
- Hide gallery captions on mobile to prevent clipping

Version 1.01 (2017-07-09)
-------------------------
- Fixed margins between multiple stacked galleries on small screen sizes

Version 1.0 (2017-07-09)
-------------------------
