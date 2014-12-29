<?php

/**
 * Followgram Widgets
 *
 * @class           WPXFollowgramWidget
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2012 wpXtreme Inc. All Rights Reserved.
 * @date            2013-11-08
 * @version         1.1.0
 *
 */
class WPXFollowgramWidget extends WPDKWidget {

  /**
   * Create an instance of WPXFollowgramWidget class
   *
   * @return WPXFollowgramWidget
   */
  public function __construct()
  {
    $widget_ops = array(
      'classname'   => 'wpx-followgram',
      'description' => __( 'Displays Followgram profile.', WPXFOLLOWGRAM_TEXTDOMAIN )
    );

    $control_ops = array(
      'width'        => 400,
      'height'       => 350,
      'wpdk_icon'    => WPXFOLLOWGRAM_URL_IMAGES . 'logo-16x16.png',
      'wpdk_version' => WPXFOLLOWGRAM_VERSION,
    );

    wp_enqueue_style( 'wpxfg-widget', WPXFOLLOWGRAM_URL_CSS . 'wpxfg-widget.css', false, WPXFOLLOWGRAM_VERSION );

    parent::__construct( 'wpx-followgram-widget', __( 'Followgram', WPXFOLLOWGRAM_TEXTDOMAIN ), $widget_ops, $control_ops );

  }

  /**
   * Echo the widget content.
   * Subclasses should over-ride this function to generate their widget code.
   *
   * @param array $args     Display arguments including before_title, after_title, before_widget, and after_widget.
   * @param array $instance The settings for the particular instance of the widget
   */
  public function widget( $args, $instance )
  {

    // Init variable for extract.
    $after_title   = '';
    $after_widget  = '';
    $before_widget = '';
    $before_title  = '';

    // Etract, see above.
    extract( $args );

    // Get the title.
    $title = apply_filters( 'widget_title', $instance['title'] );

    // Photo number.
    $photo_number = $instance['photo_number'];

    // Photo size.
    $photo_size = $instance['size'];

    // Get cached duration.
    $enabled_cache = $instance['enabled_cache'];
    $cacheduration = empty( $instance['cacheduration'] ) ? 3600 : $instance['cacheduration'];

    // Check for cached transient.
    $transient_name = sprintf( 'wpxf_%s', WPXFollowgramPreferences::init()->account->user_id );
    $profile        = get_transient( $transient_name );
    if ( empty( $profile ) || 'on' !== $enabled_cache ) {

      // Get data profile.
      $profile   = $this->getProfile();
      $serialize = json_encode( $profile );
      if ( 'on' === $enabled_cache ) {
        set_transient( $transient_name, $serialize, $cacheduration );
      }
    }
    else {
      $profile = json_decode( $profile );
    }

    if ( false !== $profile ) {

      // Get some useful properties.
      $followgram_link = sprintf( 'http://followgram.me/%s', $profile->info->username );

      // Include custom style sheets.
      $theme = $instance['theme'];
      $style = file_get_contents( WPXFOLLOWGRAM_PATH_CSS . $theme );
      printf( '<style type="text/css">%s</style>', $style );

      // Standard WordPress.
      echo $before_widget;

      if ( ! empty( $title ) ) {
        echo $before_title . $title . $after_title;
      }

      // Custom markup.
      ?>
      <div class="wpx-followgram-widget clearfix">
      <div class="wpx-followgram-profile clearfix">
        <a class="wpx-followgram-profile-image" href="<?php echo $followgram_link ?>">
          <img src="<?php echo $profile->info->profile_picture ?>"
               alt="<?php echo $profile->info->full_name ?>" />
        </a>
        <a class="wpx-followgram-profile-name" href="<?php echo $followgram_link ?>">
          <?php echo $profile->info->full_name ?> <span>on</span><br /><span>instagram</span>
        </a>
      </div>

      <table class="wpx-followgram-infos" border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <a href="<?php echo $followgram_link ?>">
              <span class="wpx-followgram-count"><?php echo $profile->info->counts->media ?></span>
              <span>Photo</span>
            </a></td>
          <td>
            <a href="<?php echo $followgram_link ?>/following">
              <span class="wpx-followgram-count"><?php echo $profile->info->counts->follows ?></span>
              <span>Following</span>
            </a>
          </td>
          <td>
            <a href="<?php echo $followgram_link ?>/follower">
              <span class="wpx-followgram-count"><?php echo $profile->info->counts->followed_by ?></span>
              <span>Follower</span>
            </a>
          </td>
        </tr>
      </table>

      <div class="wpx-followgram-photos clearfix">

        <?php
        $count = 1;
        foreach ( $profile->photos as $photo ) : ?>
          <a href="http://followgram.me/i/<?php echo $photo->id ?>" target="_blank">
            <img class="<?php echo $photo_size ?>"
                 src="<?php echo $photo->images->low_resolution->url ?>"
                 alt="<?php echo $photo->caption->text ?>'"
                 title="<?php echo $photo->caption->text ?>'"
                 border="0" />
          </a>
          <?php if ( ++$count > $photo_number ) {
            break;
          } ?>
        <?php endforeach; ?>
      </div>

      <div class="wpx-follogram-firm clearfix">
        <a rel="<?php echo WPXFollowgramPreferences::init()->account->user_id ?>"
           href="http://followgram.me/<?php echo $profile->info->username ?>"
           username="<?php echo $profile->info->username ?>"
           class="followgrambutton">@<?php echo $profile->info->username ?></a>
        <script src="http://external.followgram.me/v1/follow/js/" type="text/javascript"></script>

      </div>

      <div class="wpx-followgram-visit clearfix">
        Visit <a href="http://followgram.me">Followgram.me</a>
      </div>

    </div>

      <?php
      echo $after_widget;
    }

    // Can't get the profile.
    else {
      _e( 'Please, check your backend settings! Can\'t get the instagram profile information.', WPXFOLLOWGRAM_TEXTDOMAIN );
    }
  }

