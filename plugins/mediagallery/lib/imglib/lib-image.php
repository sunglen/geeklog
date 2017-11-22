<?php
// +--------------------------------------------------------------------------+
// | glFusion CMS                                                             |
// +--------------------------------------------------------------------------+
// | lib-image.php                                                            |
// |                                                                          |
// | glFusion media handling library.                                         |
// +--------------------------------------------------------------------------+
// | $Id:: lib-image.php 5164 2009-11-24 03:09:13Z mevans0263                $|
// +--------------------------------------------------------------------------+
// | Copyright (C) 2002-2008 by the following authors:                        |
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

if (!defined ('GVERSION')) {
    die ('This file can not be used on its own.');
}

/*
 * Include the proper graphics support package
 */

switch ( $_CONF['image_lib'] ) {
    case 'imagemagick' :    // ImageMagick...
        require_once $_CONF['path'] . 'plugins/mediagallery/lib/imglib/im_image.php';
        break;
    case 'netpbm' :    // NetPBM
        require_once $_CONF['path'] . 'plugins/mediagallery/lib/imglib/pbm_image.php';
        break;
    case 'gdlib' :    // GD Library
        require_once $_CONF['path'] . 'plugins/mediagallery/lib/imglib/gd_image.php';
        break;
    default:
        require_once $_CONF['path'] . 'plugins/mediagallery/lib/imglib/gd_image.php';
        break;
}

/* - the next two calls need to move to a new library -- */


function UTL_exec($cmd) {
    global $_CONF;

    $debugfile = "";
    $status="";
    $results=array();
    if ($_CONF['debug_image_upload'] ) {
        COM_errorLog(sprintf("UTL_exec: Executing: %s",$cmd));
    }

    $debugfile = $_CONF['path'] . 'logs/debug.log';

    if (PHP_OS == "WINNT") {
//        $cmd .= ">NUL 2>&1";
        exec('"' . $cmd . '"', $results, $status);
    } else {
        exec($cmd, $results, $status);
    }

    return array($results, $status);
}

function UTL_execWrapper($cmd) {

    list($results, $status) = UTL_exec($cmd);

    if ( $status == 0 ) {
        return true;
    } else {
        COM_errorLog("UTL_execWrapper: Failed Command: " . $cmd);
        return false;
    }
}

/**
 * Returns the mime type and other meta data for an image or multi-media file.
 *
 *
 * @param   string  $filename   The absolute path to the media file
 *
 * @return  string  An array of meta data - mime_type will always be set.
 *
 */

function MG_getMediaMetaData( $filename ) {
    global $_CONF;

    // include getID3() library
    require_once $_CONF['path'] . 'plugins/mediagallery/lib/getid3/getid3.php';
    // Needed for windows only
    define('GETID3_HELPERAPPSDIR', 'C:/helperapps/');

    $getID3 = new getID3;

    // Analyze file and store returned data in $ThisFileInfo
    $ThisFileInfo = $getID3->analyze($filename);
    getid3_lib::CopyTagsToComments($ThisFileInfo);

    if ( $_CONF['debug_image_upload'] ) {
        COM_errorLog("MG_getMediaMetaData: getID3 analyzing file: " . $filename);
        COM_errorLog("MG_getMediaMetaData: getID3 found mime_type: " . $ThisFileInfo['mime_type']);
    }

    if ( isset($ThisFileInfo['error']) ) {
        if ( is_array($ThisFileInfo['error']) ) {
            foreach ($ThisFileInfo['error'] AS $error ) {
                COM_errorLog("MG_getMediaMetaData: " . $error);
            }
        }
    }

    /*
     * Check to see if we failed on getting the mime type and do the additional checks here
     */
/* --- DO NOT USE EXTENSION CHECKING - TOO DANGEROUS!
    if ( !isset($ThisFileInfo['mime_type']) || $ThisFileInfo['mime_type'] == '' || $ThisFileInfo['mime_type'] == 'application/octet-stream' ) {
        $file_extension = strtolower(substr(strrchr($filename,"."),1));
        switch ($file_extension) {
            case 'flv':
                $ThisFileInfo['mime_type'] = 'video/x-flv';
                break;
            case 'wma' :
                $ThisFileInfo['mime_type'] = 'audio/x-ms-wma';
                break;
            case 'jpg' :
                $ThisFileInfo['mime_type'] = 'image/jpeg';
                break;
            case 'png' :
                $ThisFileInfo['mime_type'] = 'image/png';
                break;
            case 'bmp' :
                $ThisFileInfo['mime_type'] = 'image/bmp';
                break;
            case 'gif' :
                $ThisFileInfo['mime_type'] = 'image/gif';
                break;
            case "exe":
                $ThisFileInfo['mime_type'] = 'application/octet-stream';
                break;
            case "zip":
                $ThisFileInfo['mime_type'] = 'application/zip';
                break;
            case "mp3":
                $ThisFileInfo['mime_type'] = 'audio/mpeg';
                break;
            case "mpg":
                $ThisFileInfo['mime_type'] = 'video/mpeg';
                break;
            case "avi":
                $ThisFileInfo['mime_type'] = 'video/x-msvideo';
                break;
            case 'tga' :
                $ThisFileInfo['mime_type'] = 'image/tga';
                break;
            case 'psd' :
                $ThisFileInfo['mime_type'] = 'image/psd';
                break;
            default:
                $ThisFileInfo['mime_type'] = 'application/octet-stream';
                break;
        }

        COM_errorLog("MG_getMediaMetaData: getID3() failed to return mime type, using file extension check.  Mime type detected is " . $ThisFileInfo['mime_type']);
    }
    ---------- */
    return $ThisFileInfo;
}

