<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>
<main class="page-deployed">
	<div class="wrap-page-deployed align-center-fx">
	  <h1 class="title-page-deployed">Oops!</h1>
	  <div class="info-deployed">
	    <p class="align-center-fx">We’re sorry, but the property (MLS #: <?php echo $mls_num; ?> | <?php echo $address_slug; ?> ) you are looking for appears to have been removed or is currently unavailable for download from our system. We encourage you to initiate a new search.</p>
	    <!--<span>Here are some helpful links instead:</span>-->
	  </div>
	  <a href="/" class="clidxboost-btn-link"><span>Go to Home page</span></a>
	  <!--
	  <ul class="list-deployed">
	    <li><a href="">Home</a></li>
	    <li><a href="">Advance Search</a></li>
	    <li><a href="">Neighborhoods</a></li>
	    <li><a href="">Condo Buildings</a></li>
	  </ul>
	-->
	</div>
	<div class="layer-mx"></div>
</main>
<?php get_footer(); ?>
