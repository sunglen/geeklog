<?php
// +--------------------------------------------------------------------------+
// | Media Gallery Plugin for glFusion CMS                                    |
// +--------------------------------------------------------------------------+
// | $Id:: export.php 5847 2010-04-09 13:16:50Z mevans0263                   $|
// | Export routine for Media Gallery.                                        |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2005-2010 by the following authors:                        |
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
//

require_once '../../../lib-common.php';
require_once '../../auth.inc.php';

// Only let admin users access this page
if (!SEC_hasRights('mediagallery.config')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the Media Gallery Configuration page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: " . $_SERVER['REMOTE_ADDR'],1);
    $display  = COM_siteHeader();
    $display .= COM_startBlock($LANG_MG00['access_denied']);
    $display .= $LANG_MG00['access_denied_msg'];
    $display .= COM_endBlock();
    $display .= COM_siteFooter(true);
    echo $display;
    exit;
}

MG_initAlbums();

function MG_exportAlbums( $aid, $path, $srcRoot, $destRoot ) {
	global $MG_albums, $_TABLES, $fp,$mvorcopy,$unix;

	if ( $unix == 0 ) {
		$sep = '\\';
		$begin = '"';
		$end   = '"';
	} else {
		$sep = '/';
		$begin = "'";
		$end   = "'";
	}

	if ( $mvorcopy == 0 ) {
		if ( $unix == 1 ) {
			$cpyCmd = 'mv';
		} else {
			$cpyCmd = 'move';
		}
	} else {
		if ($unix == 1) {
			$cpyCmd = 'cp';
		} else {
			$cpyCmd = 'copy';
		}
	}

	$children = $MG_albums[$aid]->getChildren();
	$nrows    = count($children);

	if ($aid != 0 ) {
        $file_name = stripslashes($MG_albums[$aid]->title);
        $file_name = MG_replace_accents($file_name);
        if ( $unix == 1 ) {
        	$file_name = preg_replace("#[ ]#","_",$file_name);  // change spaces to underscore
      	    $file_name = preg_replace('#[^()\.\-,\w]#','_',$file_name);  //only parenthesis, underscore, letters, numbers, comma, hyphen, period - others to underscore
  	    } else {
      	    $file_name = preg_replace('#[^()\.\- \',\w]#','_',$file_name);  //only parenthesis, underscore, letters, numbers, comma, hyphen, period - others to underscore
		}
        $file_name = preg_replace('#(_)+#','_',$file_name);  //eliminate duplicate underscore
		$path = $path . $file_name . $sep;
	}
	if ( $aid != 0 ) {
		fputs($fp, 'mkdir ' . $begin . $destRoot . $path . $end . "\n");
	}
	$sql = "SELECT * FROM {$_TABLES['mg_media_albums']} as ma INNER JOIN " . $_TABLES['mg_media'] . " as m " .
           " ON ma.media_id=m.media_id WHERE ma.album_id=" . $aid;
    $result = DB_query($sql);
    while ($M = DB_fetchArray($result)) {
	    if ($M['media_original_filename'] != '' ) {
		    $destFile = $M['media_original_filename'];
	    } else {
		    $destFile = $M['media_filename'] . '.' . $M['media_mime_ext'];
	    }
        fputs($fp, $cpyCmd . " " . $begin . $srcRoot . $M['media_filename'][0] . $sep . $M['media_filename'] . '.' . $M['media_mime_ext'] . $end . " " . $begin .  $destRoot . $path . $destFile . $end . "\n");

    }
    fputs($fp,"\n\n");
	for ($i=0; $i<$nrows; $i++) {
		MG_exportAlbums($MG_albums[$children[$i]]->id,$path,$srcRoot,$destRoot);
	}
}

/*
* Main Function
*/

global $unix, $mvorcopy;

$mode = COM_applyFilter($_POST['mode']);

$srcRoot  = $_POST['srcroot'];
$destRoot = $_POST['destroot'];
$unix     = $_POST['unix'];
$mvorcopy = $_POST['moveorcopy'];
if ( $unix ) {
	$tmpFile = 'mgexport.sh';
} else {
	$tmpFile = 'mgexport.cmd';
}

if ( $unix == 0 ) {
	if ( $srcRoot[strlen($srcRoot)-1] != '\\' ) {
		$srcRoot = $srcRoot . '\\';
	}
	if ( $destRoot[strlen($destRoot)-1] != '\\') {
		$destRoot = $destRoot . '\\';
	}
} else {
	if ( $srcRoot[strlen($srcRoot)-1] != '/' ) {
		$srcRoot = $srcRoot . '/';
	}
	if ( $destRoot[strlen($destRoot)-1] != '/') {
		$destRoot = $destRoot . '/';
	}
}

if ( $mode == 'process' ) {
	$fp = fopen($_MG_CONF['tmp_path'] .  $tmpFile,'w+');
	if ( $unix ) {
		fputs($fp,"#!/bin/sh\n");
	}
	MG_exportAlbums(0,'',$srcRoot,$destRoot);
	fclose($fp);
	$display = COM_siteHeader();
	$display .= '<h1>Media Gallery Export Script Ready for Download</h1>';
	$display .= 'Media Gallery has completed building the import script.  Use the download button below to download the script to your local system, then run.';
	$display .= '<form method="post" action="' . $_MG_CONF['admin_url'] . 'export.php" name="mgexport" enctype="multipart/form-data" id="mgexport">';
	$display .= '<input type="hidden" name="unix" value="' . $unix . '">';
	$display .= '<input type="submit" name="mode" value="download">';
	$display .= '</form>';
	$display .= COM_siteFooter();
	echo $display;
	exit;
}
if ( $mode == 'download' ) {

	// this downloads the batch file

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
    header("Cache-Control: private",false);
    header("Content-type:application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $tmpFile . "\";");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . filesize($_MG_CONF['tmp_path'] . $tmpFile));

    $fp = fopen($_MG_CONF['tmp_path'] . $tmpFile,'r');
    if ( $fp != NULL ) {
        while (!feof($fp)) {
            $buf = fgets($fp, 8192);
            echo $buf;
        }
        fclose($fp);
    }
    exit;
}
// none of the above so display input screen...
$display = COM_siteHeader();
$T = new Template($_MG_CONF['template_path']);
$T->set_file( 'page','export.thtml');
$T->set_var(array(
    'site_url'          =>  $_CONF['site_url'],
    's_form_action'		=>  $_MG_CONF['admin_url'] . 'export.php',
));
$T->parse('output','page');
$display .= $T->finish($T->get_var('output'));
$display .= COM_siteFooter();
echo $display;
exit;
?>