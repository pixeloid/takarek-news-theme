<?php 

$tax_terms = get_terms(array(
	'taxonomy' => 'category',
	'orderby' => 'slug',
	'exclude' => 9
));


$heroes = get_posts(array(
	'numberposts'	=> -1,
	'post_type'		=> 'post',
	'meta_query'	=> array(
		'relation'		=> 'AND',
		array(
			'key'	 	=> 'display_in_hero',
			'compare' 	=> '=',
			'value'	 	=> true,
		),
		array(
			'key'	 	=> 'homepage_hero',
			'compare' 	=> '!=',
			'value'	 	=> '',
		)
	),
));
$features = get_posts(array(
	'numberposts'	=> 5,
	'post_type'		=> 'post',
	'meta_query'	=> array(
		array(
			'key'	 	=> 'is_featured',
			'value'	 	=> true,
			'compare' 	=> '=',
		)
	),
));
?>


<!-- Slider main container -->
<div class="swiper-container">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
		
		<?php foreach ($heroes as $hero):?>
			<div class="swiper-slide">
				<div class="site-hero " style="background:  url(<?php echo get_field('homepage_hero', $hero); ?>) top /cover;">
					<div class="grid-container">
						<div class="site-hero__inner grid-x grid-margin-x align-middle">
							<div class="site-hero-content cell medium-8 large-7" data-swiper-parallax="-300">
							  <h1> <?php echo get_the_title($hero) ?></h1>
							  <?php if (get_field('lead', $hero)): ?>
							  	<p>
							  		<?php echo get_field('lead', $hero) ?>
							  	</p>
							  <?php endif ?>

							  <a href="<?php echo get_the_permalink($hero) ?>" class="button secondary">Tovább </a>
							</div>


						</div>
					</div>
				</div>

			</div>

		<?php endforeach; ?>
	</div>
	<div class="site-hero__pagination">
		<div class="grid-container">
			<div class="swiper-pagination"></div>
		</div>
	</div>
</div>

<div class="submenu-bar">
	
	<div class="grid-container">
		<div class="grid-x grid-margin-x align-middle ">
			<div class="cell auto show-for-xlarge">
				<?php
				if (has_nav_menu('primary_navigation')) :
				  wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'menu horizontal	 cat-menu']);
				endif;
				?>

			</div>
			<div class="cell shrink">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>

</div>

<?php if($features): ?>

	<div class="grid-container">
		<div class="list-group">
			<div class="list-group__title">
	</div>
				 <div class="grid-x grid-margin-x grid-margin-y">
				 	
				 	<?php $i=0; ?>

					 <?php foreach($features as $post):  setup_postdata($post); ?>
					 	<?php $i++; ?>

						<?php include(locate_template( 'templates/card-listitem.php' )); ?>

			  	    <?php endforeach; ?>
			  	</div>
		</div>

	</div>
<?php endif; ?>


<div class="grid-container ">
		

	  	<?php foreach($tax_terms as $term): ?>
			
			<div class="list-group">
				<div class="list-group__title">
					<h2><?php echo $term->name ?> </h2>
					<a href="<?php echo get_term_link($term) ?> " class="button">Összes</a>
				</div>	


					<?php 
					$args = array(
						'posts_per_page' => 5,
						 'category' => $term->term_id,
						'post_type' => 'post',
						'meta_query'	=> array(
							array(
								'key'	 	=> 'is_featured',
								'value'	 	=> true,
								'compare' 	=> '!=',
							)
						),

					 );
					$tax_terms_posts = get_posts( $args );
					 ?>


					 <div class="grid-x grid-margin-x grid-margin-y">
					 	
					 	<?php $i=0; ?>

						 <?php foreach($tax_terms_posts as $post):  setup_postdata($post); ?>
						 	
						 	<?php $i++; ?>

							<?php include(locate_template( 'templates/card-listitem.php' )); ?>

				  	    <?php endforeach; ?>
				  	</div>
			</div>

		<?php endforeach; ?>

		<?php 
		wp_reset_postdata();
		 ?>
	  	





</div>


<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
