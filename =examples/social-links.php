<?php use Roots\Sage\Util; ?>

<ul class="social-links">
<?php
// check if the repeater field has rows of data
if( have_rows('acf_social_media', 'options') ):
  // loop through the rows of data
  while ( have_rows('acf_social_media', 'options') ) : the_row(); ?>

    <li class="social-links__list-item">
      <a class="social-links__link" target="_blank" rel="noreferrer noopener" href="<?php the_sub_field('acf_link'); ?>">
        <?php 
        $image = get_sub_field('acf_image');
        $size = 'social-icon';
        $icon = get_sub_field('acf_site');

        if( !empty($image) ) {
          echo Util\get_image( $image, $size );
        } else {
          echo Util\local_image('social/icon-' . $icon . '-white.svg', 20, 20, $icon);
        }
        ?>
      </a>
    </li>

  <?php endwhile; ?>

<?php endif; ?>
</ul>
