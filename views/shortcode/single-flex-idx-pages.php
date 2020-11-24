<?php
get_header();
while ( have_posts() ) :
  the_post();
?>

<?php
the_content();
endwhile;
get_footer();
?>
