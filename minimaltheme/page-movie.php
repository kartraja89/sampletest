<?php 
	/* Template Name: Moviepage */
?>

<?php get_header(); ?>

<!-- PORTFOLIO AREA -->
	<section>
		<hr class="no-margin" />
		
		<div class="middle-container section-content">
			<div class="container">
				
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
                    <th align="left">Date</th>
                    <th align="left">Image</th>
                    <th align="left">Author</th>
                    <th align="center">Edit</th>
                    <th align="center">Delete</td>
                    </tr>
                    <?php
                    
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    
                    $args = array( 'post_type'        => 'movies', 
                                   'posts_per_page'   => 4, 
                                   'order'            => 'ASC',
								   'caller_get_posts' => 1,
                                   'paged'            => $paged );
                                   
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
						
						$genre_term_names = '';
						//For custom taxonomy use this line below
						$genre_terms = wp_get_object_terms( $post->ID, 'genre' );
						
						foreach( $genre_terms as $genre_term )
						{
							$genre_term_names[] = $genre_term->name;
						}
						$genre_termnames = implode( ', ', $genre_term_names );
						
						// Let's find out if we have taxonomy information to display
						// Something to build our output in
						$genre_text = '';   
						
						// Variables to store each of our possible taxonomy lists
						// This one checks for a Product Category classification
						$cat_list = get_the_term_list( $post->ID, 'genre', '', ', ', '' );
						
						// Add Product Category list if this post was so tagged
						if ( '' != $cat_list )
						{
							$genre_text .= $cat_list;
						}
						
						echo '<td>';
						echo $genre_text.'=>'.$genre_termnames; //get_the_terms($post->ID, 'genre');
						echo '</td>';
						
						// Let's find out if we have taxonomy information to display
						// Something to build our output in
						$writer_text = '';   
						
						// Variables to store each of our possible taxonomy lists
						// This one checks for a Product Category classification
						$tag_list = get_the_term_list( $post->ID, 'writer', '', ', ', '' );
						
						// Add Product Category list if this post was so tagged
						if ( '' != $tag_list )
						{
							$writer_text .= $tag_list;
						}
						
						$post_id = get_the_ID();
						$edit_post = add_query_arg( 'movies', get_the_ID(), get_permalink( 61 + $_POST['_wp_http_referer'] ) );
						
						echo '<td>';
						echo $writer_text; //get_the_terms($post->ID, 'genre');
						echo '</td>';
						
						echo '<td>';
						$portfolio_description = esc_html(get_post_meta($post->ID, 'portfolio_description', true));
						echo $portfolio_description;
						echo '</td>';
						
						echo '<td>';
						the_time('d-m-Y H:i:s A'); //Use the_time('F j, Y'); (OR) echo get_the_date();
						echo '</td>';
						
						echo '<td>';
						add_image_size('new-thumbnail-size',100,100, true);
						echo the_post_thumbnail('new-thumbnail-size');
						echo '</td>';
						
						echo '<td>';
						$movie_author = esc_html(get_post_meta($post->ID, 'movie_author', true));
						echo $movie_author;
						echo '</td>';
						
						echo '<td><a href="'.$post_id.'">Edit</a></td>';
						echo '<td><a href="#">Delete</a></td>';
						
						echo '</tr>';
						  
                        endwhile;
                        
                        //if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
                        
                    endif;
                    
                    ?>
                    </table>
                    
                
                    <div class="navigation">
                      <div align="left"><?php previous_posts_link('&laquo; Previous', $loop->max_num_pages) ?></div>
                      <div align="right"><?php next_posts_link('Next &raquo;', $loop->max_num_pages) ?></div>
                    </div>
                
                </div>
                
                <?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
                
                <br />
                
                
                <div align="left">
                    <table width="100%" align="center" cellpadding="2" cellspacing="2">
                    <tr>
                    <th align="left">Term_id</th>
                    <th align="left">Name</th>
                    <th align="left">Slug</th>
                    <th align="left">Taxonomy</th>
                    <th align="left">Description</th>
                    <th align="left">Count</th>
                    </tr>
                    <?php
                    
                    // no default values. using these as examples
                    $taxonomies = array( 
                        'writer',
                        'genre',
                    );
                    
                    $args = array(
                        'orderby'           => 'count', //'name', 
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
                    //echo plugins_url();
                    /*echo "<pre>";
                    print_r($terms);*/
                    
                    foreach($terms as $term)
                    {
                        echo "<tr>";
                        echo "<td>".$term->term_id."</td>";
                        echo "<td>".$term->name."</td>";
                        echo "<td>".$term->slug."</td>";
                        echo "<td>".$term->taxonomy."</td>";
                        echo "<td>".$term->description."</td>";
                        echo "<td>".$term->count."</td>";
                        echo "</tr>";	
                    }
                    ?>
                    
                    </table>
                    
                </div>
                
                
                <br />
                
                <div align="center">
                    <table width="100%" align="center" cellpadding="2" cellspacing="2">
                    <tr>
                    <th align="left">Title</th>
                    <th align="left">Content</th>
                    <th align="left">Excerpt</th>
                    <th align="left">Genre(Category)</th>
                    <th align="left">Writer(Tags)</th>
                    <th align="left">Description<br />(Custom Field)</th>
                    <th align="left">Date</th>
                    </tr>
                    <?php
                    /**** List the custom post by taxonomy (By Category) ****/
					$args=array(
							'post_type'      => 'movies',
							'taxonomy'       => 'genre',
							'term'           => 'masala', //$term->slug,
							'post_status'    => 'publish',
							'posts_per_page' => -1
							);
							
					$new = null;
                    $new = new WP_Query( $args );
					
                    if( $new->have_posts() ) :
                        while ( $new->have_posts() ) : $new->the_post();
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
						  {
                          	$genre_text .= $cat_list;
						  }
                          
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
						  {
                          	$writer_text .= $tag_list;
						  }
						  
                          echo '<td>';
                          echo $writer_text; //get_the_terms($post->ID, 'genre');
                          echo '</td>';
                          
                          echo '<td>';
                          $portfolio_description = esc_html(get_post_meta($post->ID, 'portfolio_description', true));
                          echo $portfolio_description;
                          echo '</td>';
						  
						  echo '<td>';
						  the_time('d-m-Y H:i:s A'); //Use the_time('F j, Y'); (OR) echo get_the_date();
						  echo '</td></tr>';
						  
                        endwhile;
                        
                        //if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
                        
                    endif;
                    
                    ?>
                    </table>
                
                </div>
                
                <?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
                
                <br />
                
                
                
                <div align="center">
                    <table width="100%" align="center" cellpadding="2" cellspacing="2">
                    <tr>
                    <th align="left">Title</th>
                    <th align="left">Content</th>
                    <th align="left">Excerpt</th>
                    <th align="left">Genre(Category)</th>
                    <th align="left">Writer(Tags)</th>
                    <th align="left">Description<br />(Custom Field)</th>
                    <th align="left">Date</th>
                    </tr>
                    <?php
                    /**** List the custom post by taxonomy (By Tag) ****/
					$args=array(
							'post_type'      => 'movies',
							'taxonomy'       => 'writer',
							'term'           => 'manirath', //$term->slug,
							'post_status'    => 'publish',
							'posts_per_page' => -1
							);
							
					$new = null;
                    $new = new WP_Query( $args );
					
                    if( $new->have_posts() ) :
                        while ( $new->have_posts() ) : $new->the_post();
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
						  {
                          	$genre_text .= $cat_list;
						  }
                          
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
						  {
                          	$writer_text .= $tag_list;
						  }
						  
                          echo '<td>';
                          echo $writer_text; //get_the_terms($post->ID, 'genre');
                          echo '</td>';
                          
                          echo '<td>';
                          $portfolio_description = esc_html(get_post_meta($post->ID, 'portfolio_description', true));
                          echo $portfolio_description;
                          echo '</td>';
						  
						  echo '<td>';
						  the_time('d-m-Y H:i:s A'); //Use the_time('F j, Y'); (OR) echo get_the_date();
						  echo '</td></tr>';
						  
                        endwhile;
                        
                        //if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
                        
                    endif;
                    
                    ?>
                    </table>
                
                </div>
                
                <?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
                
                <br />
                
                
                
			</div> <!-- end container -->
		</div> <!-- end middle-container -->
	</section>
    
    
    

<?php if ( have_posts() ) : ?>
                 
                <h1 class="page-title"><?php _e( 'Search Results for: ', 'your-theme' ); ?><span><?php the_search_query(); ?></span></h1>
                 
<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
                <div id="nav-above" class="navigation">
                    <div class="nav-previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'your-theme' )) ?></div>
                    <div class="nav-next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'your-theme' )) ?></div>
                </div><!-- #nav-above -->
<?php } ?>                            
 