/**
 * Takes an image file and resizes it
 *
 * @param   string  $srcImage       Absolute path to the source image
 * @param   string  $destImage      Absolute path to the destination image
 * @param   string  $dImageHeight   Destination image height
 * @param   string  $dImageWidth    Destination image width
 * @param   string  $mimeType       Source image mime type, if known
 * @param   bool    $deleteSrc      Should the source image be deleted after resizing
 *
 * @return  array   Returns $rc and $msg. $msg will be set if there was an error
 *
 * Note: $srcImage and $destImage can be the same location in which case the
 *       original image will be resized
 */

function MG_resizeImage($srcImage, $destImage, $dImageHeight, $dImageWidth, $mimeType='', $deleteSrc=0, $JpegQuality=85) {
    global $_CONF, $_MG_CONF;

    if ( $dImageHeight == 0 ) {
        $dImageHeight = 200;
    }
    if ( $dImageWidth == 0 ) {
        $dImageWidth = 200;
    }

    $imgsize    = @getimagesize("$srcImage");
    $imgwidth   = $imgsize[0];
    $imgheight  = $imgsize[1];
    if ($imgwidth == 0 || $imgheight == 0 ) {
        $imgwidth   = $dImageWidth;
        $imgheight  = $dImageHeight;
    }

    if ( $mimeType == '' ) {
        $metaData = MG_getMediaMetaData($srcImage);
        $mimeType = $metaData['mime_type'];
    }

    if ( $mimeType == 'image/x-targa' || $mimeType == 'image/tga' ) {
        $fp = @fopen($srcImage,'rb');
        if ( $fp == false ) {
            return array(false,'Failed to open source TGA image.');
        }
        $data = fread($fp,filesize($srcImage));
        fclose($fp);
        $imgwidth = base_convert(bin2hex(strrev(substr($data,12,2))),16,10);
        $imgheight = base_convert(bin2hex(strrev(substr($data,12,2))),16,10);
        COM_errorLog("TGA resolution: height: " . $imgheight . " width: " . $imgwidth);
    }

    if ( $imgwidth > $imgheight ) {
        $ratio = $imgwidth / $dImageWidth;
        $newwidth = $dImageWidth;
        $newheight = round($imgheight / $ratio);
    } else {
        $ratio = $imgheight / $dImageHeight;
        $newheight = $dImageHeight;
        $newwidth = round($imgwidth / $ratio);
    }

    // check to see if srcImage is smaller than desired target,
    // if smaller, do not upsize, simply copy the src to the dest.

    if ( ( $newheight > $imgheight) && ($newwidth > $imgwidth ) )  {
        $rc = copy($srcImage, $destImage);
        COM_errorLog("MG_resizeImage: Original (" . $srcImage . ") is smaller than target, original copied to target image (" . $destImage . ".");
        return array(true,'Original is smaller than target, original copied to target image.');
    }

    list($rc, $msg) = _img_resizeImage($srcImage, $destImage, $imgheight, $imgwidth, $newheight, $newwidth, $mimeType, $JpegQuality);
    if ( $rc == false ) {
        return array($rc, $msg);
    }

    return array(true,'Image successfully resized');
}

