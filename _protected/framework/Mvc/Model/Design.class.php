<?php
/**
 * @title            Design Model Class
 * @desc             Design Model for the HTML contents.
 *
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license          GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package          PH7 / Framework / Mvc / Model
 * @version          1.0
 */

namespace PH7\Framework\Mvc\Model;
defined('PH7') or exit('Restricted access');

use
PH7\Framework\Mvc\Model\Engine\Db,
PH7\Framework\Cache\Cache,
PH7\Framework\Parse\SysVar;

class Design extends \PH7\Framework\Layout\Html\Design
{
    const CACHE_STATIC_GROUP = 'db/design/static', CACHE_TIME = 172800;

    private $_oCache;

    public function __construct()
    {
        parent::__construct();
        $this->_oCache = new Cache;
    }

    public function langList()
    {
        $sCurrentPage = \PH7\Framework\Navigation\Page::cleanDynamicUrl('l');

        $oData = (new Lang)->getInfos();

        foreach ($oData as $sLang)
        {
            if ($sLang->langId === PH7_LANG_NAME) continue;

            // Retrieve only the first two characters
            $sAbbrLang = substr($sLang->langId,0,2);

            echo '<a href="', $sCurrentPage, $sLang->langId, '"><img src="', PH7_URL_STATIC, PH7_IMG, 'flag/s/', $sAbbrLang, '.gif" alt="', t($sAbbrLang),'" title="', t($sAbbrLang),'" /></a>';
        }

        unset($oData);
    }

    /**
     * Gets Ads with ORDER BY RAND() SQL aggregate function.
     * With caching, advertising changes every hour.
     *
     * @param integer $iWidth
     * @param integer $iHeight
     * @param boolean $bOnlyActive Default: TRUE
     * @return object Query
     */
    public function ads($iWidth, $iHeight, $bOnlyActive = true)
    {
        $this->_oCache->start(self::CACHE_STATIC_GROUP, 'ads' . $iWidth . $iHeight . $bOnlyActive, static::CACHE_TIME);

        if (!$oData = $this->_oCache->get())
        {
            $sSqlActive = ($bOnlyActive) ? 'AND (active=\'1\') ' : ' ';
            $rStmt = Db::getInstance()->prepare('SELECT * FROM ' . Db::prefix('Ads') . 'WHERE (width=:width) AND (height=:height)' . $sSqlActive . 'ORDER BY RAND() LIMIT 1');
            $rStmt->bindValue(':width', $iWidth, \PDO::PARAM_INT);
            $rStmt->bindValue(':height', $iHeight, \PDO::PARAM_INT);
            $rStmt->execute();
            $oData = $rStmt->fetch(\PDO::FETCH_OBJ);
            Db::free($rStmt);
            $this->_oCache->put($oData);
        }

        /**
         * Only if the administrator is not connected,
         * otherwise it doesn't make sense and tracking of advertising could reveal the URL of directors or retrieve sensitive data from the administrator, ...
         */
        if (!\PH7\AdminCore::auth() && $oData)
            echo \PH7\Framework\Ads\Ads::output($oData);

        unset($oData);
    }

    /**
     * Analytics API code.
     *
     * @param boolean $bPrint Echo the analytics HTML code. Default TRUE.
     * @param boolean $bOnlyActive Only active code. Default TRUE
     * @return mixed (string | void)
     */
    public function analyticsApi($bPrint = true, $bOnlyActive = true)
    {
        $this->_oCache->start(self::CACHE_STATIC_GROUP, 'analyticsApi' . $bOnlyActive, static::CACHE_TIME);

        if (!$sData = $this->_oCache->get())
        {
            $sSqlWhere = ($bOnlyActive) ? 'WHERE active=\'1\'' : '';
            $rStmt = Db::getInstance()->prepare('SELECT code FROM ' . Db::prefix('AnalyticsApi') . $sSqlWhere . ' LIMIT 1');
            $rStmt->execute();
            $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
            Db::free($rStmt);
            $sData = $oRow->code;
            unset($oRow);
            $this->_oCache->put($sData);
        }

        if ($bPrint)
            echo $sData;
        else
            return $sData;
    }

    /**
     * Get the custom code.
     *
     * @param string $sType  Choose between 'css' and 'js'.
     * @return string
     */
    public function customCode($sType)
    {
        $this->_oCache->start(self::CACHE_STATIC_GROUP, 'customCode' . $sType, static::CACHE_TIME);

        if (!$sData = $this->_oCache->get())
        {
            $rStmt = Db::getInstance()->prepare('SELECT code FROM ' . Db::prefix('CustomCode') . 'WHERE codeType = :type LIMIT 1');
            $rStmt->bindValue(':type', $sType, \PDO::PARAM_STR);
            $rStmt->execute();
            $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
            Db::free($rStmt);
            $sData = $oRow->code;
            unset($oRow);
            $this->_oCache->put($sData);
        }

        return $sData;
    }

    /**
     * Get CSS/JS files in their HTML tags.
     *
     * @param string $sType  Choose between 'css' and 'js'.
     * @param boolean $bOnlyActive Default: TRUE
     * @return void HTML output.
     */
    public function files($sType, $bOnlyActive = true)
    {
        $this->_oCache->start(self::CACHE_STATIC_GROUP, 'files' . $sType . $bOnlyActive, static::CACHE_TIME);

        if (!$oData = $this->_oCache->get())
        {
            $sSqlWhere = ($bOnlyActive) ? ' AND active=\'1\'' : '';
            $rStmt = Db::getInstance()->prepare('SELECT file FROM ' . Db::prefix('StaticFiles') . 'WHERE fileType = :type' . $sSqlWhere);
            $rStmt->bindValue(':type', $sType, \PDO::PARAM_STR);
            $rStmt->execute();
            $oData = $rStmt->fetch(\PDO::FETCH_OBJ);
            Db::free($rStmt);
            $this->_oCache->put($oData);
        }

        if (!empty($oData) && is_string($oData))
        {
            while ($oData)
            {
                $sFullPath = PH7_RELATIVE . 'templates/' . (new SysVar)->parse($oData->file);

                if ($sType == 'js')
                    $this->externalJsFile($sFullPath);
                else
                    $this->externalCssFile($sFullPath);
            }
        }

        unset($oData);
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->_oCache);
    }

}
