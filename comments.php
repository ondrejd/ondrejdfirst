<?php
/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/ondrejdfirst for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package ondrejdfirst
 * @since 1.0.0
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( $comments ) :
?>
<div class="comments">
	<h3 class="comment-reply-title"><?php _e( 'Komentáře', 'ondrejdfirst' ) ?></h3>
	<?php
	wp_list_comments( [
		'style'       => 'div',
		'avatar_size' => 110,
	] );

	if( paginate_comments_links( 'echo=0' ) ) :
?>
	<div class="comments-pagination pagination"><?php paginate_comments_links() ?></div>
<?php
	endif;
?>
</div>
<?php
endif;

if( comments_open() || pings_open() ) :
	comment_form( 'comment_notes_before=&comment_notes_after=' );
elseif( $comments ) :
?>
<div id="respond">
	<p class="closed"><?php _e( 'Komentáře jsou uzavřeny', 'ondrejdfirst' ) ?></p>
</div>
<?php
endif;
