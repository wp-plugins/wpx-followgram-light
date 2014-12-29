<?php

/**
 * The Followgram API class.
 * Used to manage the send and receive.
 *
 * @class           WPXFollowgramAPI
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012-2014 wpXtreme Inc. All Rights Reserved.
 * @date            2014-10-01
 * @version         1.0.1
 *
 */
class WPXFollowgramAPI {

  /**
   * The followgram ID for proxy
   */
  const FOLLOWGRAM_ID = '14a122ae27822cdb28cfccc6a879125c';

  /**
   * The API endpoint address on followgram server
   */
  const API_ENDPOINT = 'http://api2.followgram.me/';

  /**
   * Timeout connection request
   */
  const CONNECTION_TIMEOUT = 45;

  /**
   * The User Agent request
   */
  const USER_AGENT = 'wpx-followgram/1.0';

  // -------------------------------------------------------------------------------------------------------------------
  // Request
  // -------------------------------------------------------------------------------------------------------------------

  /**
   * Do a request to the wpXtreme Server.
   *
   * @param string $resource Resource, ie. `profile/user/11`
   * @param array  $args     (Optional) parameters
   *
   * @return WP_Error|array|bool The response or WP_Error on failure.
   */
  public function request( $resource, $args = array() )
  {

    // Casting to array
    if ( ! is_array( $args ) ) {
      $args = array( 'param' => $args );
    }

    // Prepare array for request.
    $params = array(
      'method'      => 'POST',
      'timeout'     => self::CONNECTION_TIMEOUT,
      'redirection' => 5,
      'httpversion' => '1.0',
      'user-agent'  => self::USER_AGENT,
      'blocking'    => true,
      'headers'     => array(),
      'cookies'     => array(),
      'body'        => $args,
      'compress'    => false,
      'decompress'  => true,
      'sslverify'   => true,
    );

    if ( ! empty( $resource ) ) {
      $endpoint = sprintf( '%s%s', trailingslashit( self::API_ENDPOINT ), $resource );
      $request  = wp_remote_request( $endpoint, $params );

      if ( 200 != wp_remote_retrieve_response_code( $request ) ) {
        return false;
      }

      return $request;
    }

    return false;
  }
}