<?php

// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/sitemap/sql-1.0_1.0.1.php                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2008 mystral-kk - geeklog AT mystral-k DOT net         |
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

require_once $_CONF['path'] . 'plugins/sitemap/config.php';

if (strpos(strtolower($_SERVER['PHP_SELF']), 'sql-1.0_1.0.1.php') !== FALSE) {
	die('This file cannot be used on its own.');
}

// Default data
$DATA_100_TO_101 = array(
	// Whether to include data source into sitemap
	array('order_article',       1),
	array('order_comments',      2),
	array('order_trackback',     3),
	array('order_staticpages',   4),
	array('order_calendar',      5),
	array('order_links',         6),
	array('order_polls',         7),
	array('order_dokuwiki',      8),
	array('order_forum',         9),
	array('order_filemgmt',     10),
	array('order_faqman',       11),
	array('order_mediagallery', 12),
);

$VALUES_100_TO_101 = array();

// Builds SQL's into $DEFVALUES[]
foreach ($DATA_100_TO_101 as $data) {
	list($name, $value) = $data;
	$name  = addslashes($name);
	$value = addslashes($value);
	$VALUES_100_TO_101['smap_config'][] = "INSERT INTO {$_TABLES['smap_config']} "
		. "VALUES ('" . $name . "', '" . $value . "')";
}
