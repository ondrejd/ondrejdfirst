/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/ondrejdfirst for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package ondrejdfirst
 * @since 1.0.0
 */

( function( $ ) {
    wp.customize.bind( 'ready', function() {
        var customize = this;

        customize.previewer.bind( 'preview-edit', function( data ) {
            console.log( data );
            var json = JSON.parse( data );
            console.log( json );
            var control = customize.control( data.name );
            control.focus( {
                completeCallback : function() {
                    setTimeout( function() {
                        control.container.addClass( 'shake animated' );
                    }, 300 );
                }
            } );
        } );

        // Preview Content: Thumbnail
        customize( 'ondrejdfirst_preview_show_thumbnail', function( setting ) {
            setting.bind( function( newval ) {
                customize.previewer.refresh();
            } );
        } );

        // Hook for "show_on_front" setting to bind toggling disabled property
        // on front page title/description inputs.
        customize( 'show_on_front', function( setting ) {
            // Settings (controls)
            var controls = [
                'ondrejdfirst_home_title',
                'ondrejdfirst_show_home_title',
                'ondrejdfirst_home_description',
                'ondrejdfirst_show_home_description'
            ];

            $.each( controls, function( index, id ) {
                customize.control( id, function( control ) {
                    // Toggling function
                    var toggle = function( to ) {
                        control.toggle( to );
                    };

                    // 1. On loading.
                    toggle( setting.get() == 'posts' );
                    // 2. On value change.
                    setting.bind( function( to ) {
                        toggle( to == 'posts' );
                    } );
                } );
            } );

            setting.bind( function( to ) {
                var url = customize.settings.url.home;
                customize.previewer.previewUrl.set( url );
            } );
        } );
    } );
} )( jQuery );
