<?php
/**
 * @title          User Model
 *
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7/ App / System / Module / User / Model
 * @version        1.0
 */
namespace PH7;

use PH7\Framework\Security\Security, PH7\Framework\Mvc\Model\Engine\Db;

class UserModel extends UserCoreModel
{

    /**
     * Join Step 1
     *
     * @param array $aData
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function join(array $aData)
    {
        $rStmt = Db::getInstance()->prepare('INSERT INTO' . Db::prefix('Members') .
            '(email, username, password, firstName, reference, active, ip, hashValidation, prefixSalt, suffixSalt, joinDate, lastActivity, groupId)
        VALUES (:email, :username, :password, :firstName, :reference, :active, :ip, :hashValidation, :prefixSalt, :suffixSalt, :joinDate, :lastActivity, :groupId)');
        $rStmt->bindValue(':email', $aData['email'], \PDO::PARAM_STR);
        $rStmt->bindValue(':username', $aData['username'], \PDO::PARAM_STR);
        $rStmt->bindParam(':password', Security::hashPwd($aData['prefix_salt'], $aData['password'], $aData['suffix_salt']), \PDO::PARAM_STR, Security::LENGTH_USER_PASSWORD);
        $rStmt->bindValue(':firstName', $aData['first_name'], \PDO::PARAM_STR);
        $rStmt->bindValue(':reference', $aData['reference'], \PDO::PARAM_STR);
        $rStmt->bindValue(':active', $aData['is_active'], \PDO::PARAM_INT);
        $rStmt->bindValue(':ip', $aData['ip'], \PDO::PARAM_STR);
        $rStmt->bindParam(':hashValidation', $aData['hash_validation'], \PDO::PARAM_STR, 40);
        $rStmt->bindParam(':prefixSalt', $aData['prefix_salt'], \PDO::PARAM_STR, 40);
        $rStmt->bindParam(':suffixSalt', $aData['suffix_salt'], \PDO::PARAM_STR, 40);
        $rStmt->bindValue(':joinDate', $aData['current_date'], \PDO::PARAM_STR);
        $rStmt->bindValue(':lastActivity', $aData['current_date'], \PDO::PARAM_STR);
        $rStmt->bindValue(':groupId', (int) Framework\Mvc\Model\DbConfig::getSetting('defaultMembershipGroupId'), \PDO::PARAM_INT);
        $rStmt->execute();
        $this->setKeyId( Db::getInstance()->lastInsertId() ); // Set the user's ID
        Db::free($rStmt);
        $this->setDefaultPrivacySetting();
        return $this->setDefaultNotification();
    }

    /**
     * Join Step 2
     *
     * @param array $aData
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function join2(array $aData)
    {
        $rStmt = Db::getInstance()->prepare('UPDATE' . Db::prefix('Members') .
            'SET sex=:sex, matchSex=:matchSex, birthDate=:birthDate WHERE profileId = :profileId');
        $rStmt->bindValue(':sex', $aData['sex'], \PDO::PARAM_STR);
        $rStmt->bindValue(':matchSex', Form::setVal($aData['match_sex']), \PDO::PARAM_STR);
        $rStmt->bindValue(':birthDate', $aData['birth_date'], \PDO::PARAM_STR);
        $rStmt->bindValue(':profileId', $aData['profile_id'], \PDO::PARAM_INT);
        $rStmt->execute();

        $rStmt = Db::getInstance()->prepare('INSERT INTO' . Db::prefix('MembersInfo') . '(profileId, country, city, state, zipCode)
            VALUES (:profileId, :country, :city, :state, :zipCode)');
        $rStmt->bindParam(':country', $aData['country'], \PDO::PARAM_STR, 2);
        $rStmt->bindValue(':city', $aData['city'], \PDO::PARAM_STR);
        $rStmt->bindValue(':state', $aData['state'], \PDO::PARAM_STR);
        $rStmt->bindValue(':zipCode', $aData['zip_code'], \PDO::PARAM_STR);
        $rStmt->bindValue(':profileId', $aData['profile_id'], \PDO::PARAM_INT);
        return $rStmt->execute();
    }

    /**
     * Join Step 3
     *
     * @param array $aData
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function join3(array $aData)
    {
        $rStmt = Db::getInstance()->prepare('UPDATE' . Db::prefix('MembersInfo') . 'SET description = :description WHERE profileId = :profileId');
        $rStmt->bindValue(':description', $aData['description'], \PDO::PARAM_STR);
        $rStmt->bindValue(':profileId', $aData['profile_id'], \PDO::PARAM_INT);
        return $rStmt->execute();
    }

}
