<?php

/*
Template Name: Login Page
*/

get_header();

?>

<!-- CONTENT AREA -->
	<section>
		<hr class="no-margin" />
		
		<div class="middle-container section-content">
			<div class="container box section-content align-center about-page">
				<h2>User Login</h2>
                
                <div class="wrapper">
                
				<form name="loginform" id="loginform" action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
                    <p>
                        <label>Username<br />
                        <input type="text" name="log" id="user_login" class="input" value="" size="20" tabindex="10" /></label>
                    </p>
                    <p>
                
                        <label>Password<br />
                        <input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" /></label>
                    </p>
                    <p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90" /> Remember Me</label></p>
                    <p class="submit">
                        <input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Log In" tabindex="100" />
                        <input type="hidden" name="redirect_to" value="<?php echo get_option('home'); ?>/wp-admin/" />
                
                        <input type="hidden" name="testcookie" value="1" />
                    </p>
                </form>
                
                <!--<script type="text/javascript" language="JavaScript">
					window.history.forward(1);
				</script>-->

				</div>
			</div> <!-- end container -->
		</div> <!-- end middle-container -->
	</section>

<?php get_footer(); ?>