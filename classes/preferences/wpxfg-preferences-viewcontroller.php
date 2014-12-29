<?php

/**
 * Followgram preferences view controller
 *
 * @class              WPXFollowgramAccountPreferencesViewController
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2014 wpXtreme Inc. All Rights Reserved.
 * @date               2014-10-01
 * @version            1.0.0
 *
 */
class WPXFollowgramAccountPreferencesViewController extends WPDKPreferencesViewController {

  /**
   * Return a singleton instance of WPXMailManagerPreferencesViewController class
   *
   * @return WPXMailManagerPreferencesViewController
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
   * Create an instance of WPXFollowgramAccountPreferencesViewController class
   *
   * @return WPXFollowgramAccountPreferencesViewController
   */
  public function __construct()
  {

    // Single instances of tab content
    $account = new WPXFollowgramAccountPreferencesView();

    // Create each single tab
    $tabs = array(
      new WPDKjQueryTab( $account->id, __( 'Store', WPXFOLLOWGRAM_TEXTDOMAIN ), $account->html() ),
    );

    parent::__construct( WPXFollowgramPreferences::init(), __( 'Preferences', WPXFOLLOWGRAM_TEXTDOMAIN ), $tabs );

  }

  /**
   * Fires when styles are printed for a specific admin page based on $hook_suffix.
   *
   * @since WP 2.6.0
   */
  public function admin_print_styles()
  {
    wp_enqueue_style( 'wpxfg-admin', WPXFOLLOWGRAM_URL_CSS . 'wpxfg-admin.css', array(), WPXFOLLOWGRAM_VERSION );
  }
}

/**
 * Followgram account preferences view
 *
 * @class           WPXFollowgramAccountPreferencesView
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2014 wpXtreme Inc. All Rights Reserved.
 * @date            2014-10-01
 * @version         1.0.0
 *
 */
class WPXFollowgramAccountPreferencesView extends WPDKPreferencesView {

  /**
   * Create an instance of WPXFollowgramAccountPreferencesView class
   *
   * @return WPXFollowgramAccountPreferencesView
   */
  public function __construct()
  {
    $preferences = WPXFollowgramPreferences::init();
    parent::__construct( $preferences, 'account' );
  }

  /**
   * Return a sdf array for form fields
   *
   * @param WPXFollowgramAccountPreferencesBranch $account
   *
   * @return array
   */
  public function fields( $account )
  {

    $fields = array(
      __( 'API keys', WPXFOLLOWGRAM_TEXTDOMAIN ) => array(
        array(
          array(
            'type'        => WPDKUIControlType::TEXT,
            'name'        => WPXFollowgramAccountPreferencesBranch::USER_ID,
            'value'       => $account->user_id,
            'label'       => __( 'UserID', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'size'        => 48,
            'title'       => __( 'This is your Followgram UserID', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'placeholder' => __( 'Your Followgram UserID', WPXFOLLOWGRAM_TEXTDOMAIN ),
          )
        ),
        ( empty( $account->user_id ) ) ? array(
          array(
            'type'           => WPDKUIControlType::ALERT,
            'alert_type'     => WPDKUIAlertType::WARNING,
            'dismiss_button' => false,
            'title'          => WPDKGlyphIcons::html( WPDKGlyphIcons::ATTENTION ) .
                                __( 'Warning!', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'value'          => __( 'You have to set the your Followgram account in order to display your photos.', WPXFOLLOWGRAM_TEXTDOMAIN ),
          )
        ) : '',
        array(
          array(
            'type'        => WPDKUIControlType::TEXT,
            'name'        => WPXFollowgramAccountPreferencesBranch::API_KEY,
            'value'       => $account->api_key,
            'label'       => __( 'API key', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'placeholder' => __( 'Your Followgram API KEY', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'size'        => 48,
            'title'       => __( 'Your Followgram API key', WPXFOLLOWGRAM_TEXTDOMAIN ),
          )
        ),
        ( empty( $account->api_key ) ) ? array(
          array(
            'type'           => WPDKUIControlType::ALERT,
            'alert_type'     => WPDKUIAlertType::WARNING,
            'dismiss_button' => false,
            'title'          => WPDKGlyphIcons::html( WPDKGlyphIcons::ATTENTION ) .
                                __( 'Warning!', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'value'          => __( 'You have to set the your Followgram API KEY in order to display your photos.', WPXFOLLOWGRAM_TEXTDOMAIN ),
          )
        ) : '',

      ),
    );

    return $fields;
  }
}