<?php
/**
 * @title          Add Users; Processing Class
 *
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Module / Admin / From / Processing
 */
namespace PH7;
defined('PH7') or exit('Restricted access');

use
PH7\Framework\Util\Various,
PH7\Framework\Ip\Ip,
PH7\Framework\Mvc\Router\UriRoute,
PH7\Framework\Url\HeaderUrl;

class AddUserFormProcessing extends Form
{

    public function __construct()
    {
        parent::__construct();

        $sBirthDate = $this->dateTime->get($this->httpRequest->post('birth_date'))->date('Y-m-d');

        $aData = [
            'email' => $this->httpRequest->post('mail'),
            'username' => $this->httpRequest->post('username'),
            'password' => $this->httpRequest->post('password'),
            'first_name' => $this->httpRequest->post('first_name'),
            'last_name' => $this->httpRequest->post('last_name'),
            'middle_name' => $this->httpRequest->post('middle_name'),
            'sex' => $this->httpRequest->post('sex'),
            'match_sex' => $this->httpRequest->post('match_sex'),
            'birth_date' => $sBirthDate,
            'country' => $this->httpRequest->post('country'),
            'city' => $this->httpRequest->post('city'),
            'state' => $this->httpRequest->post('state'),
            'zip_code' => $this->httpRequest->post('zip_code'),
            'description' => $this->httpRequest->post('description'),
            'website' => $this->httpRequest->post('website'),
            'social_network_site' => $this->httpRequest->post('social_network_site'),
            'ip' => Ip::get(),
            'prefix_salt' => Various::genRnd(),
            'suffix_salt' => Various::genRnd()
        ];

        $iProfileId = (new UserCoreModel)->add($aData);
        if (!empty($_FILES['avatar']['tmp_name']))
            (new UserCore)->setAvatar($iProfileId, $aData['username'], $_FILES['avatar']['tmp_name'], 1);

        HeaderUrl::redirect(UriRoute::get(PH7_ADMIN_MOD, 'user', 'browse'), t('The user has been successfully added.'));
    }

}
