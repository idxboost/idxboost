<?php
get_header();

while (have_posts()) : the_post();

global $post, $flex_idx_info;

$filter_description = $post->post_content;
$filter_page_ID = $post->ID;
$post_thumbnail_id = get_post_thumbnail_id($filter_page_ID);
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
?>

    <script>
        var IB_SEARCH_FILTER_PAGE = true;
        var IB_SEARCH_FILTER_PAGE_TITLE = '<?php the_title();?>';

        jQuery(function() {
            if (true === IB_SEARCH_FILTER_PAGE) {
                jQuery('#formRegister').append('<input type="hidden" name="source_registration_title" value="'+IB_SEARCH_FILTER_PAGE_TITLE+'">');
                jQuery('#formRegister').append('<input type="hidden" name="source_registration_url" value="'+location.href+'">');
                jQuery("#formRegister_ib_tags").val(IB_SEARCH_FILTER_PAGE_TITLE);
            }
        });
    </script>

    <main id="flex-filters-theme">

        <div class="gwr gwr-breadcrumb">
            <div class="flex-breadcrumb">
                <ol>
                    <li><a href="<?php echo $flex_idx_info["website_url"]; ?>" title="Home"><?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                    <li><?php echo __(the_title(), IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                </ol>
            </div>
        </div>

        <?php if ( !empty($filter_description) || has_post_thumbnail($filter_page_ID)  ){ ?>
      
            <div class="gwr c-flex">
                <?php if (!empty($filter_description) ) { ?>
                <article class="flex-block-description">
                    <h2 class="title-block"><?php echo get_the_title(); ?></h2>
                    <p><?php the_content(); ?></p>
                </article>
                <?php } ?>

                <?php if ( has_post_thumbnail($filter_page_ID) ) { ?>
                <img src="<?php echo $post_thumbnail_url; ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" class="default-img">
                <?php } ?>            
            </div>
    
        <?php } ?>
    
        <?php echo do_shortcode('[flex_idx_filter type="'. $filter_type .'"]'); ?>
    
    </main>

<?php
endwhile;
get_footer();
?>