  /**
   * Update a particular instance.
   * This function should check that $new_instance is set correctly.
   * The newly calculated value of $instance should be returned.
   * If "false" is returned, the instance won't be saved/updated.
   *
   * @param array $new_instance New settings for this instance as input by the user via form()
   * @param array $old_instance Old settings for this instance
   *
   * @return array Settings to save or bool false to cancel saving
   */
  public function update( $new_instance, $old_instance )
  {
    $old_instance['title']         = ( $new_instance['title'] );
    $old_instance['size']          = esc_attr( $new_instance['size'] );
    $old_instance['photo_number']  = ! empty( $new_instance['photo_number'] ) ? absint( esc_attr( $new_instance['photo_number'] ) ) : '4';
    $old_instance['enabled_cache'] = isset( $new_instance['enabled_cache'] ) ? $new_instance['enabled_cache'] : '';
    $old_instance['cacheduration'] = $new_instance['cacheduration'];
    $old_instance['theme']         = $new_instance['theme'];

    return $old_instance;
  }

  /**
   * Echo the settings update form
   *
   * @param array $instance Current settings
   *
   * @return void
   */
  public function form( $instance )
  {
    $instance = wp_parse_args( $instance, $this->defaults() );

    // View form.
    $view = new WPXFollowgramWidgetView( $this, $instance );
    $view->display();

  }

  /**
   * Return a key values pairs array with the default widget settings
   *
   * @return array
   */
  private function defaults()
  {
    $defaults = array(
      'title'         => __( 'My instagrams', WPXFOLLOWGRAM_TEXTDOMAIN ),
      'size'          => 'small',
      'photo_number'  => '4',
      'theme'         => 'wpxfollowgram-widget-default.min.css',
      'enabled_cache' => 'on',
      'cacheduration' => 3600,
    );

    return $defaults;
  }

  /**
   * Get the user profile
   *
   * @return mixed
   */
  private function getProfile()
  {

    // Check configuration.
    if ( ! empty( WPXFollowgramPreferences::init()->account->user_id ) &&
         ! empty( WPXFollowgramPreferences::init()->account->api_key )
    ) {
      $api  = new WPXFollowgramAPI();
      $args = array(
        'userid' => WPXFollowgramPreferences::init()->account->user_id,
        'token'  => WPXFollowgramPreferences::init()->account->api_key
      );

      $response = $api->request( 'user/info/?clientid=' . WPXFollowgramAPI::FOLLOWGRAM_ID, $args );

      if ( ! is_wp_error( $response ) && $response['response']['code'] < 400 && $response['response']['code'] >= 200
      ) {
        $data = json_decode( $response['body'] );

        return $data->data;
      }
    }

    return false;
  }

}


/**
 * View for widget settings
 *
 * @class              WPXFollowgramWidgetView
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012 wpXtreme Inc. All Rights Reserved.
 * @date               2012-12--16
 * @version            1.0.0
 */
class WPXFollowgramWidgetView extends WPDKView {

  /**
   * Pointer to the main Widget
   *
   * @brief Widget
   *
   * @var WPXFollowgramWidget $_widget
   */
  private $_widget;

