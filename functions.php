<?php

  /* Define theme globals */
  defined('WPNA_VERSION') or define('WPNA_VERSION', '0.1.0');

  /* WP New Angle only works in WordPress 4.1 or later */
  if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
    require get_template_directory() . '/inc/back-compat.php';
  }

  /* Install and Activate required WP Plugins */
  require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';
  function wpna_register_required_plugins() {

    $plugins = array(
      array(
        'name'      => 'WP REST API (WP API)',
        'slug'      => 'json-rest-api',
        'required'  => true,
      ),
      array(
        'name'      => 'Use Google Libraries',
        'slug'      => 'use-google-libraries',
        'required'  => false,
      )
    );

    $config = array(
      'menu'         => 'wpna-install-plugins',
      'has_notices'  => true,
      'dismissable'  => false,
      'is_automatic' => true,
      'strings'      => array(
        'notice_can_install_required'     => _n_noop( 'WP New Angle requires the following plugin: %1$s.', 'WP New Angle requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
        'notice_can_install_recommended'  => _n_noop( 'WP New Angle recommends the following plugin: %1$s.', 'WP New Angle recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
        'nag_type'                        => 'update-nag' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
      )
    );
    tgmpa( $plugins, $config );

  }
  add_action( 'tgmpa_register', 'wpna_register_required_plugins' );


  /* Setup the theme defaults and registers support for various WordPress features */
  function wpna_setup() {

    // Let WordPress manage the document title
  	add_theme_support( 'title-tag' );

  	// Enable support for Post Thumbnails on posts and pages
    add_theme_support( 'post-thumbnails' );
  	set_post_thumbnail_size( 825, 510, true );

  	// This theme uses wp_nav_menu() in two locations.
  	register_nav_menus( array(
  		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
  		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),
  	) );

  	// Enable HTML5 core markup for search form, comment form, and comments
  	add_theme_support( 'html5', array(
  	   'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
  	) );

  }
  add_action( 'after_setup_theme', 'wpna_setup' );


  /* Load Styles and Scripts */
  function wpna_load_styles_scripts() {

    wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.1' );
    wp_enqueue_style( 'wpna-style', get_stylesheet_directory_uri() . '/css/wpna-main.css', array(), WPNA_VERSION );

    wp_enqueue_script(
      'modernizr-respond', get_stylesheet_directory_uri() . '/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js', array( 'jquery' )
  	);
    wp_enqueue_script(
      'angular-script', get_stylesheet_directory_uri() . '/js/vendor/angular.min.js', array( 'jquery' ), '1.4.2', true
  	);
    wp_enqueue_script(
      'bootstrap-script', get_stylesheet_directory_uri() . '/js/vendor/bootstrap.min.js', array( 'jquery' ), '3.3.1', true
  	);
    wp_enqueue_script(
      'wpna-script', get_stylesheet_directory_uri() . '/js/wpna-main.js', array( 'jquery' ), WPNA_VERSION, true
  	);
  }
  add_action( 'wp_enqueue_scripts', 'wpna_load_styles_scripts' );
