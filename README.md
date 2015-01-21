# Subar Rum WordPress Theme



## About
Subar Rum (old high german for clean room) is a clean and fully responsive
WordPress theme built around Bootstrap with many options to adapt it to
your needs. It features some built-in widgets for a nicer presentation and
posts and images can be marked as recommended to present them in two
different image sliders/carousels in the main content header. It makes
intensive use of the post thumbnail feature and adds some additonal image
sizes. Beside different stylings for post formats there are optional page
templates for full width presentations and a template for a static front
page with own widgets. Furthermore it is possible to display the blog
layout in two columns.
Developed with westphalian stubbornness in Munich.

License: GPLv3 - http://www.gnu.org/licenses/gpl-3.0.en.html  
Author: Buschmann  
Author Site: http://www.buschmann23.de  
Theme Site: http://www.buschmann23.de/entwicklung/wordpress/themes/subar-rum/  
Theme Demo: http://subarrum-demo.buschmann23.de  



## Features
* base colors: black, blue, gray and white
* two columns: content and widget area on the right
* two blog columns: optionally you can present your blog entries in two columns
* fixed width: 960px, content are 630px (but without widgets also 960px)
* custom background: set your own image or pattern
* custom headers: choose out of three headers, bxSlider, Bootstrap Corousel
  or WP custom header, or disable it completely
* custom menu: create own menus in WordPress and choose out of two possible
  positions (top navbar or header)
* editor style: see what you are doing
* featured image header: show recommended images or posts with post thumbnails
  in your header
* featured images: attach images to your posts and they will be diplayed
  automatically in the right way. Also you can use them to link posts in
  a slider/carousel in the header
* flexible header: define own header image (width 960px) with or without
  blog title and subtitle
* full width template: present your pages over the full width
* post formats: use the WordPress built in post formats, currently aside,
  image, link, quote, status, video and audio
* sticky posts: stick important posts to the start of your blog entries
* theme options: adapt many parts of the theme to your own needs
* threaded comments: structured discussions
* translation ready: present the systems text strings in your own language,
  english and german are currently in the base packge of subar rum
* responsive: show your content perfectly on every device
* meta data styles: choose from different meta data styles
* recommended items: recommend images or posts and show them in the header
  slider/carousel, link the images there directly to the posts
* navigation bar: flexible navigation bar on the top, you can disable it or show
  a menu in it, otherwise it shows a search field
* built in widgets: there are some built in widgets to present your content in a
  nicer way (recent posts/comments, recommended posts/images)



## Usage Notes
    |--------------------------------------------------------------------------------------|
    |                Top Navigation Bar (fixed/static/or disabled)                         | 
    |--------------------------------------------------------------------------------------|
    |                                                                                      |
    |  |--------------------------------------------------------------------------------|  |
    |  |                                                                                |  |
    |  |                                                                                |  |
    |  |     Header (bxSlider/Bootstrap Carousel/WP Image Header/or disabled)           |  |
    |  |                                                                                |  |
    |  |                                                                                |  |
    |  |--------------------------------------------------------------------------------|  |
    |  |                                                                                |  |
    |  |--------------------------------------------------------------------------------|  |
    |  |                               Primary Menu Place                               |  |
    |  |--------------------------------------------------------------------------------|  |
    |  |                                                                                |  |
    |  |--------------------------------------------------------------------------------|  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |    Widget Area       |  |
    |  |                                                         |       either         |  |
    |  |                                                         |        Main,         |  |
    |  |                                                         |       Entries,       |  |
    |  |                                                         |       or Pages       |  |
    |  |               Main Content Area                         |       Widgets        |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |                                                         |                      |  |
    |  |--------------------------------------------------------------------------------|  |
    |  |                                                                                |  |
    |  |--------------------------------------------------------------------------------|  |
    |  |                                                                                |  |
    |  |                 Footer Widget Area 1                                           |  |
    |  |                                                                                |  |
    |  |--------------------------------------------------------------------------------|  |
    |  |                                                                                |  |
    |  |                 Footer Widget Area 2                                           |  |
    |  |                                                                                |  |
    |  |--------------------------------------------------------------------------------|  |
    |                                                                                      |
    |--------------------------------------------------------------------------------------|


### Recommended Items
In the edit view of posts and images you can mark the item to be recommended.
Recommended items can be shown in the header carousel/slider or in a special sidebar
widget. In the carousel/slider you can link the images directly to the posts/image
pages. For posts without a post thumbnail you can specify placeholder images.
The recommended status is saved in wp_post_meta database with the subarrum_featured
key.

### Different Headers
There are three different base header styles: WP Header Image, bxSlider and Bootstrap
Carousel. With the slider and the carousel you can show your recommended content (posts
or images). If posts don't have a post thumbnail, you can specify placeholder images
that are shown then.

### Menus
You can use the built in WordPress function to build your custom menus. A custom
walker function of Subar Rum then builds the code to present them in expandable 
pop up menus. There are two menu positions. One in the top navigation bar and another
below the header (bxSlider/Carousel/WP Header Image). You can use both positions at
the same time. But be aware that the navigation bar menu does not have that much of
space for top level entries than the primary menu down below the header image.

### Widget Areas
There are different widget areas. The main area is on the right side and their image are
shown everywhere when the areas for single posts and pages are empty. There are two
footer areas for widgets which can hold 4 widgets side by side. There will be a warning in
the frontend if you try to put more than 4 widgets in it. Widgets area are only shown
and their space is only used if there are widgets present. So, if there are no widgets
in the right widget are, then the content is shown over the full width of 960px.
There are some special widget areas that are only shown on special pages: two for the
front page template and one for a possible gallery or whatever.

### Custom Functions/Classes
Subar Rum uses some custom functions to override WordPress functions.

* subarrum_walker_nav_menu extends the walker menu class to build the menu.
* subarrum_wp_link_pages builds the pagination for articles on multiple sites (instead of
  wp_link_pages)
* subarrum_paginate_links builds the pagination for multiple blog pages (instead of
  posts_nav_link or paginate_links)
* subarrum_post_thumbnail builds the html code for the featured images/post thumbnails
  (instead of the_post_thumbnail)


## Tips & Tricks ##
### Image Decorations
By default the images in the main content area get styled with rounded corners and a
shadow around. This looks good for photos and similar stuff but not for things with
transparent background like icons. For this you can use the following CSS class "img.no-deco"
to disable the decoration.

### Link Decorations
By default hovered links get underlined. But if you for example want to use links with
only Font Awesoma Icons it doesn't look that good. For this purpose there is the CSS class
"a.no-deco" to disable the decoration.



## Bundled Resources ##
Twitter Bootstrap - http://twitter.github.io/bootstrap/index.html
Licensed under Apache License v2.0 - http://www.apache.org/licenses/LICENSE-2.0

bxSlider - http://bxslider.com/
Licensed under MIT - License - http://opensource.org/licenses/MIT

Font Awesome by Dave Gandy - http://fortawesome.github.com/Font-Awesome
Font licensed under SIL Open Font License - http://scripts.sil.org/OFL
CSS licensed under MIT License - http://opensource.org/licenses/mit-license.html

HTML5 Shiv by Alexander Farkas, Jonathan Neal, Paul Irish et al.
Licensed under MIT License - http://opensource.org/licenses/mit-license.html

Justified Gallery by Miro Mannino - http://miromannino.com/projects/justified-gallery/
Licensed under MIT License - http://opensource.org/licenses/MIT