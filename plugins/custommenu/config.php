<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | CustomMenu Editor Plugin for Geeklog                                      |
// +---------------------------------------------------------------------------+
// | plugins/custommenu/config.php                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2010 dengen - taharaxp AT gmail DOT com                |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett               -    twillett AT users DOT sourceforge DOT net  |
// | Blaine Lang               -    langmail AT sympatico DOT ca               |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                -    tony AT tonybibbs DOT com                  |
// | Modified by:                                                              |
// | mystral-kk                -    geeklog AT mystral-kk DOT net              |
// | dengen                    -    taharaxp AT gmail DOT com                  |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'config.php') !== false) {
    die('This file can not be used on its own.');
}

global $_CMED_CONF, $_TABLES, $_CMED_plugin_label_var;

$_CMED_CONF = array();

/**
 *  User Configulations for GL 1.4.1
 */

/** What to show after a data has been saved? Possible choices:
 * 'list'   -> display the admin-list of custommenu
 * 'home'   -> display the site homepage
 * 'admin'  -> display the site admin homepage
 */
$_CMED_CONF['aftersave'] = 'list';

/**
 * Define default permissions for new custommenu created from the Admin panel.
 * Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
 * order). Possible values:
 * - 3 = read + write permissions (perm_owner and perm_group only)
 * - 2 = read-only
 * - 0 = neither read nor write permissions
 * (a value of 1, ie. write-only, does not make sense and is not allowed)
 */
$_CMED_CONF['default_permissions'] = array(3, 2, 2, 2);


// +---------------------------------------------------------------------------+
// | Do not change anything below this line.                                   |
// +---------------------------------------------------------------------------+

/**
* Plugin Version
*/
$_CMED_CONF['version'] = '0.5.0';

/**
* GL Version
*/
$_CMED_CONF['gl_version'] = '1.4.1';

/**
* Plugin Homepage
*/
$_CMED_CONF['pi_url'] = 'http://www.trybase.com/~dengen/log/';

/**
* Add to $_TABLES array the tables custommenu plugin uses
*/
$_TABLES['menuitems'] = $_DB_table_prefix . 'menuitems';


$_CMED_plugin_label_var = array(
    'calendar'     => "LANG_CAL_1[16]",
    'calendarjp'   => "LANG_CALJP_1[16]",
    'links'        => "LANG_LINKS[114]",
    'polls'        => "LANG_POLLS['polls']",
    'forum'        => "LANG_GF00['pluginlabel']",
    'filemgmt'     => "LANG_FILEMGMT['downloads']",
    'mediagallery' => "_MG_CONF['menulabel']",
    'sitemap'      => "LANG_SMAP['menu_label']",
    'autotags'     => "LANG_AUTO['main_menulabel']",
    'tag'          => "LANG_TAG['admin_label']",
    'faqman'       => "LANG_FAQ['headerlabel']",
    'vthemes'      => "LANG_VT00['menulabel']",
);

?>