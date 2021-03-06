<?php
/**
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Core / Class / Design
 */
namespace PH7;

use PH7\Framework\Mvc\Router\UriRoute;

class LostPwdDesignCore
{

    /**
     * Private constructor to prevent instantiation of class since it's a static class.
     *
     * @access private
     */
    private function __construct() {}

    /**
     * Get the link "forgot password".
     *
     * @param string $sMod
     * @return void
     */
    public static function link($sMod)
    {
        echo '<a rel="nofollow" href="', UriRoute::get('lost-password','main','forgot',$sMod), '">', t('Forgot your password?'), '</a>';
    }

}
