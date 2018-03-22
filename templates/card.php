<?php use Roots\Sage\Extras ?>

<a href="<?php the_permalink() ?>">
  <div class="card-post">

    <div class="card-post-img">
      <?php the_post_thumbnail('post-thumbnail', ['class' => 'card-post-img']); ?>
    </div>

    <div class="card-post-content card-section">
      <div class="card-post-avatar">
        <?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>
      </div>
      <p class="card-post-name">
        <?= Extras\snip(get_the_title(), '9', 'words'); ?>
      </p>
      <p class="card-post-status hide">
        By <?php the_author() ?>
      </p>
      <p class="card-post-status hide">
        Posted <time datetime="<?= get_the_date('c'); ?>"><?= get_the_date('F j, Y'); ?></time>
      </p>
      <p class="card-post-status hide">
        Modified <time datetime="<?= get_the_modified_date('c'); ?>"><?= get_the_modified_date('F j, Y'); ?></time>
      </p>
      <p class="card-post-info">
        <?= Extras\snip(get_the_content(), '15', 'words'); ?>
      </p>
    </div>

    <div class="card-post-actions">
      <span class="card-post-button button">Read More</span>
    </div>

  </div>
</a>
