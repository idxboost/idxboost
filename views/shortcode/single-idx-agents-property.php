<?php
get_header('idx-agents');
while (have_posts()) : the_post();
?>

    <main id="flex-filters-theme">
        <?php /*
        <div class="gwr gwr-breadcrumb">
            <div class="flex-breadcrumb">
                <ol>
                    // <?php <li><a href="<?php echo $flex_idx_info["website_url"]; ?>" title="Home"><?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li> ?>
                    <li><a href="<?php echo get_permalink(get_the_ID()); ?>" title="Home"><?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                    <li><?php echo __(the_title(), IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                </ol>
            </div>
        </div> */ ?>

        <?php echo do_shortcode('[flex_idx_property_detail]'); ?>
    </main>

<?php
endwhile;
get_footer('idx-agents');
?>