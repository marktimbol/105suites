<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.omasters.com
 * @since      0.0.1
 *
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/admin/partials
 * @template   Documentation
 */
?>
<div class="cb_hm wrap">
	<div class="clearfix">
		<div class="mixin-col span_12 text-center">
			<img src="<?php echo $plugin_admin; ?>images/cloudbeds.png" alt="Cloudbeds" />
			<p>Cheers to more reservations and happier guests.</p>
		</div>
	</div>
	<div class="container_panel documentation_panel">	
		<h1>Cloudbeds WP mybookings plugin - beta version</h1>
		<div class="clearfix">
			<h2>Description</h2>
			<p>WP Mybookings plugin is the WordPress version of mybookings--the world-class booking engine from <a href="https://www.cloudbeds.com/">Cloudbeds</a>.  As a hotelier running a WordPress-based website, this plugin makes installing and customizing your own booking engine fast and easy.  Additionally, if you are a Cloudbeds customer, you can benefit from full integration with <a href="https://www.cloudbeds.com/myfrontdesk">myfrontdesk</a>, our award-winning cloud-based property management system (PMS).</p>

			<p>If you are a <a href="https://www.cloudbeds.com/">Cloudbeds</a> myfrontdesk customer, you already know the benefits of a fully-integrated cloud-based PMS. WP Mybookings gives you even more functionality, allowing you to:
			<ul>
				<li>Customize the CSS of your website’s booking page to style it in accordance with your website’s existing design</li>
				<li>Receive new reservations directly into your myfrontdesk PMS, including all guest and reservation details, ready for room allocation and ultra-fast check-in</li>
				<li>Collect deposits upon reservation, offering multiple payment methods</li>
				<li>Manage all your inventory from a central pool, maximizing your revenue while reducing the risk of overbookings</li>
			</ul></p>
			<p>Even if you are not a Cloudbeds myfrontdesk customer, WP Mybookings comes with a <strong>free</strong>, stand-alone booking engine for your Wordpress website. The free version does not connect to myfrontdesk, but it still allows you to accept direct bookings on your website and receive email notifications when you get them.</p>
			<h3>Instructions</h3>
			<h4>Install and activate</h4>
			Install and activate the plugin.
			<h4>Navigate to plugin page</h4>
			<p>Navigate to the WP Mybookings page in your WordPress Admin dashboard.</p>
			<h4>Choose mode</h4>
			<h5>"Standalone"</h5>
			<p>Select this option to use the plugin as a standalone booking engine completely inside your WordPress implementation.</p>

			<p>By selecting this option, the settings tabs will be enabled.  Click into each tab and configure the appropriate settings for each section including your property, amenities, accommodations, policies, and rates.</p>
			<h5>"Cloudbeds API Integration"</h5>
			<p>Select this option if you have a Cloudbeds myfrontdesk account.</p>

			<p>Obtain, copy, and paste your Client ID and Client Secret from your myfrontdesk "API Integrations &amp; Credentials" page into the fields provided on the WP Mybookings page of this plugin (see below for the steps on how to obtain your Client ID and Client Secret, if needed).</p>
			<h4>Install shortcode</h4>
			<p>Once you’ve configured the plugin settings, regardless of which option you chose, you will need to create and/or navigate to the page you will use for your booking page and place the following shortcode into the body:</p>

			<strong>If you own a property:</strong>

			[cb_hm date_format="d/m/Y"]

			<strong>If you are authorized to access more than one property, but do not own a property:</strong>

			[cb_hm property_id="000" date_format="d/m/Y"]

			<p>Replace "000" with the property ID of the property you want to connect to.</p>

			<strong>Note:</strong>

			<p>If you chose the "<strong>Standalone</strong>" option, you will see any new reservations in the "Reservations" page inside this plugin.</p>

			<p>If you chose the "<strong>Cloudbeds API Integration</strong>" option, you will notice the plugin will pull availability and rates from your Cloudbeds myfrontdesk account.  It will also seamlessly add new reservations received through your booking page directly into your myfrontdesk account.</p>
			<h1>How to get a Client ID and Client Secret key pair</h1>
			<p>Follow these steps to get the Client ID and Client Secret key pair, which you need to sync WP Mybookings with your Cloudbeds myfrontdesk account:</p>
			<ol>
				<li>Go to the "API Integrations &amp; Credentials" page inside Cloudbeds myfrontdesk and click the green "+ New Credentials" button.</li>
				<li>A new form will appear. Enter a name for this new set of credentials (anything you would like works here. For example, you could use "WordPress", "My Site", or your web address).</li>
				<li>Choose "WordPress" in the Type dropdown list.</li>
				<li>Copy the Redirect URI from the mybookings page (below the Client ID and Client Secret fields), and paste it into the Redirect URI field in the Cloudbeds myfrontdesk form.</li>
				<li>Click the "Save" button at the bottom of the screen (myfrontdesk)</li>
				<li>A new row will be added to the "API INTEGRATIONS &amp; CREDENTIALS" table, which will include your newly generated Client ID and Client Secret. Copy and paste those values into the appropriate fields on the "WP Mybookings" page in this plugin.</li>
				<li>Click the "Save" button on the "WP Mybookings" page in this plugin. You will be sent to a special page on Cloudbeds.com asking if you want to allow this WordPress plugin to access your Cloudbeds account.  Click the "Approve" button on that page. You will be redirected back to this plugin’s Settings page automatically.</li>
			</ol>
			<h3>Plugin Customization</h3>
			<p>In order to customize the look of your booking page you will need the following:</p>
			<ul>
				<li>At least basic knowledge of WordPress, HTML and CSS.</li>
				<li>Admin access to WordPress (which you probably already have if you’re reading these instructions)</li>
				<li>FTP access to your website via your hosting provider</li>
			</ul>
			<p>You can get the plugin’s default CSS file to use as a baseline from /wp-content/plugins/mybookings-light/public/css/cloudbeds-hotel-management-public.css</p>

			<p>We suggest copying the contents of that file into /wp-content/themes/YOURTHEMEDIRECTORYNAME/mybookings-light/mybookings_light.css (which you may need to create), where "YOURTHEMEDIRECTORYNAME" is the name of the directory of your website’s active theme.  You may adjust the CSS inside that file as needed to fit your design.</p>

			<p>Additionally, you can copy the following files into the same "mybookings-light" directory and customize as needed.</p>
			<ul>
				<li>Search form: search.php</li>
				<li>Thank you page: thankyou.php</li>
				<li>Booking details page: jstemplate.php</li>
			</ul>
			<p>We suggest you thoroughly test any changes as modifying these files incorrectly can disrupt communication between the Cloudbeds API and the customized plugin, which may result in lost or incorrect reservations or errors.</p>
			<h3>Disclaimer</h3>
			<p>No support is provided to "Standalone" users. Cloudbeds customers can report issues through customer service contact points.</p>

			<p>The WP Mybookings plugin user is responsible for the purchase and installation of a SSL security certificate to reinforce the security of the transactions and (possibly) increase conversions - something we strongly recommend.</p>

			<p>The user and installer of this plugin understands and agrees that Cloudbeds will not be held responsible for any lost reservations, bookings, revenue, or any other communication through use of this plugin, customized or not.</p>
		</div>
	</div>
</div>
