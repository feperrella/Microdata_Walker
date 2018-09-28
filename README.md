# Microdata Walker ![WordPress](https://img.shields.io/wordpress/v/akismet.svg)

Microdata Walker is class that extends WordPress Walker_Nav_Menu class to include MicroData markup to it's wp_nav_menu().

> In the future will implement for Walker_Page used in wp_page_menu().

## Installation

### Requirements
* WordPress 4 and up
* PHP 7 and up

## Functions.php

You can save the file wherever you prefer, in this example inside "inc" folder.

First register your menu

```
register_nav_menus( array(
	'primary'    => __( 'Primary', 'project_lang' ),
));
```

Place the code below at the end of your functions.php file.

```
require_once 'inc/class_microdata_nav_walker.php';

```

## Usage

Register your menu, and assing the values in the code below.
Use in your theme with this conditions to prevent errors.
Fallsback to wp_page_menu() if no menu is selected.

```
// Check if the primary menu is activated preventing a design flaw in WP core.
// Add some classes to use with Zurb Foundation.
if ( has_nav_menu( 'primary' ) ) :
	wp_nav_menu( array(
		'theme_location'  => 'primary',
		'container'       => 'nav',
		'container_class' => 'navigation',
		'container_id'    => 'nav',
		'menu_class'      => 'vertical medium-horizontal menu',
		'menu_id'         => 'menu',
		'items_wrap'      => '<ul id="%1$s" class="%2$s" data-responsive-menu="dropdown" itemscope itemtype="http://www.schema.org/SiteNavigationElement">%3$s</ul>',
		'walker'          => new Microdata_Nav_Walker(),
	));
else :
	wp_page_menu(); // Fallsback to wp_page_menu().
endif;
```

## Output

```
<nav id="nav" class="navigation">
	<ul id="menu" class="vertical medium-horizontal menu dropdown" data-responsive-menu="dropdown" itemscope="" itemtype="http://www.schema.org/SiteNavigationElement" role="menubar">
		<li id="menu-item-1" class="main-menu-item menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-1 current_page_item" itemprop="name" role="menuitem">
			<a href="http://example.com/item1/" class="menu-link main-menu-link" itemprop="url">Menu Item</a>
		</li>
		<li id="menu-item-2" class="main-menu-item menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children" itemprop="name" role="menuitem">
			<a href="http://example.com/item2/" class="menu-link main-menu-link" itemprop="url">Menu Item</a>
			<ul class="menu vertical nested submenu" itemscope itemtype="http://www.schema.org/SiteNavigationElement" role="menu">
				<li id="menu-item-3" class="sub-menu-item menu-item menu-item-type-post_type menu-item-object-page" itemprop="name" role="menuitem">
					<a href="http://example.com/item3/" class="menu-link sub-menu-link" itemprop="url">Menu Item</a>
				</li>
			</ul>
		</li>
	</ul>
</nav>
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## References
WordPress.org Code Reference

* [wp_nav_menu](https://developer.wordpress.org/reference/functions/wp_nav_menu/)
* [walker_nav_menu](https://developer.wordpress.org/reference/classes/walker_nav_menu/)

> Future
> * [wp_page_menu](https://developer.wordpress.org/reference/functions/wp_page_menu/)
> * [walker_page](https://developer.wordpress.org/reference/classes/walker_page/)


## License
[MIT](https://choosealicense.com/licenses/mit/)