<?php

if( ! function_exists( 'ondrejdfirst_setup' ) ) :
	/**
	 * Setup the theme.
	 * @global int $content_width
	 * @return void
	 * @since 1.0.0
	 * @uses add_image_size
	 * @uses add_post_type_support
	 * @uses add_theme_support
	 * @uses load_theme_textdomain
	 * @uses register_nav_menu
	 * @uses remove_theme_support
	 */
	function ondrejdfirst_setup() {
		global $content_width;

		// Localization
		load_theme_textdomain( 'ondrejdfirst', get_template_directory() . '/languages' );

		// Theme Support: Automatic feed links
		add_theme_support( 'automatic-feed-links' );

		// Theme Support: Post thumbnails
		add_theme_support( 'post-thumbnails' );

		// Theme Support: HTML5 semantic markup
		add_theme_support( 'html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption'] );

		// Theme Support: Custom logo
		add_theme_support( 'custom-logo', [
			'height'      => 400,
			'width'       => 600,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => ['site-title', 'site-description'],
		] );

		// Theme Support: Title tag
		add_theme_support( 'title-tag' );

		// Theme Support: Jetpack Infinite Scroll Support
		add_theme_support( 'infinite-scroll', [
			'type'           => 'click',
			'footer'		 => false,
			'footer_widgets' => false,
			'container'      => 'posts',
			'render'         => false,
			'posts_per_page' => false,
		] );

		// Theme Support: WooCommerce
		add_theme_support( 'woocommerce' );

		// Theme Support: Remove Cusstom Background
		remove_theme_support( 'custom-background' );

		// Set content-width
		if( ! isset( $content_width ) ) {
			$content_width = 560;
		}

		// Custom Image Sizes
		add_image_size( 'ondrejdfirst_preview-image', 1200, 9999 );
		add_image_size( 'ondrejdfirst_fullscreen-image', 1860, 9999 );

		// Add nav menu
		register_nav_menu( 'primary-menu', __( 'Primary Menu', 'ondrejdfirst' ) );
		register_nav_menu( 'social-menu', __( 'Social Menu', 'ondrejdfirst' ) );

		// Add excerpts to pages
		add_post_type_support( 'page', ['excerpt'] );
	}
endif;

add_action( 'after_setup_theme', 'ondrejdfirst_setup' );


if( ! function_exists( 'ondrejdfirst_load_style' ) ) :
	/**
	 * Enqueue styles.
	 * @return void
	 * @since 1.0.0
	 * @uses get_stylesheet_uri
	 * @uses is_admin
	 * @uses wp_enqueue_style
	 * @uses wp_register_style
	 */
	function ondrejdfirst_load_style() {
		if ( ! is_admin() ) {
	        wp_enqueue_style( 'ondrejdfirst-style', get_stylesheet_uri(), ['ondrejdfirst-fonts'] );
			wp_register_style( 'ondrejdfirst-fonts', 'https://fonts.googleapis.com/css?family=Libre+Franklin:300,400,400i,500,700,700i&amp;subset=latin-ext', [], null );
	    }
	}
endif;

add_action( 'wp_print_styles', 'ondrejdfirst_load_style' );


if( ! function_exists( 'ondrejdfirst_add_editor_styles' ) ) :
	/**
	 * Add Editor Styles
	 * @return void
	 * @since 1.0.0
	 * @uses add_editor_style
	 */
	function ondrejdfirst_add_editor_styles() {
	    add_editor_style( [
			'ondrejdfirst-editor-styles.css',
			'https://fonts.googleapis.com/css?family=Libre+Franklin:300,400,400i,500,700,700i&amp;subset=latin-ext'
		] );
	}
endif;

add_action( 'init', 'ondrejdfirst_add_editor_styles' );


// Deactivate default WP gallery styles
add_filter( 'use_default_gallery_style', '__return_false' );


if( ! function_exists( 'ondrejdfirst_enqueue_scripts' ) ):
	/**
	 * Enqueue Scripts.
	 * @return void
	 * @since 1.0.0
	 * @uses get_template_directory_uri
	 * @uses wp_enqueue_script
	 */
	function ondrejdfirst_enqueue_scripts() {
		$script_uri = get_template_directory_uri() . '/assets/js/global.js';
		wp_enqueue_script(
			'ondrejdfirst_global',
			$script_uri,
			['jquery', 'imagesloaded', 'masonry'],
			'',
			true
		);
	}
endif;

add_action( 'wp_enqueue_scripts', 'ondrejdfirst_enqueue_scripts' );


if( ! function_exists( 'ondrejdfirst_post_classes' ) ) :
	/**
	 * Post CSS classes.
	 * @param array $classes
	 * @return array
	 * @since 1.0.0
	 */
	function ondrejdfirst_post_classes( $classes ) {
		$classes[] = ( has_post_thumbnail() ? 'has-thumbnail' : 'missing-thumbnail' );
		return $classes;
	}
endif;

add_action( 'post_class', 'ondrejdfirst_post_classes' );


