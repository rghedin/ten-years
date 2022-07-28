<?php

// Call style.css from parent Twenty Nineteen.
add_action( 'wp_enqueue_scripts', 'tnt_enqueue_parent_styles' );
function tnt_enqueue_parent_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

// Disable Gutenberg on the back end.
add_filter( 'use_block_editor_for_post', '__return_false' );

// Disable Gutenberg for widgets.
add_filter( 'use_widgets_blog_editor', '__return_false' );

add_action( 'wp_enqueue_scripts', function() {
    // Remove CSS on the front end.
	wp_dequeue_style( 'wp-block-library' );

    // Remove Gutenberg theme.
	wp_dequeue_style( 'wp-block-library-theme' );

    // Remove inline global CSS on the front end.
	wp_dequeue_style( 'global-styles' );

    // Remove Seriously Simple Podcasting blocks styles.
	wp_dequeue_style( 'ssp-block-style' );
	wp_dequeue_style( 'ssp-block-fonts-style' );
	wp_dequeue_style( 'ssp-block-gizmo-fonts-style' );
	wp_dequeue_style( 'ssp-recent-episodes' );

}, 20 );


// Enable support for Post Formats.
add_theme_support( 'post-formats', array(
	'aside', 'quote', 'image', 'link'
) );


// Remove emoji from WordPress' core.
function disable_wp_emojicons() {

	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}


// Remove website field from comment form.
add_filter('comment_form_default_fields', 'unset_url_field');
function unset_url_field($fields){
	if(isset($fields['url']))
		unset($fields['url']);
	return $fields;
}


// Head & footer cleanup.
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'twentynineteen-print-style-css');

add_filter( 'wp_enqueue_scripts', 'change_default_jquery', PHP_INT_MAX );
function change_default_jquery( ){
	wp_dequeue_script( 'jquery');
	wp_deregister_script( 'jquery');
}

function wpassist_dequeue_scripts(){
	wp_deregister_script('wp-embed');
}
add_action( 'wp_enqueue_scripts', 'wpassist_dequeue_scripts' );

global $ss_podcasting;
remove_action( 'wp_print_footer_scripts', array( $ss_podcasting, 'html5_player_conditional_scripts' ) );
remove_action( 'wp_print_footer_scripts', array( $ss_podcasting, 'html5_player_styles' ) );
remove_action( 'wp_enqueue_scripts', array( $ss_podcasting, 'load_scripts' ) );
remove_action( 'wp_footer', array( $ss_podcasting, 'ssp_override_player_styles' ) );


// Remove comments' feed.
function return_false() {
	return false;
}
add_filter('feed_links_show_comments_feed', 'return_false');


// Replace WordPress logo on login/signup page.
function my_login_logo_one() { ?>
	<style type="text/css">
		body.login div#login h1 a {
			background-image: url(https://manualdousuario.net/wp-content/uploads/2019/12/manual-do-usuário-logo.png);
			padding-bottom: 30px;
		}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo_one' );


// Remove language selector in wp-login.php
add_filter( 'login_display_language_dropdown', '__return_false' );


// Remove search box placeholder
add_filter( 'get_search_form', 'rlv_search_form' );
function rlv_search_form( $form ) {
	$form = str_replace( 'Pesquisar &hellip;', '', $form );
	return $form;
}


// Fix too sensistive reply link in comments.
function fix_reply_link_comments() {  
	if ( have_comments() ) { ?>
		<script type="text/javascript">
			window.addEventListener('load', function() {
				document.getElementById('comments').addEventListener('touchstart', function(e) {
					if( e.target.className === 'comment-reply-link' ) {
						e.stopPropagation();
					}
				}, true);
			});
		</script>
	<?php } 
}
add_action('wp_footer', 'fix_reply_link_comments'); 


// Calls Littlefoot
function calls_littlefoot() { 
	if ( is_singular() ) { ?>
		<script
		src="/wp-content/themes/twentynineteen-child/littlefoot.js"
		type="application/javascript"
		></script>
		<script type="application/javascript">
			littlefoot.default()
		</script>
	<?php }
}
add_action('wp_footer', 'calls_littlefoot'); 


// Custom favicons
function calls_better_favicon() { ?>
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#000000">
	<meta name="msapplication-TileColor" content="#f3f3f3">
	<meta name="theme-color" media="(prefers-color-scheme: light)" content="#FFFFFF">
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#000000">
	<?php } 
add_action('wp_head', 'calls_better_favicon'); 


// Chatwoot widget
function calls_txtme() { 
	if ( is_page(20602) ) { ?>
    <script>
      (function(d,t) {
        var BASE_URL="https://app.chatwoot.com";
        var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=BASE_URL+"/packs/js/sdk.js";
        g.defer = true;
        g.async = true;
        s.parentNode.insertBefore(g,s);
        g.onload=function(){
          window.chatwootSDK.run({
            websiteToken: 'cmHCiMKoVvMUPHPBd8Y6wSRi',
            baseUrl: BASE_URL
          })
        }
      })(document,"script");
    </script>
	<?php }
}
add_action('wp_footer', 'calls_txtme'); 