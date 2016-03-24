<?php get_header(); ?>

<!-- PORTFOLIO AREA -->
	<section>
		<hr class="no-margin" />
		
		<div class="align-center portfolio-header">
			<a href="<?php echo home_url(); ?>/movie" class="btn">&larr; Back to Movies</a>
		</div> <!-- end portfolio-header -->
		
        <div align="center">
			<?php if(have_posts()): while(have_posts()): the_post(); ?>
    
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php
            echo '<div class="entry-content">';
            the_content();
            echo '</div>';
            echo '<div class="entry-content">';
            the_excerpt();
            echo '</div>';
            echo '<div class="entry-content">';
            $portfolio_description = esc_html(get_post_meta($post->ID, 'portfolio_description', true));
            echo $portfolio_description;
            echo '</div>';
			echo '<div class="entry-content">';
            echo the_post_thumbnail();
            echo '</div>';
            ?>
            
            <?php endwhile; endif; ?>
        </div>
        
	</section>
	
<?php get_footer(); ?>


				


