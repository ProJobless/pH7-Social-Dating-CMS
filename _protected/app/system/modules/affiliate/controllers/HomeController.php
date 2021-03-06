<?php
/**
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Module / Affiliate / Controller
 */
namespace PH7;

class HomeController extends Controller
{

    private $sTitle;

    public function __construct()
    {
        parent::__construct();

        /** Predefined meta_description and keywords tags **/
        $this->view->meta_description = t('Become an Affiliate with the affiliate dating community platform %site_name%');
        $this->view->meta_keywords = t('affiliate,dating,dating site,social network,pay per click affiliate program, affiliate program');
    }

    public function index()
    {
        $this->view->page_title = t('Affiliate Platform with %site_name%! Dating Social Affiliate');
        $this->view->h1_title = t('Affiliate Platform - %site_name%');

        if (Affiliate::auth())
            $this->view->h3_title = t('Hello <em>%0%</em>, welcome to your site!', $this->
                session->get('affiliate_first_name'));
        if (!Affiliate::auth()) {
            $this->design->addCss(PH7_LAYOUT . PH7_SYS . PH7_MOD . $this->registry->module .
                PH7_DS . PH7_TPL . PH7_TPL_MOD_NAME . PH7_DS . PH7_CSS, 'style.css');
        }

        $this->output();
    }

    public function login()
    {
        $this->sTitle = t('Login Affiliate');
        $this->view->page_title = $this->sTitle;
        $this->view->meta_description = $this->sTitle;
        $this->view->h1_title = $this->sTitle;
        $this->output();
    }

    public function resendActivation()
    {
        $this->sTitle = t('Resend activation email');
        $this->view->page_title = $this->sTitle;
        $this->view->h2_title = $this->sTitle;
        $this->output();
    }

    public function logout()
    {
        (new Affiliate)->logout();
    }

}
