<?php
/**
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Module / Newsletter / Form / Processing
 */
namespace PH7;
defined('PH7') or exit('Restricted access');

class MsgFormProcessing
{

    public function __construct()
    {
        $aData = (new Newsletter)->sendMessages();

        if (!$aData['status'])
            \PFBC\Form::setError('form_msg', Form::errorSendingEmail());
        else
            \PFBC\Form::setSuccess('form_msg', nt('%n% newsletters were sent successfully!', '%n% newsletter has been sent successfully', $aData['nb_mail_sent']));
    }

}
