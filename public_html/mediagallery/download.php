<?php
// +--------------------------------------------------------------------------+
// | Media Gallery Plugin - glFusion CMS                                      |
// +--------------------------------------------------------------------------+
// | download.php                                                             |
// |                                                                          |
// | Download objects directly                                                |
// +--------------------------------------------------------------------------+
// | $Id:: download.php 5614 2010-03-19 19:08:33Z mevans0263                 $|
// +--------------------------------------------------------------------------+
// | Copyright (C) 2002-2010 by the following authors:                        |
// |                                                                          |
// | Mark R. Evans          mark AT glfusion DOT org                          |
// +--------------------------------------------------------------------------+
// |                                                                          |
// | This program is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU General Public License              |
// | as published by the Free Software Foundation; either version 2           |
// | of the License, or (at your option) any later version.                   |
// |                                                                          |
// | This program is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
// | GNU General Public License for more details.                             |
// |                                                                          |
// | You should have received a copy of the GNU General Public License        |
// | along with this program; if not, write to the Free Software Foundation,  |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.          |
// |                                                                          |
// +--------------------------------------------------------------------------+

require_once '../lib-common.php';

if (!in_array('mediagallery', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

if ( COM_isAnonUser() && $_MG_CONF['loginrequired'] == 1 )  {
    $display = MG_siteHeader();
    $display .= SEC_loginRequiredForm();
    $display .= COM_siteFooter();
    echo $display;
    exit;
}

if ( !isset($_GET['mid'] ) ) {
    return;
}

MG_initAlbums();

// Implements a poor mans hotlink protection, if the request
// did not originate at our site, don't allow it.
$allowblank = 1;
$alloweddomains = array($_CONF['site_url']);
if (isset($_SERVER['HTTP_REFERER'])) {
    $referrer = $_SERVER['HTTP_REFERER'];
} else {
    $referrer = "";
}
$allowed = 0;
if ($allowblank > 0) {
    if($referrer=="") {
        $allowed = 1;
    }
}
$domains = count($alloweddomains);
for($y=0;$y<$domains;$y++) {
    if (strpos($referrer, $alloweddomains[$y]) !== false) {
        $allowed = 1;
        break;
    }
}
if ( $allowed == 0 ) {
    return;
}


$mid = COM_applyFilter($_GET['mid']);

$aid  = DB_getItem($_TABLES['mg_media_albums'], 'album_id','media_id="' . addslashes($mid) . '"');

if ( $MG_albums[$aid]->access == 0 ) {
    $display  = MG_siteHeader();
    $display .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',COM_getBlockTemplate ('_msg_block', 'header'))
             . '<br />' . $LANG_MG00['access_denied_msg']
             . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= MG_siteFooter();
    echo $display;
    exit;
}

$sql = "SELECT * FROM {$_TABLES['mg_media']} WHERE media_id='" . addslashes($mid) . "'";
$result = DB_query($sql);
$numRows = DB_numRows($result);
if ( $numRows > 0 ) {
    $row = DB_fetchArray($result);
    if ( $row['media_original_filename'] != "" ) {
        $filename = $row['media_original_filename'];
    } else {
        $filename = $row['media_filename'] . '.' . $row['media_mime_ext'];
    }
    if ( $row['mime_type'] == 'application/octet-stream' ) {
        switch ($row['media_mime_ext']) {
            case 'pdf' :
            case 'PDF' :
                $mime_type = 'application/pdf';
                break;
            default :
                $mime_type = $row['mime_type'];
                break;
        }
    } else {
        $mime_type = $row['mime_type'];
    }
    if (!$MG_albums[0]->owner_id) {
        $media_views = $row['media_views'] + 1;
        DB_query("UPDATE " . $_TABLES['mg_media'] . " SET media_views=" . $media_views . " WHERE media_id='" . addslashes($mid) . "'");
    }
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
    header("Cache-Control: private",false);
    header("Content-type:" . $mime_type);
    header("Content-Disposition: attachment; filename=\"" . $filename . "\";");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . filesize($_MG_CONF['path_mediaobjects'] . 'orig/' . $row['media_filename'][0] . '/' . $row['media_filename'] . '.' . $row['media_mime_ext']));

    $fp = fopen($_MG_CONF['path_mediaobjects'] . 'orig/' . $row['media_filename'][0] . '/' . $row['media_filename'] . '.' . $row['media_mime_ext'],'r');
    if ( $fp != NULL ) {
        while (!feof($fp)) {
            $buf = fgets($fp, 8192);
            echo $buf;
        }
        fclose($fp);
    }
}
return;
?>