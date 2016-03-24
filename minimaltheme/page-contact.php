<?php 
	/* Template Name: Contact Page */
?>

<?php

	global $wpdb; 
	
	$table_prefix = $wpdb->prefix;
	$table = $table_prefix.'contact';
	
	$date = date('Y-m-d');

	// Function for email address validation
	function isEmail($verify_email) {
	
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$verify_email));
	
	}
	
	$error_name = false;
	$error_email = false;
	$error_phone = false;
	$error_prj_type = false;
	$error_prj_description = false;
	$error_budget = false;

	if (isset($_POST['quote-submit'])) {
		
		// Initialize the variables
		$name = '';
		$email = '';
		$phone = '';
		$type = '';
		$description = '';
		$budget = '';
		
		// Get the name
		if (trim($_POST['quote-name']) === '') {
			$error_name = true;
		} else {
			$name = trim($_POST['quote-name']);
		}
		
		// Get the email
		if (trim($_POST['quote-email']) === '' || !isEmail($_POST['quote-email'])) {
			$error_email = true;
		} else {
			$email = trim($_POST['quote-email']);
		}

		// Get the phone number
		if (trim($_POST['quote-phone']) === '' || !is_numeric(trim($_POST['quote-phone'])) ) {
			$error_phone = true;
		} else {
			$phone = trim($_POST['quote-phone']);
		}

		// Get the project type
		if (trim($_POST['quote-project-type']) === '0') {
			$error_prj_type = true;
		} else {
			$type = trim($_POST['quote-project-type']);
		}
		
		// Get the project description
		if (trim($_POST['quote-project-description']) === '') {
			$error_prj_description = true;
		} else {
			$description = stripslashes(trim($_POST['quote-project-description']));
		}

		// Get the budget
		if (trim($_POST['quote-budget']) === '' || !is_numeric(trim($_POST['quote-budget'])) ) {
			$error_budget = true;
		} else {
			$budget = trim($_POST['quote-budget']);
		}
		
		// Check if we have errors
		if (!$error_name && !$error_email && !$error_phone && !$error_prj_type && !$error_prj_description && !$error_budget) {
			
			/*echo "<pre>";
			print_r($_POST); exit;*/
			
			// Insert the data into table using wordpress 
			$wpdb->insert(
					$table,
					array(
							'name'   => $name,
							'email'  => $email,
							'phone'  => $phone,
							'ptype'  => $type,
							'pdesc'  => $description,
							'budget' => $budget,
							'date'   => $date
						),
						array(
						 '%s',
						 '%s',
						 '%s',
						 '%s',
						 '%s',
						 '%s',
						 '%s'
						 )
			);
			
			// Get the receiver email from the WP admin panel
			$receiver_email = get_option('admin_email');

			$subject = "Quote request from $name";
			$body = "You have a new quote request from $name. Project details:" . PHP_EOL . PHP_EOL;
			$body .= "Project type: $type" . PHP_EOL;
			$body .= "Project description: $description" . PHP_EOL . PHP_EOL;
			$body .= "Available budget: $budget" . PHP_EOL . PHP_EOL;
			$body .= "You can contact $name via email at $email or via phone at $phone.";
			$body .= PHP_EOL . PHP_EOL;
			
			$headers = "From: $email" . PHP_EOL;
			$headers .= "Reply-To: $email" . PHP_EOL;
			$headers .= "MIME-Version: 1.0" . PHP_EOL;
			$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
			$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

			// If all is good, we send the email
			if (mail($receiver_email, $subject, $body, $headers)) {
				$email_sent = true;
			} else {
				$email_sent_error = true;
			}
		}
	}
	
?>

<?php get_header(); ?>

