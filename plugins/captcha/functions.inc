<?php
// +---------------------------------------------------------------------------+
// | CAPTCHA v4 Plugin                                                         |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by the following authors:                              |
// |                                                                           |
// | Author: Mark R. Evans - mevans@ecsnet.com                                 |
// |         Hiroron       - hiroron AT hiroron DOT com                        |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+
//

// this file can't be used on its own
if (strpos ( strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false)
{
    die ('This file can not be used on its own.');
}

if (!defined('XHTML')) { define('XHTML', ''); }

$langfile = $_CONF['path'] . 'plugins/captcha/language/' . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    include_once ($langfile);
} else {
    include_once ($_CONF['path'] . 'plugins/captcha/language/english.php');
}
/*
* Include captcha config file
*/
require_once($_CONF['path'] . 'plugins/captcha/config.php');

$result = DB_query("SELECT * FROM {$_TABLES['cp_config']}",1);
while ($row = DB_fetchArray($result)) {
    $_CP_CONF[$row['config_name']] = stripslashes($row['config_value']);
}

if ($_CP_CONF['gfxDriver'] == 1) {  // auth sister
    // Include captcha sister
    require( 'class/auth_sister/core.php' );
    auth_session_start();
}

function CAPTCHA_sid() {
    return dechex(time()).dechex(mt_rand(1,65535));
}

function plugin_commentPreSave_captcha($uid, $title, $comment, $sid, $pid, $type, $postmode) {
    global $_CP_CONF, $_USER, $_POST;

    if ( $_CP_CONF['enable_comment'] != 1 ) {
        return 0;
    }

    if ( ($_CP_CONF['anonymous_only'] && $_USER['uid'] < 2) || $_CP_CONF['anonymous_only'] == 0 || ($_CP_CONF['remoteusers'] == 1 && SEC_inGroup("Remote Users") ) ) {
        $str = $_POST['captcha'];
        list( $rc, $msg )  = CAPTCHA_checkInput( 'comment',$str );
        if ( $rc == 1 )
            return 0;
        else
            return 1;
    }
    return 0;
}

function plugin_itemPreSave_captcha( $type='registration', $content='' ) {
    global $_CP_CONF, $_USER, $_POST;

    $msg = '';

    switch( $type ) {
        case 'comment' :
            if ( $_CP_CONF['enable_comment'] != 1 ) {
                return '';
            }
            break;
        case 'story' :
            if ( $_CP_CONF['enable_story'] != 1 ) {
                return '';
            }
            break;
        case 'registration' :
            if ( $_CP_CONF['enable_registration'] != 1 ) {
                return '';
            }
            break;
        case 'contact' :
            if ( $_CP_CONF['enable_contact'] != 1 ) {
                return '';
            }
            break;
        case 'emailstory' :
            if ( $_CP_CONF['enable_emailstory'] != 1 ) {
                return '';
            }
            break;
        case 'forum' :
            if ( $_CP_CONF['enable_forum'] != 1 ) {
                return '';
            }
            break;
        case 'mediagallery' :
            if ( $_CP_CONF['enable_mediagallery'] != 1 ) {
                return '';
            }
            break;
        default :
            if ( isset( $_CP_CONF['enable_'.$type]) ) {
                if ( $_CP_CONF['enable_'.$type] != 1 ) {
                    return '';
                }
            } else {
                return '';
            }
    }
    if ( ($_CP_CONF['anonymous_only'] && $_USER['uid'] < 2) || $_CP_CONF['anonymous_only'] == 0 || ($_CP_CONF['remoteusers'] == 1 && SEC_inGroup("Remote Users") ) ) {
        $str = COM_applyFilter($_POST['captcha']);
        list( $rc, $msg )  = CAPTCHA_checkInput( $type, $str );
        return $msg;
    }
    return '';
}

