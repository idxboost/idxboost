<?php
get_header();

echo do_shortcode('[new_development_collections]');

// New Development no es página CMS: solo se necesita la traducción, no el resto de hooks de get_footer.
if (function_exists('idxboost_cms_translate')) {
    idxboost_cms_translate();
}

wp_footer();
?>
