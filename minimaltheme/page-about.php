<?php 
	/* Template Name: About Page */
?>

<?php get_header(); ?>

<!-- CONTENT AREA -->
	<section>
		<hr class="no-margin" />
		
		<div class="middle-container section-content">
			<div class="container box section-content align-center about-page">
				<h2>About Me</h2>
                
                <div class="wrapper">
	
                <?php
                $err = '';
                $success = '';
             
                global $wpdb, $PasswordHash, $current_user, $user_ID;
             
                if(isset($_POST['task']) && $_POST['task'] == 'register' ) {
             
                    
                    $pwd1 = $wpdb->escape(trim($_POST['pwd1']));
                    $pwd2 = $wpdb->escape(trim($_POST['pwd2']));
                    $first_name = $wpdb->escape(trim($_POST['first_name']));
                    $last_name = $wpdb->escape(trim($_POST['last_name']));
                    $email = $wpdb->escape(trim($_POST['email']));
                    $username = $wpdb->escape(trim($_POST['username']));
                    
                    if( $email == "" || $pwd1 == "" || $pwd2 == "" || $username == "" || $first_name == "" || $last_name == "") {
                        $err = 'Please don\'t leave the required fields.';
                    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $err = 'Invalid email address.';
                    } else if(email_exists($email) ) {
                        $err = 'Email already exist.';
                    } else if($pwd1 <> $pwd2 ){
                        $err = 'Password do not match.';		
                    } else {
             
                        $user_id = wp_insert_user( array ('first_name' => apply_filters('pre_user_first_name', $first_name), 'last_name' => apply_filters('pre_user_last_name', $last_name), 'user_pass' => apply_filters('pre_user_user_pass', $pwd1), 'user_login' => apply_filters('pre_user_user_login', $username), 'user_email' => apply_filters('pre_user_user_email', $email), 'role' => 'subscriber' ) );
                        if( is_wp_error($user_id) ) {
                            $err = 'Error on user creation.';
                        } else {
                            do_action('user_register', $user_id);
                            
                            $success = 'You\'re successfully register';
                        }
                        
                    }
                    
                }
                ?>
             
                    <!--display error/success message-->
                <div id="message">
                    <?php 
                        if(! empty($err) ) :
                            echo '<p class="error">'.$err.'';
                        endif;
                    ?>
                    
                    <?php 
                        if(! empty($success) ) :
                            echo '<p class="error">'.$success.'';
                        endif;
                    ?>
                </div>
             
                <form method="post" action="">
                
                	<div class="alignleft"><p><?php if($sucess != "") { echo $sucess; } ?> <?php if($err != "") { echo $err; } ?></p></div>
                    
                    <h3>Don't have an account?<br /> Create one now.</h3>
                    
                    <div align="center">
                    <table cellpadding="2" cellspacing="2" align="center">
                    <tr>
                    <td><label>Last Name</label></td>
                    <td><input type="text" value="" name="last_name" id="last_name" /></td>
                    </tr>
                    <tr>
                    <td><label>First Name</label></td>
                    <td><input type="text" value="" name="first_name" id="first_name" /></td>
                    </tr>
                    <tr>
                    <td><label>Email</label></td>
                    <td><input type="text" value="" name="email" id="email" /></td>
                    </tr>
                    <tr>
                    <td><label>Username</label></td>
                    <td><input type="text" value="" name="username" id="username" /></td>
                    </tr>
                    <tr>
                    <td><label>Password</label></td>
                    <td><input type="password" value="" name="pwd1" id="pwd1" /></td>
                    </tr>
                    <tr>
                    <td><label>Password again</label></td>
                    <td><input type="password" value="" name="pwd2" id="pwd2" /></td>
                    </tr>
                    
                    <tr>
                    <td colspan="2" align="center"><button type="submit" name="btnregister" class="button">Submit</button>
                    <input type="hidden" name="task" value="register" /></td>
                    </tr>
                    </table>
                    </div>
                    
                </form>
             
            </div><br />
				
				<p class="narrow-p">I’m a web designer based in Romania. I create clean websites, love Apple products and I’m a big fan of trance music.</p>
				<p class="narrow-p">Wanna get in touch? Do a quick scroll to the bottom of the page.<a href="<?php echo home_url(); ?>/contact"> It’s all there</a> :)</p>
				
				<hr class="alt" />
				
				<h2 class="available">I’m currently available for freelance projects.</h2>
				<h2>Rates start at $50/hour.</h2>
				
				<div class="cta">
					<a href="<?php echo home_url(); ?>/portfolio" class="btn btn-primary">See my portfolio</a>
				</div> <!-- enc cta -->
			</div> <!-- end container -->
		</div> <!-- end middle-container -->
	</section>

<?php get_footer(); ?>