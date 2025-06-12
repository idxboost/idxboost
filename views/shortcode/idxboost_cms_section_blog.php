<?php 
$args = array(
    'post_status' => array('publish'),
    'numberposts' => 10,
);

$posts = get_posts($args);

if ($posts) : 
    ?>

    <div class="ip-slider js-slider-blog" id="slider-<?php echo $atts['id']; ?>">

        <?php 
        if ( 
            ( $atts['format'] === "" || $atts['format'] === "ip-format-a") &&
            isset($atts['max_post']) && 
            $atts['max_post']
        ) :
            $length = $atts['max_post'];
            $posts = array_slice($posts, 0, $length);
        endif;

        if ( "ip-format-b" === $atts['format']  ) :
            $posts = array_slice($posts, 0, 5);
        endif;

        if ( "ip-format-c" === $atts['format'] ):
            $posts = array_slice($posts, 0, 4);
        endif;
        
        foreach ($posts as $key => $post) {

            $default_image  = 'https://cpanel.idxboost.com/bundles/cpanel/single-property/images/large-default-image.jpg';
            $image          = get_the_post_thumbnail_url($post) ?: $default_image;
            $excerpt        = get_the_excerpt($post);
            $excerpt        = $excerpt != '' ? $excerpt : mb_strimwidth(wp_trim_excerpt('', $post), 0, 100, '...');
            $excerpt        = str_replace('[&hellip;]', '...', $excerpt);
            ?>
            
            <div class="ip-item">
                <a class="ip-wrap-image" href="<?php echo esc_url( get_permalink($post) ); ?>" draggable="false">
                    <img class="ip-img ms-lazy ibc-js-lazy" alt="<?php echo $post->post_title; ?>" 
                        data-type="image"
                        data-src="<?php echo esc_url( $image ); ?>">
                </a>
                
                <div class="ip-item-content">
                    <?php if ( 'ip-format-b' === $atts['format']  && $key === array_key_first($posts) ) : ?>
                        <div class="ip-item-overlay">
                    <?php endif; ?>
                    
                    <?php if ( $atts['show_date'] ) : ?>
                        <span class="ip-item-date ip-font-light">
                            <time datetime="<?php echo $post->post_date; ?>">
                                <?php echo date("M j, Y", strtotime($post->post_date)); ?>
                            </time>
                        </span>
                    <?php endif; ?>

                    <h3 class="ip-item-title ip-text-left ip-font-semibold">
                        <a href="<?php echo esc_url( get_permalink($post) ); ?>">
                            <?php echo $post->post_title; ?>
                        </a>
                    </h3>
                    
                    <?php if ( $atts['show_excerpt'] ) : ?>
                        <p class="ip-item-text ibc-u-text body-md">
                            <?php echo $excerpt; ?>
                        </p>
                    <?php endif; ?>

                    <a class="ip-item-link" 
                        href="<?php echo esc_url( get_permalink($post) ); ?>">
                        Read more
                    </a>

                    <?php if ( 'ip-format-b' === $atts['format']  && $key === array_key_first($posts) ) : ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php
        }
        ?>

    </div>

    <?php 
else: 
    ?>

    <div class="ip-text-center">
        No blogs found. <a href="<?php echo esc_url( get_site_url() . '/wp-admin/edit.php' ); ?>" rel="nofollow">Click here to start blogging.</a>
    </div>

    <?php 
endif; 
?>
