<?php
/**
 * Template Name: Page IDX Video Steps
 * Theme: boostidx
 */ 
get_header();
while ( have_posts() ) : the_post();?>
<link rel="stylesheet" href="<?php echo $assests_dir; ?>css/pages/video_steps/index.css">
<main id="videoSteps">
  <section class="ms-section ms-animate" id="welcome">
    <div class="ms-wrapper-section">
      <div class="ms-wrapper-info ms-video-list form-activation">
        <h1 class="ms-title" title="Dominate Your Real Estate Market">Dominate Your <br><span class="-text-red">Real Estate Market</span></h1>
        <div id="playerVideo" class="ms-wrapper-video js-active-video-ab" data-video="https://www.youtube.com/embed/snMXaCC8yK0?autoplay=1&loop=0&rel=0&showinfo=0">
          <?php the_post_thumbnail(); ?>
        </div>
        <!--esto es para los botones de next y prev-->
        <?php the_content(); ?>
        <div class="ms-wrapper-btn">
          <button class="ms-btn -idx -line -xl js-show-calendar-sm" aria-label="Schedule a Call">
            <span>Schedule a Call</span>
          </button>
        </div>
      </div>
    </div>
  </section>
  <?php //get_template_part('blocks/new_testimonials'); ?>

  <section class="ms-section ms-animate ms-animate-section ms-standar-section" id="section01">
    <div class="ms-wrapper-section">
      <div class="ms-flex -reverse">
        <div class="ms-item">
          <article class="ms-article">
            <h2 class="ms-title">Niche Market</h2>
            <p>A niche market is a portion of the market where you offer your services. It has its own needs, demographics, and price range.</p>
          </article>
        </div>
        <div class="ms-item">
          <div class="ms-wrapper-img">
            <picture data-real-type="webp" data-img="<?php echo $assests_dir; ?>images/playbook/01" data-view="" data-format=".png" class="ms-image">
              <source type="image/webp" srcset="<?php echo $assests_dir; ?>images/same/temp.webp">
              <img src="<?php echo $assests_dir; ?>images/same/temp.png" width="1" height="1" alt="Upload & Publish Your Listings">
            </picture>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ms-section ms-animate ms-animate-section ms-standar-section" id="section02">
    <div class="ms-wrapper-section">
      <div class="ms-flex">
        <div class="ms-item">
          <article class="ms-article">
            <h2 class="ms-title">Infrastructure</h2>
            <p>Your infrastructure is formed by all your digital platforms and the communication between them.</p>
            <ul class="ms-bullet-list -standar -red">
              <li>Helps you close down on the highest potential opportunities within your farming markets.</li>
              <li>Gain clarity on where to best invest your budget and time in a tactical way to dominate your market.</li>
            </ul>
          </article>
        </div>
        <div class="ms-item">
          <div class="ms-wrapper-img">
            <picture data-real-type="webp" data-img="<?php echo $assests_dir; ?>images/playbook/02" data-view="" data-format=".png" class="ms-image">
              <source type="image/webp" srcset="<?php echo $assests_dir; ?>images/same/temp.webp">
              <img src="<?php echo $assests_dir; ?>images/same/temp.png" width="1" height="1" alt="Infrastructure">
            </picture>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ms-section ms-animate ms-animate-section ms-standar-section" id="section03">
    <div class="ms-wrapper-section">
      <div class="ms-flex -reverse">
        <div class="ms-item">
          <article class="ms-article">
            <h2 class="ms-title">Lead Flow</h2>
            <p>A lead flow is a steady flow of people that visit your online real estate website, having several touch-points with your brand before they become clients.</p>
            <ul class="ms-bullet-list -standar -red">
              <li>Solid technologies to support the growth of you real estate brand.</li>
              <li>Social Media, Search Engine and Media Outlets working in synergy with your marketing platform, to improve your customer's journey and create new revenue streams</li>
            </ul>
          </article>
        </div>
        <div class="ms-item">
          <div class="ms-wrapper-img">
            <picture data-real-type="webp" data-img="<?php echo $assests_dir; ?>images/playbook/03" data-view="" data-format=".png" class="ms-image">
              <source type="image/webp" srcset="<?php echo $assests_dir; ?>images/same/temp.webp">
              <img src="<?php echo $assests_dir; ?>images/same/temp.png" width="1" height="1" alt="Lead Flow">
            </picture>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ms-section ms-animate ms-animate-section ms-standar-section" id="section05">
    <div class="ms-wrapper-section">
      <div class="ms-flex">
        <div class="ms-item">
          <article class="ms-article">
            <h2 class="ms-title">User Experience</h2>
            <p>The user experience is how your online visitors interact with and experience your website.</p>
            <ul class="ms-bullet-list -standar -red">
              <li>Boost engagement and conversions, using a unique set of tools that let users easily find what they’re looking for.</li>
              <li>Let your visitors understand the value of your services by communicating in a clear and concise way, using videos and exclusive pictures.</li>
            </ul>
          </article>
        </div>
        <div class="ms-item">
          <div class="ms-wrapper-img">
            <picture data-real-type="webp" data-img="<?php echo $assests_dir; ?>images/playbook/05" data-view="" data-format=".png" class="ms-image">
              <source type="image/webp" srcset="<?php echo $assests_dir; ?>images/same/temp.webp">
              <img src="<?php echo $assests_dir; ?>images/same/temp.png" width="1" height="1" alt="User Experience">
            </picture>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ms-section ms-animate ms-animate-section ms-standar-section" id="section06">
    <div class="ms-wrapper-section">
      <div class="ms-flex -reverse">
        <div class="ms-item">
          <article class="ms-article">
            <h2 class="ms-title">Conversion Strategy</h2>
            <p>The Conversion Strategy is a digital marketing strategy that focuses on increasing the percentage of website visitors that hire your real estate services.</p>
            <ul class="ms-bullet-list -standar -red">
              <li>Maximizes your traffic conversions while positioning your brand at the forefront.</li>
              <li>Increases your sales and accelerates revenue.</li>
            </ul>
          </article>
        </div>
        <div class="ms-item">
          <div class="ms-wrapper-img">
            <picture data-real-type="webp" data-img="<?php echo $assests_dir; ?>images/playbook/06" data-view="" data-format=".png" class="ms-image">
              <source type="image/webp" srcset="<?php echo $assests_dir; ?>images/same/temp.webp">
              <img src="<?php echo $assests_dir; ?>images/same/temp.png" width="1" height="1" alt="Conversion Strategy">
            </picture>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ms-section ms-animate ms-animate-section ms-standar-section" id="section07">
    <div class="ms-wrapper-section">
      <div class="ms-flex">
        <div class="ms-item">
          <article class="ms-article">
            <h2 class="ms-title">Return & Nurture</h2>
            <p>Lead nurturing is the process of building lasting relationships with your clients by connecting with them at every stage of their journey, throughout their individual buying and selling cycles.</p>
            <ul class="ms-bullet-list -standar -red">
              <li>Makes your online visitors come back to your website, through valuable information like smart property alerts.</li>
              <li>Makes your brand more accessible, since most visitors won’t remember your exact domain name after just one visit.</li>
              <li>It accelerates your brand’s trust and authority, by automating several brand touchpoints.</li>
              <li>Lets you work smarter by automating time consuming tasks.</li>
            </ul>
          </article>
        </div>
        <div class="ms-item">
          <div class="ms-wrapper-img">
            <picture data-real-type="webp" data-img="<?php echo $assests_dir; ?>images/playbook/07" data-view="" data-format=".png" class="ms-image">
              <source type="image/webp" srcset="<?php echo $assests_dir; ?>images/same/temp.webp">
              <img src="<?php echo $assests_dir; ?>images/same/temp.png" width="1" height="1" alt="Return & Nurture">
            </picture>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ms-section ms-animate ms-animate-section ms-standar-section" id="section08">
    <div class="ms-wrapper-section">
      <div class="ms-flex -reverse">
        <div class="ms-item">
          <article class="ms-article">
            <h2 class="ms-title">Brand Authority</h2>
            <p>Brand authority refers to how likely clients are to view your real estate business as a trustworthy company or an expert opinion in its field.</p>
            <ul class="ms-bullet-list -standar -red">
              <li>Be recognized as the loyal and trustworthy real estate professional you are.</li>
              <li>Locally establish the cycle of buyers and sellers and achieve market domination.</li>
              <li>Generate new revenue streams and scale your business.</li>
            </ul>
          </article>
        </div>
        <div class="ms-item">
          <div class="ms-wrapper-img">
            <picture data-real-type="webp" data-img="<?php echo $assests_dir; ?>images/playbook/08" data-view="" data-format=".png" class="ms-image">
              <source type="image/webp" srcset="<?php echo $assests_dir; ?>images/same/temp.webp">
              <img src="<?php echo $assests_dir; ?>images/same/temp.png" width="1" height="1" alt="Brand Authority">
            </picture>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ms-section ms-animate ms-animate-section ms-standar-section" id="section09">
    <div class="ms-wrapper-section">
      <div class="ms-flex">
        <div class="ms-item">
          <article class="ms-article">
            <h2 class="ms-title">Connect & Follow Up</h2>
            <p>Following up with potential clients from cold to closed is one of the most essential things you must do as a successful real estate agent.</p>
            <ul class="ms-bullet-list -standar -red">
              <li>Increase your chances of being recommended. Most buyers and sellers use an agent they previously worked with or a referral from a friend or family member.</li>
              <li>Establish your reputation as being diligent and dedicated. You want prospective clients to know you can handle their next real estate transaction.</li>
              <li>Boost conversion and increase sales.</li>
            </ul>
          </article>
        </div>
        <div class="ms-item">
          <div class="ms-wrapper-img">
            <picture data-real-type="webp" data-img="<?php echo $assests_dir; ?>images/playbook/09" data-view="" data-format=".png" class="ms-image">
              <source type="image/webp" srcset="<?php echo $assests_dir; ?>images/same/temp.webp">
              <img src="<?php echo $assests_dir; ?>images/same/temp.png" width="1" height="1" alt="Connect & Follow Up">
            </picture>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php endwhile; get_footer(); ?>
