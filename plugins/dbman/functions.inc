<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Dbman Plugin for Geeklog - The Ultimate Weblog                            |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dbman/functions.inc                                       |
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
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
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

global $_DB_dbms;				// needs to be declared while UnInstallation

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file can not be used on its own.');
}

if (!defined('LB')) {
    define('LB', "\n");
}
if (!defined('XHTML')) {
    define('XHTML', '');
}

$langfile = $_CONF['path'] . 'plugins/dbman/language/' . $_CONF['language'] . '.php';
clearstatcache();
if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $_CONF['path'] . 'plugins/dbman/language/english.php';
}

require_once $_CONF['path'] . 'plugins/dbman/config.php';

define('DBMAN_BASE_URL', $_CONF['site_admin_url'] . '/plugins/dbman');
if (version_compare(VERSION, '1.5') >= 0) {	// for GL-1.5 +
    define('DBMAN_GL15', true);
}

/**
* Include DB-specific functions
*/
if (strcasecmp($_DB_dbms, 'mysql') == 0) {
    require_once 'sql/dbman-mysql.inc.php';
} else {
    COM_errorLog("Dbman: Database type '{$_DB_dbms}' is not supported in Dbman plugin.", 1);
    exit;
}

/**
*  DBMAN_timer class -- prevents the script from running out of time
*/
class DBMAN_timer {

    var $last_time;		// Last time when this timer was reset
    
    function __construct() {
        $this->DBMAN_timer();
    }
    
    function __destruct() {
        // Do nothing
    }
    
    function DBMAN_timer() {
        $this->last_time = time();
    }
    
    function update() {
        $current_time = time();
        if ($current_time > $this->last_time + 25) {
            header('X-dbmanPing: Pong');	// Borrowed from PHPMyAdmin/export.php
            $this->last_time = $current_time;
        }
    }
}

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

// ============================================================================
//		MAIN
// ============================================================================

/**
* Geeklog is checking to see if this plugin supports comments, tell it no.
*/
function plugin_commentsupport_dbman() {
    return false;
}

/**
* This will put an option for the plugin in the command and control block on
* moderation.php
*/
function plugin_cclabel_dbman() {
    global $_CONF;

    if (SEC_hasRights('dbman.edit')) {
        return array(
            'Dbman',
            DBMAN_BASE_URL . '/index.php',
            DBMAN_BASE_URL . '/images/dbman.png'
        );
    }
}

/**
* Returns the administrative option for this plugin
*/
function plugin_getadminoption_dbman() {
    global $_CONF;

    if (SEC_hasRights('dbman.edit')) {
        return array('Dbman', DBMAN_BASE_URL . '/index.php', '');
    }
}

/**
* Insert a header link to 'dbman.js'
*/
function plugin_getheadercode_dbman() {
    return '<script type="text/javascript" src="' . DBMAN_BASE_URL
         . '/dbman.js' . '"></script>' . LB;
}

/**
* Upgrade Dbman plugin
*/
function plugin_upgrade_dbman() {
    global $_CONF, $_TABLES, $_DBMAN_CONF;
    
    $result = DB_query("SELECT pi_version FROM {$_TABLES['plugins']} WHERE (pi_name = 'dbman')");
    $A = DB_fetchArray($result);
    $pi_version = $A['pi_version'];
    
    /**
    * If the version of Dbman plugin is lower than 0.5 AND Geeklog version is
	* 1.5 or newer, then save config values into DB with config.class.php.
    */
    if ((version_compare($pi_version, '0.5') < 0)
	 AND (version_compare(VERSION, '1.5') >= 0)) {
        require_once $_CONF['path'] . 'plugins/dbman/install_defaults.php';
        plugin_initconfig_dbman();;
    }
    
    /**
    * update plugin info
    */
    $sql = "UPDATE " . $_TABLES['plugins']
         . " SET pi_version = '" . $_DBMAN_CONF['version'] . "'"
         . " WHERE (pi_name = 'dbman')";
    $result = DB_query($sql);
    COM_errorLog("Dbman plugin was successfully updated to version {$_DBMAN_CONF['version']}.");
    
    return true;
}

