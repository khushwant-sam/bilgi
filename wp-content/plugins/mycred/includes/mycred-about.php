<?php
if ( !defined( 'myCRED_VERSION' ) ) exit;

/**
 * myCRED About Page Header
 * @since 1.3.2
 * @version 1.1
 */
function mycred_about_header( $name ) {
	$new = $credit = '';
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'mycred-credit' )
		$credit = ' nav-tab-active';
	else
		$new = ' nav-tab-active';
	
	$index_php = admin_url( 'index.php' );
	$about_page = esc_url( add_query_arg( array( 'page' => 'mycred' ), $index_php ) );
	$credit_page = esc_url( add_query_arg( array( 'page' => 'mycred-credit' ), $index_php ) );
	
	$admin_php = admin_url( 'admin.php' );
	$log_url = esc_url( add_query_arg( array( 'page' => 'myCRED' ), $admin_php ) );
	$hook_url = esc_url( add_query_arg( array( 'page' => 'myCRED_page_hooks' ), $admin_php ) );
	$addons_url = esc_url( add_query_arg( array( 'page' => 'myCRED_page_addons' ), $admin_php ) );
	$settings_url = esc_url( add_query_arg( array( 'page' => 'myCRED_page_settings' ), $admin_php ) ); ?>

	<div class="about-text"><?php printf( 'Thank you for choosing %s as your points management tool!<br />I hope you have as much fun using it as I had developing it.', $name ); ?></div>
	<p class="mycred-actions">
		<a href="<?php echo $log_url; ?>" class="button">Log</a>
		<a href="<?php echo $hook_url; ?>" class="button">Hooks</a>
		<a href="<?php echo $addons_url; ?>" class="button">Add-ons</a>
		<a href="<?php echo $settings_url; ?>" class="button button-primary">Settings</a>
	</p>
	<div class="mycred-badge">&nbsp;</div>
	
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab<?php echo $new; ?>" href="<?php echo $about_page; ?>">What&#8217;s New</a><a class="nav-tab<?php echo $credit; ?>" href="<?php echo $credit_page; ?>">Credits</a><a class="nav-tab" href="http://codex.mycred.me" target="_blank">Documentation</a><a class="nav-tab" href="http://mycred.me/support/forums/" target="_blank">Support Forum</a><a class="nav-tab" href="http://mycred.me/store/" target="_blank">Store</a>
	</h2>
<?php
}

/**
 * myCRED About Page Footer
 * @since 1.3.2
 * @version 1.0
 */
function mycred_about_footer() { ?>

	<p>&nbsp;</p>
	<div id="social-media">
		<a href="//plus.google.com/102981932999764129220?prsrc=3" rel="publisher" style="text-decoration:none;float: left; margin-right: 12px;">
<img src="//ssl.gstatic.com/images/icons/gplus-32.png" alt="Google+" style="border:0;width:24px;height:24px;"/></a><div class="fb-like" data-href="https://www.facebook.com/myCRED" data-height="32" data-colorscheme="light" data-layout="standard" data-action="like" data-show-faces="false" data-send="false" style="display:inline;"></div>
	</div>
	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=283161791819752";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
}

/**
 * About myCRED Page
 * @since 1.3.2
 * @version 1.1
 */