  /**
   * Array with the widget settings values
   *
   * @brief Widget settings values
   *
   * @var array $_instance
   */
  private $_instance;

  /**
   * Create an instance of WPXFollowgramWidgetView class
   *
   * @brief Construct
   *
   * @param WPXFollowgramWidget $widget
   * @param array|string        $instance
   */
  public function __construct( $widget, $instance )
  {
    parent::__construct( 'wpx-followgram-widget' );

    $this->_widget   = $widget;
    $this->_instance = $instance;
  }

  /**
   * @brief Return the Controls Layout Array
   *
   * @return array
   */
  private function fields()
  {
    /**
     * Pointer to the main Widget
     *
     * @brief Widget
     *
     * @var WPXFollowgramWidget $widget
     */
    $widget = $this->_widget;

    $fields = array(
      __( 'Appearance', WPXFOLLOWGRAM_TEXTDOMAIN )    => array(
        array(
          array(
            'type'        => WPDKUIControlType::TEXT,
            'name'        => $widget->get_field_name( 'title' ),
            'value'       => $this->_instance['title'],
            'label'       => __( 'Title', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'size'        => 24,
            'title'       => __( 'This title will be displayed in frontend', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'placeholder' => __( 'Title in frontend', WPXFOLLOWGRAM_TEXTDOMAIN ),
          )
        ),
        array(
          array(
            'type'    => WPDKUIControlType::SELECT,
            'name'    => $widget->get_field_name( 'size' ),
            'value'   => $this->_instance['size'],
            'label'   => __( 'Picture size', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'options' => array(
              'small'  => __( 'Small', WPXFOLLOWGRAM_TEXTDOMAIN ),
              'medium' => __( 'Medium', WPXFOLLOWGRAM_TEXTDOMAIN ),
              'large'  => __( 'Large', WPXFOLLOWGRAM_TEXTDOMAIN ),
            ),
            'append'  => __( 'pixel', WPXFOLLOWGRAM_TEXTDOMAIN ),
          )
        ),
        array(
          array(
            'type'  => WPDKUIControlType::NUMBER,
            'name'  => $widget->get_field_name( 'photo_number' ),
            'value' => empty( $this->_instance['photo_number'] ) ? 4 : $this->_instance['photo_number'],
            'label' => __( 'Photo number', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'min'   => 4,
            'max'   => 16,
            'title' => __( 'Number of photo to display: min 4 max 16', WPXFOLLOWGRAM_TEXTDOMAIN ),
          )
        ),
        array(
          array(
            'type'    => WPDKUIControlType::SELECT,
            'name'    => $widget->get_field_name( 'theme' ),
            'value'   => $this->_instance['theme'],
            'label'   => __( 'Theme', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'options' => array(
              'wpxfollowgram-widget-default.min.css'  => __( 'Default', WPXFOLLOWGRAM_TEXTDOMAIN ),
              'wpxfollowgram-widget-darkness.min.css' => __( 'Darkness', WPXFOLLOWGRAM_TEXTDOMAIN ),
            ),
          )
        ),
      ),
      __( 'Advance cache', WPXFOLLOWGRAM_TEXTDOMAIN ) => array(
        array(
          array(
            'type'    => WPDKUIControlType::CHECKBOX,
            'name'    => $widget->get_field_name( 'enabled_cache' ),
            'value'   => 'on',
            'checked' => $this->_instance['enabled_cache'],
            'label'   => __( 'Enable cache', WPXFOLLOWGRAM_TEXTDOMAIN ),
          )
        ),
        array(
          array(
            'type'    => WPDKUIControlType::SELECT,
            'name'    => $widget->get_field_name( 'cacheduration' ),
            'value'   => $this->_instance['cacheduration'],
            'label'   => __( 'Duration', WPXFOLLOWGRAM_TEXTDOMAIN ),
            'options' => array(
              '900'   => __( '15 minutes', WPXFOLLOWGRAM_TEXTDOMAIN ),
              '1800'  => __( '30 minutes', WPXFOLLOWGRAM_TEXTDOMAIN ),
              '3600'  => __( '1 hour', WPXFOLLOWGRAM_TEXTDOMAIN ),
              '21600' => __( '6 hours', WPXFOLLOWGRAM_TEXTDOMAIN ),
            ),
          )
        ),
      )

    );

    return $fields;
  }

  /**
   * @brief Override draw
   */
  public function draw()
  {
    $layout = new WPDKUIControlsLayout( $this->fields() );
    $layout->display();
  }

}