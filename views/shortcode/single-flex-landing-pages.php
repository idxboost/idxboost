<?php
get_header();
while (have_posts()) : the_post();

    global $flex_idx_info;
    $idx_v = ( array_key_exists("idx_v", $flex_idx_info["agent"] ) && !empty($flex_idx_info["agent"]["idx_v"]) ) ? $flex_idx_info["agent"]["idx_v"] : '0';
?>

<main id="flex-filters-theme">

      <?php if (
        ( $idx_v != "1" ) ||
            (
                $idx_v == "1" && !array_key_exists("idx_page_map_search_filter", $GLOBALS)
            )
        ) { ?>
        
        <div class="gwr gwr-breadcrumb">
          <div class="flex-breadcrumb">
            <ol>
              <li><a href="<?php echo $flex_idx_info["website_url"]; ?>" title="<?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
              <li><?php echo __(the_title(), IDXBOOST_DOMAIN_THEME_LANG); ?></li>
            </ol>
          </div>
        </div>

      <?php } ?>          

    <?php the_content(); ?>
</main>

<?php
endwhile;
get_footer();
?>
