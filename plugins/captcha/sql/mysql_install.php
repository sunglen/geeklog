<?php
// +---------------------------------------------------------------------------+
// | CAPTCHA v4 Plugin                                                         |
// +---------------------------------------------------------------------------+
// | Installation SQL                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008 by the following authors:                              |
// |                                                                           |
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

$_SQL[] = "
CREATE TABLE {$_TABLES['cp_config']} (
  config_name     varchar(255) NOT NULL default '', 
  config_value    varchar(255) NOT NULL default '', 
  PRIMARY KEY (config_name)
) TYPE=MyISAM
";

$_SQL[] = "
CREATE TABLE {$_TABLES['cp_sessions']} (
  session_id      varchar(40) NOT NULL default '', 
  cptime          INT(11) NOT NULL default 0, 
  validation      varchar(40) NOT NULL default '', 
  counter         TINYINT(4) NOT NULL default 0, 
  PRIMARY KEY (session_id)
) TYPE=MyISAM
";

$_DEFVALUES[] = "INSERT INTO `{$_TABLES['cp_config']}` (`config_name`, `config_value`) VALUES ('anonymous_only', '1'), ('remoteusers','0'), ('debug', '0'), ('enable_comment', '0'), ('enable_contact', '0'), ('enable_emailstory', '0'), ('enable_forum', '0'), ('enable_registration', '0'), ('enable_story', '0'), ('gfxDriver', '3'), ('gfxFormat', 'jpg'), ('gfxPath', '');";

?>
