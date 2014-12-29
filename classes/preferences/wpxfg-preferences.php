<?php

/**
 * Main model for WPXFollowgram Preferences
 *
 * @class           WPXFollowgramPreferences
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2014 wpXtreme Inc. All Rights Reserved.
 * @date            2014-10-01
 * @version         1.0.0
 *
 */
class WPXFollowgramPreferences extends WPDKPreferences {

  /**
   * The Preferences name used on database
   *
   * @brief Preferences name
   *
   * @var string
   */
  const PREFERENCES_NAME = 'wpxfg-followgram-preferences';

  /**
   * Your preferences property
   *
   * @brief Preferences version
   *
   * @var string $version
   */
  public $version = WPXFOLLOWGRAM_VERSION;

  /**
   * An instance of WPXFollowgramAccountPreferencesBranch class.
   *
   * @var WPXFollowgramAccountPreferencesBranch $account
   */
  public $account;

  /**
   * Return an instance of WPXFollowgramPreferences class from the database or onfly.
   *
   * @brief Get the preferences
   *
   * @return WPXFollowgramPreferences
   */
  public static function init()
  {
    return parent::init( self::PREFERENCES_NAME, __CLASS__, WPXFOLLOWGRAM_VERSION );
  }

  /**
   * Set the default preferences
   *
   * @brief Default preferences
   */
  public function defaults()
  {
    $this->account = new WPXFollowgramAccountPreferencesBranch;
  }

}

/**
 * Account preferences branch model
 *
 * @class           WPXFollowgramAccountPreferencesBranch
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2014 wpXtreme Inc. All Rights Reserved.
 * @date            2014-10-01
 * @version         1.0.0
 *
 */
class WPXFollowgramAccountPreferencesBranch extends WPDKPreferencesBranch {

  const USER_ID = 'user_id';
  const API_KEY = 'api_key';

  /**
   * User id
   *
   * @var string $user_id
   */
  public $user_id;

  /**
   * API Key
   *
   * @var string $api_key
   */
  public $api_key;

  /**
   * Reset to defaults values
   *
   * @brief Reset to default
   */
  public function defaults()
  {
    $this->user_id = '';
    $this->api_key = '';
  }

  /**
   * Update this branch
   *
   * @brief Update
   */
  public function update()
  {
    $this->user_id = esc_attr( $_POST[ self::USER_ID ] );
    $this->api_key = esc_attr( $_POST[ self::API_KEY ] );
  }
}