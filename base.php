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
      do_action('get_header');
      get_template_part('templates/header', 'site');
      get_template_part('templates/offcanvas');
    ?>
    <div class="content content--site" role="document">
      <?php
        if (Setup\display_breadcrumbs()) {
          Util\breadcrumbs();
        }
      ?>
      <main class="main <?php if (Setup\display_sidebar()): ?>main--has-sidebar<?php endif; ?>" id="main">
        <?php include Wrapper\template_path(); ?>
      </main><!-- /.main -->
      <?php if (Setup\display_sidebar()) : ?>
        <aside class="sidebar">
          <?php include Wrapper\sidebar_path(); ?>
        </aside><!-- /.sidebar -->
      <?php endif; ?>
    </div><!-- /.content -->
    <?php
      do_action('get_footer');
      get_template_part('templates/footer', 'site');
      get_template_part('templates/menu', 'bottombar');
      wp_footer();
    ?>
  </body>
</html>
