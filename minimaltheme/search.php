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
            	
                <?php /*?><?php 
				$args = array(
						'numberposts' => -1,
						'post_type' => 'movies',
						'meta_query' => array(
							'relation' => 'AND',
							array(
								'key' => 'portfolio_description',
								'value' => 'movie5',
								'compare' => '='
							),
						)
					);
				
				// get results
				$the_query = new WP_Query( $args );
				
				// The Loop
				?>
				<?php if( $the_query->have_posts() ): ?>
					<ul>
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</li>
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>
				
				<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?><?php */?>
                
                
				<?php
				//$args = array( 'post_type' => 'post', 's' => get_search_query() );
				//$args = array( 'post_type' => 'post', 's' => sanitize_text_field( $_GET['s'] ), 'meta_key' => 'portfolio_description', 'meta_value' => sanitize_text_field( $_GET['portfolio_description'] ), 'meta_compare' => 'LIKE' );
				/*$args = array( 
							'post_type' => 'post', 
							's' => sanitize_text_field( $_GET['s'] ),
							'meta_query' => array(
												'relation' => 'AND',
												array( 'key' => 'portfolio_description', 'compare' => 'LIKE', 'value' => $_GET['s'] )
											)
							);*/
							
				//$args = array( 'post_type' => 'post', 's' => sanitize_text_field( $_GET['s'] ), 'meta_query' => array('key' => 'portfolio_description', 'type' => 'CHAR', 'value'=> $_GET['s'], 'compare'=> 'LIKE') );
          		
				/*$portfolio_quote = sanitize_text_field( $_GET['portfolio_quote'] );
				
				$args = array(
							'post_type'  => 'post',
							's'          => sanitize_text_field( $_GET['s'] ),
							'meta_query' => array(
												'relation' => 'OR',
													array(
														'key'     => 'portfolio_quote',
														'value'   => $portfolio_quote ,
														'compare' => 'LIKE'
														 )
												)
							);*/
				
				/*$q = new WP_Query(
								array(
									'fields' => 'ids',
									'ignore_sticky_posts' => true,
									'meta_query' => array(
										'relation' => 'OR',
										array(
											'key' => 'portfolio_quote',
											'value' => array( 'post1 quote' ),
											'compare' => 'IN'
										),
										array(
											'key' => 'bar',
											'value' => array( 'foobar2' ),
											'compare' => 'IN'
										)
									)
								) );
				print_r( $q->posts );*/
				
				
				/****** Different Search for Custom Post *******/
				
				/*$args1 = array( 
							'post_type'  => 'movies', 
							's'          => sanitize_text_field( $_GET['s'] ),
							'meta_key'   => 'color',
							'meta_value' => array('blue','white') 
							 );*/
							 
				/*$args1 = array(
							'post_type'  => 'movies',
							'meta_query' => array(
												'relation' => 'OR',
												array(
													'key'     => 'color',
													'value'   => 'blue',
													'compare' => 'NOT LIKE',
												),
												array(
													'key'     => 'price',
													'value'   => array( 10, 45 ),
													'type'    => 'numeric',
													'compare' => 'BETWEEN',
												)
												),
							);*/
				
				/*$args1 = array(
							'post_type'  => 'movies',
							'meta_key'   => 'price',
							'orderby'    => 'meta_value_num',
							'order'      => 'DESC',
							'meta_query' => array(
												array(
													'key'     => 'price',
													'value'   => sanitize_text_field( $_GET['s'] ), //array( 10, 45 ),
													'type'    => 'numeric',
													'compare' => '>'
												)
												),
							);*/
							
				/*$args1 = array(
							'post_type'  => 'movies',
							'meta_key'   => 'price',
							'orderby'    => 'meta_value_num',
							'order'      => 'DESC',
							'meta_query' => array(
												array(
													'key'     => 'color',
													'value'   => sanitize_text_field( $_GET['s'] ), //'blue',
													'compare' => 'LIKE',
												),
												'relation' => 'AND',
												array(
													'key'     => 'price',
													'value'   => array( 10, 40 ),
													'type'    => 'numeric',
													'compare' => 'BETWEEN',
												)
												),
						    );*/
							?>
				
                <?php /*?><?php
							 
				$wp_query = new WP_Query( $args1 );
				
				if ( $_GET['s']!='' && $wp_query->have_posts() ) : ?>
                
                <?php if( $_GET['s']!='' ) { ?>
				<div class="heading clearfix">
                  <h4><?php printf( __( 'Search Results for: %s', 'minimaltheme' ), '<span>' . sanitize_text_field( $_GET['s'] ) . '</span>' ); ?></h4>
                </div>
                <?php } ?>
            	
				<ul class="row portfolio-entries">
				<?php
				while( $wp_query->have_posts()) : $wp_query->the_post(); ?>
				<li>
                    <div>
                        <p><?php the_title(); ?>, Color => <?php echo esc_html(get_post_meta($post->ID, 'color', true)); ?>, Price => <?php echo esc_html(get_post_meta($post->ID, 'price', true)); ?></p>
                    </div>
                </li>
				<?php endwhile; ?>
				</ul>
				
                <?php wp_reset_postdata(); ?>
                
                <?php else:  ?>
                
                <?php if( $_GET['s']!='' ) { ?>
				<div class="heading clearfix">
                  <h4><?php printf( __( 'Search Results for: %s', 'minimaltheme' ), '<span>' . get_search_query() . '</span>' ); ?></h4>
                </div>
                <?php } ?>
                
                <div class="middle-container section-content">
					<div class="container box section-content align-center">
						<h2>No posts were found.</h2>
					</div> <!--end container-->
				</div> <!-- end middle-container -->
				<?php endif; ?><?php */?>
                
                         
                <?php 
				/****** Search with Default Post *******/ ?>
                <?php
				/*$args = array( 
							'post_type' => 'post', 
							's'         => sanitize_text_field( $_GET['s'] ),
							);*/
				?>
                
                <?php 
				/****** Search Custom fields in Normal Post *******/ ?>
                <?php       
				$args = array( 
							'post_type' => 'post', 
							//'s'         => sanitize_text_field( $_GET['s'] ),
							'meta_query' => array(
												'relation' => 'OR',
												array(
													'key'     => 'portfolio_quote',
													'value'   => sanitize_text_field( $_GET['s'] ), //'blue',
													'compare' => 'LIKE'
													 ),
												array(
													'key'     => 'portfolio_quote_author',
													'value'   => sanitize_text_field( $_GET['s'] ), //'blue',
													'compare' => 'LIKE'
													 )
												)
							);
							 
				$wp_query = new WP_Query( $args ); //new WP_Query($args);
				
				if ( $_GET['s']!='' && $wp_query->have_posts() ) : ?>
                
                <?php if( $_GET['s']!='' ) { ?>
				<div class="heading clearfix">
				  <?php /**** If Normal Search we use this line ****/ /*?><h4><?php printf( __( 'Search Results for: %s', 'minimaltheme' ), '<span>' . get_search_query() . '</span>' ); ?></h4><?php */?>
                  <h4><?php printf( __( 'Search Results for: %s', 'minimaltheme' ), '<span>' . sanitize_text_field( $_GET['s'] ) . '</span>' ); ?></h4>
                </div>
                <?php } ?>
            	
				<ul class="row portfolio-entries">
				<?php
				while( $wp_query->have_posts()) : $wp_query->the_post(); ?>
					
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
							<p><?php the_title(); ?>=><?php the_ID(); ?></p>
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
				
                <?php wp_reset_postdata(); ?>
                
				<?php else:  ?>
                
                <?php if( $_GET['s']!='' ) { ?>
				<div class="heading clearfix">
                  <?php /**** If Normal Search we use this line ****/ /*?><h4><?php printf( __( 'Search Results for: %s', 'minimaltheme' ), '<span>' . get_search_query() . '</span>' ); ?></h4><?php */?>
                  <h4><?php printf( __( 'Search Results for: %s', 'minimaltheme' ), '<span>' . sanitize_text_field( $_GET['s'] ) . '</span>' ); ?></h4>
                </div>
                <?php } ?>
                	
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