/*
 * Rotates an image left or right 90 degrees
 */

function MG_rotateImage( $srcImage, $direction ) {
    global $_CONF, $_MG_CONF;

    $metaData = MG_getMediaMetaData($srcImage);
    $mimeType = $metaData['mime_type'];

    /*
     * Check image format, jpegtan will only work for JPG images
     */

    if ( $_MG_CONF['jpegtran_enabled'] == 1 && ($mimeType == 'image/jpeg' || $mimeType == 'image/jpg') ) {
        switch( $direction ) {
            case 'right' :
                $JT_rotate = "90";
                break;
            case 'left' :
                $JT_rotate = "270";
                break;
            default :
                COM_errorLog("MG_rotateImage: Invalid direction passed to rotate, must be left or right");
                return array(false,'Invalid direction passed to rotate, must be left or right');
        }
        $tmpImage   = $srcImage . '.rt';

        $rc = UTL_execWrapper('"' . $_CONF['path_to_jpegtran'] . "/jpegtran" . '"' . " -rotate " . $JT_rotate . " -trim \"$srcImage\" > \"$tmpImage\"");

        if ( $rc != true ) {
            @unlink($tmpImage);
            return array(false,'IMG Rotate: Error rotating image');
        }
        clearstatcache();
        $rtFileSize = 0;
        $rtFileSize = @filesize($tmpImage);
        if ( $rtFileSize < 1 ) {
            @unlink($tmpImage);
            return array(false,'IMG Rotate: Error rotating image');
        }
        if ( $_MG_CONF['jhead_enabled'] == 1 ) {
            $rc = UTL_execWrapper('"' . $_CONF['jhead_path'] . "/jhead" . '"' . " -te " . $srcImage . " " . $tmpImage);
            COM_errorLog("MG_rotateImage: jhead returned " . $rc );
        }
        $rc = @copy($tmpImage, $srcImage);
        @unlink($tmpImage);
        return array(true,'');
    } else {
        list($rc,$msg) = _img_RotateImage($srcImage, $direction, $mimeType);
        return array($rc,$msg);
    }
}

/*
 * convert an image from one format to another
 */

function MG_convertImageFormat ( $srcImage, $destImage, $destFormat, $deleteOriginal=1 ) {
    global $_CONF;

    $newSrc = $srcImage;

    if ($_CONF['debug_image_upload'] ) {
        COM_errorLog("MG_convertImageFormat: Entering MG_convertImageFormat()");
    }

    $metaData = array();

    $metaData = MG_getMediaMetaData($srcImage);
    $mimeType = $metaData['mime_type'];

    $imgsize = @getimagesize($srcImage);
    if ( $imgsize == false &&
         $mimeType != 'image/x-targa' &&
         $mimeType != 'image/tga' &&
         $mimeType != 'image/photoshop' &&
         $mimeType != 'image/x-photoshop' &&
         $mimeType != 'image/psd' &&
         $mimeType != 'application/photoshop' &&
         $mimeType != 'application/psd' &&
         $mimeType != 'image/tiff' ) {
        COM_errorLog("MG_convertImageFormat: Error - unable to retrieve srcImage resolution");
        return array(false,'Unable to determine source image resolution');
    }

    $imgwidth = $imgsize[0];
    $imgheight = $imgsize[1];

    if ($imgsize == false || $imgwidth == 0 || $imgheight == 0 ) {
        $imgwidth = 620;
        $imgheight = 465;
    }
    if ( $mimeType == $destFormat ) {
        if ( $srcImage != $destImage ) {
            $rc = copy($srcImage, $destImage);
        }
        return array(true,'Original image copied to destination image.');
    }

    list($rc,$msg) = _img_convertImageFormat($srcImage,$destImage,$destFormat, $mimeType);

    return array($rc,$msg);
}

