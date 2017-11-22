<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Dbman Plugin for Geeklog - The Ultimate Weblog                            |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dbman/install_defaults.php                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2010 mystral-kk - geeklog AT mystral-kk DOT net        |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== FALSE) {
    die('This file can not be used on its own.');
}

/**
* Dbman default settings
*
* Initial Installation Defaults used when loading the online configuration
* records. These settings are only used during the initial installation
* and not referenced any more once the plugin is installed
*/

/**
* Dbman plugin configuration file
*/

global $_DB_table_prefix, $_DBMAN_DEFAULT;

/**
* the Dbman plugin's config array
* 
* @global array $_DBMAN_DEFAULT
*/
$_DBMAN_DEFAULT = array();

/**
* the dbman plugin's version setting
*/
$_DBMAN_DEFAULT['version'] = '0.5.4';					// Plugin Version

//===============================================
// Global settings
//===============================================

/**
* the flag to decide whether to allow restoration in Dbman plugin.
* SHOULD BE FALSE TO PREVENT ACCIDENTAL DAMAGE TO DATABASE.  SET THIS OPTION TO
* TRUE ONLY IF YOU KNOW WHAT YOU DO.  YOU HAVE BEEN WARNED!
*/
$_DBMAN_DEFAULT['allow_restore'] = FALSE;

//===============================================
// Default settings for backup
//===============================================

/**
* the flag to decide whether to add "DROP TABLE IF EXISTS ...".
* For the compatibility with PhpMyAdminin, this should be set FALSE.
*/
$_DBMAN_DEFAULT['add_drop_table'] = FALSE;

/**
* the number of records to select data from database when the dbman plugin
* backups a table.  If "MySQL client run out of memory." error occurs,
* decrease this value
*/
$_DBMAN_DEFAULT['chunk_size'] = 100;

/**
* the dbman Plugin doen't backup BLOB data for the compatibility with
* PhpMyAdminin but replaces the data with a string '(BLOB)'.  However, if this
* flag is set TRUE, the plugin will backup BLOB data in the base64 format.
* Still, "INSERT INTO ..." SQL statements with BLOB are commented out.
*/
$_DBMAN_DEFAULT['backup_blob'] = FALSE;

/**
* the flag to decide whether to compress backup files.  If set TRUE, the
* dbman plugin tries to compress the data with Zlib.  In this case,
* names of backup files are '*.sql.gz'.
*/
$_DBMAN_DEFAULT['compress_data'] = FALSE;

/**
* the flag to indicate compression level:
* valid values: 1 (largest size) - 9 (smallest size)
*/
$_DBMAN_DEFAULT['compression_level'] = 8;

/**
* the flag to decide whether to download backup files.
*/
$_DBMAN_DEFAULT['download_as_file'] = FALSE;

//===============================================
// Additional settings for backup
//===============================================

/**
* table names which the Dbman plugin shouldn't backup the data of (table
* structures will always be backupped).  You can use regular expressions
* (preg_match() style) to designate table name(s).
* e.g. "/^{$_DB_table_prefix}sessions_/"
*/
$_DBMAN_DEFAULT['backup_except'] = array();
$_DBMAN_DEFAULT['backup_except'][] = "/^{$_DB_table_prefix}gus_/";

/**
* the flag to decide whether to backup with psedo-cron
*/
$_DBMAN_DEFAULT['cron_backup'] = FALSE;

/**
* Maximum number of backup files to be kept.  When set to 0, no backup file
* will be deleted.
*/
$_DBMAN_DEFAULT['max_backup'] = 0;

//===============================================
// Additional settings for restore
//===============================================

/**
* the flag to decide whether to restore BLOB fields.
*/
$_DBMAN_DEFAULT['restore_blob'] = FALSE;

/**
* Initialize Dbman plugin configuration
*
* Creates the database entries for the configuation if they don't already exist.
* Initial values will be taken from $_DBMAN_CONF if available (e.g. from an old
* config.php), uses $_DBMAN_CONF otherwise.
*
* @return   boolean     TRUE: success; FALSE: an error occurred
*/
function plugin_initconfig_dbman() {
    global $_DBMAN_CONF, $_DBMAN_DEFAULT;
    
    if (isset($_DBMAN_CONF) AND is_array($_DBMAN_CONF)
     AND (count($_DBMAN_CONF) >= 1)) {
        $_DBMAN_DEFAULT = array_merge($_DBMAN_DEFAULT, $_DBMAN_CONF);
    }
    
    $c = config::get_instance();
    if (!$c->group_exists('dbman')) {
        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, TRUE, 'dbman');
        $c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, TRUE, 'dbman');
        $c->add('fs_backup', NULL, 'fieldset', 0, 1, NULL, 0, TRUE, 'dbman');
        
        /**
        * Main
        */
        $c->add('add_drop_table', $_DBMAN_DEFAULT['add_drop_table'], 'select', 0, 0, 0, 10, TRUE, 'dbman');
        $c->add('chunk_size', $_DBMAN_DEFAULT['chunk_size'], 'text', 0, 0, NULL, 20, TRUE, 'dbman');
        $c->add('backup_except', $_DBMAN_DEFAULT['backup_except'], '%text', 0, 0, NULL, 30, TRUE, 'dbman');
        $c->add('allow_restore', $_DBMAN_DEFAULT['allow_restore'], 'select', 0, 0, 0, 40, TRUE, 'dbman');
//		$c->add('backup_blob', $_DBMAN_DEFAULT['backup_blob'], 'select', 0, 0, 0, 50, TRUE, 'dbman');
//		$c->add('restore_blob', $_DBMAN_DEFAULT['restore_blob'], 'select', 0, 0, 0, 60, TRUE, 'dbman');
        $c->add('cron_backup', $_DBMAN_DEFAULT['cron_backup'], 'select', 0, 0, 0, 70, TRUE, 'dbman');
        $c->add('max_backup', $_DBMAN_DEFAULT['max_backup'], 'text', 0, 0, NULL, 80, TRUE, 'dbman');
        
        /**
        * Backup Defaults
        */
        $c->add('compress_data', $_DBMAN_DEFAULT['compress_data'], 'select', 0, 1, 0, 100, TRUE, 'dbman');
        $c->add('compression_level', $_DBMAN_DEFAULT['compression_level'], 'select', 0, 1, 1, 110, TRUE, 'dbman');
        $c->add('download_as_file', $_DBMAN_DEFAULT['download_as_file'], 'select', 0, 1, 0, 120, TRUE, 'dbman');
    }
    
    return TRUE;
}