if( ! function_exists( 'ondrejdfirst_body_classes' ) ) :
	/**
	 * Body classes.
	 * @param array $classes
	 * @return array
	 * @since 1.0.0
	 */
	function ondrejdfirst_body_classes( $classes ) {
		// Check whether we're in the customizer preview
		if( is_customize_preview() ) {
			$classes[] = 'customizer-preview';
		}

		// Set color mode
		$color_mode = get_theme_mod( 'ondrejdfirst_color_mode' );
		if( $color_mode == 'ubuntu' ) {
			$classes[] = 'ubuntu';
		}
		elseif( $color_mode == 'ubuntu-dark' ) {
			$classes[] = 'ubuntu-dark';
		}

		// Alternate navigation
		if( get_theme_mod( 'ondrejdfirst_alt_nav' ) ) {
			$classes[] = 'show-alt-nav';
		}

		// Three preview columns
		if( get_theme_mod( 'ondrejdfirst_three_columns' ) ) {
			$classes[] = 'three-columns-grid';
		}

		// Cookies usage warning
		if( get_theme_mod( 'ondrejdfirst_cookies_warning' ) ) {
			$classes[] = 'show-cookies-usage-warning';
		}

		// Add short class to body if resumé page template
		if( is_page_template( 'resume-page-template.php' ) ) {
			$classes[] = 'resume-template';
		}

		return $classes;
	}
endif;

add_action( 'body_class', 'ondrejdfirst_body_classes' );


if( ! function_exists( 'ondrejdfirst_has_js' ) ) :
	/**
	 * Customizes WP head
	 * @return void
	 * @since 1.0.0
	 */
	 function ondrejdfirst_has_js() {
?>
<script>jQuery( 'html' ).removeClass( 'no-js' ).addClass( 'js' );</script>
<?php
	}
endif;

add_action( 'wp_head', 'ondrejdfirst_has_js' );


if( ! function_exists( 'ondrejdfirst_load_scripts' ) ) :
	/**
	 * Enqueue comment-reply.js
	 * @return void
	 * @since 1.0.0
	 */
	function ondrejdfirst_load_scripts(){
	    if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	        wp_enqueue_script( 'comment-reply' );
	    }
	}
endif;

add_action( 'wp_print_scripts', 'ondrejdfirst_load_scripts' );


if( ! function_exists( 'ondrejdfirst_remove_archive_title_prefix' ) ) :
	/**
	 * Remove prefix before archive titles
	 * @param string $title
	 * @return string
	 * @since 1.0.0
	 */
	function ondrejdfirst_remove_archive_title_prefix( $title ) {
	    if ( is_category() ) {
	        $title = single_cat_title( '', false );
	    } elseif ( is_tag() ) {
	        $title = single_tag_title( '#', false );
	    } elseif ( is_author() ) {
	        $title = '<span class="vcard">' . get_the_author() . '</span>';
	    } elseif ( is_year() ) {
	        $title = get_the_date( 'Y' );
	    } elseif ( is_month() ) {
	        $title = get_the_date( 'F Y' );
	    } elseif ( is_day() ) {
	        $title = get_the_date( get_option( 'date_format' ) );
	    } elseif ( is_tax( 'post_format' ) ) {
	        if ( is_tax( 'post_format', 'post-format-aside' ) ) {
	            $title = _x( 'Asides', 'post format archive title', 'ondrejdfirst' );
	        } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
	            $title = _x( 'Galleries', 'post format archive title', 'ondrejdfirst' );
	        } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
	            $title = _x( 'Images', 'post format archive title', 'ondrejdfirst' );
	        } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
	            $title = _x( 'Videos', 'post format archive title', 'ondrejdfirst' );
	        } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
	            $title = _x( 'Quotes', 'post format archive title', 'ondrejdfirst' );
	        } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
	            $title = _x( 'Links', 'post format archive title', 'ondrejdfirst' );
	        } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
	            $title = _x( 'Statuses', 'post format archive title', 'ondrejdfirst' );
	        } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
	            $title = _x( 'Audio', 'post format archive title', 'ondrejdfirst' );
	        } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
	            $title = _x( 'Chats', 'post format archive title', 'ondrejdfirst' );
	        }
	    } elseif ( is_post_type_archive() ) {
	        $title = post_type_archive_title( '', false );
	    } elseif ( is_tax() ) {
	        $title = single_term_title( '', false );
	    } else {
	        $title = __( 'Archives', 'ondrejdfirst' );
	    }
	    return $title;
	}
endif;

add_filter( 'get_the_archive_title', 'ondrejdfirst_remove_archive_title_prefix' );


if( ! function_exists( 'ondrejdfirst_print_customize_button' ) ) :
	/**
	 * Prints customize button.
	 * @param string $id Value of "id" attribute"
	 * @param string $control Value of "data-control" attribute.
	 * @param string $title Value of "aria-label" and "title" attributes.
	 * @return void
	 * @since 1.0.0
	 */
	function ondrejdfirst_print_customize_button( $id, $control, $title ) {
?>
<span id="<?php echo esc_attr( $id ) ?>" class="customize-partial-edit-shortcut">
    <button class="ondrejdfirst-customize-button customize-partial-edit-shortcut-button" data-control='<?php echo $control ?>' aria-label="<?php echo esc_attr( $title ) ?>" title="<?php echo esc_attr( $title ) ?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z"></path>
        </svg>
    </button>
</span>
<?php
	}
endif;


/**
 * @var string $tpl_dir
 * @since 1.0.0
 */
$tpl_dir = get_template_directory() . '/includes';

// Include customize classes
include( "$tpl_dir/OndrejdFirst_Customize.php" );
include( "$tpl_dir/OndrejdFirst_Login_Customize.php" );
include( "$tpl_dir/OndrejdFirst_WooCommerce_Customize.php" );
include( "$tpl_dir/OndrejdFirst_Cookies_Usage_Warning.php" );
