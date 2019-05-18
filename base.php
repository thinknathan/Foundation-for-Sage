<?php
use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Util;
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <?php do_action( 'wp_body_open' ); ?>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/" rel="nofollow">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      get_template_part('templates/header', 'site');
    ?>
    <div class="wrap container" role="document">
      <div class="content">
        <?php
          if (Setup\display_breadcrumbs()) :
            Util\breadcrumbs();
          endif;
        ?>
        <main class="main">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
        <?php if (Setup\display_sidebar()) : ?>
          <aside class="sidebar">
            <?php include Wrapper\sidebar_path(); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
      </div><!-- /.content -->
    </div><!-- /.wrap -->
    <?php
      get_template_part('templates/footer', 'site');
      wp_footer();
    ?>
  </body>
</html>