function mycred_about_page() {
	$name = mycred_label();
	$mycred = mycred();
	$settings_url = esc_url( add_query_arg( array( 'page' => 'myCRED_page_settings' ), admin_url( 'admin.php' ) ) ); ?>

<div class="wrap about-wrap" id="mycred-about-wrap">
	<h1><?php printf( __( 'Welcome to %s %s', 'mycred' ), $name, myCRED_VERSION ); ?></h1>
	<?php mycred_about_header( $name ); ?>

	<div class="changelog">
		<h3>Version Changes</h3>
		<div class="feature-section col two-col">
			<div>
				<h4>WooCommerce 2.2</h4>
				<p>myCRED 1.5.4 now supports the latest version of WooCommerce including refunds. If you use the WooCommerce rewards system awarding points for purchases, these will now be paid out when orders are paid.</p>
			</div>
			<div class="last-feature">
				<h4>My Balance Widget</h4>
				<p>The My Balance widget has been updated and you will need to update your widget settings.</p>
			</div>
			<div>
				<h4>BuddyPress 2.1</h4>
				<p>myCRED now supports BuddyPress 2.1!</p>
			</div>
			<div class="last-feature">
				<h4>Leaderboard</h4>
				<p>The myCRED Leaderboard shortcode has been improved and now will by default exclude users with zero balance. You can disable this via the new "exclude_zero" attribute:</p>
				<pre>[mycred_leaderboard exclude_zero="0"]</pre>
			</div>
		</div>
		<h3>Add-on News</h3>
		<div class="feature-section col two-col">
			<div>
				<h4>Badges</h4>
				<p>Similar to ranks, badges are based on a users actions and not their balance. You can award badges for any myCRED action taken on your website like sending BuddyPress messages, logging in or even transfers.</p>
			</div>
			<div class="last-feature">
				<h4>Transfer Add-on</h4>
				<p>In 1.5 the transfer add-on has been adjusted to make it easier for you to customize it by adding custom fields. No need to replace the transfer script any longer!</p>
			</div>
		</div>
		<h3>Added Support</h3>
		<div class="feature-section col two-col">
			<div>
				<h4><a href="https://wordpress.org/plugins/share-this/" target="_blank">ShareThis</a></h4>
				<p>Award points for users sharing your websites content on popular social media sites like Facebook and Twitter! Requires the ShareThis plugin to be installed and setup!</p>
			</div>
			<div class="last-feature">
				<h4>Site Visits</h4>
				<p>The new Site Visit hook allows you to award points for users visiting your website on a daily basis.</p>
			</div>
		</div>
		<h3>Improvements</h3>
		<div class="feature-section col three-col">
			<div>
				<h4>Leaderboard</h4>
				<p>You can now create leaderboards based on your users actions and not just their balance! Both the mycred_leaderboard shortcode and widget has been updated.</p>
			</div>
			<div>
				<h4>Exchange</h4>
				<p>The new myCRED Exchange shortcode allows your users to exchange one point type for another at a rate of your choosing.</p>
			</div>
			<div class="last-feature">
				<h4>Easier to Exclude</h4>
				<p>As of 1.5, you can not exclude users from using any point type directly from their profiles in the admin area.</p>
			</div>
		</div>
		<p style="text-align:right;">Want to help further development of <strong>my</strong>CRED? <a href="http://mycred.me/about/support-mycred/" target="_blank">Here is a list</a> of things you can do to help!</p>
	</div>
	<?php mycred_about_footer(); ?>

</div>
<?php
}

/**
 * myCRED Credit Page
 * @since 1.3.2
 * @version 1.0
 */
function mycred_about_credit_page() {
	$name = mycred_label(); ?>

<div class="wrap about-wrap" id="mycred-credit-wrap">
	<h1>Awesome People</h1>
	<?php mycred_about_header( $name ); ?>

	<div class="changelog">
		<h3>myCRED Users</h3>
		<div class="feature-section col two-col">
			<div>
				<h4>Bug Finders</h4>
				<p>Users who have taken the time to report bugs helping me improve this plugin.</p>
				<ul>
					<li><a href="http://mycred.me/community/jommy99/">John Moore</a></li>
					<li><a href="http://mycred.me/community/keisermedia/">Lucas Keiser</a></li>
					<li><a href="http://mycred.me/community/lionelbernard/">Siargao</a></li>
					<li><a href="http://mycred.me/community/woekerzee/">woekerzee</a></li>
					<li><a href="http://mycred.me/community/jmaubert75/">JM AUBERT</a></li>
					<li><a href="http://mycred.me/community/NUHISON/">David J</a></li>
					<li><a href="http://mycred.me/community/shmoo/">Shmoo</a></li>
				</ul>
			</div>
			<div class="last-feature">
				<h4>Plugin Translators</h4>
				<p>Users who have helped with translating this plugin.</p>
				<ul>
					<li><a href="http://bp-fr.net/">Dan</a> <em>( French )</em></li>
					<li><a href="http://mycred.me/members/maniv-a/">Mani Akhtar</a> <em>( Persian )</em></li>
					<li><a href="http://www.merovingi.com/">Gabriel S Merovingi</a> <em>( Swedish )</em></li>
					<li><a href="http://robertrowshan.com/">Robert Rowshan</a> <em>( Spanish )</em></li>
					<li>Skladchik <em>( Russian )</em></li>
					<lo>Guilherme <em>( Portuguese - Brazil )</em></li>
				</ul>
			</div>
		</div>
		<h3>Find out more</h3>
		<p>You can always find more information about this plugin on the <strong>my</strong>CRED <a href="http://mycred.me/">website</a>.</p>
	</div>
	<?php mycred_about_footer(); ?>

</div>
<?php
}
?>