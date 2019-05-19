<?php use Roots\Sage\Util ?>

<a href="<?php the_permalink() ?>" class="card">
  <div class="card-section">
    <h2 class="h3">
      <?= Util\snip(get_the_title(), '9', 'words'); ?>
    </h2>
    <p class="card-meta">
      By <?php the_author() ?>
    </p>
    <?php /*
    <div class="card-avatar">
      <?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>
    </div>
    <p class="card-meta">
      Posted <time datetime="<?= get_the_date('c'); ?>"><?= get_the_date('F j, Y'); ?></time>
    </p>
    <p class="card-meta">
      Modified <time datetime="<?= get_the_modified_date('c'); ?>"><?= get_the_modified_date('F j, Y'); ?></time>
    </p>
    */ ?>
  </div>

  <div class="card-image">
    <?php the_post_thumbnail('card-thumbnail'); ?>
  </div>

  <div class="card-section">
    <p class="card-meta">
      <?= Util\snip(get_the_content(), '15', 'words'); ?>
    </p>
  </div>

  <div class="card-section">
    <div class="button-group">
      <span class="button">Read More</span>
    </div>
  </div>
</a>
