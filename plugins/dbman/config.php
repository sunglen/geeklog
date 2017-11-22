<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Dbman Plugin for Geeklog - The Ultimate Weblog                            |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dbman/config.php                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2010 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// +---------------------------------------------------------------------------+

if (strpos(strtolower($_SERVER['PHP_SELF']), 'config.php') !== false) {
    die('This file can not be used on its own.');
}

/**
* Dbman plugin configuration file
*/

global $_DB_table_prefix, $_CONF;

/**
* the Dbman plugin's config array
* 
* @global array $_DBMAN_CONF
*/
$_DBMAN_CONF = array();

/**
* the dbman plugin's version setting
*/
$_DBMAN_CONF['version'] = '0.5.4';					// Plugin Version

//===============================================
// Global settings
//===============================================

/**
* the flag to decide whether to allow restoration in Dbman plugin.
* SHOULD BE FALSE TO PREVENT ACCIDENTAL DAMAGE TO DATABASE.  SET THIS OPTION TO
* TRUE ONLY IF YOU KNOW WHAT YOU DO.  YOU HAVE BEEN WARNED!
*/
$_DBMAN_CONF['allow_restore'] = FALSE;

//===============================================
// Default settings for backup
//===============================================

/**
* the flag to decide whether to add "DROP TABLE IF EXISTS ...".
* For the compatibility with PhpMyAdminin, this should be set false.
*/
$_DBMAN_CONF['add_drop_table'] = FALSE;

/**
* the number of records to select data from database when the dbman plugin
* backups a table.  If "MySQL client run out of memory." error occurs,
* decrease this value
*/
$_DBMAN_CONF['chunk_size'] = 100;

/**
* the dbman Plugin doen't backup BLOB data for the compatibility with
* PhpMyAdminin but replaces the data with a string '(BLOB)'.  However, if this
* flag is set true, the plugin will backup BLOB data in the base64 format.
* Still, "INSERT INTO ..." SQL statements with BLOB are commented out.
*/
//$_DBMAN_CONF['backup_blob'] = FALSE;

/**
* the flag to decide whether to compress backup files.  If set true, the
* dbman plugin tries to compress the data with Zlib.  In this case,
* names of backup files are '*.sql.gz'.
*/
$_DBMAN_CONF['compress_data'] = FALSE;

/**
* the flag to indicate compression level:
* valid values: 1 (largest size) - 9 (smallest size)
*/
$_DBMAN_CONF['compression_level'] = 8;

/**
* the flag to decide whether to download backup files.
*/
$_DBMAN_CONF['download_as_file'] = FALSE;

//===============================================
// Additional settings for backup
//===============================================

/**
* table names which the Dbman plugin shouldn't backup the data of (table
* structures will always be backupped).  You can use regular expressions
* (preg_match() style) to designate table name(s).
* e.g. "/^{$_DB_table_prefix}sessions_/"
*/
$_DBMAN_CONF['backup_except']   = array();
$_DBMAN_CONF['backup_except'][] = "/^{$_DB_table_prefix}gus_/";

/**
* the flag to decide whether to backup with psedo-cron
*/
$_DBMAN_CONF['cron_backup'] = FALSE;

/**
* Maximum number of backup files to be kept.  When set to 0, no backup file
* will be deleted.
*/
$_DBMAN_CONF['max_backup'] = 0;

//===============================================
// Additional settings for restore
//===============================================

/**
* the flag to decide whether to restore BLOB fields.
*/
//$_DBMAN_CONF['restore_blob'] = false;

//===============================================
// For GL-1.5+
//===============================================

/**
* Check and see if we need to load the plugin configuration
*/
if (version_compare(VERSION, '1.5') >= 0) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';
    
    $dbman_config = config::get_instance();
    if ($dbman_config->group_exists('dbman')) {
        $temp = $dbman_config->get_config('dbman');
        if (is_array($temp) AND (count($temp) >= 1)) {
            $_DBMAN_CONF = array_merge($_DBMAN_CONF, $temp);
        }
    }
}
