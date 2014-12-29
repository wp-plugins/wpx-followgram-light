jQuery( function ( $ )
{
  "use strict";

  /**
   * Description
   *
   * @class           WPXFollowgram
   * @author          =undo= <info@wpxtre.me>
   * @copyright       Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
   * @date            2013-12-18
   * @version         1.0.0
   *
   */
  window.WPXFollowgram = (function ()
  {

    /**
     * This Object
     *
     * @type {{}}
     */
    var $t = {
      version : '1.0.0',
      init    : _init
    };

    /**
     * Return an instance of WPXFollowgram object
     *
     * @private
     *
     * @return {}
     */
    function _init()
    {
      /* Your init here. */

      return $t;
    };

    return $t.init();

  })();

} );