/**
* Removes the datastructures for this plugin from the Geeklog database.
*
* @param  string  $installCheck  Default is blank but if set, check if plugin
* is disabled first
* 
* @return   boolean True if successful false otherwise
*/
function plugin_uninstall_dbman($installCheck = '') {
    global $_CONF, $_TABLES;
    
    $pi_name = 'dbman';
    $NEW_FEATURES = array('dbman.edit');
    $display = '';
    
    /**
    * Check and see if plugin is still enabled - if so display warning and exit
    */
    if (($installCheck != '')
     AND DB_getItem($_TABLES['plugins'], 'pi_enabled', 'pi_name = "' .$pi_name . '"')) {
        COM_errorLog("Plugin is installed and enabled.  Disable first if you want to de-install it", 1);
            $display .= COM_startBlock(DBMAN_str('warning'))
                     .  DBMAN_str('enabled')
                     .  COM_endBlock()
                     .  COM_siteFooter();
            echo $display;
            return false;
        }
        
    /**
    * Ok to proceed and delete plugin
    */
    
    /**
    * Unregister the plugin with Geeklog
    */
    COM_errorLog('Attempting to unregister the Dbman plugin from Geeklog', 1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = '{$pi_name}'", 1);
    
    /**
    * Remove all the associated features -- access rights
    */
    foreach ($NEW_FEATURES as $feature) {
        COM_errorLog("Removing '{$feature}' feature and rights to it", 1);
        $feat_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '{$feature}'");
        DB_query("DELETE FROM {$_TABLES['access']} WHERE (acc_ft_id = '{$feat_id}')", 1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE (ft_id = '{$feat_id}')", 1);
    }
    
    /**
    * Get group_id, if any
    */
    $rst = DB_query("SELECT value FROM {$_TABLES['vars']} WHERE (name = '{$pi_name}_gid')", 1);
    if ($rst !== false) {
        $ar = DB_fetchArray($rst);
        $group_id = $ar[0];
        DB_query("DELETE FROM {$_TABLES['vars']} WHERE (name = '{$pi_name}_gid')", 1);
        DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_main_grp_id = '{$group_id}') AND (ug_grp_id = 1)", 1);
        DB_query("DELETE FROM {$_TABLES['groups']} WHERE (grp_id = '{$group_id}')", 1);
    }
    
    /**
    * Delete config info
    */
    if (defined('DBMAN_GL15')) {
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        
        $dbman_config = config::get_instance();
        if ($dbman_config->group_exists('dbman')) {
            $param_names = array(
                'allow_restore', 'add_drop_table', 'chunk_size',
                'compress_data', 'compression_level', 'download_as_file',
                'backup_except',
            );
            
            foreach ($param_names as $param_name) {
                $dbman_config->del($param_name, 'dbman');
            }
        }
    }
    
    /**
    * Finish
    */
    COM_errorLog('Succesfully uninstalled the Dbman Plugin!', 1);
    return true;
}

/**
* Returns the version for this plugin
*/
function plugin_chkVersion_dbman() {
    global $_DBMAN_CONF;
    
    return $_DBMAN_CONF['version'];
}

/**
* Does a psedo-cron job
*/
function plugin_runScheduledTask_dbman() {
    global $_DBMAN_CONF;
    
    if ($_DBMAN_CONF['cron_backup']) {
        DBMAN_backup($_DBMAN_CONF['add_drop_table'], false, $_DBMAN_CONF['compress_data'], false);
    }
}

/**
* Escapes a string for output
*/
function DBMAN_esc($str) {
    global $LANG_CHARSET;
    
    $str = str_replace(
        array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
        array(   '<',    '>',     '&',      '"',      "'"),
        $str
    );
    return htmlspecialchars($str, ENT_QUOTES, $LANG_CHARSET);
}

function DBMAN_str($label) {
    global $LANG_DBMAN;
    
    if (isset($LANG_DBMAN[$label])) {
        return DBMAN_esc($LANG_DBMAN[$label]);
    } else {
        COM_errorLog('Dbman: Undefined index: ' . $label);
        return '(undefined)';
    }
}

/**
* Check if the {$filename} file is actually created
*/
function DBMAN_isCreated($filename) {
    
    clearstatcache();
    $retval = file_exists($filename);
    if ($retval) {
        clearstatcache();
        $retval = (@filesize($filename) > 0);
    }
    
    return $retval;
}

/**
* Checks if the number of backup files is within limit
*/
function DBMAN_checkNumFile() {
    global $_DBMAN_CONF;
    
    if ($_DBMAN_CONF['max_backup'] <= 0) {
        return;
    }
    
    $files = DBMAN_listBackupFiles();
    if (count($files) > $_DBMAN_CONF['max_backup']) {
        $old_files = array_slice($files, $_DBMAN_CONF['max_backup']);
        
        foreach ($old_files as $old_file) {
            DBMAN_delete($old_file);
        }
    }
}

/**
* Returns if a table should be ignored while backupping
*/
function DBMAN_isBackupExcept($table_name) {
    global $_DBMAN_CONF;
    
    foreach ($_DBMAN_CONF['backup_except'] as $pattern) {
        if (preg_match($pattern, $table_name)) {
            return true;
        }
    }
    
    return false;
}

/**
* Returns the difference in the creation times
*/
function DBMAN_compareBackupFiles ($pFileA, $pFileB) {
    global $_CONF;
    
    clearstatcache();
    $lFiletimeA = filemtime($_CONF['backup_path'] . $pFileA);
    clearstatcache();
    $lFiletimeB = filemtime($_CONF['backup_path'] . $pFileB);
    if ($lFiletimeA == $lFiletimeB) {
        return 0;
    }
    
    return ($lFiletimeA > $lFiletimeB) ? -1 : 1;
}

/**
* adopted from database.php.  To avoid collision, renamed as DBMAN_listBackupFiles
*/
function DBMAN_listBackupFiles() {
    global $_CONF;
    
    $backups = array();
    $fd = @opendir($_CONF['backup_path']);
    if ($fd === false) {
        return $backups;
    }
    
    while ((false !== ($file = @readdir($fd)))) {
        if (preg_match('/\.sql$/i', $file) OR preg_match('/\.sql\.gz$/i', $file)) {
            $backups[] = $file;
        }
    }
    
    usort($backups, 'DBMAN_compareBackupFiles');
    return $backups;
}

/**
* Show backup options
*
* @return (string) backup options in HTML format
*/
function DBMAN_backupOptions($add_drop_table, $backup_blob, $compress_data, 
    $download_as_file) {
    global $_CONF;
    
    $retval = DBMAN_createMenu('backup', DBMAN_str('db_explanation_backup'))
            . DBMAN_form();
    $header_arr = array(DBMAN_str('option'));
    $data_arr   = array();
    $data_arr[] = array(
        DBMAN_checkbox('add_drop_table', 'add_drop_table', '', DBMAN_str('add_drop_table'), $add_drop_table)
    );
    $data_arr[] = array(
        DBMAN_checkbox('download_as_file', 'download_as_file', '', DBMAN_str('download_as_file'), $download_as_file)
    );
    
# 	/**
# 	* checks if DB has any BLOB field
# 	*/
# 	$has_blob = false;
# 	$table_names = dbman_getTableList();
# 	foreach ($table_names as $table_name) {
# 		$has_blob = $has_blob OR dbman_isHasBLOBField($table_name);
# 	}
# 	if ($has_blob) {
# 		$data_arr[] = DBMAN_checkbox('backup_blob', 'backup_blob', '', DBMAN_str('backup_blob'), $backup_blob);
# 	}
    
    if (function_exists('gzopen') AND is_callable('gzopen')) {
        $data_arr[] = array(
            DBMAN_checkbox('compress_data', 'compress_data', '', DBMAN_str('compress_data'), $compress_data)
        );
    }
    
    $retval .= DBMAN_list($header_arr, $data_arr)
            .  '<br' . XHTML . '>' . LB
            .  '<input name="cmd" type="hidden" value="backup"' . XHTML . '>' . LB
            .  '<input name="submit" type="submit" value="'
            .  DBMAN_str('backup_now') . '"' . XHTML . '>' . LB
            .  DBMAN_getToken()
            .  '</form>' . LB;
    return $retval;
}

/*
 * Show restore options
 *
 * @return (string) restore options in HTML format
 */

function DBMAN_restoreSelectFile() {
    global $_CONF, $_DBMAN_CONF;
    
    if ($_DBMAN_CONF['allow_restore'] == false) {
        header('Location: ' . DBMAN_BASE_URL . '/index.php');
        exit;
    }
    
    $retval = DBMAN_createMenu('restore', DBMAN_str('db_explanation_restore'))
            . DBMAN_form();
    $header_arr = array(DBMAN_str('backup_file'), DBMAN_str('size'));
    $data_arr   = array();
    
    $backups  = DBMAN_listBackupFiles();
    $data_arr = array();
    $ct = 1;
    
    foreach ($backups as $backup) {
        $id = 'filename' . $ct;
        $backupfilename = $backup;
        $backupfilesize = COM_numberFormat(filesize($_CONF['backup_path'] . $backupfilename));
        $data_arr[] = array(
            DBMAN_radio('filename', $id, $backupfilename, $backupfilename, false),
            $backupfilesize
        );
        $ct ++;
    }
    
    $retval .= DBMAN_list($header_arr, $data_arr)
            .  '<br' . XHTML . '>' . LB
            .  '<input name="cmd" type="hidden" value="restore_option"' . XHTML . '>' . LB
            .  '<input name="submit" type="submit" value="'
            .  DBMAN_str('next') . '"' . XHTML . '>' . LB
            .  DBMAN_getToken()
            .  '</form>' . LB;
    
    return $retval;
}

/**
*  Returns restore options in HTML format.  The options are:
*    1. which table to restore (table strcuture and/or data)
*    2. whther to restore BLOB fields if any
*/
function DBMAN_restoreOption($filename, $restore_blob = false) {
    global $_CONF, $LANG_DBMAN, $_DBMAN_CONF;
    
    if ($_DBMAN_CONF['allow_restore'] == false) {
        header('Location: ' . DBMAN_BASE_URL . '/index.php');
        exit;
    }
    
    $text = DBMAN_str('menu_restore') . '<br' . XHTML . '>' . LB
          . sprintf($LANG_DBMAN['db_explanation_restore_option'], $filename);
    if (defined('XHTML')) {
        $text = str_replace('<br>', '<br' . XHTML . '>', $text);
    }
    $retval = DBMAN_createMenu('', $text, false)
            . DBMAN_form();
    
    $tables    = dbman_getTableNameFromBackup($_CONF['backup_path'] . $filename);
    $num_table = count($tables);
    
    $link_to_table = '<br' . XHTML . '>' . '<input type="button" value="'
                   . DBMAN_str('check_all') . '"'
                   . ' onClick="checkTable(' . $num_table . ', true)"' . XHTML
                   . '><br' . XHTML . '>' . '<input type="button" value="'
                   . DBMAN_str('uncheck_all') . '"'
                   . ' onClick="checkTable(' . $num_table . ', false)"' . XHTML
                   . '>';
    $link_to_data  = '<br' . XHTML . '>' . '<input type="button" value="'
                   . DBMAN_str('check_all') . '"'
                   . ' onClick="checkData(' . $num_table . ', true)"' . XHTML
                   . '><br' . XHTML . '>' . '<input type="button" value="'
                   . DBMAN_str('uncheck_all') . '"'
                   . ' onClick="checkData(' . $num_table . ', false)"' . XHTML
                   . '>';
    $header_arr = array(
        DBMAN_str('restore_header1'),
        DBMAN_str('restore_header2') . $link_to_table,
        DBMAN_str('restore_header3') . $link_to_data
    );
    
    $data_arr  = array();
    
    $hasBlob = false;
    $i = 0;

    foreach ($tables as $t) {
        $hasBlob = ($hasBlob OR dbman_isHasBLOBField($t));
        $id_structure = 'restore_structure' . $i;
        $id_data      = 'restore_data' . $i;
        $data_arr[] = array(
            DBMAN_esc($t),
            DBMAN_checkbox('restore_structure[]', $id_structure, $t, DBMAN_str('restore'), false),
            DBMAN_checkbox('restore_data[]', $id_data, $t, DBMAN_str('restore'), false),
        );
        $i ++;
    };
    
    // Add links to Javascript
    $data_arr[] = array(
        DBMAN_str('operation'),
        $link_to_table,
        $link_to_data,
    );
    
    $retval .= DBMAN_list($header_arr, $data_arr)
            .  '<br' . XHTML . '>' . LB;
    
/**
* other options
*/
    if ($hasBlob) {
        $retval .= '<h3>' . DBMAN_str('other_options') . '</h3>' . LB
                .  DBMAN_checkbox('restore_blob', 'restore_blob', '', DBMAN_str('restore_blob'), false);
    }

    $retval .= '<input name="cmd" type="hidden" value="restore"' . XHTML . '>' . LB
            .  '<input name="filename" type="hidden" value="' . $filename . '"'
            .  XHTML . '>' . LB
            .  '<input name="submit" type="submit" value="'
            .  DBMAN_str('restore_now') . '"' . XHTML . '>' . LB
            .  DBMAN_getToken()
            .  '</form>' . LB;
    
    return $retval;
}

/*
 * List backup files ('databasename_db_backup_YYYY_MM_DD_hh:mm:ss.sql[.gz]')
 * in the /backups directory.
 *
 * @return (string) a list of backup files in HTML format
 */

function DBMAN_listBackups() {
    global $_CONF, $_TABLES;
    
    $retval = '';
    $text   = DBMAN_str('db_explanation_list');
    if (!is_writable($_CONF['backup_path'])) {
        $text .= '<br' . XHTML . '>' . LB . '<span style="font-weight: bold;">'
              .  DBMAN_str('not_writable') . '</span>' . LB;
    }
    
    $retval = DBMAN_createMenu('list', $text, false)
            . '<h2>' . DBMAN_str('last_ten_backups') . '</h2>' . LB
            . DBMAN_form();
    $backups = DBMAN_listBackupFiles();
    $header_arr = array(DBMAN_str('backup_file'), DBMAN_str('size'));
    $data_arr = array();
    if (count($backups) == 0) {
        $data_arr[] = array(DBMAN_str('no_backup_file'), '-');
    } else {
        foreach ($backups as $backup) {
            $backupfile = $_CONF['backup_path'] . $backup;
            $filesize   = COM_numberFormat(filesize($backupfile));
            $url        = '<input name="deletefiles[]" type="checkbox" '
                        . 'value="' . $backup . '"' . XHTML . '>  '
                        . '<a href="' . $_CONF['site_url']
                        . '/admin/plugins/dbman/download.php?filename='
                        . rawurlencode($backup) . '">' . $backup . '</a>';
            $data_arr[] = array($url, $filesize);
        }
    }
    
    $retval .= DBMAN_list($header_arr, $data_arr);
    if (count($backups) > 0) {
        $retval .= '<br' . XHTML . '>' . LB
                .  '<input name="cmd" type="hidden" value="delete"' .  XHTML . '>' . LB
                .  '<input name="submit" type="submit" value="'
                .  DBMAN_str('lbl_delete_file') . '"' . XHTML . '>' . LB
                .  DBMAN_getToken();
    }
    
    $retval .= '</form>' . LB;
    return $retval;
}

/*
 * Create a backup file ('geeklog_db_backup_YYYY_MM_DD_hh:mm:ss.sql[.gz]')
 * in the /backups directory.
 *
 * @parameters:
 *   $add_drop_table (boolean)  : if true, adds "DROP TABLE IF EXISTS ..." before
 *                                  "CREATE TABLE ..."
 *   $backup_blob (boolean)     : if true, backups blob fields as well in the form of
 *                                  comment("-- ") for the compatibility with phpMyAdmin
 *   $compress_data (boolean)   : if true, tries to compress SQL statements in the
 *                                  '.gz' format.  In case of failure, this function
 *                                  tries to backup DB again without compression
 *   $download_as_file (boolean): if true, tries to download the resulting SQL file
 *
 * @return (int) 0 = success, 1 = success(file downloaded), 2 = failure
 */

function DBMAN_backup($add_drop_table = false, $backup_blob = false,
    $compress_data = false, $download_as_file = false) {
    
    global $_CONF, $_DB_host, $_DB_name, $_DB_dbms, $_TABLES, $_DBMAN_CONF,
           $dbman_string_types, $dbman_blob_types;
        
    COM_errorLog("Dbman: Started backuping.", 1);
    @set_time_limit(0);		// has no effect in case the safe_mode is on
    $timer   = new DBMAN_timer();	// Create timer
    $db_name = dbman_quoteItem($_DB_name);
    $ver     = dbman_getDBversion();
    $bkdate  = date("Y-m-d H:i:s O");
    $sql     = <<<EOD1
-- ------------------------------------------------------
-- Geeklog Dbman Plugin {$_DBMAN_CONF['version']}
--
-- Host: {$_DB_host}    Database Name: {$db_name}
-- ------------------------------------------------------
-- Database: {$_DB_dbms}    Version: {$ver}
--
-- Backup made: {$bkdate}
-- ------------------------------------------------------


EOD1;
    $foreign_keys = array();
    
    //	Get a list of table names
    $tables = dbman_getTableList();

    //	Get table definitions
    foreach ($tables as $table) {
        $is_to_be_quoted = array();
        $is_blob         = array();
        $def = dbman_getTableDef($table['name']);
        $lines = explode(LB, $def);
        $num_lines = count($lines);
        $new_lines = array();
        
        for ($i = 0; $i < $num_lines; $i ++) {
            $line = $lines[$i];
            // PHP 4.x.x doesn't support stripos
            if (!preg_match('/FOREIGN KEY/i', $line)
             AND !preg_match('/CONSTRAINT/i', $line)) {
                // Column definition found
                if (preg_match('/^[ ]*`(.*)`[ ]+([a-zA-Z0-9_]*).*$/i', $line, $match)) {
                    $column_name = $match[1];
                    $column_def  = strtoupper(trim($match[2]));
                    $is_to_be_quoted[$column_name] = in_array($column_def, $dbman_string_types);
                    $is_blob[$column_name]         = in_array($column_def, $dbman_blob_types);
                }
                $new_lines[] = $line;
            } else {
                //  Foreign key/Constraint found
                $line = rtrim($line);
                //  If this line ends with a ',', delete it
                if (substr($line, -1) == ',') {
                    $line = substr($line, 0, strlen($line) - 1);
                } else {  // This line is the last row of the definition.  So delete the ','
                                    // at the end of the previous line.
                    $new_lines[$i - 1] = substr($new_lines[$i - 1], 0, strlen($new_lines[$i - 1]) - 1);
                }
                $foreign_keys[] = 'ALTER TABLE ' . dbman_quoteItem($table['name'])
                                . LB . '  ADD ' . $line . ';';
            }
        }
        
        $tables[$table['name']]['def']             = implode(LB, $new_lines);
        $tables[$table['name']]['is_to_be_quoted'] = $is_to_be_quoted;
        $tables[$table['name']]['is_blob']         = $is_blob;
        $timer->update();
    }
    
    //	Get table contents
    foreach ($tables as $table) {
        //	Append table definition to $sql
        $sql .= '--' . LB
             .  '-- Table structure for table ' . dbman_quoteItem($table['name']) . LB
             .  '--' . LB . LB;
        if ($add_drop_table) {
            $sql .= 'DROP TABLE IF EXISTS ' . dbman_quoteItem($table['name']) . ';' . LB . LB;
        }
        $sql .= $tables[$table['name']]['def'] . LB . LB
             .  '--' . LB
             .  '-- Dumping data for table ' . dbman_quoteItem($table['name']) . LB
             .  '--' . LB . LB;

        if (DBMAN_isBackupExcept($table['name'])) {
            $sql .= "-- (skipped backuping {$table['name']})" . LB . LB;
            continue;
        }

        //  Count records in advance to be used in "SELECT * LIMIT ..."
        $rs = DB_query("SELECT COUNT(*) AS cnt FROM {$table['name']}");
        $A  = DB_fetchArray($rs);
        $num_rows = $A['cnt'];
        
        for ($offset = 0; $offset < $num_rows; $offset += $_DBMAN_CONF['chunk_size']) {
            //	Build an SQL to pump out data
            $rst = DB_query("SELECT * FROM {$table['name']} LIMIT {$offset}, {$_DBMAN_CONF['chunk_size']};");
            if ($rst !== false) {
                //  Prefetch $table['is_to_be_quoted'], $table['is_blob']
                $is_to_be_quoted = $table['is_to_be_quoted'];
                $is_blob         = $table['is_blob'];
                $has_blob_field  = in_array(true, $is_blob);

                //  Fetch an associative array alone
                while (($r = DB_fetchArray($rst, false)) !== false) {
                    $column_values = array();
                    foreach ($r as $column_name => $column_value) {
                        if (is_null($column_value)) {
                            $column_value = 'NULL';
                        } else if ($is_to_be_quoted[$column_name]) {
                            $column_value = dbman_quoteString($column_value);
                        } else if ($is_blob[$column_name]) {
                            if ($backup_blob) {
                                $column_value = "\"\n-- B:" 
                                    . chunk_split(base64_encode($column_value), 75, "\n-- B:");
                                $column_value = substr($column_value, 0, strlen($column_value) - 2) . 'Q:"';
                            } else {
                                $column_value = "'(BLOB)'";
                            }
                        }
                        $column_values[] = $column_value;
                    }
                    if ($has_blob_field AND $backup_blob) {
                        $sql .= '-- Q:';
                    }
                    $sql .= 'INSERT INTO ' . dbman_quoteItem($table['name'])
                         .  'VALUES (' . implode(',' , $column_values) . ');' . LB;
                }
            }

            $timer->update();
        } /* End of for-loop */

        $sql .= LB;
        $timer->update();
    } /* End of foreach-loop */
    
    //  Append foreign key definitions if any
    if (count($foreign_keys) > 0) {
        $sql .= '--' . LB . '-- FOREIGN KEY and CONSTRAINT definitions' . LB
             .  '--' . LB . LB
             .  implode(LB, $foreign_keys) . LB;
    }
    
    //	Save data into a file in the 'backups' dir
    clearstatcache();
    if (!is_writable($_CONF['backup_path'])) {
        COM_errorLog("Dbman: the '/backups' directory is not writable.  Please chmod it to 775 or 777.");
        return 2;
    }
    
    $isSuccess   = false;			//  flag to show a success in saving
    $curdatetime = date("Y_m_d_H_i_s");
    $backupfile  = "{$_CONF['backup_path']}{$_DB_name}_db_backup_{$curdatetime}.sql";
    clearstatcache();
    if (file_exists($backupfile) AND !is_writable($backupfile)) {
        COM_errorLog("Dbman: Couldn't create a backup file.");
        return 2;
    }
    
    //  If $compress_data is true, try to compress the data
    if ($compress_data AND function_exists('gzopen')) {
        $backupfile .= '.gz';
        $fh = @gzopen($backupfile, 'wb' . $_DBMAN_CONF['compression_level']);
        if ($fh === false) {
            COM_errorLog("Dbman: Couldn't open a backup-file for writing.", 1);
        } else {
            $rst = gzwrite($fh, $sql);
            if ($rst === false) {
                COM_errorLog("Dbman: Couldn't write data into a backup-file.", 1);
                @gzclose($fh);
            } else {
                $isSuccess = @gzclose($fh);
                if ($isSuccess) {
                    $isSuccess = DBMAN_isCreated($backupfile);
                    if ($isSuccess) {
                        COM_errorLog("Dbman: Backup completed successfully.", 1);
                    } else {
                        COM_errorLog("Dbman: Couldn't write data into a backup-file.", 1);
                    }
                }
            }
        }
    }
    $timer->update();
    
    //  If $compress_data is false, or when there is a failure to compress, save 
    //  backup files without compression
    if (!$isSuccess) {
        $fh = @fopen($backupfile, 'wb');
        if ($fh === false) {
            COM_errorLog("Dbman: Couldn't open a backup-file for writing.", 1);
        } else {
            $rst = fwrite($fh, $sql);
            if ($rst === false) {
                COM_errorLog("Dbman: Couldn't write data into a backup-file.", 1);
            } else {
                $isSuccess = @fclose($fh);
                if ($isSuccess) {
                    $isSuccess = DBMAN_isCreated($backupfile);
                    if ($isSuccess) {
                        COM_errorLog("Dbman: Backup completed successfully.", 1);
                        @chmod($backupfile, 0644);
                    } else {
                        COM_errorLog("Dbman: Couldn't write data into a backup-file.", 1);
                    }
                }
            }
        }
    }
    
    if (!$isSuccess) {		// couldn't backup at all
        return 2;
    }
    
    DBMAN_checkNumFile();
    
    if ($download_as_file) {
        $info = pathinfo($backupfile);
        if (isset($info['extension']) AND $info['extension'] == 'gz') {
            header('Content-type: application/x-gzip');
        } else {
            header('Content-type: text/x-sql');
//            header('Content-type: application/octetstream');
        }
        
        header("Content-Disposition: attachment; filename={$info['basename']}");
        readfile($backupfile);
        return 1;
    }

    return 0;
}

/**
* Restore from a designated backup file
*
*   ('geeklog_db_backup_YYYY_MM_DD_hh:mm:ss.sql[.gz]') in the /backups directory.
*
* @parameters:
*   $filename (string)         : the full path to a backup file
*   $structures_arr (array of string): an array of table names to restore their
*                                structures
*   $data_arr (array of string): an array of table names to restore their data
*
*   $restore_blob (boolean)    : if true, tries to restore blob fields as well by
*                                analyzing comment fields written by Dbman.  If
*                                there is no commented-out data, this functions
*                                writes '(BLOB)' into the field
*
* @return (int) true = success, false = failure
*
* :TODO:  implement the feature of restoring BLOB fields
*
*/
function DBMAN_restore($filename, $structures_arr, $data_arr, $restore_blob = false) {
    global $_CONF, $_DBMAN_CONF;
    
    if ($_DBMAN_CONF['allow_restore'] == false) {
        header('Location: ' . DBMAN_BASE_URL . '/index.php');
        exit;
    }
    $filename = $_CONF['backup_path'] . $filename;
    $num_structure = count($structures_arr);
    $num_data      = count($data_arr);
    $num_structure_success = $num_data_success = 0;
    $timer = new DBMAN_timer();	// Create timer
    $msg   = 'Dbman: restoration started.';
    COM_errorLog($msg);
    echo $msg . '<br' . XHTML . '>';

    // Recreate table structures
    for ($i = 0; $i < $num_structure; $i ++) {
        // Drop tables first
        $table    = $structures_arr[$i];
        $drop_sql = 'DROP TABLE ' . dbman_quoteItem($table);
        echo $drop_sql . '<br' . XHTML . '>';
        DB_query($drop_sql, 1);
        if (DB_error()) {
            $msg = "Dbman: couldn't drop table {$table}.";
            COM_errorLog($msg);
            echo $msg . '<br' .  XHTML . '>' . LB;
        }

        // Then, recreate tables
        $create_sql = dbman_extractTableDefFromBackup($table, $filename);
        DB_query($create_sql, 1);
        if (DB_error()) {
            $msg = "Dbman: couldn't re-create table {$table}.";
            COM_errorLog($msg);
            echo $msg . '<br' . XHTML . '>' . LB;
        } else {
            $msg = "Dbman: re-created table {$table} successfully.";
            COM_errorLog($msg);
            echo $msg . '<br' . XHTML . '>' . LB;
            $num_structure_success ++;
        }

        $timer->update();
    }
    
    echo '<hr' . XHTML . '>' . LB;
    
    // Restore table contents
    $data = file_get_contents($filename);
    $data = str_replace(array("\r\n", "\r"), LF, trim($data));
    $data = explode(LB, $data);
    for ($i = 0; $i < $num_data; $i ++) {
        $table   = $data_arr[$i];
//		$hasBlob = dbman_isHasBLOBField($table);
        $msg = "Dbman: started restoring data into {$table}.";
        COM_errorLog($msg);
        
        echo $msg . '<br' . XHTML . '>' . LB;
        reset($data);
        $num_error = 0;
        
        for ($j = 0; $j < count($data); $j ++) {
            if (eregi("^[ \t]*INSERT[ \t]+INTO[ \t]+" . dbman_quoteItem($table), $data[$j], $match) > 10) {
                $d = $data[$j];
                $d = str_replace("INSERT INTO", "REPLACE", $d);	//  MySQL-specific SQL
                DB_query($d, 1);
                if (DB_error()) {
                    $msg = "Dbman: couldn't insert data into table {$table}.  SQL in question is {$d}.";
                    COM_errorLog($msg);
                    echo $msg . '<br' . XHTML . '>' . LB;
                } else {
                    echo '.';
                }
            }
            
            $timer->update();
        }
        
        $msg = "Dbman: finished restoring data into table {$table}.";
        COM_errorLog($msg);
        echo '<br' . XHTML . '>' . $msg . '<br' . XHTML . '>' . LB;
        if ($num_error == 0) {
            $num_data_success ++;
        }
        
        $timer->update();
    }
    
    $msg ='Dbman: restoration completed.';
    COM_errorLog($msg);
    echo $msg . '<br' . XHTML . '><hr' . XHTML . '>' . LB
         . "<p>To return to the top page, <a href=\"{$_CONF['site_url']}\"><strong>CLICK HERE</strong></a>.</p>" . LB;
    
    return true;
}

/**
* Delete the specified backup file
*
* @return: true (success) false (failute)
*/
function DBMAN_delete($filename) {
    global $_CONF, $_USER;
    
    if ($filename != basename($filename) OR (!preg_match('/\.sql$/i', $filename)
     AND !preg_match('/\.sql\.gz$/i', $filename))) {
        COM_errorLog("Dbman: Error!  Path Traversal attack deteced.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}");
        return false;
    }
    
    $filename = $_CONF['backup_path'] . $filename;
    clearstatcache();
    if (file_exists($filename)) {
        $result = @unlink($filename);
        if ($result === false) {
            COM_errorLog('Dbman: Error!  Cannot delete "' . $filename . '".');
        }
    }
    
    return $result;
}

/**
* Show SQL console
*/
function DBMAN_showSQLConsole() {
    global $_CONF;
    
    $retval = DBMAN_createMenu('console', DBMAN_str('desc_exec_sql'))
            . DBMAN_form()
            . '<textarea name="SQL" rows="10" cols="80"></textarea><br' . XHTML . '>' . LB
            . '<input name="cmd" type="hidden" value="console_exec"' . XHTML . '>' . LB
            . '<input name="submit" type="submit" value="' . DBMAN_str('lbl_exec_sql')
            . '"' . XHTML . '>' . LB
            . DBMAN_getToken()
            . '</form>' . LB;
    return $retval;
}

/**
* Execute SQL and show results
*/
function DBMAN_execSQL() {
    global $_CONF;
    
    $result = '';
    $has_error = false;
    $retval = DBMAN_createMenu('', DBMAN_str('lbl_exec_sql'));
    if (isset($_POST['SQL'])) {
        $SQL = trim($_POST['SQL']);
        $SQL = str_replace(array("\r\n", "\n\r", "\r", "\n"), ' ', $SQL);
        $retval .= '<br' . XHTML . '>' . DBMAN_str('sql_executed')
                .  '<br' . XHTML . '><p style="color: black; background-color: white; padding: 5px; border: solid 1px black;">' . DBMAN_highliteSQL(DBMAN_esc($SQL))
                . '</p>' .  DBMAN_str('sql_result') . '<br' . XHTML . '>';
        if (!preg_match('/^(SELECT|DELETE|UPDATE|INSERT)/i', $SQL)) {
            $has_error = true;
            $result = DBMAN_str('sql_error_siud');
        } else {
            DB_displayError(true);
            $r = DB_query($SQL, 1);	//	Ignore errors
            if ($r === false) {
                $has_error = true;
                $result = DBMAN_esc(DB_error());
            } else {
                if (preg_match('/^SELECT/i', $SQL)) {
                    $result = '<table cellpadding="3" cellspacing="0" border="1">' . LB;
                    $row_names = array();
                    $A = DB_fetchArray($r);
                    $keys = array_keys($A);
                    $result .= '<tr>';
                    
                    foreach ($keys as $key) {
                        if (!is_numeric($key)) {
                            $row_names[] = $key;
                            $result .= '<th>' . COM_applyFilter($key) . '</th>' . LB;
                        }
                    }
                    $result .= '</tr>' . LB;
                
                    $even = true;
                    while ($A = DB_fetchArray($r)) {
                        if ($even) {
                            $result .= '<tr bgcolor="#ccffff">';
                        } else {
                            $result .= '<tr bgcolor="#6699cc">';
                        }
                        $even = !$even;
                        foreach ($row_names as $row_name) {
                            $result .= '<td>';
                            if ($A[$row_name] == '') {
                                $result .= '&nbsp;';
                            } else {
                                $result .= DBMAN_esc($A[$row_name]);
                            }
                            $result .= '</td>' . LB;
                        }
                        $result .= '</tr>' . LB;
                    }

                    $result .= '</table>' . LB;
                } else {
                    $result = "<p>Succeeded.</p>" . LB;
                }
            }
            DB_displayError(false);
        }
    }
    
    if (isset($result)) {
        if ($has_error) {
            $retval .= '<p style="color: red; background-color: white; padding: 5px; border: solid 1px black;">' . $result . '</p>' . LB;
        } else {
            $retval .= $result;
        }
    }
    
    return $retval;
}

/**
* For lower compatibility
*/

/**
* Creates a menu with an optional icon and optional text below
* this is used in the admin screens but may be used elsewhere also.
*
* @param    string  $text           instructions to be displayed
* @return   string                  HTML output of function
*
*/
function DBMAN_createMenu($current_menu = 'list', $text = '', $noesc = true) {
    global $_CONF, $_DBMAN_CONF;
    
    $DBMAN_MENU = array(
        'admin' => array(
                    'url'  => $_CONF['site_admin_url'],
                    'text' => DBMAN_str('admin_home'),
        ),
        'backup' => array(
                    'url'  => DBMAN_BASE_URL . '/index.php?cmd=backup_option',
                    'text' => DBMAN_str('menu_backup'),
        ),
        'list' => array(
                    'url'  => DBMAN_BASE_URL . '/index.php',
                    'text' => DBMAN_str('menu_list'),
        ),
        'restore' => array(
                    'url'  => DBMAN_BASE_URL . '/index.php?cmd=restore_select',
                    'text' => DBMAN_str('menu_restore'),
        ),
        'console' => array(
                    'url'  => DBMAN_BASE_URL . '/index.php?cmd=console',
                    'text' => DBMAN_str('menu_console'),
        ),
# 		'import' => array(
# 					'url'  => DBMAN_BASE_URL . '/index.php?cmd=import',
# 					'text' => DBMAN_str('menu_import'),
# 		),
# 		'export' => array(
# 					'url'  => DBMAN_BASE_URL . '/index.php?cmd=export',
# 					'text' => DBMAN_str('menu_export'),
# 		),
    );
    
    if ($_DBMAN_CONF['allow_restore'] == false) {
        unset($DBMAN_MENU['restore']);
    }
    $admin_templates = new Template($_CONF['path'] . 'plugins/dbman/templates');
    $admin_templates->set_file (
        array ('top_menu' => 'topmenu.thtml')
    );
    
    $menu_fields = array();
    $attr = array(
        'class' => 'admin-menu-item'
    );
    
    foreach ($DBMAN_MENU as $key => $value) {
        if ($key != $current_menu) {
            $menu_fields[] = '<a href="' . $value['url']
                           . '" class="admin-menu-item">' . $value['text'] . '</a>';
        } else {
            $menu_fields[] = '<strong>' . $value['text'] . '</strong>';
        }
    }
    
    $admin_templates->set_var('icon', DBMAN_BASE_URL . '/images/dbman.png');
    $admin_templates->set_var('menu_fields', implode(' | ', $menu_fields));
    if ($noesc) {
        $admin_templates->set_var('lang_instructions', DBMAN_esc($text));
    } else {
        $admin_templates->set_var('lang_instructions', $text);
    }
    $admin_templates->set_var('xhtml', XHTML);
    $admin_templates->parse('top_menu', 'top_menu');
    $retval = $admin_templates->finish($admin_templates->get_var('top_menu'));
    
    return $retval;
}

function DBMAN_list($header_arr, $data_arr) {
    $retval = '<table class="admin-list-table">' . LB
            . '<tr style="background: #ffffff;">' . LB;
    
    foreach ($header_arr as $header) {
        $retval .= '<th class="admin-list-headerfield">' . $header . '</th>' . LB;
    }
    
    $retval .= '</tr>' . LB;
    $class = 'pluginRow1';
    
    foreach ($data_arr as $row) {
        $retval .= '<tr class="' . $class . '" onmouseover="className=\'pluginRollOver\';" onmouseout="className=\'' . $class . '\';">' . LB;

        foreach ($row as $cell) {
            $retval .= '<td class="admin-list-field">' . $cell . '</td>' . LB;
        }
        
        $retval .= '</tr>' . LB;
        $class = ($class == 'pluginRow1' ? 'pluginRow2' : 'pluginRow1');
    }
    
    $retval .= '</table>' . LB;
    return $retval;
}

function DBMAN_form() {
    return '<form action="' . DBMAN_BASE_URL . '/index.php" method="post">' . LB;
}

function DBMAN_checkbox($name, $id, $value, $label, $checked = true) {
    $retval = '<input type="checkbox" id="' . $id . '" name="' . $name
            . '" value="' . $value . '"';
    if ($checked) {
        $retval .= ' checked="checked"';
    }
    
    $retval .= XHTML . '><label for="' . $id . '">' . $label . '</label>';
    return $retval;
}

function DBMAN_radio($name, $id, $value, $label, $checked = true) {
    $retval = '<input type="radio" id="' . $id . '" name="' . $name
            . '" value="' . $value . '"';
    if ($checked) {
        $retval .= ' checked="checked"';
    }
    
    $retval .= XHTML . '><label for="' . $id . '">' . DBMAN_esc($label) . '</label>';
    return $retval;
}

function DBMAN_getToken() {
    if (defined('DBMAN_GL15')) {
        $retval = '<input type="hidden" name="' . CSRF_TOKEN . '" value="'
                . SEC_createToken() . '"' . XHTML . '>' . LB;
    } else {
        $retval = '';
    }
    
    return $retval;
}

function DBMAN_checkToken() {
    global $_USER;
    
    if (defined('DBMAN_GL15')) {
        if (!SEC_checkToken()) {
            COM_errorLog("User {$_USER['username']} failed CSRF checks.");
            header('Location: ' . DBMAN_BASE_URL . '/index.php?msg=1');
            exit;
        }
    }
    
    return;
}

function DBMAN_highliteSQL($sql) {
    $words = array(
        'select', 'from', 'where', 'order', 'by', 'limit', 'delete', 'insert',
        'into', 'values', 'update', 'set',
    );
    
    foreach ($words as $word) {
        $sql = preg_replace("/\b{$word}\b/i", '<strong>' . strtoupper($word) . '</strong>', $sql);
    }
    
    return $sql;
}
