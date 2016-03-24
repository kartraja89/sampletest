<?php 
	/* Template Name: Homepage */
?>

<?php get_header(); ?>

<!-- PORTFOLIO AREA -->
	<section>
		<hr class="no-margin" />
		
		<div class="middle-container section-content">
			<div class="container">
				<ul class="row">
					<li class="span4 box">
						<div class="intro-content align-center">
							<h1 class="special-intro">I'm Adi</h1>
						</div> <!-- end intro-content -->
					</li>
					<li class="span4 box">
						<div class="intro-content align-center">
							<h1 class="intro-color-1">I create super awesome stuff</h1>
						</div> <!-- end intro-content -->
					</li>
					<li class="span4 box">
						<div class="intro-content align-center">
							<h1 class="intro-color-2">I’m available for freelance projects</h1>
						</div> <!-- end intro-content -->
					</li>
				</ul>
				
                <?php 
				$args = array(
					'posts_per_page' => 6
				);
				
				$portfolio_items = new WP_Query($args);
				
				if ($portfolio_items->have_posts()) : ?>
                
				<ul class="row portfolio-entries">
                	<?php while ($portfolio_items->have_posts()) : $portfolio_items->the_post(); ?>
					<li class="span4 box portfolio-entry">
						<div class="hover-state align-right">
                        	<p><?php the_title(); ?></p>
                            <p><?php the_date(); ?></p>
							<!--<p>The title</p>-->
							<em>Click to see project</em>
						</div> <!-- end hover-state -->
					
                    	<?php if (has_post_thumbnail()) : ?>
						<figure>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
						</figure>
						<?php endif; ?>
                        <!--<figure>
							<a href="portfolio-single.html">
								<img src="images/stock/portfolio-thumb-1.jpg" alt="Portfolio entry" />
							</a>
						</figure>-->
                    </li>
                    <?php endwhile; ?>
				</ul>
                <?php endif; ?>
				
                <div class="cta align-center">
                	<a href="<?php echo home_url(); ?>/portfolio" class="btn btn-primary">See my full portfolio</a>
                </div>
                
                <!--<div class="cta align-center">
					<a href="portfolio.html" class="btn btn-primary">See my full portfolio</a>
				</div>--> <!-- end cta -->
                
                
                <div align="left">
            	
					<?php
                    $comments_count = wp_count_comments();
                    $num_comments = $comments_count->approved;
					
					if ( comments_open() ) {
						if ( $num_comments == 0 ) {
							$comments = __('No Comments');
						} elseif ( $num_comments > 1 ) {
							$comments = $num_comments . __(' Comments');
						} else {
							$comments = __('1 Comment');
						}
						$write_comments = $comments.'</a>';
					} else {
						$write_comments =  __('Comments are off for this post.');
					}
                    ?>
    				
                    <?php if (have_posts()) : ?>
                    <h3><i></i><?php echo $write_comments; //comments_number('No Comments','1 Comment','% Comments'); ?></h3>
                    <div class="add_comment clearfix">
                       <div class="cmnt_heading clearfix" id="comments">
                            <a href="#cmnt_write">add comment</a>
                       </div>
                       <?php while ( have_posts() ) : the_post(); ?>
                        
                            <?php comments_template(); ?>                 
                        
                       <?php endwhile; ?>   
                    </div>
                    <?php endif; ?>
                </div>
                
                
                <!--Displaying Custom Post and their Datas-->
                
                <div align="center">
                <table width="100%" align="center" cellpadding="2" cellspacing="2">
                <tr>
                <th align="left">Title</th>
                <th align="left">Content</th>
                <th align="left">Excerpt</th>
                <th align="left">Genre(Category)</th>
                <th align="left">Writer(Tags)</th>
                <th align="left">Description<br />(Custom Field)</th>
                </tr>
                <?php
				$args = array( 'post_type' => 'movies', 'posts_per_page' => 10 );
				$loop = new WP_Query( $args );
				if( $loop->have_posts() ) :
					while ( $loop->have_posts() ) : $loop->the_post();
					  ?>
                      <tr>
                      <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td><?php
					  echo '<td>';
					  the_content();
					  echo '</td>';
					  echo '<td>';
					  the_excerpt();
					  echo '</td>';
					  
					  // Let's find out if we have taxonomy information to display
					  // Something to build our output in
					  $genre_text = '';   
					
					  // Variables to store each of our possible taxonomy lists
					  // This one checks for a Product Category classification
					  $cat_list = get_the_term_list( $post->ID, 'genre', '', ', ', '' );
					
					  // Add Product Category list if this post was so tagged
					  if ( '' != $cat_list )
					  $genre_text .= $cat_list;
					  
					  echo '<td>';
					  echo $genre_text; //get_the_terms($post->ID, 'genre');
					  echo '</td>';
					  
					  // Let's find out if we have taxonomy information to display
					  // Something to build our output in
					  $writer_text = '';   
					
					  // Variables to store each of our possible taxonomy lists
					  // This one checks for a Product Category classification
					  $tag_list = get_the_term_list( $post->ID, 'writer', '', ', ', '' );
					
					  // Add Product Category list if this post was so tagged
					  if ( '' != $tag_list )
					  $writer_text .= $tag_list;
					  
					  echo '<td>';
					  echo $writer_text; //get_the_terms($post->ID, 'genre');
					  echo '</td>';
					  
					  echo '<td>';
					  $portfolio_description = esc_html(get_post_meta($post->ID, 'portfolio_description', true));
					  echo $portfolio_description;
					  echo '</td></tr>';
					endwhile;
				endif;
				?>
                <?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
                </table>
                </div>
                
                
				<div align="center">
                <table width="50%" align="center" cellpadding="2" cellspacing="2">
                <tr>
                <?php
				/**** Output a list all registered taxonomies ****/
				$taxonomies = get_taxonomies(); 
				foreach ( $taxonomies as $taxonomy ) {
					echo '<td>' . $taxonomy . '</td>';
				}
				?>
                </tr>
                </table>
                </div>
                
                <div align="center">
                <table width="50%" align="center" cellpadding="2" cellspacing="2">
                <tr>
                <?php
				/**** Output a list of all public custom taxonomies ****/ 
				$args = array(
				  'public'   => true,
				  '_builtin' => false
				); 
				$output = 'names'; // or objects
				$operator = 'and'; // 'and' or 'or'
				$taxonomies = get_taxonomies( $args, $output, $operator ); 
				if ( $taxonomies ) {
				  foreach ( $taxonomies  as $taxonomy ) {
					echo '<td>' . $taxonomy . '</td>';
				  }
				}
				?>
                </tr>
                </table>
                </div>
                
                <div align="center">
                <table width="50%" align="center" cellpadding="2" cellspacing="2">
                <tr>
                <?php
				/**** Output a named taxonomy ****/ 
				$args=array(
				  'name' => 'genre'
				);
				$output = 'objects'; // or names
				$taxonomies=get_taxonomies($args,$output); 
				if  ($taxonomies) {
				  foreach ($taxonomies  as $taxonomy ) {
					echo '<td>' . $taxonomy->name . '</td>';
				  }
				}  
				?>
                </tr>
                </table>
                </div>
                
                <div align="left">
                <?php 
				// no default values. using these as examples
				$taxonomies = array( 
					'writer',
					'genre',
				);
				
				$args = array(
					'orderby'           => 'name', 
					'order'             => 'ASC',
					'hide_empty'        => true, 
					'exclude'           => array(), 
					'exclude_tree'      => array(), 
					'include'           => array(),
					'number'            => '', 
					'fields'            => 'all', 
					'slug'              => '', 
					'parent'            => '',
					'hierarchical'      => true, 
					'child_of'          => 0, 
					'get'               => '', 
					'name__like'        => '',
					'description__like' => '',
					'pad_counts'        => false, 
					'offset'            => '', 
					'search'            => '', 
					'cache_domain'      => 'core'
				); 
				
				$terms = get_terms($taxonomies, $args);
				echo plugins_url();
				echo "<pre>";
				print_r($terms);
				?>


        <?php //echo custom_taxonomies_terms_links(); ?>

        </div>
                
                
			</div> <!-- end container -->
		</div> <!-- end middle-container -->
	</section>

<?php get_footer(); ?>