<?php while ( have_posts() ) : the_post() ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'your-theme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
 
<?php if ( $post->post_type == 'post' ) { ?>                                   
                    <div class="entry-meta">
                        <span class="meta-prep meta-prep-author"><?php _e('By ', 'your-theme'); ?></span>
                        <span class="author vcard"><a class="url fn n" href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'your-theme' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
                        <span class="meta-sep"> | </span>
                        <span class="meta-prep meta-prep-entry-date"><?php _e('Published ', 'your-theme'); ?></span>
                        <span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-dTH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
                        <?php edit_post_link( __( 'Edit', 'your-theme' ), "<span class='meta-sep'>|</span>ntttttt<span class='edit-link'>", "</span>nttttt" ) ?>
                    </div><!-- .entry-meta -->
<?php } ?>
                     
                    <div class="entry-summary">   
<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'your-theme' )  ); ?>
<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>
                    </div><!-- .entry-summary -->
 
<?php if ( $post->post_type == 'post' ) { ?>                                   
                    <div class="entry-utility">
                        <span class="cat-links"><span class="entry-utility-prep entry-utility-prep-cat-links"><?php _e( 'Posted in ', 'your-theme' ); ?></span><?php echo get_the_category_list(', '); ?></span>
                        <span class="meta-sep"> | </span>
                        <?php the_tags( '<span class="tag-links"><span class="entry-utility-prep entry-utility-prep-tag-links">' . __('Tagged ', 'your-theme' ) . '</span>', ", ", "</span>ntttttt<span class='meta-sep'>|</span>n" ) ?>
                        <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'your-theme' ), __( '1 Comment', 'your-theme' ), __( '% Comments', 'your-theme' ) ) ?></span>
                        <?php edit_post_link( __( 'Edit', 'your-theme' ), "<span class='meta-sep'>|</span>ntttttt<span class='edit-link'>", "</span>ntttttn" ) ?>
                    </div><!-- #entry-utility -->   
