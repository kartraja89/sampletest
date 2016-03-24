<?php 
	/* Template Name: ACF */
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
				
				if (have_posts()) : ?>
                
				<ul class="row portfolio-entries">
                	<?php while (have_posts()) : the_post(); ?>
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
                        
                        <?php the_content(); ?><br />Above is the Text Widget using shortcode
                        
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
                
                <?php //if ( dynamic_sidebar('home_right_sidebar') ) : else : endif; ?>
                
                <?php
				echo "ACF Type : Image<br><br>";
				/**** Basic display (Object) ****/
				echo "<b>Basic display (Object)</b><br><br>";
				 
				$image = get_field('image');
				
				if( !empty($image) ): ?>
				
					<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
				
				<?php endif; ?>
                
                <?php echo "<br><br>"; ?>
                
                <?php 
				/**** Customized display (Object) ****/
				echo "<b>Customized display (Object)</b><br><br>";
				
				$image = get_field('image');
				
				if( !empty($image) ): 
				
					// vars
					$url = $image['url'];
					$title = $image['title'];
					$alt = $image['alt'];
					$caption = $image['caption'];
				
					// thumbnail
					$size = 'thumbnail';
					$thumb = $image['sizes'][ $size ];
					$width = $image['sizes'][ $size . '-width' ];
					$height = $image['sizes'][ $size . '-height' ];
				
					if( $caption ): ?>
				
						<div class="wp-caption">
				
					<?php endif; ?>
				
					<a href="<?php echo $url; ?>" title="<?php echo $title; ?>">
				
						<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
				
					</a>
				
					<?php if( $caption ): ?>
				
							<p class="wp-caption-text"><?php echo $caption; ?></p>
				
						</div>
				
					<?php endif; ?>
				
				<?php endif; ?>
                
                
                <?php echo "<br><br>"; ?>
                
                <?php 
				echo "ACF Type : Relationship<br><br>";
				/**** Basic loop (with setup_postdata) ****/
				echo "Basic loop (with setup_postdata)<br><br>";
				
				$posts = get_field('featured_posts');
				
				if( $posts ): ?>
					<ul>
					<?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
						<?php setup_postdata($post); ?>
						<li>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<span>Custom field from $post: <?php the_author(); ?></span>
						</li>
					<?php endforeach; ?>
					</ul>
					<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
				<?php endif; ?>
                
                <?php echo "<br><br>"; ?>
                
                <?php 
				/**** Basic loop (without setup_postdata) ****/
				echo "Basic loop (without setup_postdata)<br><br>";
				
				$posts = get_field('featured_posts');
				
				if( $posts ): ?>
					<ul>
					<?php foreach( $posts as $p ): // variable must NOT be called $post (IMPORTANT)
						
						$autor_id = $p->post_author;
						?>
						<li>
							<a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title( $p->ID ); ?></a>
							<span>Custom field from $post: <?php $autor_name = the_author_meta('user_nicename', $autor_id); //the_field('author', $p->ID); ?></span>
						</li>
					<?php endforeach; ?>
					</ul>
                    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
				<?php endif; ?>
                
                <?php echo "<br><br>"; ?>
                
                <?php 
				/**** Using WP_Query arguments ****/
				echo "Using WP_Query arguments<br><br>";
				
				// get only first 3 results
				$ids = get_field('featured_posts', false, false);
				
				$query = new WP_Query(array(
					'post_type'      	=> 'page',
					'posts_per_page'	=> 3,
					'post__in'		    => $ids,
					'post_status'		=> 'any',
					'orderby'        	=> 'rand',
				));
				
				if ( $query->have_posts() ) : ?>
                
                	<ul>
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<li><?php the_title(); ?></li>
                    <?php endwhile; ?>
                    </ul>
                    
                    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
				<?php endif; ?>
                
                
				<?php echo "<br><br>"; ?>
                
                <?php 
				echo "ACF Type : Date picker<br><br>";
				/**** Date picker field ****/
				?>
                
				<p>Posted on: <?php the_field('date_post'); ?></p>
                
                <?php 
				if(get_field('date_post')) {
					echo '<li><strong>Deadline: </strong>' . get_field('date_post') . '</li>';
				}
				
				echo date("dS F Y",strtotime(get_field('date_post')));
				
				echo "<br>";
				
				$date = DateTime::createFromFormat('Ymd', get_field('date_post'));
				echo $date->format('d-m-Y');
				?>
                
                <?php echo "<br><br>"; ?>
                
                <?php
				echo "ACF Type : Text field<br><br>"; 
				/**** Text field ****/
				?>
                <h2><?php the_field('nametext'); ?></h2>
                
                
                <?php 
				echo "ACF Type : Checkbox<br><br>"; 
				/**** Checkbox ****/
				
				/**** Displaying single value ****/ ?>
				Color: <?php the_field('checkbox'); ?>
                <?php echo "<br>"; ?>
                
				<?php 
				/**** Displaying a single value's Label ****/
				
				$field = get_field_object('checkbox');
				$value = get_field('checkbox');
				//$label = $field['choices'][ $value ];
				
				foreach($value as $val) {
					$label = $field['choices'][ $val ];
					//echo $val.',';	
					echo $label.',';	
				}
				?>
				<?php echo "<br>"; ?>
                
                <?php /**** Displaying multiple values ****/ ?>
				Colors: <?php echo implode(', ', get_field('checkbox')); ?>
                <?php echo "<br>"; ?>
                
                <?php
				/**** Conditional statement (Checkbox rvalue is an array) ****/
				
				if( in_array( 'red', get_field('checkbox') ) ) {
					//...
				}
				?>
                
                <?php echo "<br><br>"; ?>
                
                <?php
				echo "ACF Type : Select (Dropdown)<br><br>"; 
				/**** Select (Dropdown) ****/
				
				/**** Displaying single value ****/
				?>
				Column: <?php the_field('page_layout'); ?>
                
                <?php echo "<br>"; ?>
                
                <?php
				/**** Displaying a single value's Label ****/
				
				$field = get_field_object('page_layout');
				$value = get_field('page_layout');
				echo $label = $field['choices'][ $value ];
				?>
                
                <?php
				/**** Conditional statement (Single Value) ****/
				if(get_field('page_layout') == "col_1") {
					//...
				}
				
				/****  Conditional statement (Multiple Values) ****/
				if( in_array( 'col_1', get_field('page_layout') ) ) {
					//...
				}
				?>
                
                <?php echo "<br><br>"; ?>
                
                <?php
				echo "ACF Type : True / False<br><br>"; 
				/**** True / False ****/
				
				/**** View value data (for debugging) ****/
				var_dump( get_field('member_content') );
				
				echo "<br>";
				
				/**** Conditional Statement ****/
				if( get_field('member_content') ) {
					echo "do something";
				} else {
					echo "do something else";
				}
				?>
                
                <?php echo "<br><br>"; ?>
                
                <?php
				echo "ACF Type : TextArea<br><br>"; 
				/**** TextArea ****/
				?>
                <?php the_field('textarea'); ?>
                
                <?php echo "<br><br>"; ?>
                
                <?php
				echo "ACF Type : Color Picker<br><br>"; 
				/**** Color Picker ****/
				?>
                <div style="background-color:<?php the_field('color'); ?>">Something here...</div>
                
                <?php echo "<br><br>"; ?>
                
                <?php
				echo "ACF Type : Page Link<br><br>"; 
				/**** Page Link ****/
				?>
                <a href="<?php the_field('page_link'); ?>">Read this!</a>
                
                <?php echo "<br><br>"; ?>
                
                <?php
				echo "ACF Type : File<br><br>"; 
				/**** File ****/
				 
				/**** Show selected file, Return value = URL ****/
				?>
                <a href="<?php the_field('file'); ?>" >Download File</a>
                
                <?php echo "<br>"; ?>
                
                <?php
				/**** Show selected file if value exists, Return value = URL ****/
				if( get_field('file') ):
				?><a href="<?php the_field('file'); ?>" >Download File</a>
				<?php endif; ?>
                
                <?php echo "<br>"; ?>
                
                <?php
				/**** Show selected file, Return value = ID ( allows us to get more data about the image ) ****/
				
				echo $attachment_id = get_field('file');
				$url = wp_get_attachment_url( $attachment_id );
				$title = get_the_title( $attachment_id );
				
				if( get_field('file') ):
					?><a href="<?php echo $url; ?>" >Download File "<?php echo $title; ?>"</a><?php
				endif;
				
				?>
                <?php echo "<br>"; ?>
                
                <?php
				
				/**** Show selected file, Return value = Object, requires ACF 3.3.7+ ****/
				
				$file = get_field('file');
				// view array of data
				var_dump($file);
				?>
                
                <?php echo "<br><br>"; ?>
                
                <?php
				echo "ACF Type : Wysiwyg Editor<br><br>"; 
				/**** Wysiwyg Editor ****/
				?>
                <?php the_field('editor'); ?>
                
                <?php echo "<br><br>"; ?>
                
                <?php 
				echo "ACF Type : Taxonomy<br><br>"; 
				/**** Taxonomy ****/
				
				$terms = get_field('taxcat');
				
				if( $terms ): ?>
				
					<ul>
					<?php foreach( $terms as $term ): ?>
				
						<h2><?php echo get_cat_name( $term ); ?></h2>
						<p><?php echo category_description( $term ); ?></p>
						<a href="<?php echo get_category_link( $term ); ?>">View all '<?php echo get_cat_name( $term ); ?>' posts</a>
                        <?php echo "<br><br>"; ?>
				
					<?php endforeach; ?>
					</ul>
				
				<?php endif; ?>
                
                <?php echo "<br><br>"; ?>
                
                <?php 
				echo "ACF Type : Google Map<br><br>"; 
				/**** Google Map ****/ 
				
				$location = get_field('google_map');
				
				if( !empty($location) ):
				?>
				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
                    <p class="address"><?php echo $location['address']; ?></p>
				</div>
				<?php endif; ?>
                
                <?php echo "<br><br>"; ?>
                
                <?php 
				echo 'How to query posts filtered by custom field values<br>';
				
				echo '1. Compare with a single custom field value<br>';
				// args
				$args = array(
					'numberposts' => -1,
					'post_type' => 'movies',
					/*'meta_key' => 'color',
					'meta_value' => 'red',*/
					'meta_key' => 'price',
					'meta_value' => '35'
					
				);
				
				// get results
				$the_query = new WP_Query( $args );
				
				// The Loop
				?>
				<?php if( $the_query->have_posts() ): ?>
					<ul>
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> => <?php the_field('color'); ?> => <?php the_field('price'); ?>
						</li>
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>
				
				<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
                
                <?php echo "<br><br>"; ?>
                
                <?php 
				echo '2. Compare with multiple custom field values (text based values)<br>';

				// args
				$args = array(
					'numberposts' => -1,
					'post_type' => 'movies',
					'meta_query' => array(
						'relation' => 'AND',
						array(
							'key' => 'color',
							'value' => 'red',
							'compare' => '='
						),
						array(
							'key' => 'price',
							'value' => 20,
							'type' => 'NUMERIC',
							'compare' => '>' // '>','<','>=','<='
						)
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
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> => <?php the_field('color'); ?> => <?php the_field('price'); ?>
						</li>
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>
				
				<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
                
                <?php echo "<br><br>"; ?>
                
                <?php 
				echo '3. Compare with multiple custom field values (array based values)<br>';
				
				// args
				$args = array(
					'numberposts' => -1,
					'post_type' => 'movies',
					'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => 'color',
							'value' => 'red',
							'compare' => 'LIKE'
						),
						array(
							'key' => 'color',
							'value' => 'blue',
							'compare' => 'LIKE'
						)
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
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> => <?php the_field('color'); ?> => <?php the_field('price'); ?>
						</li>
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>
				
				<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
                
                <?php echo "<br><br>"; ?>
                
                
				<div class="cta align-center">
                	<a href="<?php echo home_url(); ?>/portfolio" class="btn btn-primary">See my full portfolio</a>
                </div>
                
			</div> <!-- end container -->
		</div> <!-- end middle-container -->
	</section>
    

<style type="text/css">

.acf-map {
	width: 100%;
	height: 400px;
	border: #ccc solid 1px;
	margin: 20px 0;
}

</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
(function($) {

/*
*  render_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/

function render_map( $el ) {

	// var
	var $markers = $el.find('.marker');

	// vars
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP
	};

	// create map	        	
	var map = new google.maps.Map( $el[0], args);

	// add a markers reference
	map.markers = [];

	// add markers
	$markers.each(function(){

    	add_marker( $(this), map );

	});

	// center map
	center_map( map );

}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/

function add_marker( $marker, map ) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

	// create marker
	var marker = new google.maps.Marker({
		position	: latlng,
		map			: map
	});

	// add to array
	map.markers.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});

		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {

			infowindow.open( map, marker );

		});
	}

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/

function center_map( map ) {

	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

	// only 1 marker?
	if( map.markers.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/

$(document).ready(function(){

	$('.acf-map').each(function(){

		render_map( $(this) );

	});

});

})(jQuery);
</script>

<?php get_footer(); ?>