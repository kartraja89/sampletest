<?php get_header(); ?>
	
<!-- PORTFOLIO AREA -->
	<section>
    	
        	<?php /*?><div style="text-align:center;">
        	<?php get_search_form(); ?>
            </div><?php */?>
            
            <ul style="text-align:center;">
            <li>
            <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/" enctype="multipart/form-data">
            <input type="text" value="<?php the_search_query(); ?>" placeholder="Search here" name="s" id="s" /><i></i>
            <input type="submit" value="submit">
            </form>
            </li>
            </ul>
            
		<hr class="no-margin" />
		
        <?php 
			wp_nav_menu(array(
				'theme_location' => 'category-menu',
				'container' => '',
				'menu_class' => 'inline align-center portfolio-header',
				'menu_id' => 'portfolio-sorting'
			));
		?>
		<!--<ul class="inline align-center portfolio-header" id="portfolio-sorting">
			<li><a href="#" class="btn active">All</a></li>
			<li><a href="#" class="btn">Print</a></li>
			<li><a href="#" class="btn">Websites</a></li>
			<li><a href="#" class="btn">iOS Apps</a></li>
		</ul>-->
		
		<div class="middle-container section-content">
			<div class="container">
            	<?php if (have_posts()) : ?>
				<ul class="row portfolio-entries">
				<?php while(have_posts()) : the_post(); ?>
					
                    <?php 
					$categories = get_the_category();
					
					// If we have any categories, then we'll copy them in an array
					if ($categories) {
						$class_names = array();
						
						foreach ($categories as $category) {
							$class_names[] = 'cat-'.$category->slug;
						}
						
						$classes = join(' ', $class_names);
					}
					?>
                    
					<li class="span4 box portfolio-entry <?php echo $classes; ?>">
						<div class="hover-state align-right">
							<p><?php the_title(); ?></p>
							<em>Click to see project</em>
						</div>
					
						<?php if (has_post_thumbnail()) : ?>
						<figure>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
						</figure>
						<?php endif; ?>
					</li>
				<?php endwhile; ?>
				</ul>
				
				<?php else:  ?>
				<div class="middle-container section-content">
					<div class="container box section-content align-center">
						<h2>No posts were found.</h2>
					</div> <!--end container-->
				</div> <!-- end middle-container -->
				<?php endif; ?>
                
				<?php /*?><ul class="row portfolio-entries">
					<li class="span4 box portfolio-entry">
						<div class="hover-state align-right">
							<p>The title</p>
							<em>Click to see project</em>
						</div> <!-- end hover-state -->
					
						<figure>
							<a href="portfolio-single.html">
								<img src="images/stock/portfolio-thumb-1.jpg" alt="Portfolio entry" />
							</a>
						</figure>
					</li>
				</ul><?php */?>
				
                <?php 
				global $wp_query;
				
				if ($wp_query->max_num_pages > 1) : ?>
				<div class="box align-center portfolio-nav">
					<ul class="inline">
						<li><?php previous_posts_link('&larr; Previous Page', $wp_query->max_num_pages); ?></li>
						<li><?php next_posts_link('Next Page &rarr;', $wp_query->max_num_pages); ?></li>
					</ul>
				</div> <!-- end box -->
				<?php endif; ?>


				
                
                <?php //echo do_shortcode('[dm_registration_form]'); ?>
                
				<!--<div class="box align-center portfolio-nav">
					<ul class="inline">
						<li><a href="#" class="btn">&larr; Previous Page</a></li>
						<li><a href="#" class="btn">Next Page &rarr;</a></li>
					</ul>
				</div>--> <!-- end cta -->
                
                
			</div> <!-- end container -->
		</div> <!-- end middle-container -->
	</section>
		
<?php get_footer(); ?>
