<?php
get_header();
while (have_posts()) : the_post();
?>

<main id="flex-filters-theme">
    <div class="gwr gwr-breadcrumb">
    <div class="flex-breadcrumb">
        <ol>
        <li><a href="<?php echo $flex_idx_info["website_url"]; ?>" title="Home"><?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
        <li><?php echo __(the_title(), IDXBOOST_DOMAIN_THEME_LANG); ?></li>
        </ol>
    </div>
    </div>

    <?php the_content(); ?>
</main>

<?php
endwhile;
get_footer();
?>
