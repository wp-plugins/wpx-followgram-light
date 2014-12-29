<?php

/**
 * Followgram admin class
 *
 * @class              WPXFollowgramAdmin
 * @author             wpXtreme, Inc.
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               2013-10-18
 * @version            1.0.3
 *
 */

final class WPXFollowgramAdmin extends WPDKWordPressAdmin {

  /**
   * This is the minumun capability required to display admin menu item
   */
  const MENU_CAPABILITY = 'manage_options';

  /**
   * Return a singleton instance of WPXFollowgramAdmin class
   *
   * @return WPXFollowgramAdmin
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
   * Create an instance of WPXFollowgramAdmin class
   *
   * @return WPXFollowgramAdmin
   */
  public function __construct()
  {
    /**
     * @var WPXFollowgram $plugin
     */
    $plugin = $GLOBALS['WPXFollowgram'];
    parent::__construct( $plugin );

    /* Plugin column in Plugin List view. */
    add_action( 'plugin_action_links_' . $this->plugin->pluginBasename, array( $this, 'plugin_action_links' ), 10, 4 );

    /* Description column in Plugin List view. */
    add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );

  }

  /**
   * Return an HTML markup link to add in Plugin column in Plugin List.
   *
   * @param array $links
   *
   * @return array
   */
  public function plugin_action_links( $links )
  {
    $links[] = '<a href="' . admin_url( 'widgets.php' ) . '" target="_blank">' .
      __( 'Visit Followgram', WPXFOLLOWGRAM_TEXTDOMAIN ) . '</a>';
    return $links;
  }

  /**
   * Return an HTML markup link to add in Plugin column in Plugin List.
   *
   * @param array  $links Links array
   * @param string $file  Plugin path/main_file.php
   *
   * @return array
   */
  public function plugin_row_meta( $links, $file )
  {
    /* am I? */
    if ( $file == $this->plugin->pluginBasename ) {
      $links[] =
        '<a href="http://followgram.me" target="_blank">' . __( 'Visit Followgram', WPXFOLLOWGRAM_TEXTDOMAIN ) . '</a>';
    }
    return $links;
  }

  /**
   * Called when WordPress is ready to build the admin menu.
   * Sample hot to build a simple menu.
   */
  public function admin_menu()
  {

    // Hack for wpXtreme icon.
    $icon_menu = $this->plugin->imagesURL . 'logo-16x16.png';

    $menus = array(
      'wpxfollowgram_menu' => array(
        'menuTitle'  => __( 'Followgram', WPXFOLLOWGRAM_TEXTDOMAIN ),
        'capability' => self::MENU_CAPABILITY,
        'icon'       => $icon_menu,
        'subMenus'   => array(
          array(
            'menuTitle'      => __( 'Account Settings', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'capability'     => self::MENU_CAPABILITY,
            'viewController' => 'WPXFollowgramAccountPreferencesViewController',
          ),
          WPDKSubMenuDivider::DIVIDER,
          array(
            'menuTitle'      => __( 'Widget', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'capability'     => self::MENU_CAPABILITY,
            'viewController' => 'WPXFollowgramIntroViewController',
          ),
        )
      )
    );

    WPXMenu::init( $menus, $this->plugin );
  }

}