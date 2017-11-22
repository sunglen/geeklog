<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Autotags Geeklog Plugin 1.0                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Administration page.                                                      |
// +---------------------------------------------------------------------------+
// | Autotags Plugin Copyright (C) 2006 by the following authors:              |
// |          Joe Mucchiello    - jmucchiello AT yahoo DOT com                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Phill Gillespie  - phill AT mediaaustralia DOT com DOT au        |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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

require_once ('../../../lib-common.php');
require_once ('../../auth.inc.php');

if (!SEC_hasRights ('autotags.admin')) {
    $display = COM_siteHeader ('menu');
    $display .= COM_startBlock ($LANG_AUTO['access_denied'], '',
                        COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $LANG_AUTO['access_denied_msg'];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    COM_accessLog ("User {$_USER['username']} tried to illegally access the autotags administration screen.");
    echo $display;
    exit;
}

if (!defined('XHTML')) {
    define('XHTML', '');
}

/**
* Displays the autotags form 
*
* @param    array   $A      Data to display
* @param    string  $error  Error message to display
*
*/ 
function form ($A, $error = false) 
{
    global $_CONF, $LANG_AUTO, $_AUTO_CONF;

    $retval = '';

    if ($error) {
        $retval .= $error . '<br' . XHTML . '><br' . XHTML . '>';
    } else {
        $template_path = autotags_templatePath ('admin');
        $at_template = new Template ($template_path);

        $at_template->set_file ('form', 'autotags.thtml');
        $at_template->set_var('xhtml', XHTML);
        $at_template->set_var('layout_url', $_CONF['layout_url']);
        
        $at_template->set_var('site_url', $_CONF['site_url']);
        $at_template->set_var('site_admin_url', $_CONF['site_admin_url']);
        $at_template->set_var('start_block_editor',
                COM_startBlock($LANG_AUTO['autotagseditor']), '',
                        COM_getBlockTemplate ('_admin_block', 'header'));
        $at_template->set_var('lang_save', $LANG_AUTO['save']);
        $at_template->set_var('lang_cancel', $LANG_AUTO['cancel']);
        $at_template->set_var('delete_option', '<input type="submit" value="' . $LANG_AUTO['delete'] . '" name="mode"' . XHTML . '>');

        $at_template->set_var('lang_tag', $LANG_AUTO['tag']);
        $at_template->set_var('tag', $A['tag']);
        $at_template->set_var('old_tag', $A['old_tag']);

        $at_template->set_var('lang_desc', $LANG_AUTO['desc']);
        $at_template->set_var('description', $A['description']);

        $at_template->set_var('lang_enabled', $LANG_AUTO['enabled']);
        if ($A['is_enabled'] == 1)
            $at_template->set_var('is_enabled_checked', 'checked="checked"');
        else
            $at_template->set_var('is_enabled_checked', '');

        $at_template->set_var('lang_replacement', $LANG_AUTO['replacement']);
        $at_template->set_var('replacement', $A['replacement']);
        $at_template->set_var('lang_replace_explain', $LANG_AUTO['replace_explain']);

        $at_template->set_var('lang_function', $LANG_AUTO['function']);
        if (($_AUTO_CONF['allow_php'] == 1) && SEC_hasRights ('autotags.PHP'))
        {
            $is_function_checkbox = '<td><input type="checkbox" name="is_function"';
            if ($A['is_function'] == 1)
            {
                $is_function_checkbox .= ' checked="checked"';
            }
            $is_function_checkbox .= XHTML . '>&nbsp;&nbsp;</td>';
                    
            $at_template->set_var('is_function_checkbox', $is_function_checkbox);
            $at_template->set_var ('php_msg', $LANG_AUTO['php_msg_enabled']);
        }
        else
        {
            $at_template->set_var('is_function_checkbox', '');
            $at_template->set_var ('php_msg', $LANG_AUTO['php_msg_disabled']);
        }

        $at_template->set_var('end_block',
                COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer')));
        // Added CSRF protection
        if (version_compare(VERSION, '1.5.0') >= 0) {
            $at_template->set_var('token_name', CSRF_TOKEN);
            $at_template->set_var('token_value', SEC_createToken());
        }
        $retval .= $at_template->parse('output','form');
    }

    return $retval;
}


function listautotags()
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE, $LANG_ADMIN, $LANG_AUTO;
    require_once( $_CONF['path_system'] . 'lib-admin.php' );
    $retval = '';

    $header_arr = array(      # dislay 'text' and use table field 'field'
                    array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
                    array('text' => $LANG_AUTO['tag'], 'field' => 'tag', 'sort' => true),
                    array('text' => $LANG_AUTO['desc'], 'field' => 'description', 'sort' => true),
                    array('text' => $LANG_ADMIN['enabled'], 'field' => 'is_enabled', 'sort' => true),
                    array('text' => $LANG_AUTO['short_function'], 'field' => 'is_function', 'sort' => true)
    );
    $defsort_arr = array('field' => 'tag', 'direction' => 'asc');

    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'] . '/plugins/autotags/index.php?mode=edit',
                          'text' => $LANG_ADMIN['create_new']),
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home'])
    );

    $text_arr = array('has_menu' =>  true,
                       'has_extras'   => true,
                       'title' => $LANG_AUTO['autotagslist'],
                       'instructions' => $LANG_AUTO['instructions'],
                       'icon' => $_CONF['site_admin_url'] . '/plugins/autotags/images/autotags.png',
                       'form_url' => $_CONF['site_admin_url'] . "/plugins/autotags/index.php");

    $query_arr = array('table' => 'autotags',
                       'sql' => "SELECT * "
                               ."FROM {$_TABLES['autotags']} WHERE 1 ",
                       'query_fields' => array('tag'),
                       'default_filter' => "");

    if (version_compare(VERSION, '1.5.0') >= 0) {
        $text   = $LANG_AUTO['instructions'];
        $icon   = $_CONF['site_admin_url'] . '/plugins/autotags/images/autotags.png';
        $retval = ADMIN_createMenu($menu_arr, $text, $icon)
                . ADMIN_list ("autotags", "plugin_getListField_autotags", $header_arr,
                    $text_arr, $query_arr, $defsort_arr);
    } else {
        $retval = ADMIN_list ("autotags", "plugin_getListField_autotags", $header_arr,
                    $text_arr, $query_arr, $menu_arr, $defsort_arr);
    }
    return $retval;

}