function MG_watermarkImage( $origImage, $watermarkImage, $opacity, $location ) {
    global $_MG_CONF, $_CONF;

    if ( $_CONF['debug_image_upload'] ) {
        COM_errorLog("MG_watermarkImage: Entering MG_watermarkImage()");
    }

    $mType = MG_getMediaMetaData($origImage);
    $mimeType = $mType['mime_type'];

    if ( !in_array($mimeType,$_MG_CONF['watermark_types']) ) {
        COM_errorLog("MG_watermarkImage: Media type is not in allowed watermark types (config.php)");
        return false;
    }

    list($rc,$msg) = _img_watermarkImage($origImage, $watermarkImage, $opacity, $location, $mimeType );
    return array($rc,$msg);
}

/**
 * Takes an image file and resizes it
 *
 * @param   string  $srcImage       Absolute path to the source image
 * @param   string  $destImage      Absolute path to the destination image
 * @param   string  $dImageHeight   Destination image height
 * @param   string  $dImageWidth    Destination image width
 * @param   string  $mimeType       Source image mime type, if known
 * @param   bool    $deleteSrc      Should the source image be deleted after resizing
 *
 * @return  array   Returns $rc and $msg. $msg will be set if there was an error
 *
 * Note: $srcImage and $destImage can be the same location in which case the
 *       original image will be resized
 */
// added by dengen
function MG_resizeImage_crop($srcImage, $destImage, $dImageHeight, $dImageWidth, $mimeType='', $deleteSrc=0, $JpegQuality=85) {
    global $_CONF;

    if ( $dImageHeight == 0 ) {
        $dImageHeight = 200;
    }
    if ( $dImageWidth == 0 ) {
        $dImageWidth = 200;
    }

    $imgsize    = @getimagesize("$srcImage");
    $imgwidth   = $imgsize[0];
    $imgheight  = $imgsize[1];
    if ($imgwidth == 0 || $imgheight == 0 ) {
        $imgwidth   = $dImageWidth;
        $imgheight  = $dImageHeight;
    }

    if ( $mimeType == '' ) {
        $metaData = MG_getMediaMetaData($srcImage);
        $mimeType = $metaData['mime_type'];
    }

    if ( $mimeType == 'image/x-targa' || $mimeType == 'image/tga' ) {
        $fp = @fopen($srcImage,'rb');
        if ( $fp == false ) {
            return array(false,'Failed to open source TGA image.');
        }
        $data = fread($fp,filesize($srcImage));
        fclose($fp);
        $imgwidth = base_convert(bin2hex(strrev(substr($data,12,2))),16,10);
        $imgheight = base_convert(bin2hex(strrev(substr($data,12,2))),16,10);
        COM_errorLog("TGA resolution: height: " . $imgheight . " width: " . $imgwidth);
    }

    $dAspectRatio = $dImageWidth / $dImageHeight;
    $sAspectRatio = $imgwidth / $imgheight;
    $newwidth  = $dImageWidth;
    $newheight = $dImageHeight;
    $new_x = 0;
    $new_y = 0;

    if ( $dAspectRatio > $sAspectRatio ) {
        
        $src_w = $imgwidth;
        $src_h = intval(round($imgwidth / $dAspectRatio));
        $src_x = 0;
        $src_y = intval(round(($imgheight - $src_h) / 2));

    } else {

        $src_w = intval(round($imgheight * $dAspectRatio));
        $src_h = $imgheight;
        $src_x = intval(round(($imgwidth - $src_w) / 2));
        $src_y = 0;
    }

    // check to see if srcImage is smaller than desired target,
    // if smaller, do not upsize, simply copy the src to the dest.

    if ( ( $newheight > $imgheight) && ($newwidth > $imgwidth ) )  {
        $rc = copy($srcImage, $destImage);
        COM_errorLog("MG_resizeImage_square: Original (" . $srcImage . ") is smaller than target, original copied to target image (" . $destImage . ".");
        return array(true,'Original is smaller than target, original copied to target image.');
    }

    list($rc,$msg) = _img_resizeImage_crop($srcImage, $destImage,
                                           $src_x, $src_y,
                                           $new_x, $new_y,
                                           $src_h, $src_w,
                                           $newheight, $newwidth,
                                           $mimeType,
                                           $JpegQuality);
    if ( $rc == false ) {
        return array($rc,$msg);
    }
    return array(true,'Image successfully resized');
}

