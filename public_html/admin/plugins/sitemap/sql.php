<?php

// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/sitemap/sql.php                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2009 mystral-kk - geeklog AT mystral-k DOT net         |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'sql.php') !== FALSE) {
	die('This file cannot be used on its own.');
}

require_once '../../../lib-common.php';
require_once $_CONF['path'] . 'plugins/sitemap/config.php';

// New table
$NEWTABLE = array();
$NEWTABLE['smap_config'] = "CREATE TABLE {$_TABLES['smap_config']} ("
	. "name VARCHAR(30) NOT NULL default '',"
	. "value VARCHAR(255),"
	. "PRIMARY KEY name(name)"
	. ")";

// Default data
$DEFAULT_DATA = array(
	//for sitemap
	array('anon_access', 'true'),
	array('date_format', '[[Y-m-d] ]'),
	array('sitemap_in_xhtml', 'false'),
	
	// Whether to include data source into sitemap
	array('sitemap_article', 'true'),
	array('sitemap_staticpages', 'true'),
	array('sitemap_calendar', 'true'),
	array('sitemap_links', 'true'),
	array('sitemap_polls', 'true'),
	array('sitemap_forum', 'true'),
	array('sitemap_filemgmt', 'true'),
	array('sitemap_faqman', 'true'),
	array('sitemap_dokuwiki', 'true'),
	array('sitemap_comments', 'true'),
	array('sitemap_trackback', 'true'),
	array('sitemap_mediagallery', 'true'),
	
	// for Google sitemap
	array('google_sitemap_name', 'sitemap.xml'),
	array('time_zone', '+09:00'),
	
	// Whether to include data source into Google sitemap
	array('gsmap_article', 'true'),
	array('gsmap_staticpages', 'true'),
	array('gsmap_calendar', 'true'),
	array('gsmap_links', 'true'),
	array('gsmap_polls', 'true'),
	array('gsmap_forum', 'true'),
	array('gsmap_filemgmt', 'true'),
	array('gsmap_faqman', 'true'),
	array('gsmap_dokuwiki', 'true'),
	array('gsmap_comments', 'false'),
	array('gsmap_trackback', 'false'),
	array('gsmap_mediagallery', 'true'),
	
	// Updating frequency
	array('freq_article', 'daily'),
	array('freq_staticpages', 'weekly'),
	array('freq_calendar', 'daily'),
	array('freq_links', 'weekly'),
	array('freq_polls', 'weekly'),
	array('freq_forum', 'daily'),
	array('freq_filemgmt', 'daily'),
	array('freq_faqman', 'weekly'),
	array('freq_dokuwiki', 'daily'),
	array('freq_comments', 'daily'),
	array('freq_trackback', 'daily'),
	array('freq_mediagallery', 'daily'),
	
	// Priority
	array('priority_article', '0.5'),
	array('priority_staticpages', '0.5'),
	array('priority_calendar', '0.5'),
	array('priority_links', '0.5'),
	array('priority_polls', '0.5'),
	array('priority_forum', '0.5'),
	array('priority_filemgmt', '0.5'),
	array('priority_faqman', '0.5'),
	array('priority_dokuwiki', '0.5'),
	array('priority_comments', '0.5'),
	array('priority_trackback', '0.5'),
	array('priority_mediagallery', '0.5'),
);

$DEFVALUES = array();

// Builds SQL's into $DEFVALUES[]
foreach ($DEFAULT_DATA as $data) {
	list($name, $value) = $data;
	$name  = addslashes($name);
	$value = addslashes($value);
	$DEFVALUES['smap_config'][] = "INSERT INTO {$_TABLES['smap_config']} "
				 . "VALUES ('" . $name . "', '" . $value . "')";
}

// Appends data for sitemap-1.0.1
require_once 'sql-1.0_1.0.1.php';
$DEFVALUES['smap_config'] = array_merge($DEFVALUES['smap_config'], $VALUES_100_TO_101['smap_config']);

// Appends data for sitemap-1.1.4
require_once 'sql-1.0.1_1.1.4.php';
$DEFVALUES['smap_config'] = array_merge($DEFVALUES['smap_config'], $DATA_101_TO_114);

// Appends data for sitemap-1.1.6
require_once 'sql-1.1.5_1.1.6.php';
$DEFVALUES['smap_config'] = array_merge($DEFVALUES['smap_config'], $VALUES_115_TO_116['smap_config']);
