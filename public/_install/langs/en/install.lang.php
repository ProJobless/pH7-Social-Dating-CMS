<?php
/**
 * @title            English Language File
 *
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2012-2013, Pierre-Henry Soria. All Rights Reserved.
 * @license          GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package          PH7 / Lang / EN
 * @update           07/13/13 00:22
 */

namespace PH7;

$LANG = array (
    'lang' => 'en',
    'charset' => 'utf-8',
    'lang_name' => 'English',
    'version' => 'version',
    'CMS_desc' => '<p>Welcome to installation of '.Controller::SOFTWARE_NAME.'.<br />
    Thank you for choosing our CMS and we hope it will please you.</p>
    <p>Please follow the six step of the installation.</p>',
    'chose_lang_for_install' => 'Please choose your language to begin the installation',
    'requirements_desc' => 'WARNING! Please be sure that your server has the necessary <a href="'.Controller::SOFTWARE_REQUIREMENTS_URL.'" target="_blank">requirements</a> to correctly run pH7CMS.',
    'config_path' => '&quot;protected&quot; directory path',
    'desc_config_path' => 'Please specify the full path to your &quot;protected&quot; folder.<br />
    It is wise and advisable to put this directory outside the public root of the your Web server.',
    'need_frame' => 'You must use a Web browser that supports inline frames!',
    'path_protected' => 'Path of the &quot;protected&quot; folder',
    'next' => 'Next',
    'go' => 'Next step =>',
    'license' => 'License',
    'license_desc' => 'Please read the license carefully and accept it before continuing the installation of the software!',
    'registration_for_license' => 'Please register on this <a href="'.Controller::SOFTWARE_WEBSITE.'" target="_blank">website</a> to get your free license is required to continue.',
    'your_license' => 'Your license key',
    'agree_license' => 'I have read and agree to the above Terms.',
    'step' => 'Step',
    'welcome' => 'Welcome to the installation of',
    'welcome_to_installer' => 'Install of',
    'config_site' => 'Configure your website!',
    'config_system' => 'Configure of CMS system!',
    'bad_email' => 'Incorrect email',
    'finish' => 'Finish installation!',
    'go_your_site' => 'Go to your new website!',
    'error_page_not_found' => 'Page not found',
    'error_page_not_found_desc' => 'Sorry, but the page you are looking for could not be found.',
    'success_license' => 'Your license key is correct!',
    'failure_license' => 'Sorry, your license key is incorrect!',
    'no_protected_exist' => 'Sorry, but we did not find the &quot;protected&quot; directory.',
    'no_protected_readable' => 'Please change the permissions of the &quot;protected&quot; directory in read mode (CHMOD 755).',
    'no_public_writable' => 'Please change the permissions of the &quot;public&quot; directory in write mode (CHMOD 777).',
    'no_app_config_writable' => 'Please change the permissions of the &quot;protected/app/configs&quot; directory in write mode (CHMOD 777).',
    'database_error' => 'Error connecting to your database.<br />',
    'error_sql_import' => 'An error occurred while importing the file to your SQL database',
    'field_required' => 'This field is required',
    'all_fields_mandatory' => 'All fields marked with an asterisk (*) are required',
    'db_hostname' => 'Database Server hostname',
    'desc_db_hostname' => '(Generally &quot;localhost&quot; or &quot;127.0.0.1&quot;)',
    'db_name' =>'Name of the database',
    'db_username' => 'Username of your database',
    'db_password' => 'Database Password',
    'db_prefix' => 'The prefix of the tables in the database',
    'desc_db_prefix' => 'This option is useful when you have multiple installations of pH7CMS on the same database. We recommend that you still change the default values ​​in order to increase the security of your website.',
    'desc_charset' => 'Database Encoding, usually UTF8 encoding for international.',
    'db_port' => 'Port of your database',
    'ffmpeg_path' => 'The path to the FFmpeg executable (if you do not know where he is, please ask your hosting)',
    'password_empty' => 'Your password is empty',
    'passwordS_different' => 'The password confirmation does not match the initial password',
    'username_badusername' => 'Your username is incorrect',
    'username_tooshort' => 'Your username is too short, at least 4 characters',
    'username_toolong' => 'Your username is too long, maximum 40 characters',
    'email_empty' => 'Email is a field mandatory',
    'password_nonumber' => 'Your password must contain at least one number',
    'password_noupper' => 'Your password must contain at least one uppercase',
    'password_tooshort' => 'Your password is too short',
    'password_toolong' => 'Your password is too long',
    'bug_report_email' => 'Bug reports email',
    'admin_first_name' => 'Your first name',
    'admin_last_name' => 'Your last name',
    'admin_username' => 'Your username to login in your administration panel',
    'admin_login_email' => 'Your email to login in your administration panel',
    'admin_email' => 'Your email address for administration',
    'admin_return_email' => 'Noreply email address (generally noreply@yoursite.com)',
    'admin_feedback_email' => 'Email address for the contact form (feedback)',
    'admin_password' => 'Your password',
    'admin_passwordS' => 'Please confirm your password',
    'bad_first_name' => 'Please enter your first name, it must also be between 2 and 20 characters.',
    'bad_last_name'=> 'Please enter your last name, it must also be between 2 and 20 characters.',
    'remove_install_folder_auto' => 'Automatically delete the &quot;install&quot; directory (this requires access rights to delete the &quot;install&quot; directory).',
    'confirm_remove_install_folder_auto' => 'WARNING, All files in the /_install/ folder will be removed.',
    'title_email_finish_install' => 'Congratulations, the installation of your website is finished!',
    'content_email_finish_install' => '<p><strong>Congratulations, your website is now successfully installed!</strong></p>
    <p>We hope you\'ll enjoy using '.Controller::SOFTWARE_NAME.'</p>
    <p>For bug reports, suggestions, proposals, partnership, participation in the development of CMS and its translation, etc.</p>
    <p>Please visit our <a href="'.Controller::SOFTWARE_WEBSITE.'" target="_blank">website</a>.</p>
    <p>---</p>
    <p>Kind regards,</p>
    <p>The pH7CMS developers team.</p>',
    'yes_dir' => 'The directory was found successfully!',
    'no_dir' => 'The directory does not exist.',
    'wait_importing_database' => 'Please wait while importing the database.<br />
    This may take several minutes.',
    'error_get_server_url' => 'Access problems with our Web server.<br />
    Please verify that your server is connected to internet, otherwise please wait a bit (it is possible that our server is overloaded).',
    'powered' => 'Powered by',
    'loading' => 'Loading...',
);