function plugin_templatesetvars_captcha($name, &$template) {
    global $_CP_CONF, $_USER, $_TABLES;

    switch( $name ) {
        case 'comment' :
            if ( $_CP_CONF['enable_comment'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'story' :
            if ( $_CP_CONF['enable_story'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'registration' :
            if ( $_CP_CONF['enable_registration'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'contact' :
            if ( $_CP_CONF['enable_contact'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'emailstory' :
            if ( $_CP_CONF['enable_emailstory'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'forum' :
            if ( $_CP_CONF['enable_forum'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        case 'mediagallery' :
            if ( $_CP_CONF['enable_mediagallery'] != 1 ) {
                $template->set_var('captcha', '');
                return;
            }
            break;
        default :
            if ( isset( $_CP_CONF['enable_'.$name]) ) {
                if ( $_CP_CONF['enable_'.$name] != 1 ) {
                    $template->set_var('captcha', '');
                    return;
                }
            } else {
                $template->set_var('captcha', '');
                return;
            }
            break;
    }

    if ( ($_CP_CONF['anonymous_only'] && $_USER['uid'] < 2) || $_CP_CONF['anonymous_only'] == 0 || ($_CP_CONF['remoteusers'] == 1 && SEC_inGroup("Remote Users") ) ) {

        $csid = 0;
        if ($_CP_CONF['gfxDriver'] != 1) {

            // housekeeping, delete old captcha sessions
            $oldSessions = time() - ($_CP_CONFIG['expire']+900);
            DB_query("DELETE FROM {$_TABLES['cp_sessions']} WHERE cptime < " . $oldSessions,1);

            // OK, we need to insert the CAPTCHA, so now we need to setup the session_id:

            // check to see if a failed entry happened...
            if ( isset($_POST['csid']) ) {
                $csid = COM_applyFilter($_POST['csid']);
            } else {
                $csid = CAPTCHA_sid();
            }
            $time    = time();
            $counter = 0;
            $validation = '';  // this will be filled in by the CAPTCHA

                "  `session_id` varchar(40) NOT NULL default '', " .
                "  `cptime`  INT(11) NOT NULL default 0, " .
                "  `validation` varchar(40) NOT NULL default '', " .
                "  `counter`    TINYINT(4) NOT NULL default 0, " .

            DB_save($_TABLES['cp_sessions'],"session_id,cptime,validation,counter","'$csid','$time','','0'");
    //        $sql = "REPLACE INTO {$_TABLES['cp_sessions']} (session_id,cptime,validation,counter) VALUES ('" . $csid . "','" . $time . "','',0)";
    //        DB_query($sql);
        }

        $captcha = CAPTCHA_getHTML($csid,$name);
        $template->set_var('captcha', $captcha);
    } else {
        $template->set_var('captcha', '');
    }
}

// Internal CAPTCHA functions...

function CAPTCHA_getHTML($csid, $type='general' ) {
    global $_CONF, $_CP_CONF, $LANG_CP00;

    $retval = '';

    if ($_CP_CONF['gfxDriver'] != 1) {
        $T = new Template($_CONF['path'] . 'plugins/captcha/templates');
        switch ( $type ) {
            case 'comment' :
                $T->set_file('page', 'captcha_comment.thtml');
                break;
            case 'story' :
                $T->set_file('page', 'captcha_story.thtml');
                break;
            case 'registration' :
                $T->set_file('page', 'captcha_registration.thtml');
                break;
            case 'contact' :
                $T->set_file('page', 'captcha_contact.thtml');
                break;
            case 'emailstory' :
                $T->set_file('page', 'captcha_emailstory.thtml');
                break;
            case 'forum' :
                $T->set_file('page', 'captcha_forum.thtml');
                break;
            case 'mediagallery' :
                $T->set_file('page', 'captcha_mediagallery.thtml');
                break;
            default :
                $tfile = 'captcha.thtml';
                $function = 'plugin_templatePath_'.$type;
                if ( function_exists($function) ) {
                    $path = $function();
                }
                if ( ! file_exists($path.'/'.$tfile) ) {
                    $path = $_CONF['path'].'plugins/'.$type.'/templates';
                    if ( ! file_exists($path.'/'.$tfile) ) {
                        $path = $_CONF['path'].'plugins/captcha/templates';
                        $tfile = 'captcha_others.thtml';
                        if ( ! file_exists($path.'/'.$tfile) ) {
                            return '';
                        }
                    }
                }
                $T = new Template($path);
                $T->set_file('page', $tfile);
                break;
        }

        $T->set_var(array(
            'lang_captcha_help'     => $LANG_CP00['captcha_help'],
            'lang_refresh'          => $LANG_CP00['refresh'],
            'lang_alt'              => $LANG_CP00['captcha_alt'],
            'captcha_image'         => $_CONF['site_url'] . '/captcha/captcha.php?csid=' . $csid . '&amp;.' . ($_CP_CONF['gfxFormat'] != '' ? $_CP_CONF['gfxFormat'] : 'jpg'),
            'lang_reload'           => $LANG_CP00['reload'],
            'lang_reload_failed'    => $LANG_CP00['reload_failed'],
            'lang_too_many'         => $LANG_CP00['reload_too_many'],
            'csid'                  => $csid,
            'xhtml'                 => XHTML,
        ));

        $T->parse('output', 'page');
        $retval .= $T->finish($T->get_var('output'));
    } else {
        // auth sister
        auth_sister_load();
        $retval .= auth_sister_insert();
    }

    return $retval;
}

function CAPTCHA_checkInput( $type, $str ) {
    global $_CONF, $_CP_CONF, $_TABLES, $LANG_CP00, $_SERVER;

    $msg = '';
    $rc = 0;

    if ($_CP_CONF['gfxDriver'] != 1) {
        // housekeeping, delete old captcha sessions
        $oldSessions = time() - ($_CP_CONFIG['expire']+900);
        DB_query("DELETE FROM {$_TABLES['cp_sessions']} WHERE cptime < " . $oldSessions,1);

        if ( !isset($_POST['csid']) || $str == '' ) {
            if ( !isset($_POST['csid']) ) {
                CAPTCHA_errorLog("CAPTCHA: Detected an attempt to bypass CAPTCHA (no session id) in " . $type . " - IP Address: " . $_SERVER['REMOTE_ADDR'] );
            } else {
                CAPTCHA_errorLog("CAPTCHA: Detected an attempt to bypass CAPTCHA (blank input string) in " . $type . " - IP Address: " . $_SERVER['REMOTE_ADDR'] );
            }
            $msg = $LANG_CP00['bypass_error_blank'];
            $rc = 0;
        } else {
            $csid = COM_applyFilter($_POST['csid']);
            // check the time
            $cTime = DB_getItem($_TABLES['cp_sessions'],'cptime',"session_id='" . $csid . "'");
            $now = time();
            if ( $cTime == '' || $cTime+$_CP_CONF['expire'] < $now ) {
                CAPTCHA_errorLog("CAPTCHA: Detected an attempt to use an expired CAPTCHA in " . $type . " - IP Address: " . $_SERVER['REMOTE_ADDR'] );
                $msg = $LANG_CP00['session_expired'];
                $rc = 0;
                return ( array( $rc, $msg ) );
            }
            $validationString = DB_getItem($_TABLES['cp_sessions'],'validation',"session_id='" . $csid . "'");
            if ( $validationString == '' ) {
               // no active session was found
                CAPTCHA_errorLog("CAPTCHA: Detected an attempt to use old CAPTCHA Session in " . $type . " - IP Address: " . $_SERVER['REMOTE_ADDR'] );
                $msg = $LANG_CP00['bypass_error_blank'];
                $rc = 0;
                return ( array( $rc, $msg ) );
            }
            if ( $validationString != $str ) {
                $msg = $LANG_CP00['entry_error'];
                CAPTCHA_errorLog("CAPTCHA: An invalid CAPTCHA string was entered in " . $type . " - IP Address: " . $_SERVER['REMOTE_ADDR'] );
                $rc = 0;
                return ( array( $rc, $msg ) );
            }
            if ( $validationString == $str && $str != '' ) {
                // we got it, so delete the record to keep others from using it
                DB_query("DELETE FROM {$_TABLES['cp_sessions']} WHERE session_id='" . $csid . "'",1);
                $rc = 1;
            }
        }
    } else {
        // auth sister
        if( auth_sister_auth() ) {
            $rc = 1;
        } else {
            $authid= $_SESSION['auth_sister_authID'];
            $select = COM_applyFilter($_POST[$authid]);
            if ( $select == '' ) {
                //$msg = $LANG_CP00['bypass_error_blank'];
                $msg = auth_sister_res();
                $rc = 0;
                return ( array( $rc, $msg ) );
            } else {
                //$msg = $LANG_CP00['entry_error'];
                $msg = auth_sister_res();
                $rc = 0;
                return ( array( $rc, $msg ) );
            }
        }
    }
    return ( array( $rc, $msg ) );
}

function CAPTCHA_errorLog( $logentry ) {
    global $_CONF;

    if( !empty( $logentry )) {
        $timestamp = strftime( '%c' );
        $logfile = $_CONF['path_log'] . 'captcha.log';

        if( $file = fopen( $logfile, 'a' )) {
            fputs( $file, "$timestamp - $logentry \n" );
            fclose($file);
        }
    }
}

function plugin_chkVersion_captcha() {
    global $_CP_CONF;

    return $_CP_CONF['version'];
}

/**
* This will put an option for the plugin in the command and control block on moderation.php
*
* Add the plugin name, icon and link to the command and control block in moderation.php
*
* @return   array   Array containing (plugin name, admin url, url of plugin icon)
*
*/

function plugin_cclabel_captcha() {
    global $_CONF, $LANG_CP00;

    if (SEC_inGroup('Root') ) {
        return array($LANG_CP00['plugin'],
            $_CONF['site_admin_url'] . '/plugins/captcha/index.php',
            $_CONF['site_url'] . '/captcha/captcha.png');
    } else {
        return '';
    }
}

/**
* Returns the administrative option for this plugin
*
* Adds the plugin to the Admin menu
*
* Universal Plugin:  Modify/Uncomment use it
*
* @return   array   Array containing (plugin name, plugin admin url, # of items in plugin or '')
*
*/
function plugin_getadminoption_captcha() {
    global $_CONF, $_TABLES, $LANG_CP00;

    if (SEC_inGroup('Root')) {
        return array($LANG_CP00['plugin'], $_CONF['site_admin_url'] . '/plugins/captcha/index.php','');
    }
}

/**
* Removes the data structures for this plugin from the Geeklog database.
* This routine will get called from the Plugin install program if user select De-Install or if Delete is used in the Plugin Editor.
* The Plugin Installer will also call this routine upon and install error to remove anything it has created.
* The Plugin installer will pass the optional parameter which will then double check that plugin has first been disabled.
*
* For this plugin, this routine will also remove the Block definition.
*
* Returns True if all Plugin related data is removed without error
*
* @param    string   $installCheck     Defult is blank but if set, check if plugin is disabled first
*
* @return   boolean True if successful false otherwise
*
*/
function plugin_uninstall_captcha($installCheck='') {
    global $_TABLES, $LANG_CP00;

    $pi_name    = 'captcha';

    $TABLES   = array ( 'cp_config', 'cp_sessions' );

    // Check and see if plugin is still enabled - if so display warning and exit
    if ($installCheck != '' && DB_getItem($_TABLES['plugins'],'pi_enabled', 'pi_name = "' .$pi_name. '"')) {
        COM_errorLog("Plugin is installed and enabled. Disable first if you want to de-install it",1);
        $display .= COM_startBlock($LANG_CP00['warning']);
        $display .= $LANG_CP00['enabled'];
        $display .= COM_endBlock();
        echo $display;
        return false;
        exit;
    }

    // Ok to proceed and delete plugin

    // Drop plugin tables
    foreach ( $TABLES as $table ) {
        $t = $_TABLES["$table"];
        COM_errorLog ('Dropping $table table', 1);
        DB_query ( "DROP TABLE $t", 1 );
        COM_errorLog ('...success', 1);
    }

    // Unregister the plugin with Geeklog
    COM_errorLog("Attempting to unregister the $pi_name Plugin from Geeklog",1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = '$pi_name'",1);
    COM_errorLog('...success',1);
    COM_errorLog ('Finished uninstalling the $pi_name plugin.', 1);
    return true;
}

function plugin_upgrade_captcha()
{
    global $_TABLES, $_CONF, $_CP_CONF;

    $pi_name    = 'captcha';

    include ($_CONF['path'] . '/plugins/'.$pi_name.'/upgrade.inc');

    $currentVersion = DB_getItem($_TABLES['plugins'],'pi_version',"pi_name='$pi_name'");

    switch( $currentVersion ) {
        case "2.0.0" :
        case "2.0.1" :
        case "2.0.2" :
            if ( CATPCHA_upgrade_210() == 0 ) {
                DB_query("UPDATE {$_TABLES['plugins']} SET pi_version='2.1.0' WHERE pi_name='$pi_name' LIMIT 1");
            }
        case "2.1.0" :
        case "2.1.1" :
        case "2.1.2" :
            if ( CATPCHA_upgrade_300() == 0 ) {
                DB_query("UPDATE {$_TABLES['plugins']} SET pi_version='3.0.0' WHERE pi_name='$pi_name' LIMIT 1");
            }
        default :
            if ( CATPCHA_upgrade_400() == 0 ) {
                DB_query("UPDATE {$_TABLES['plugins']} SET pi_version='".$_CP_CONF['version']."' WHERE pi_name='$pi_name' LIMIT 1");
            }
            break;
    }
    if ( DB_getItem($_TABLES['plugins'],'pi_version',"pi_name='$pi_name'") == $_CP_CONF['version']) {
        return 1;
    } else {
        return 2;
    }
}

function plugin_getheadercode_captcha() {
    global $_CONF, $_CP_CONF;
    $retval = '';
    if ($_CP_CONF['gfxDriver'] == 1) {  // auth sister
        //$retval .= auth_sister_header();
        $retval .= '<link rel="stylesheet" type="text/css" href="'.$_CONF['site_url'].'/captcha/auth_sister.css"' . XHTML . '>';
    }
    if (SEC_inGroup('Root')) {
        if ( file_exists( $_CONF['path_layout'] . 'captcha/style.css' ) ) {
            $url = $_CONF['layout_url'] . '/captcha/style.css';
        } else {
            $url = $_CONF['site_admin_url'] . '/plugins/captcha/style.css';
        }
        $retval .= '
<!-- Include CSS for CAPTCHA plugin -->
<link rel="stylesheet" type="text/css" href="' . $url . '"' . XHTML . '>
';
    }
    return $retval;
}

if ((!function_exists('COM_output'))) {
    function COM_output($display) {
        echo $display;
    }
}

?>