/**
* Displays the Auto Tag Editor
*
* @tag          string      tag to edit
* @mode         string      Mode
*
*/
function autotagseditor ($tag, $mode = '')
{
    global $_TABLES;

    if (!empty ($tag) && $mode == 'edit') {
        $query = DB_query("SELECT * FROM {$_TABLES['autotags']} WHERE tag = '$tag'");
        $A = DB_fetchArray($query);
        $A['old_tag'] = $A['tag'];
    } elseif ($mode == 'edit') {
        $A['tag'] = '';
        $A['old_tag'] = '';
        $A['is_enabled'] = '0';
    } else {
        $A = $_POST;
        $A['tag'] = COM_applyFilter($A['tag']);
    }
    return form($A);
}

/** 
* Saves a Auto Tag to the database
*
*/
function saveautotags ($tag, $old_tag, $description, $is_enabled, $is_function, $replacement)
{
    global $_CONF, $LANG_AUTO, $_AUTO_CONF, $_TABLES;

    $old_tag = COM_applyFilter($old_tag);

    // Check for unique page ID
    $duplicate_id = false;
    $delete_old_page = false;
    if (DB_count ($_TABLES['autotags'], 'tag', $tag) > 0) {
        if ($tag != $old_tag) {
            $duplicate_id = true;
        }
    } elseif (!empty ($old_tag)) {
        if ($tag != $old_tag) {
            $delete_old_page = true;
        }
    }

    $is_function = ($is_function == 'on') ? 1 : 0;

    // If user does not have php edit perms, then set php flag to 0.
    if (($_AUTO_CONF['allow_php'] != 1) || !SEC_hasRights ('autotags.PHP')) {
        $is_function = 0;
    }
    if ($is_function == 1)
        $replacement = '';

    $retval = '';
    if ($duplicate_id) {
        $retval .= COM_siteHeader ();
        $retval .= COM_errorLog ($LANG_AUTO['duplicate_tag'], 2);
        $retval .= autotagseditor ($tag);
        $retval .= COM_siteFooter ();
    } elseif (!empty($tag) && in_array($tag, autotags_existing_tags())) {
        $retval .= COM_siteHeader ();
        $retval .= COM_errorLog ($LANG_AUTO['disallowed_tag'], 2);
        $retval .= autotagseditor ('');
        $retval .= COM_siteFooter ();
    } elseif (!empty($tag) && (!empty($replacement) || $is_function == 1)) {
        if ($is_enabled == 'on') {
            $is_enabled = 1;
        } else {
            $is_enabled = 0;
        }

        // Clean up the text
        $description = strip_tags($description);

        $description = addslashes($description);
        $replacement = addslashes($replacement);

        DB_save($_TABLES['autotags'], 'tag,description,is_enabled,is_function,replacement', "'$tag','$description',$is_enabled,$is_function,'$replacement'");
        if ($delete_old_page && !empty ($old_tag)) {
            DB_delete($_TABLES['autotags'], 'tag', $old_tag);
        }
        $retval = COM_refresh($_CONF['site_admin_url']
                          . '/plugins/autotags/index.php');
    } else {
        $retval .= COM_siteHeader ();
        $retval .= COM_errorLog ($LANG_AUTO['no_tag_or_replacement'], 2);
        $retval .= autotagseditor ($tag);
        $retval .= COM_siteFooter ();
    }
    return $retval;
}

