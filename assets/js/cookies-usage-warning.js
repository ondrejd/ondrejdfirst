/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/ondrejdfirst for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package ondrejdfirst
 * @since 1.0.0
 */

jQuery( document ).ready( function( $ ) {
    $( "#cookies_usage_warning--form" ).submit( function( event ) {
        $.post( ajax_object.url, {
                "action": ajax_object.action,
                "email": "example@gmail.com",
                "security" : ajax_object.nonce,
            },
            function( respond ) {
                $( "#cookies_usage_warning--cont" ).hide();
            }
        );
        event.preventDefault();
    } );
} );
