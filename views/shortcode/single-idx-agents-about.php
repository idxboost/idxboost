<?php
get_header('idx-agent'); 
 while ( have_posts() ) : the_post();
?>

    <main id="flex-blog-detail-theme">
      <div class="gwr gwr-breadcrumb">
        <nav class="flex-breadcrumb" aria-label="breadcrumb">
          <ol>
            <li><a href="<?php echo site_url(); ?>" title="Home">Home</a></li>
            <li aria-current="page"><?php echo get_the_title(); ?></li>
          </ol>
        </nav>
      </div>
      <div class="gwr c-flex">
        <article class="flex-block-description">
          <div class="flex-blog-header">
            <h1 class="flex-page-title"><?php echo get_the_title(); ?> (About Page)</h1>
            <span class="date-publish"><?php echo get_the_date(); ?></span>
            <!--
            <div class="flex-block-share mini">
              <span class="title-share">Share this article</span>
                <div class="social-networks">
             
                  <ul class="item-header social-networks">
                    <?php if (!empty( get_theme_mod('idx_social_media' )['facebook'] )): ?>
                    <li class="clidxboost-icon-facebook"><a href="<?php echo get_theme_mod('idx_social_media' )['facebook']; ?>" title="Facebook" target="_blank" rel="nofollow">Facebook</a></li>
                    <?php endif; ?>
                    <?php if (!empty(get_theme_mod('idx_social_media' )['twitter']  )): ?>
                    <li class="clidxboost-icon-twitter"><a href="<?php echo get_theme_mod('idx_social_media' )['twitter']; ?>" title="Twitter" target="_blank" rel="nofollow">Twitter</a></li>
                    <?php endif; ?>
                    <?php if (!empty( get_theme_mod('idx_social_media' )['google'] )): ?>
                    <li class="clidxboost-icon-google-plus"><a href="<?php echo get_theme_mod('idx_social_media' )['google']; ?>" title="Google+" target="_blank" rel="nofollow">Google+</a></li>
                    <?php endif; ?>
                    <?php if (!empty( get_theme_mod('idx_social_media' )['instagram'] )): ?>
                    <li class="clidxboost-icon-instagram"><a href="<?php echo get_theme_mod('idx_social_media' )['instagram']; ?>" title="Instagram" target="_blank" rel="nofollow">Instagram</a></li>
                    <?php endif; ?>
                    <?php if (!empty( get_theme_mod('idx_social_media' )['linkedin'] )): ?>
                    <li class="clidxboost-icon-linkedin"><a href="<?php echo get_theme_mod('idx_social_media' )['linkedin']; ?>" title="Linked In" target="_blank" rel="nofollow">Linked In</a></li>
                    <?php endif; ?>

                    <?php if (!empty( get_theme_mod('idx_social_media' )['youtube'] )): ?>
                    <li class="clidxboost-icon-youtube"><a href="<?php echo get_theme_mod('idx_social_media' )['youtube']; ?>" title="Youtube" target="_blank" rel="nofollow">YouTube</a></li>
                    <?php endif; ?>

                  </ul>  
                </div>
            </div>
            -->
          </div>
          <?php the_content(); ?>

          <div class="flex-block-share standar">
            <!--
            <span class="title-share">Share this article</span>
            <div class="social-networks">

            <ul class="item-header social-networks">
              <?php if (!empty( get_theme_mod('idx_social_media' )['facebook'] )): ?>
              <li class="clidxboost-icon-facebook"><a href="<?php echo get_theme_mod('idx_social_media' )['facebook']; ?>" title="Facebook" target="_blank" rel="nofollow">Facebook</a></li>
              <?php endif; ?>
              <?php if (!empty(get_theme_mod('idx_social_media' )['twitter']  )): ?>
              <li class="clidxboost-icon-twitter"><a href="<?php echo get_theme_mod('idx_social_media' )['twitter']; ?>" title="Twitter" target="_blank" rel="nofollow">Twitter</a></li>
              <?php endif; ?>
              <?php if (!empty( get_theme_mod('idx_social_media' )['google'] )): ?>
              <li class="clidxboost-icon-google-plus"><a href="<?php echo get_theme_mod('idx_social_media' )['google']; ?>" title="Google+" target="_blank" rel="nofollow">Google+</a></li>
              <?php endif; ?>
              <?php if (!empty( get_theme_mod('idx_social_media' )['instagram'] )): ?>
              <li class="clidxboost-icon-instagram"><a href="<?php echo get_theme_mod('idx_social_media' )['instagram']; ?>" title="Instagram" target="_blank" rel="nofollow">Instagram</a></li>
              <?php endif; ?>
              <?php if (!empty( get_theme_mod('idx_social_media' )['linkedin'] )): ?>
              <li class="clidxboost-icon-linkedin"><a href="<?php echo get_theme_mod('idx_social_media' )['linkedin']; ?>" title="Linked In" target="_blank" rel="nofollow">Linked In</a></li>
              <?php endif; ?>

              <?php if (!empty( get_theme_mod('idx_social_media' )['youtube'] )): ?>
              <li class="clidxboost-icon-youtube"><a href="<?php echo get_theme_mod('idx_social_media' )['youtube']; ?>" title="Youtube" target="_blank" rel="nofollow">YouTube</a></li>
              <?php endif; ?>
            </ul>  

            </div>
            -->
            <!-- <a class="clidxboost-btn-link" href="<?php echo get_site_url(); ?>/blog"><span>Back to Blog</span></a> -->
          </div>
          
        </article>
      </div>
    </main>

<?php endwhile; get_footer(); ?>
