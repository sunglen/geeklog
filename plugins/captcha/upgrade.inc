<?php
// +---------------------------------------------------------------------------+
// | CAPTCHA v4 Plugin                                                         |
// +---------------------------------------------------------------------------+
// | This file has the functions necessary to upgrade CATPCHA to the latest    |
// | release                                                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008 by                                                     |
// | Author: Hiroron       - hiroron AT hiroron DOT com                        |
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

function CATPCHA_upgrade_210( )
{
    global $_TABLES;

    $_SQL = array();
    
    $_SQL[] = "CREATE TABLE {$_TABLES['cp_config']} ( 
      `config_name` varchar(255) NOT NULL default '', 
      `config_value` varchar(255) NOT NULL default '', 
      PRIMARY KEY  (`config_name`) 
    );";
    $_SQL[] = "INSERT INTO `{$_TABLES['cp_config']}` (`config_name`, `config_value`) VALUES
      ('anonymous_only', '1'), 
      ('debug', '0'), 
      ('enable_comment', '0'), 
      ('enable_contact', '0'), 
      ('enable_emailstory', '0'), 
      ('enable_forum', '0'), 
      ('enable_registration', '0'), 
      ('enable_story', '0'), 
      ('gfxDriver', '2'), 
      ('gfxFormat', 'jpg'), 
      ('gfxPath', '');";

    /* Execute SQL now to perform the upgrade */
    for ($i = 1; $i <= count($_SQL); $i++) {
        COM_errorLOG("CATPCHA plugin 2.1.0 update: Executing SQL => " . current($_SQL));
        DB_query(current($_SQL));
        if (DB_error()) {
            COM_errorLog("SQL Error during CATPCHA plugin update",1);
            return 1;
            break;
        }
        next($_SQL);
    }
    
    COM_errorLog("Success - Completed CATPCHA plugin version 2.1.0 update",1);
    return 0;
}

function CATPCHA_upgrade_300( )
{
    global $_TABLES;

    $_SQL = array();
    
    $_SQL[] = "CREATE TABLE {$_TABLES['cp_sessions']} ( 
      `session_id` varchar(40) NOT NULL default '', 
      `cptime`  INT(11) NOT NULL default 0, 
      `validation` varchar(40) NOT NULL default '', 
      `counter`    TINYINT(4) NOT NULL default 0, 
      PRIMARY KEY (`session_id`) 
    );";
    $_SQL[] = "INSERT INTO `{$_TABLES['cp_config']}` (`config_name`, `config_value`) VALUES 
      ('enable_mediagallery', '0'), 
      ('remoteusers', '0');";

    /* Execute SQL now to perform the upgrade */
    for ($i = 1; $i <= count($_SQL); $i++) {
        COM_errorLOG("CATPCHA plugin 3.0.0 update: Executing SQL => " . current($_SQL));
        DB_query(current($_SQL));
        if (DB_error()) {
            COM_errorLog("SQL Error during CATPCHA plugin update",1);
            return 1;
            break;
        }
        next($_SQL);
    }
    
    COM_errorLog("Success - Completed CATPCHA plugin version 3.0.0 update",1);
    return 0;
}

function CATPCHA_upgrade_400( )
{
    global $_TABLES;

    $driver = DB_getItem($_TABLES['cp_config'], 'config_value', "config_name = 'gfxDriver'");

    $_SQL = array();
    
    switch( $driver ) {
        case "1" : // ImageMagick
            $_SQL[] = "REPLACE INTO `{$_TABLES['cp_config']}` VALUES ('gfxDriver', '2');";
            break;
        case "2" : // static image
            $_SQL[] = "REPLACE INTO `{$_TABLES['cp_config']}` VALUES ('gfxDriver', '3');";
            break;
    }

    /* Execute SQL now to perform the upgrade */
    for ($i = 1; $i <= count($_SQL); $i++) {
        COM_errorLOG("CATPCHA plugin 4.0.0 update: Executing SQL => " . current($_SQL));
        DB_query(current($_SQL));
        if (DB_error()) {
            COM_errorLog("SQL Error during CATPCHA plugin update",1);
            return 1;
            break;
        }
        next($_SQL);
    }
    
    COM_errorLog("Success - Completed CATPCHA plugin version 4.0.0 update",1);
    return 0;
}

?>
