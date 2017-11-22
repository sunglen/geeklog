<?php
// +--------------------------------------------------------------------------+
// | Media Gallery Plugin - glFusion CMS                                      |
// +--------------------------------------------------------------------------+
// | album_rpc.php                                                            |
// |                                                                          |
// | AJAX component to retrieve album attributes                              |
// +--------------------------------------------------------------------------+
// | $Id:: album_rpc.php 5614 2010-03-19 19:08:33Z mevans0263                $|
// +--------------------------------------------------------------------------+
// | Copyright (C) 2009-2010 by the following authors:                        |
// |                                                                          |
// | Mark A. Howard         mark AT usable-web DOT com                        |
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

global $_CONF, $_MG_CONF, $MG_albums;

// main

if ( COM_isAnonUser() && $_MG_CONF['loginrequired'] == 1 )  {
    exit;
}

if( $_MG_CONF['verbose'] ) {
    COM_errorLog( 'album_rpc.php: invocation ------------------------' );
}

if( isset( $_REQUEST['aid'] ) ) {

    // retrieve the album_id passed
    $album_id = COM_applyFilter( $_REQUEST['aid'], true );
    if( $_MG_CONF['verbose'] ) {
        COM_errorLog( 'album_id=' . $album_id );
    }

    // initialize the $MG_albums array
    MG_initAlbums();
    $albums = sizeof( $MG_albums );
    if( $_MG_CONF['verbose'] ) {
        COM_errorLog( 'initialized ' . $albums . ' albums' );
    }

    // check to ensure we have a valid album_id
    if ( isset($MG_albums[$album_id]->id) && $MG_albums[$album_id]->id == $album_id ) {
        // retrieve the upload filesize limit
        $size_limit = MG_getUploadLimit( $album_id );

        // retrieve the valid filetypes
        $valid_types = MG_getValidFileTypes( $album_id );
    } else {
        COM_errorLog( 'album_rpc.php: invalid album id' );
        $size_limit = 0;
        $valid_types = '';
    }

    // return the album-specific data
    echo $size_limit . '%' . $valid_types;

    if( $_MG_CONF['verbose'] ) {
        COM_errorLog( 'size_limit=' . $size_limit );
        COM_errorLog( 'valid_types=' . $valid_types );
        COM_errorLog( 'album_rpc.php: normal termination ----------------' );
    }

} else {
    COM_errorLog( 'album_rpc.php: invocation with no album parameter' );
}
exit(0);
?>