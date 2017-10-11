/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/ondrejdfirst for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package ondrejdfirst
 * @since 1.0.0
 */

( function( $ ) {

	// Site title
	wp.customize( 'blogname', function( setting ) {
		setting.bind( function( newval ) {
			$( '.site-title a.site-name' ).html( newval );
		} );
	} );

	// Site description
	wp.customize( 'blogdescription', function( setting ) {
		setting.bind( function( newval ) {
			$( '.site-description' ).html( newval );
		} );
	} );

	// Show site description
	wp.customize( 'ondrejdfirst_site_description', function( setting ) {
		setting.bind( function( newval ) {
			if ( newval == true ) {
				$( '.site-description' ).css( 'display', 'block' );
			} else {
				$( '.site-description' ).css( 'display', 'none' );
			}
		} );
	} );

	// XXX Color Mode
	/*wp.customize( 'hamilton_dark_mode', function( setting ) {
		setting.bind( function( newval ) {
			if ( newval == true ) {
				$( 'body' ).addClass( 'dark-mode' );
			} else {
				$( 'body' ).removeClass( 'dark-mode' );
			}
		} );
	} );*/

	// Alt Nav
	wp.customize( 'ondrejdfirst_alt_nav', function( setting ) {
		setting.bind( function( newval ) {
			if ( newval == true ) {
				$( 'body' ).addClass( 'show-alt-nav' );
			} else {
				$( 'body' ).removeClass( 'show-alt-nav' );
			}
		} );
	} );

	// Cookie warning
	wp.customize( 'ondrejdfirst_cookies_warning', function( setting ) {
		setting.bind( function( newval ) {
			if ( newval == true ) {
				$( '#cookies-usage-warning--cont' ).css( 'display', 'block' );
			} else {
				$( '#cookies-usage-warning--cont' ).css( 'display', 'none' );
			}
		} );
	} );

	// Three grid columns
	wp.customize( 'ondrejdfirst_three_columns', function( setting ) {
		setting.bind( function( newval ) {
			if ( newval == true ) {
				$( 'body' ).addClass( 'three-columns-grid' );
			} else {
				$( 'body' ).removeClass( 'three-columns-grid' );
			}
			// XXX Does this work also on Shop page?
			$( '.posts' ).masonry();
			$( '.tracker' ).each( function() {
				$( this ).addClass( 'will-spot' ).removeClass( 'spotted' );
				if ( $( this ).offset().top < $( window ).height() ) {
					$( this ).addClass( 'spotted' );
				}
			} );
		} );
	} );

	// Front Page Title
	wp.customize( 'ondrejdfirst_home_title', function( setting ) {
		setting.bind( function( newval ) {
			$( '#ondrejdfirst_home_title' ).text( newval );
		} );
	} );
	wp.customize( 'ondrejdfirst_show_home_title', function( setting ) {
		setting.bind( function( newval ) {
			if ( newval == true ) {
				$( '#ondrejdfirst_home_title--header' ).css( 'display', 'block' );
			} else {
				$( '#ondrejdfirst_home_title--header' ).css( 'display', 'none' );
			}
		} );
	} );

	// Front Page Description
	wp.customize( 'ondrejdfirst_home_description', function( setting ) {
		setting.bind( function( newval ) {
			$( '#ondrejdfirst_home_description' ).html( newval );
		} );
	} );
	wp.customize( 'ondrejdfirst_show_home_description', function( setting ) {
		setting.bind( function( newval ) {
			if ( newval == true ) {
				$( '#ondrejdfirst_home_description' ).css( 'display', 'block' );
			} else {
				$( '#ondrejdfirst_home_description' ).css( 'display', 'none' );
			}
		} );
	} );

	// Preview Content: Category
	wp.customize( 'ondrejdfirst_preview_show_category', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.preview-header .preview-category' ).css( 'display', 'block' );
			} else {
				$( '.preview-header .preview-category' ).css( 'display', 'none' );
			}
		} );
	} );

	// Preview Content: Date and Time
	wp.customize( 'ondrejdfirst_preview_show_date', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.preview-header .preview-date' ).css( 'display', 'block' );
			} else {
				$( '.preview-header .preview-date' ).css( 'display', 'none' );
			}
		} );
	} );

	// Preview Content: Excerpt
	wp.customize( 'ondrejdfirst_preview_show_excerpt', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.preview-header .preview-excerpt' ).css( 'display', 'block' );
			} else {
				$( '.preview-header .preview-excerpt' ).css( 'display', 'none' );
			}
		} );
	} );

	// Preview Content: Tags
	wp.customize( 'ondrejdfirst_preview_show_tags', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.preview-header .preview-tags' ).css( 'display', 'block' );
			} else {
				$( '.preview-header .preview-tags' ).css( 'display', 'none' );
			}
		} );
	} );

	// Show blog filter
	wp.customize( 'ondrejdfirst_blog_filter', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '#ondrejdfirst_blog_filter' ).css( 'display', 'block' );
			} else {
				$( '#ondrejdfirst_blog_filter' ).css( 'display', 'none' );
			}
		} );
	} );

	// WC General: Page Title
	wp.customize( 'ondrejdfirst_wc_pages_title', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.ondrejdfirst-wc-content-wrapper .page-title' ).css( 'display', 'block' );
			} else {
				$( '.ondrejdfirst-wc-content-wrapper .page-title' ).css( 'display', 'none' );
			}
		} );
	} );

	// WC General: Breadcrumbs
	wp.customize( 'ondrejdfirst_wc_breadcrumbs', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.ondrejdfirst-wc-content-wrapper .woocommerce-breadcrumb' ).css( 'display', 'block' );
			} else {
				$( '.ondrejdfirst-wc-content-wrapper .woocommerce-breadcrumb' ).css( 'display', 'none' );
			}
		} );
	} );

	// WC General: Result count
	wp.customize( 'ondrejdfirst_wc_result_count', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.ondrejdfirst-wc-content-wrapper .woocommerce-result-count' ).css( 'display', 'block' );
			} else {
				$( '.ondrejdfirst-wc-content-wrapper .woocommerce-result-count' ).css( 'display', 'none' );
			}
		} );
	} );

	// WC Shop Page: Fancy orderby
	wp.customize( 'ondrejdfirst_wc_fancy_order_select' , function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.woocommerce-ordering select[name="orderby"]' ).css( 'display', 'none' );
				$( '.ondrejdfirst-wc-ordering' ).toggleClass( 'active' );
				$( '#ondrejdfirst-ordering' ).css( 'display', 'block' );
			} else {
				$( '.ondrejdfirst-wc-ordering' ).toggleClass( 'active' );
				$( '.woocommerce-ordering select[name="orderby"]' ).css( 'display', 'block' );
				$( '#ondrejdfirst-ordering' ).css( 'display', 'none' );
			}
		} );
	} );

	// WC Shop Page: Sidebar
	wp.customize( 'ondrejdfirst_wc_sidebar', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '#sidebar' ).css( 'display', 'block' );
			} else {
				$( '#sidebar' ).css( 'display', 'none' );
			}
		} );
	} );
} )( jQuery );
