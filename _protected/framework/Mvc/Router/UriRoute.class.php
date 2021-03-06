<?php
/**
 * @title            Uri Router Class
 * @desc             Uri Router for the URL rewrite
 *
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license          GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package          PH7 / Framework / Mvc / Router
 * @version          1.0
 */

namespace PH7\Framework\Mvc\Router;
defined('PH7') or exit('Restricted access');

use PH7\Framework\Parse\Url;

class UriRoute
{

    /**
     * @staticvar boolean $_bFullClean If you need to completely clean URL.
     */
    private static $_bFullClean;

    /**
     * Private constructor to prevent instantiation of class since it is a private class.
     *
     * @access private
     */
    private function __construct() {}

    /**
     * Load route file.
     *
     * @param string \DOMDocument $oDom
     * @return object \DOMDocument
     * @throws \PH7\Framework\File\Exception If the file is not found.
     */
    public static function loadFile(\DOMDocument $oDom)
    {
        $sPathDefaultLang = PH7_PATH_APP_CONFIG . 'routes/' . PH7_DEFAULT_LANG_CODE . '.xml';
        $sPathLangName = PH7_PATH_APP_CONFIG . 'routes/' . PH7_LANG_CODE . '.xml';

        if (is_file($sPathLangName))
            $sRoutePath = $sPathLangName;
        elseif (is_file($sPathDefaultLang))
            $sRoutePath = $sPathDefaultLang;
        else
            throw new \PH7\Framework\File\Exception('File route xml not found: ' . $sPathDefaultLang);

        $sContents = file_get_contents($sRoutePath); // Get the XML contents
        $sContents = static::_parseVariable($sContents); // Parse the variables
        $oDom->loadXML($sContents); // Load the XML contents

        return $oDom;
    }

    /**
     * @param string $sModule
     * @param string $sController
     * @param string $sAction
     * @param string $sVars Default NULL
     * @param boolean $bFullClean Default TRUE
     * @return string
     */
    public static function get($sModule, $sController, $sAction, $sVars = null, $bFullClean = true)
    {
        static::$_bFullClean = $bFullClean;
        $sUrl = static::_uri( array('module' => $sModule, 'controller' => $sController, 'action' => $sAction, 'vars' => $sVars) );
        return $sUrl;
    }

    /**
     * @access private
     * @param array $aParams
     * @return string
     * @throws \PH7\Framework\File\Exception If the XML file is not found.
     */
    private static function _uri(array $aParams)
    {
        $sModule = $aParams['module'];
        $sController = $aParams['controller'];
        $sAction = $aParams['action'];
        $sVars = ''; // Default value

        if (!empty($aParams['vars']))
        {
            // Removes the comma which are part of a sentence and not the url parameters
            $aParams['vars'] = str_replace(array(', ', ' ,'), '', $aParams['vars']);

            $aVar = explode(',', $aParams['vars']);
            foreach ($aVar as $sKey => $sVal)
                $sVars .= '/' . $sVal;
            unset($aVar);

            $sVars = Url::clean($sVars, static::$_bFullClean);

        }

        $oUrl = static::loadFile(new \DOMDocument);
        foreach ($oUrl->getElementsByTagName('route') as $oRoute)
        {
            if (preg_match('#^' . $oRoute->getAttribute('module') . '$#', $sModule) && preg_match('#^' . $oRoute->getAttribute('controller') . '$#', $sController) && preg_match('#^' . $oRoute->getAttribute('action') . '$#', $sAction))
            {
                // Strip the special characters
                $sUri = $oRoute->getAttribute('url');
                $sUri = str_replace('\\', '', $sUri);
                $sUri = preg_replace('#\(.+\)#', '', $sUri);
                $sUri = preg_replace('#([/\?]+)$#', '',$sUri);
                return PH7_URL_ROOT . $sUri . $sVars;
            }
        }
        unset($oUrl);

        return PH7_URL_ROOT . "$sModule/$sController/$sAction$sVars";
    }

    /**
     * Parse the variables route.
     *
     * @access private
     * @param string $sContents
     * @return string The contents parsed.
     */
    private static function _parseVariable($sContents)
    {
        /**
         * Replace the "[$page_ext]" variable by the "PH7_PAGE_EXT" constant.
         *
         * @internal We add a slash for RegEx ignores the dot (e.g., '.'html), (in RegEx, the dot means "any single character").
         */
        $sContents = str_replace('[$page_ext]', '\\' . PH7_PAGE_EXT, $sContents);

        /**
         * Replace the "[$admin_mod]" variable by the "PH7_ADMIN_MOD" constant.
         */
        $sContents = str_replace('[$admin_mod]', PH7_ADMIN_MOD, $sContents);

        return $sContents;
    }



}