<!-- CONTENT AREA -->
	<section>
		<hr class="no-margin" />
		
		<div class="middle-container section-content">
			<div class="container box section-content align-center contact-page">
				<h2>Let's Get in Touch</h2>
				
				<p class="narrow-p">You can call me, email me directly or connect with me through my social networks.</p>
				<p>(+40) 744122222 <br /> <a href="#">hello@adipurdila.com</a></p>
				
				<ul class="social-icons inline">
					<li><a href="" class="icon-twitter"></a></li>
					<li><a href="" class="icon-facebook"></a></li>
					<li><a href="" class="icon-dribbble"></a></li>
				</ul>
				
				<hr class="alt" />
                
                <?php if (isset($email_sent) && $email_sent == true) : ?>
				
					<h2>Success!</h2>
					<p>You have successfully sent the quote request. I'll get back to you as soon as possible.</p>
				
				<?php elseif (isset($email_sent_error) && $email_sent_error == true) : ?>

					<h2>There was an error!</h2>
					<p>Unfortunately, there was an error while trying to send the email. Please try again.</p>
					
				<?php else : ?>
				
				<h2>Need a Quote?</h2>
				
				<p class="narrow-p">Use the form below. All fields are required.</p>
				
				<form action="<?php the_permalink(); ?>" method="POST" class="quote-form" novalidate>
                	<p <?php if ($error_name) echo 'class="error"'; ?>>
						<label for="quote-name">Full Name:</label>
						<input type="text" name="quote-name" id="quote-name" value="<?php if (isset($_POST['quote-name'])) echo $_POST['quote-name']; ?>" />
					</p>
					<p <?php if ($error_email) echo 'class="error"'; ?>>
						<label for="quote-email">Email Address:</label>
						<input type="email" name="quote-email" id="quote-email" value="<?php if (isset($_POST['quote-email'])) echo $_POST['quote-email']; ?>" />
					</p>
					<p <?php if ($error_phone) echo 'class="error"'; ?>>
						<label for="quote-phone">Phone Number:</label>
						<input type="text" name="quote-phone" id="quote-phone" value="<?php if (isset($_POST['quote-phone'])) echo $_POST['quote-phone']; ?>" />
					</p>
					<p class="select-container <?php if ($error_prj_type) echo 'error'; ?>">
						<label for="quote-project-type">Project Type:</label>
						<select name="quote-project-type" id="quote-project-type">
							<option value="0">- Select Project Type -</option>
							<option value="1" <?php if (isset($_POST['quote-project-type']) && $_POST['quote-project-type'] == '1' ) echo 'selected'; ?>>Website</option>
							<option value="2" <?php if (isset($_POST['quote-project-type']) && $_POST['quote-project-type'] == '2' ) echo 'selected'; ?>>Logo Design</option>
							<option value="3" <?php if (isset($_POST['quote-project-type']) && $_POST['quote-project-type'] == '3' ) echo 'selected'; ?>>Print</option>
						</select>
					</p>
					<p <?php if ($error_prj_description) echo 'class="error"'; ?>>
						<label for="quote-project-description">Project Description:</label>
						<textarea name="quote-project-description" id="quote-project-description" cols="30" rows="10"><?php if (isset($_POST['quote-project-description'])) echo $_POST['quote-project-description']; ?></textarea>
					</p>
					<p <?php if ($error_budget) echo 'class="error"'; ?>>
						<label for="quote-budget">Available Budget:</label>
						<input type="number" name="quote-budget" id="quote-budget" min="50" step="50" class="align-right" value="<?php if (isset($_POST['quote-budget'])) echo $_POST['quote-budget']; ?>" />
					</p>
					
					<div class="cta">
						<input type="hidden" id="quote-submit" name="quote-submit" value="true" />
						<input type="submit" class="btn btn-primary" value="Give me a quote" />
					</div> <!-- end cta -->
                    
                    
					<!--<p>
						<label for="quote-name">Full Name:</label>
						<input type="text" name="quote-name" id="quote-name" />
					</p>
					<p>
						<label for="quote-email">Email Address:</label>
						<input type="email" name="quote-email" id="quote-email" />
					</p>
					<p>
						<label for="quote-phone">Phone Number:</label>
						<input type="text" name="quote-phone" id="quote-phone" />
					</p>
					<p class="select-container">
						<label for="quote-project-type">Project Type:</label>
						<select name="quote-project-type" id="quote-project-type">
							<option value="0">- Select Project Type -</option>
							<option value="1">Website</option>
							<option value="2">Logo Design</option>
							<option value="3">Print</option>
						</select>
					</p>
					<p>
						<label for="quote-project-description">Project Description:</label>
						<textarea name="quote-project-description" id="quote-project-description" cols="30" rows="10"></textarea>
					</p>
					<p>
						<label for="quote-budget">Available Budget:</label>
						<input type="number" name="quote-budget" id="quote-budget" min="50" step="50" class="align-right" />
					</p>
					
					<div class="cta">
						<input type="submit" class="btn btn-primary" value="Give me a quote" />
					</div>--> <!-- end cta -->
                    
				</form>
                
                <?php endif; ?>
                
			</div> <!-- end container -->
		</div> <!-- end middle-container -->
	</section>

<?php get_footer('contact'); ?>