<?php } ?>                    
                </div><!-- #post-<?php the_ID(); ?> -->
 
<?php endwhile; ?>
 
<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
                <div id="nav-below" class="navigation">
                    <div class="nav-previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'your-theme' )) ?></div>
                    <div class="nav-next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'your-theme' )) ?></div>
                </div><!-- #nav-below -->
<?php } ?>            
 
<?php else : ?>
 
                <div id="post-0" class="post no-results not-found">
                    <h2 class="entry-title"><?php _e( 'Nothing Found', 'your-theme' ) ?></h2>
                    <div class="entry-content">
                        <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'your-theme' ); ?></p>
    <?php get_search_form(); ?>                       
                    </div><!-- .entry-content -->
                </div>
 
<?php endif; ?>

<?php echo get_option('myname'); ?>


<!--Login/Logout and User Welcome-->

<div id="user-details">
<?php
   if (is_user_logged_in()) {
      $user = wp_get_current_user();
      echo 'Welcome back <strong>'.$user->display_name.'</strong> !';
   } else { ?>
      Please <strong><?php wp_loginout(); ?></strong>
      or <a href="<?php echo get_option('home'); ?>/wp-login.php?action=register"> <strong>Register</strong></a>
<?php } ?>



</div>





<?php get_footer(); ?>