<script>
  jQuery(".ms-wrapper-tripwire").remove();
  jQuery("#showTripwire").remove();

  jQuery(document).on('click', '.js-active-video-ab', function(event){
    event.preventDefault();
    jQuery("#playerVideo").addClass("active");
    jQuery("#playerVideo").removeClass("msCursorVideo js-active-video-ab");
    jQuery("#playerVideo").empty().html('<iframe class="_iframe" data-type="vimeo" id="aboutVideoActive" allow="autoplay; encrypted-media" src="'+jQuery(this).attr("data-video")+'" frameborder="0" allowfullscreen></iframe>') 
  });

  jQuery(document).on('click', '.js-show-calendar-sm', function(){
    showModal("#modalVideoTestimonials");
    jQuery("#modalVideoTestimonials").addClass("ms-show-calendar");
    jQuery("#calendarResult").html('<div class="calendly-inline-widget" style="min-width: 320px; height: 630px;" data-url="https://calendly.com/idxboost-sales-events/schedule-a-call"></div>');
    if(!jQuery("#calendarResult").hasClass("active")){
      var s = document.createElement("script");
      s.type = "text/javascript";
      s.src = "https://assets.calendly.com/assets/external/widget.js";
      jQuery("#calendarResult").append(s);
    }
    setTimeout(function(){
      jQuery("#calendarResult").addClass("active");
      jQuery("#videoResultTestimonials").empty();
    }, 900);
  });

/*
  let cookieFormRegister = window.localStorage.getItem('cookieFormRegister');

  if (!cookieFormRegister) {
    jQuery(location).prop("href","https://www.idxboost.com/");
  }*/
</script>