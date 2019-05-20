<?php
/**
 * Social Share links
 * Adapted from:
 * @link https://10up.github.io/wp-component-library/component/social-share/index.html
 */
?>

<div class="social-share button-group">

  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>&t=<?php echo urlencode( $post->post_title ); ?>" target="_blank" rel="noopener noreferrer" class="social-share__link button">
    <?php esc_html_e( 'Share on Facebook', 'sage' ); ?><span class="show-for-sr"><?php esc_html_e( '(opens new window)', 'sage' ); ?></span>
  </a>

  <a href="https://twitter.com/share?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>" target="_blank" rel="noopener noreferrer" class="social-share__link button">
    <?php esc_html_e( 'Share on Twitter', 'sage' ); ?>  <span class="show-for-sr"><?php esc_html_e( '(opens new window)', 'sage' ); ?></span>
  </a>

  <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank" rel="noopener noreferrer" class="social-share__link button">
    <?php esc_html_e( 'Share on LinkedIn', 'sage' ); ?> <span class="show-for-sr"><?php esc_html_e( '(opens new window)', 'sage' ); ?></span>
  </a>

  <a href="http://www.pinterest.com/pin/create/bookmarklet/?url=<?php echo urlencode( esc_url( get_permalink( get_the_ID() ) ) ); ?>&media=<?php echo urlencode( esc_url( $imgurl )); ?>&is_video=false&description=<?php echo urlencode( esc_attr( get_the_excerpt() ) ); ?>" target="_blank" rel="noopener noreferrer" class="social-share__link button">
    <?php esc_html_e( 'Share on Pinterest', 'sage' ); ?> <span class="show-for-sr"><?php esc_html_e( '(opens new window)', 'sage' ); ?></span>
  </a>

</div>
