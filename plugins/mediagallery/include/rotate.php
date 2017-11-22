<?php
// +--------------------------------------------------------------------------+
// | Media Gallery Plugin - glFusion CMS                                      |
// +--------------------------------------------------------------------------+
// | rotate.php                                                               |
// |                                                                          |
// | Image rotation routines                                                  |
// +--------------------------------------------------------------------------+
// | $Id:: rotate.php 3070 2008-09-07 02:40:49Z mevans0263                   $|
// +--------------------------------------------------------------------------+
// | Copyright (C) 2002-2009 by the following authors:                        |
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

// this file can't be used on its own
if (!defined ('GVERSION')) {
    die ('This file can not be used on its own.');
}

require_once $_CONF['path'] . 'plugins/mediagallery/lib/imglib/lib-image.php';

function MG_rotateMedia( $album_id, $media_id, $direction, $actionURL='') {
    global $_TABLES, $_MG_CONF, $_POST;

    $sql = "SELECT * FROM " . $_TABLES['mg_media'] . " WHERE media_id='" . addslashes($media_id) . "'";
    $result=DB_query($sql);
    $row = DB_fetchArray($result);
    if ( DB_error() != 0 )  {
        COM_errorLog("MG_rotateMedia: Unable to retrieve media object data");
        if ( $actionURL == '' ) {
            return false;
        }
        echo COM_refresh( $actionURL );
        exit;
    }
    $filename = $row['media_filename'];

    $media_size = false;
    foreach ($_MG_CONF['validExtensions'] as $ext ) {
        if ( file_exists($_MG_CONF['path_mediaobjects'] . 'tn/'   . $filename[0] . '/' . $filename . $ext) ) {
            $tn     = $_MG_CONF['path_mediaobjects'] . 'tn/'   . $filename[0] . '/' . $filename . $ext;
            $disp = $_MG_CONF['path_mediaobjects'] . 'disp/' . $filename[0] . '/' . $filename . $ext;
            break;
        }
    }
    $orig   = $_MG_CONF['path_mediaobjects'] . 'orig/' . $filename[0] . '/' . $filename . '.' . $row['media_mime_ext'];

    list($rc,$msg) = MG_rotateImage( $tn, $direction );
    list($rc,$msg) = MG_rotateImage( $disp, $direction );
    list($rc,$msg) = MG_rotateImage( $orig, $direction );

    if ( $actionURL == -1 || $actionURL == '' )
        return true;

    echo COM_refresh( $actionURL . '&t=' . time() );
    exit;
}
?>