<?php

/**
 * The intro view controller
 *
 * @class              WPXFollowgramIntroViewController
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               2013-09-03
 * @version            1.0.2
 *
 */
class WPXFollowgramIntroViewController extends WPDKViewController {

  /**
   * Return a singleton instance of WPXFollowgramIntroViewController class
   *
   * @brief Singleton
   *
   * @return WPXFollowgramIntroViewController
   */
  public static function init()
  {
    static $instance = null;
    if ( is_null( $instance ) ) {
      $instance = new self();
    }

    return $instance;
  }

  /**
   * Return an instance of WPXFollowgramIntroViewController class
   *
   * @brief Construct
   *
   * @return WPXFollowgramIntroViewController
   */
  public function __construct()
  {
    parent::__construct( 'wpxfollowgram-intro', __( 'Followgram', WPXTREME_TEXTDOMAIN ) );

    $view = new WPXFollowgramIntroView;
    $this->view->addSubview( $view );
  }

  /**
   * Fires when styles are printed for a specific admin page based on $hook_suffix.
   *
   * @since WP 2.6.0
   * @since 1.6.0
   */
  public function admin_print_styles()
  {
    wp_enqueue_style( 'wpxfg-admin', WPXFOLLOWGRAM_URL_CSS . 'wpxfg-admin.css', array(), WPXFOLLOWGRAM_VERSION );
  }

  /**
   * Loading scripts and styles
   *
   * @brief Brief
   */
  public function admin_head()
  {
    wp_enqueue_script( 'wpxfg-admin', WPXFOLLOWGRAM_URL_JAVASCRIPT .
                                      'wpxfg-admin.js', array( 'jquery' ), WPXFOLLOWGRAM_VERSION, true );
  }
}


/**
 * The intro View
 *
 * @class              WPXFollowgramIntroView
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               2013-09-03
 * @version            1.0.3
 *
 */
class WPXFollowgramIntroView extends WPDKView {

  /**
   * Return an instance of WPXFollowgramIntroView class
   *
   * @brief Construct
   *
   * @return WPXFollowgramIntroView
   */
  public function __construct()
  {
    parent::__construct( 'wpxfollowgram-intro', 'wpdk-border-container' );
  }


  /**
   * Display the view
   *
   * @brief Draw
   */
  public function draw()
  {
    ?>
    <h3><?php _e( 'Welcome to Followgram wpXtreme plugin for WordPress', WPXFOLLOWGRAM_TEXTDOMAIN ) ?></h3>
    <p><?php printf( __( 'In order to display your instragram images, go to <a href="%s">Widgets</a> menu and settings the <strong>Followgram</strong> widgets properties like shows below.', WPXFOLLOWGRAM_TEXTDOMAIN ), admin_url( 'widgets.php' ) ) ?></p>
    <p class="aligncenter">
    <img alt="<?php _e( 'Settings Widgets', WPXFOLLOWGRAM_TEXTDOMAIN ) ?>"
         src="<?php echo WPXFOLLOWGRAM_URL . 'screenshot-1.png' ?>" />
    <span><?php _e( 'Settings Widgets', WPXFOLLOWGRAM_TEXTDOMAIN ) ?></span>
  </p>
    <p class="aligncenter">
    <img alt="<?php _e( 'Choose your theme', WPXFOLLOWGRAM_TEXTDOMAIN ) ?>"
         src="<?php echo WPXFOLLOWGRAM_URL . 'screenshot-2.png' ?>" />
    <span><?php _e( 'Choose your theme', WPXFOLLOWGRAM_TEXTDOMAIN ) ?></span>
  </p>
  <?php
  }
}