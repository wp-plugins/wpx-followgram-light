<?php

/**
 * wpXtreme main Plugin Class.
 * This is the main class of plugin. This class extends WPDKWordPressPlugin in order to make easy several WordPress
 * funtions.
 *
 * @class              WPXFollowgram
 * @author             wpXtreme
 * @copyright          Copyright (C) 2013 wpXtreme Inc. All Rights Reserved.
 * @date               2013-09-03
 * @version            1.1.1
 *
 */
final class WPXFollowgram extends WPXPlugin {

  /**
   * Create and return a singleton instance of WPXFollowgram class
   *
   * @param string $file The main file of this plugin. Usually __FILE__ (main.php)
   *
   * @return WPXFollowgram
   */
  public static function boot( $file = null )
  {
    static $instance = null;
    if ( is_null( $instance ) && ( ! empty( $file ) ) ) {
      $instance = new self( $file );
    }

    return $instance;
  }

  /**
   * Create an instance of WPXFollowgram class
   *
   * @param string $file The main file of this plugin. Usually __FILE__ (main.php)
   *
   * @return WPXFollowgram object instance
   */
  public function __construct( $file = null )
  {
    parent::__construct( $file );
  }

  /**
   * Include all core file
   */
  public function classesAutoload()
  {
    $includes = array(
    	$this->classesPath . 'admin/wpxfg-admin.php' => 'WPXFollowgramAdmin',

    	$this->classesPath . 'admin/wpxfg-intro-viewcontroller.php' => array(
    		'WPXFollowgramIntroViewController',
    		'WPXFollowgramIntroView'
    		),

    	$this->classesPath . 'core/wpxfg-api.php' => 'WPXFollowgramAPI',

    	$this->classesPath . 'preferences/wpxfg-preferences-viewcontroller.php' => array(
    		'WPXFollowgramAccountPreferencesViewController',
    		'WPXFollowgramAccountPreferencesView'
    		),

    	$this->classesPath . 'preferences/wpxfg-preferences.php' => array(
    		'WPXFollowgramPreferences',
    		'WPXFollowgramAccountPreferencesBranch'
    		),

    	$this->classesPath . 'widgets/wpxfg-widget.php' => array(
    		'WPXFollowgramWidget',
    		'WPXFollowgramWidgetView'
    		)
    	);

    return $includes;
  }

  /**
   * Catch for admin
   */
  public function admin()
  {
    WPXFollowgramAdmin::init();
  }

  /**
   * Catch for activation. This method is called one shot.
   */
  public function activation()
  {
    WPXFollowgramPreferences::init()->delta();

    // Backward compatibility
    $old_configuration = get_option( 'wpx-followgram-config' );

    // If exisis an old configuration
    if( ! empty( $old_configuration ) ) {

      // Delete
      // TODO to remove on next
      delete_option( 'wpx-followgram-config' );
    }
  }

  /**
   * Called when the widget are init
   */
  public function widgets()
  {
    register_widget( 'WPXFollowgramWidget' );
  }

}