function autotags_existing_tags()
{
    global $_AUTOTAGS, $_AUTO_CONF;
    
    $A = PLG_collectTags();
    $A = array_keys($A);
    $A = array_diff($A, array_keys($_AUTOTAGS));
    return array_merge($A, $_AUTO_CONF['disallow']);    
}

/**
* Enable and Disable tag
*/
function changeTagStatus ($tag)
{
    global $_CONF, $_TABLES, $_AUTOTAGS;

    $A = $_AUTOTAGS[$tag];
    if ($A['is_enabled']) {
        DB_query("UPDATE {$_TABLES['autotags']} set is_enabled = '0' WHERE tag='$tag'");
        return;
    } else if ($A['is_function'] == 0 OR $_AUTO_CONF['allow_php'] == 1 && $A['is_function'] == 1) {
        DB_query("UPDATE {$_TABLES['autotags']} set is_enabled = '1' WHERE tag='$tag'");
        return;
    }
}

// MAIN
$mode = '';
if (isset($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode']);
}
$tag = '';
if (isset($_REQUEST['tag'])) {
    $tag = COM_applyFilter ($_REQUEST['tag']);
}

if (isset ($_POST['tagChange'])) {
    changeTagStatus( COM_applyFilter ($_POST['tagChange']));
    $mode = '';
    $tag = '';
}

if (($mode == $LANG_AUTO['delete']) && !empty ($LANG_AUTO['delete'])) {
    if ((version_compare(VERSION, '1.5.0') >= 0)
     AND !SEC_checkToken()) {
        $display = COM_refresh ($_CONF['site_admin_url'] . '/index.php');
    } else {
        DB_delete ($_TABLES['autotags'], 'tag', $tag,
                $_CONF['site_admin_url'] . '/plugins/autotags/index.php');
        exit;
    }
} else if ($mode == 'edit') {
    $display .= COM_siteHeader('menu', $LANG_AUTO['autotagseditor']);
    $display .= autotagseditor($tag, $mode);
    $display .= COM_siteFooter();
} else if (($mode == $LANG_AUTO['save']) && !empty ($LANG_AUTO['save'])) {
    if (!empty ($tag)) {
        if ((version_compare(VERSION, '1.5.0') >= 0)
         AND !SEC_checkToken()) {
            $display = COM_refresh ($_CONF['site_admin_url'] . '/index.php');
        } else {
            $display = saveautotags($tag, COM_applyFilter($_POST['old_tag']),
                         COM_applyFilter($_POST['description']), COM_applyFilter($_POST['is_enabled']),
                         COM_applyFilter($_POST['is_function']), COM_stripslashes($_POST['replacement']));
        }
    } else {
        $display = COM_refresh ($_CONF['site_admin_url'] . '/index.php');
    }
} else {
    $display .= COM_siteHeader ('menu', $LANG_AUTO['autotagslist']);
    $display .= listautotags();
    $display .= COM_siteFooter ();
}

echo $display;

?>