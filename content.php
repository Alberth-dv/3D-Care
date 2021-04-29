<?php
/**
 * @package quadro
 */
?>

<?php // Set current formatting options for blog module if we are on it.
$thumb_size = '';
if ( isset($mod_id) ) {
	if ( $blog_layout == 'grid' ) {
		if ( $blog_columns == 'two' ) {
			$thumb_size = 'portfolio-masonry-two';
		} elseif ( $blog_columns == 'three' ) {
			$thumb_size = 'portfolio-masonry-three';
		}
	}
	elseif ( $blog_layout == 'classic' ) $thumb_size = 'portfolio-grid-two';
	elseif ( $blog_layout == 'teasers' ) $thumb_size = 'common-thumb';
} 
$post_format = get_post_format();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php // Declare global $more (before the loop) to allow <!--more--> tag
	global $more; $more = 0; ?>

	<?php // If post format has header...
	if ( $post_format != 'aside' && $post_format != 'status' && $post_format != 'quote' && $post_format != 'link' ) { ?>
	<header class="entry-header">

		<?php switch ( $post_format ) {
			case 'video':
				$media_return = quadro_print_media(get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'quadro' ) ), array('video', 'iframe', 'embed'), 1, '', '');
				// Break if no media returned
				if ( $media_return['media'] == '' ) break;
				echo '<div class="entry-thumbnail">';
				echo $media_return['media'];
				echo '</div>';
				break;

			case 'audio':
				$media_return = quadro_print_media(get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'quadro' ) ), array('audio', 'iframe', 'embed'), 1, '', '');
				// Break if no media returned
				if ( $media_return['media'] == '' ) break;
				echo '<div class="entry-thumbnail">';
				echo $media_return['media'];
				echo '</div>';
				break;
			
			case 'image':
				if ( has_post_thumbnail() && ! post_password_required() ) : 
				$thumb_size = 'portfolio-masonry-two'; ?>
				<div class="entry-thumbnail">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( $thumb_size, array('alt' => get_the_title(), 'title' => get_the_title()) ); ?></a>
				</div>
				<?php endif;
				break;

			case 'gallery':
				if ( get_post_gallery() ) {
					// Retrieve first gallery
					$gallery = get_post_gallery( get_the_ID(), false );
					if ( isset($gallery['ids']) ) {
						// Remove Galleries from content
						$content = quadro_strip_shortcode_gallery( get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'quadro' ) ) );
						// Filter through the_content filter
						$content = apply_filters( 'the_content', $content );
						$content = str_replace( ']]>', ']]&gt;', $content );
						echo '<div class="entry-gallery">';
						echo '<ul class="slides">';
						/* Loop through all images and output them one by one */
						$gallery_ids = explode(',', $gallery['ids']);
						foreach( $gallery_ids as $pic_id ) {
							echo '<li class="gallery-item">';
							echo wp_get_attachment_image( $pic_id, $thumb_size );
							echo ( get_post($pic_id) && get_post($pic_id)->post_excerpt != '' ) ? '<p class="gallery-caption">' . get_post($pic_id)->post_excerpt . '</p>' : '';
							echo '</li>';
						}
						echo '</ul></div>';
					} else {
						// Exit if gallery has no ids (old versions),
						// and leave content intact.
						$content = get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'quadro' ) );
						// Filter through the_content filter
						$content = apply_filters( 'the_content', $content );
						$content = str_replace( ']]>', ']]&gt;', $content );
					}
				} else {
					// Bring Content if no gallery anyway
					$content = get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'quadro' ) );
					// Filter through the_content filter
					$content = apply_filters( 'the_content', $content );
					$content = str_replace( ']]>', ']]&gt;', $content );
				}
				break;

			default:
				if ( has_post_thumbnail() && ! post_password_required() ) : ?>
				<div class="entry-thumbnail">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( $thumb_size, array('alt' => get_the_title(), 'title' => get_the_title()) ); ?></a>
				</div>
				<?php endif;
				break;
		} ?>

		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>

		<?php quadro_posted_by(); ?>

		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php $categories_list = get_the_category_list( __( ' ', 'quadro' ) );
			if ( $categories_list && quadro_categorized_blog() ) : ?>
				<span class="cat-links">
					<?php echo $categories_list; ?>
				</span>
			<?php endif; // End if categories ?>
		<?php endif; ?>

	</header><!-- .entry-header -->
	<?php } // End if post format has header... ?>

	<?php if ( is_search() || (isset($blog_layout) && $blog_layout != 'classic') || get_post_type() == 'quadro_nym_portfolio' ) : // Display Excerpts for Search and Grid/Teaser Blog Styles
	 	
	 	// We show here the excerpt, but not for these formats
	 	if ( $post_format != 'aside' && $post_format != 'status' && $post_format != 'quote' && $post_format != 'link' ) { ?>
			<div class="entry-summary">
				<?php echo quadro_excerpt(get_the_excerpt(), 30, '<span class="read-more">' . __('Read more', 'quadro') . '</span><i class="fa fa-chevron-right"></i>'); ?>
			</div><!-- .entry-summary -->
		<?php } else {
			if ( $post_format == 'quote' ) {
				echo '<div class="entry-content">';
				$quote = quadro_print_quote(get_the_content(), '', '');
				echo $quote['request'];
				echo quadro_excerpt($quote['content'], 5, '<span class="read-more">' . __('Read more', 'quadro') . '</span><i class="fa fa-chevron-right"></i>');
				echo '</div>';
			} elseif ( $post_format == 'link' ) {
				echo '<div class="entry-content">';
				echo quadro_excerpt(get_the_content(), 35, '<span class="read-more">' . __('Read more', 'quadro') . '</span><i class="fa fa-chevron-right"></i>');
				echo '</div>';
			} else {
				// Bring the full content for those formats
				echo '<div class="entry-content">';
				the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'quadro' ) );
				echo '</div><!-- .entry-content -->';
			}
		} ?>
	
	<?php else : ?>
	
	<div class="entry-content">
		<?php if ( $post_format == 'video' || $post_format == 'audio' ) echo $media_return['content'];
		elseif ( $post_format == 'gallery' ) echo $content;
		else the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'quadro' ) ); ?>
		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'quadro' ),
			'after'  => '</div>',
		) ); ?>
	</div><!-- .entry-content -->
	
	<?php endif; ?>

	<footer class="entry-meta clear">

		<?php // Hide category and tag text for pages on Search
		if ( 'post' == get_post_type() ) {
			// Print date meta
			quadro_posted_on();
		} ?>

		<?php // Print Tags list
		$tags_list = get_the_tag_list( '', __( ', ', 'quadro' ) );
		if ( $tags_list ) { ?>
			<span class="tags-links">
				<?php printf( __( 'Tagged: %1$s', 'quadro' ), $tags_list ); ?>
			</span>
		<?php } ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Comment', 'quadro' ), __( '1 Comment', 'quadro' ), __( '% Comments', 'quadro' ) ); ?></span>
		<?php endif; ?>

		<div class="post-icon-wrapper">
			<span class="post-icon"></span>
		</div>

	</footer><!-- .entry-meta -->

</article><!-- #post-## -->
