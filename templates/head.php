<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style><?php $fileToInline = get_template_directory() . '/dist/styles/' . basename(Roots\Sage\Assets\asset_path('styles/head-critical.css'));
               if ( file_exists($fileToInline) ) { readfile($fileToInline); }
               $fileToInline = get_template_directory() . '/dist/styles/' . basename(Roots\Sage\Assets\asset_path('styles/head-inline.css'));
               if ( file_exists($fileToInline) ) { readfile($fileToInline); }
               ?></style>
  <?php wp_head(); ?>
  <?php $fileToInline = get_template_directory() . '/dist/scripts/' . basename(Roots\Sage\Assets\asset_path('scripts/head-inline.js')); if ( file_exists($fileToInline) ): ?><script><?php readfile($fileToInline); ?></script><?php endif; ?>
</head>
