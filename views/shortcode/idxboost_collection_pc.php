<div class="op-neighborhood-list">
<ul class="clidxboost-neighborhood-lt clidxboost-cl-4">
<?php
$args = array('post_type' => 'flex-filter-pages','posts_per_page'   => -1,'no_found_rows'    => true,'suppress_filters' => false,'order'=> 'ASC', 'orderby' => 'title');
$query = new WP_Query( $args );
while ($query->have_posts()): $query->the_post();
$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
if (empty($post_thumbnail_url)) {
	$post_thumbnail_url='//idxboost.com/i/default_thumbnail.jpg';
}
?>
	<li>
<div class="clidxboost-content-areasearch">
<div class="clidxboost-content-figure">
	<a href="<?php echo get_the_permalink(); ?>"><img class="clidxboost-img-areasearch" src="<?php echo $post_thumbnail_url; ?>" alt="<?php echo get_the_title();?>" /></a>
	<h2><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?> </a></h2>
</div>
</div>
</li>
<?php endwhile; ?>


</ul>
</div>