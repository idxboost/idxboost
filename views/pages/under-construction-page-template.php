<?php get_header(); ?>

<style>
	.ip-tripwire {
		display: none;
	}

	.page-deployed {
		justify-content: center;
		min-height: 100vh;
	}

	.page-deployed .wrap-page-deployed .title-page-deployed {
		line-height: 1.125;
	}

	.page-deployed .wrap-page-deployed .info-deployed p {
		margin-left: auto;
		margin-right: auto;
	}

	@media (max-width: 767.98px) {
		.page-deployed .wrap-page-deployed .title-page-deployed {
			font-size: 3rem;
		}

		.page-deployed .wrap-page-deployed .info-deployed p {
			font-size: 18px;
		}
	}

	@media (min-width: 992px) {
		.page-deployed .wrap-page-deployed .title-page-deployed {
			font-size: 4.75rem;
		}

		.page-deployed .wrap-page-deployed .info-deployed p {
			font-size: 1.5rem;
		}
	}
</style>

<main class="page-deployed">

	<div class="wrap-page-deployed align-center-fx">
	  <h1 class="title-page-deployed">Site Under <br> Construction</h1>

	  <div class="info-deployed">
	    <p class="align-center-fx">Coming soon, stay tuned!</p>
	  </div>
	</div>

	<div class="layer-mx"></div>
	
</main>

<?php get_footer(); ?>