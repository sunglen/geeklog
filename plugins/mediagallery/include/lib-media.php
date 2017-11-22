<?php
// +--------------------------------------------------------------------------+
// | Media Gallery Plugin - glFusion CMS                                      |
// +--------------------------------------------------------------------------+
// | lib-media.php                                                            |
// |                                                                          |
// | General purpose media display / manipulation interface                   |
// +--------------------------------------------------------------------------+
// | $Id:: lib-media.php 5598 2010-03-19 13:24:45Z mevans0263                $|
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

// this file can't be used on its own
if (!defined ('GVERSION')) {
    die ('This file can not be used on its own.');
}

// require_once $_CONF['path'] . 'plugins/mediagallery/include/classFrame.php';

function MG_getNextitem($num_items, $start_item, $is_next = TRUE)
{
    global $_MG_CONF;

    if ($num_items <= 1) return 0;
    $retval = '';
    if ($is_next) { // next item index
        if ($start_item < $num_items - 1) {
            $retval = $start_item + 1;
        } else {
            $retval = $_MG_CONF['enable_loop_pagination'] ? 0 : '';
        }
    } else {        // previous item index
        if ($start_item > 0) {
            $retval = $start_item - 1;
        } else {
            $retval = $_MG_CONF['enable_loop_pagination'] ? ($num_items - 1) : '';
        }
    }
    return $retval;
}

/*
 * Generate the prev and next links for media browsing.
 */
function MG_getNextandPrev($base_url, $num_items, $start_item, &$media)
{
    if ($num_items <= 1) return array('', '');

    $prev_string = '';
    $next_string = '';
    $base_url .= strstr( $base_url, '?' ) ? "&amp;s=" : "?s=";

    $prev = MG_getNextitem($num_items, $start_item, FALSE);
    if ($prev !== '') {
        $prev_string = $base_url . $media[$prev]['media_id'];
    }

    $next = MG_getNextitem($num_items, $start_item, TRUE);
    if ($next !== '') {
        $next_string = $base_url . $media[$next]['media_id'];
    }

    return array($prev_string, $next_string);
}

function MG_displayASF( $aid, $I, $full ) {
    global $_TABLES, $_CONF, $_MG_CONF, $_MG_USERPREFS, $MG_albums;

    $retval = '';

    // set the default playback options...

    $playback_options['autostart']          = $_MG_CONF['asf_autostart'];
    $playback_options['enablecontextmenu']  = $_MG_CONF['asf_enablecontextmenu'];
    $playback_options['stretchtofit']       = $_MG_CONF['asf_stretchtofit'];
    $playback_options['showstatusbar']      = $_MG_CONF['asf_showstatusbar'];
    $playback_options['uimode']             = $_MG_CONF['asf_uimode'];
    $playback_options['height']             = $_MG_CONF['asf_height'];
    $playback_options['width']              = $_MG_CONF['asf_width'];
    $playback_options['bgcolor']            = $_MG_CONF['asf_bgcolor'];
    $playback_options['playcount']          = $_MG_CONF['asf_playcount'];

    $poResult = DB_query("SELECT * FROM {$_TABLES['mg_playback_options']} WHERE media_id='" . addslashes($I['media_id']) . "'");
    while ($poRow = DB_fetchArray($poResult)) {
        $playback_options[$poRow['option_name']] = $poRow['option_value'];
    }

    if (isset($_MG_USERPREFS['playback_mode']) && $_MG_USERPREFS['playback_mode'] != -1 ) {
        $playback_type = $_MG_USERPREFS['playback_mode'];
    } else {
        $playback_type = $MG_albums[$aid]->playback_type;
    }
    if ( isset($I['media_resolution_x']) && $I['media_resolution_x'] > 0 ) {
        $resolution_x = $I['media_resolution_x'];
        $resolution_y = $I['media_resolution_y'];
    } else {
        if ( $I['media_resolution_x'] == 0 ) {
            require_once $_CONF['path'] . '/lib/getid3/getid3.php';
            // Needed for windows only
            define('GETID3_HELPERAPPSDIR', 'C:/helperapps/');

            $getID3 = new getID3;
            // Analyze file and store returned data in $ThisFileInfo
            $ThisFileInfo = $getID3->analyze($_MG_CONF['path_mediaobjects'] . 'orig/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext']);
            getid3_lib::CopyTagsToComments($ThisFileInfo);
            if ( $ThisFileInfo['video']['resolution_x'] < 1 || $ThisFileInfo['video']['resolution_y'] < 1 ) {
                if (isset($ThisFileInfo['meta']['onMetaData']['width']) && isset($ThisFileInfo['meta']['onMetaData']['height']) ) {
                    $resolution_x = $ThisFileInfo['meta']['onMetaData']['width'];
                    $resolution_y = $ThisFileInfo['meta']['onMetaData']['height'];
                } else {
                    $resolution_x = -1;
                    $resolution_y = -1;
                }
            } else {
                $resolution_x = $ThisFileInfo['video']['resolution_x'];
                $resolution_y = $ThisFileInfo['video']['resolution_y'];
            }
            if ( $resolution_x != 0 ) {
                $sql = "UPDATE " . $_TABLES['mg_media'] . " SET media_resolution_x=" . intval($resolution_x) . ",media_resolution_y=" . intval($resolution_y) . " WHERE media_id='" . addslashes($I['media_id']) . "'";
                DB_query( $sql );
            }
        } else {
            $resolution_x = $I['media_resolution_x'];
            $resolution_y = $I['media_resolution_y'];
        }
    }
    $raw_link_url = '';
    switch ($playback_type) {
        case 0 :                    // Popup Window
            $win_width = $playback_options['width'] + 40;
            $win_height = $playback_options['height'] + 40;
            $u_pic = "javascript:showVideo('" . $_MG_CONF['site_url'] . "/video.php?n=" . $I['media_id'] . "'," . $win_height . "," . $win_width . ")";
            $raw_link_url = "javascript:showVideo('" . $_MG_CONF['site_url'] . "/video.php?n=" . $I['media_id'] . "'," . $win_height . "," . $win_width . ")";
            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/wmp.png';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'wmp.png');
            }
            break;
        case 1: // download
            $u_pic = $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'];
            $raw_link_url = $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'];
            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/wmp.png';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'wmp.png');
            }
            break;
        case 2 :    // inline
            $V = MG_templateInstance( MG_getTemplatePath($aid) );
            $V->set_file (array ('video' => 'view_asf.thtml'));
            $V->set_var(array(
                'autostart'         => ($playback_options['autostart'] ? 'true' : 'false'),
                'enablecontextmenu' => ($playback_options['enablecontextmenu'] ? 'true' : 'false'),
                'stretchtofit'      => ($playback_options['stretchtofit'] ? 'true' : 'false'),
                'showstatusbar'     => ($playback_options['showstatusbar'] ? 'true' : 'false'),
                'uimode'            => $playback_options['uimode'],
                'playcount'         => $playback_options['playcount'],
                'height'            => $playback_options['height'] + 45,
                'width'             => $playback_options['width'],
                'bgcolor'           => $playback_options['bgcolor'],
                'movie'             => $_MG_CONF['mediaobjects_url'] . '/orig/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext'],
                'autostart0'         => ($playback_options['autostart'] ? '1' : '0'),
                'enablecontextmenu0' => ($playback_options['enablecontextmenu'] ? '1' : '0'),
                'stretchtofit0'      => ($playback_options['stretchtofit'] ? '1' : '0'),
                'showstatusbar0'     => ($playback_options['showstatusbar'] ? '1' : '0'),
                'xhtml'              => XHTML,
            ));
            switch ($playback_options['uimode'] ) {
                case 'mini' :
                case 'full' :
                    $V->set_var(array(
                        'showcontrols'         => 'true',
                        'showcontrols0'         => '1',
                    ));
                    break;
                case 'none' :
                    $V->set_var(array(
                        'showcontrols'         => 'false',
                        'showcontrols0'        => '0',
                    ));
                    break;
            }
            $V->parse('output','video');
            $u_image = $V->finish($V->get_var('output'));
            return array($u_image,'',$resolution_x,$resolution_y,'');
            break;
        case 3: // use mms links
            $mms_path = preg_replace("/http/i",'mms',$_MG_CONF['mediaobjects_url']);
            $u_pic = $mms_path . '/orig/'.  $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext'];
            $raw_link_url = $mms_path . '/orig/'.  $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext'];
            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/video.png';
                $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'video.png');
            }
            break;
    }

    $imageWidth  = $media_size_disp[0];
    $imageHeight = $media_size_disp[1];

    //frame
    $F = new Template($_MG_CONF['template_path']);
    $F->set_var('media_frame',$MG_albums[$aid]->displayFrameTemplate);
    $F->set_var(array(
        'media_link_start'  => '<a href="' . $u_pic . '">',
        'media_link_end'    => '</a>',
        'url_media_item'    =>  $u_pic,
        'media_thumbnail'   =>  $u_image,
        'media_size'        =>  'width="' . $imageWidth . '" height="' . $imageHeight . '"',
        'media_height'      =>  $imageHeight,
        'media_width'       =>  $imageWidth,
        'border_width'      =>  $imageWidth  + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'border_height'     =>  $imageHeight + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'media_title'       =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
        'media_tag'         =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
        'frWidth'           =>  $imageWidth  - $MG_albums[$aid]->dfrWidth,
        'frHeight'          =>  $imageHeight - $MG_albums[$aid]->dfrHeight,
        'xhtml'             =>  XHTML,
    ));
    $F->parse('media','media_frame');
    $retval .= $F->finish($F->get_var('media'));
    return array($retval,$u_image,$imageWidth,$imageHeight,$raw_link_url);
//    return $retval;
}

function MG_displayMOV( $aid, $I, $full ) {
    global $_TABLES, $_CONF, $_MG_CONF, $_MG_USERPREFS, $MG_albums, $LANG_MG03;

    $retval = '';

    // set the default playback options...
    $playback_options['autoref']        = $_MG_CONF['mov_autoref'];
    $playback_options['autoplay']       = $_MG_CONF['mov_autoplay'];
    $playback_options['controller']     = $_MG_CONF['mov_controller'];
    $playback_options['kioskmode']      = $_MG_CONF['mov_kioskmode'];
    $playback_options['scale']          = $_MG_CONF['mov_scale'];
    $playback_options['loop']           = $_MG_CONF['mov_loop'];
    $playback_options['height']         = $_MG_CONF['mov_height'];
    $playback_options['width']          = $_MG_CONF['mov_width'];
    $playback_options['bgcolor']        = $_MG_CONF['mov_bgcolor'];

    $poResult = DB_query("SELECT * FROM {$_TABLES['mg_playback_options']} WHERE media_id='" . addslashes($I['media_id']) . "'");
    while ( $poRow = DB_fetchArray($poResult) ) {
        $playback_options[$poRow['option_name']] = $poRow['option_value'];
    }
    if (isset($_MG_USERPREFS['playback_mode']) && $_MG_USERPREFS['playback_mode'] != -1 ) {
        $playback_type = $_MG_USERPREFS['playback_mode'];
    } else {
        $playback_type = $MG_albums[$aid]->playback_type;
    }

    if ( isset($I['resolution_x']) && $I['resolution_x'] > 0 ) {
        $resolution_x = $I['resolution_x'];
        $resolution_y = $I['resolution_y'];
    } else {
        if ( $I['media_resolution_x'] == 0 ) {
            require_once $_CONF['path'] . 'plugins/mediagallery/lib/getid3/getid3.php';
            // Needed for windows only
            define('GETID3_HELPERAPPSDIR', 'C:/helperapps/');

            $getID3 = new getID3;
            // Analyze file and store returned data in $ThisFileInfo
            $ThisFileInfo = $getID3->analyze($_MG_CONF['path_mediaobjects'] . 'orig/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext']);
            getid3_lib::CopyTagsToComments($ThisFileInfo);
            if ( $ThisFileInfo['video']['resolution_x'] < 1 || $ThisFileInfo['video']['resolution_y'] < 1 ) {
                if (isset($ThisFileInfo['meta']['onMetaData']['width']) && isset($ThisFileInfo['meta']['onMetaData']['height']) ) {
                    $resolution_x = $ThisFileInfo['meta']['onMetaData']['width'];
                    $resolution_y = $ThisFileInfo['meta']['onMetaData']['height'];
                } else {
                    $resolution_x = -1;
                    $resolution_y = -1;
                }
            } else {
                $resolution_x = $ThisFileInfo['video']['resolution_x'];
                $resolution_y = $ThisFileInfo['video']['resolution_y'];
            }
            if ( $resolution_x != 0 ) {
                $sql = "UPDATE " . $_TABLES['mg_media'] . " SET media_resolution_x=" . intval($resolution_x) . ",media_resolution_y=" . intval($resolution_y) . " WHERE media_id='" . addslashes($I['media_id']) . "'";
                DB_query( $sql );
            }
        } else {
            $resolution_x = $I['media_resolution_x'];
            $resolution_y = $I['media_resolution_y'];
        }
    }

    switch ($playback_type) {
        case 0 :                    // Popup Window
            $win_width = $playback_options['width'] + 40;
            $win_height = $playback_options['height'] + 40;
            $u_pic = "javascript:showVideo('" . $_MG_CONF['site_url'] . "/video.php?n=" . $I['media_id'] . "'," . $win_height . "," . $win_width . ")";
            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/quicktime.png';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'quicktime.png');
            }
            break;
        case 1: // download
        case 3: // use mms links
            $u_pic = $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'];
            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/quicktime.png';
                $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'quicktime.png');
            }
            break;
        case 2 :    // inline
            $V = MG_templateInstance( MG_getTemplatePath($aid) );
            $V->set_file (array ('video' => 'view_quicktime.thtml'));
            $V->set_var(array(
                'site_url'      => $_MG_CONF['site_url'],
                'autoref'       => ($playback_options['autoref'] ? 'true' : 'false'),
                'autoplay'      => ($playback_options['autoplay'] ? 'true' : 'false'),
                'controller'    => ($playback_options['controller'] ? 'true' : 'false'),
                'kioskmode'     => ($playback_options['kioskmode'] ? 'true' : 'false'),
                'loop'          => ($playback_options['loop'] ? 'true' : 'false'),
                'scale'         => $playback_options['scale'],
                'height'        => $playback_options['height'] + ($playback_options['controller'] ? 20 : 0),
                'width'         => $playback_options['width'],
                'bgcolor'       => $playback_options['bgcolor'],
                'movie'         => $_MG_CONF['mediaobjects_url'] . '/orig/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext'],
                'filename'      => $I['media_original_filename'],
                'lang_noquicktime' => $LANG_MG03['no_quicktime'],
                'xhtml'         => XHTML,
            ));
            $V->parse('output','video');
            $u_image = $V->finish($V->get_var('output'));
            return array($u_image,'',$resolution_x,$resolution_y,'');
            break;
    }

    $imageWidth  = $media_size_disp[0];
    $imageHeight = $media_size_disp[1];

    //frame
    $F = new Template($_MG_CONF['template_path']);
    $F->set_var('media_frame',$MG_albums[$aid]->displayFrameTemplate);
    $F->set_var(array(
        'media_link_start'  =>  '<a href="' . $u_pic . '">',
        'media_link_end'    =>  '</a>',
        'url_media_item'    =>  $u_pic,
        'media_thumbnail'   =>  $u_image,
        'media_size'        =>  'width="' . $imageWidth . '" height="' . $imageHeight . '"',
        'media_height'      =>  $imageHeight,
        'media_width'       =>  $imageWidth,
        'border_width'      =>  $imageWidth  + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'border_height'     =>  $imageHeight + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'media_title'       =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
        'media_tag'         =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
        'frWidth'           =>  $imageWidth  - $MG_albums[$aid]->dfrWidth,
        'frHeight'          =>  $imageHeight - $MG_albums[$aid]->dfrHeight,
        'xhtml'             =>  XHTML,
    ));
    $F->parse('media','media_frame');
    $retval .= $F->finish($F->get_var('media'));
    return array($retval,$u_image,$imageWidth,$imageHeight,$u_pic);
//    return $retval;
}

function MG_displaySWF( $aid, $I, $full ) {
    global $_TABLES, $_CONF, $_MG_CONF, $_MG_USERPREFS, $MG_albums, $LANG_MG03;

    $retval = '';

    // set the default playback options...
    $playback_options['play']    = $_MG_CONF['swf_play'];
    $playback_options['menu']    = $_MG_CONF['swf_menu'];
    $playback_options['quality'] = $_MG_CONF['swf_quality'];
    $playback_options['height']  = $_MG_CONF['swf_height'];
    $playback_options['width']   = $_MG_CONF['swf_width'];
    $playback_options['loop']    = $_MG_CONF['swf_loop'];
    $playback_options['scale']   = $_MG_CONF['swf_scale'];
    $playback_options['wmode']   = $_MG_CONF['swf_wmode'];
    $playback_options['allowscriptaccess'] = $_MG_CONF['swf_allowscriptaccess'];
    $playback_options['bgcolor']    = $_MG_CONF['swf_bgcolor'];
    $playback_options['swf_version'] = $_MG_CONF['swf_version'];
    $playback_options['flashvars']   = $_MG_CONF['swf_flashvars'];

    $poResult = DB_query("SELECT * FROM {$_TABLES['mg_playback_options']} WHERE media_id='" . addslashes($I['media_id']) . "'");
    while ( $poRow = DB_fetchArray($poResult) ) {
        $playback_options[$poRow['option_name']] = $poRow['option_value'];
    }
    if (isset($_MG_USERPREFS['playback_mode']) && $_MG_USERPREFS['playback_mode'] != -1 ) {
        $playback_type = $_MG_USERPREFS['playback_mode'];
    } else {
        $playback_type = $MG_albums[$aid]->playback_type;
    }
    if ( $I['resolution_x'] > 0 ) {
        $resolution_x = $I['resolution_x'];
        $resolution_y = $I['resolution_y'];
    } else {
        if ( $I['media_resolution_x'] == 0 ) {
            require_once $_CONF['path'] . 'plugins/mediagallery/lib/getid3/getid3.php';
            // Needed for windows only
            define('GETID3_HELPERAPPSDIR', 'C:/helperapps/');

            $getID3 = new getID3;
            // Analyze file and store returned data in $ThisFileInfo
            $ThisFileInfo = $getID3->analyze($_MG_CONF['path_mediaobjects'] . 'orig/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext']);
            getid3_lib::CopyTagsToComments($ThisFileInfo);
            if ( $ThisFileInfo['video']['resolution_x'] < 1 || $ThisFileInfo['video']['resolution_y'] < 1 ) {
                if (isset($ThisFileInfo['meta']['onMetaData']['width']) && isset($ThisFileInfo['meta']['onMetaData']['height']) ) {
                    $resolution_x = $ThisFileInfo['meta']['onMetaData']['width'];
                    $resolution_y = $ThisFileInfo['meta']['onMetaData']['height'];
                } else {
                    $resolution_x = -1;
                    $resolution_y = -1;
                }
            } else {
                $resolution_x = $ThisFileInfo['video']['resolution_x'];
                $resolution_y = $ThisFileInfo['video']['resolution_y'];
            }
            if ( $resolution_x != 0 ) {
                $sql = "UPDATE " . $_TABLES['mg_media'] . " SET media_resolution_x=" . intval($resolution_x) . ",media_resolution_y=" . intval($resolution_y) . " WHERE media_id='" . addslashes($I['media_id']) . "'";
                DB_query( $sql );
            }
        } else {
            $resolution_x = $I['media_resolution_x'];
            $resolution_y = $I['media_resolution_y'];
        }
    }
    switch ($playback_type) {
        case 0 :                    // Popup Window
            $win_width  = $playback_options['width'] + 40;
            $win_height = $playback_options['height'] + 40;
            $u_pic = "javascript:showVideo('" . $_MG_CONF['site_url'] . "/video.php?n=" . $I['media_id'] . "'," . $win_height . "," . $win_width . ")";
            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/flash.png';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'flash.png');
            }
            break;
        case 1: // download
        case 3: // mms - not supported for flash
            $u_pic = $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'];

            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/flash.png';
                $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'flash.png');
            }
            break;
        case 2 :    // inline
            $u_image = '';
            $V = MG_templateInstance( MG_getTemplatePath($aid) );
            $V->set_file (array ('video' => 'view_swf.thtml'));
            $V->set_var(array(
                'site_url'  => $_MG_CONF['site_url'],
                'lang_noflash' => $LANG_MG03['no_flash'],
                'play'      => ($playback_options['play'] ? 'true' : 'false'),
                'menu'      => ($playback_options['menu'] ? 'true' : 'false'),
                'loop'      => ($playback_options['loop'] ? 'true' : 'false'),
                'scale'     => $playback_options['scale'],
                'wmode'     => $playback_options['wmode'],
                'quality'   => $playback_options['quality'],
                'height'    => $playback_options['height'],
                'width'     => $playback_options['width'],
                'asa'       => $playback_options['allowscriptaccess'],
                'bgcolor'   => $playback_options['bgcolor'],
                'swf_version' => $playback_options['swf_version'],
                'filename'  => $I['media_original_filename'],
                'id'        => 'swf' . rand(),
                'id2'       => 'swf2' . rand(),
                'movie'     => $_MG_CONF['mediaobjects_url'] . '/orig/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext'],
                'xhtml'     => XHTML,
            ));

            $flasharray = array();
            $flasharray = explode('&',$playback_options['flashvars']);

            $i = 0;
            $V->set_block('video','flashvars','flashvar');

            foreach( $flasharray as $var ) {
                $temp = split("=",$var);
                $variable = $temp[0];
                $value = implode("=",array_slice($temp,1));
                if ( !isset($variable) && $variable != '' ) {
                    $V->set_var('fv','flashvars.' . $variable . '="' . $value . '";' .  LB);
                    $V->parse('flashvar','flashvars',true);
                    $i++;
                }
                $i++;
            }
            $V->parse('output','video');

            $u_image .= $V->finish($V->get_var('output'));
            return array($u_image,'',$resolution_x,$resolution_y,'');
            break;
    }

    $imageWidth  = $media_size_disp[0];
    $imageHeight = $media_size_disp[1];

    //frame
    $F = new Template($_MG_CONF['template_path']);
    $F->set_var('media_frame',$MG_albums[$aid]->displayFrameTemplate);
    $F->set_var(array(
        'media_link_start'  =>  '<a href="' . $u_pic . '">',
        'media_link_end'    =>  '</a>',
        'url_media_item'    =>  $u_pic,
        'media_thumbnail'   =>  $u_image,
        'media_size'        =>  'width="' . $imageWidth . '" height="' . $imageHeight . '"',
        'media_height'      =>  $imageHeight,
        'media_width'       =>  $imageWidth,
        'border_width'      =>  $imageWidth  + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'border_height'     =>  $imageHeight + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'media_title'       =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
        'media_tag'         =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
        'frWidth'           =>  $imageWidth  - $MG_albums[$aid]->dfrWidth,
        'frHeight'          =>  $imageHeight - $MG_albums[$aid]->dfrHeight,
        'xhtml'             =>  XHTML,

    ));
    $F->parse('media','media_frame');
    $retval .= $F->finish($F->get_var('media'));
    return array($retval,$u_image,$imageWidth,$imageHeight,$u_pic);
//    return $retval;
}


function MG_displayFLV ( $aid, $I, $full ) {
    global $_TABLES, $_CONF, $_MG_CONF, $_MG_USERPREFS, $MG_albums, $LANG_MG03;

    $retval = '';

    // set the default playback options...
    $playback_options['play']    = $_MG_CONF['swf_play'];
    $playback_options['menu']    = $_MG_CONF['swf_menu'];
    $playback_options['quality'] = $_MG_CONF['swf_quality'];
    $playback_options['height']  = $_MG_CONF['swf_height'];
    $playback_options['width']   = $_MG_CONF['swf_width'];
    $playback_options['loop']    = $_MG_CONF['swf_loop'];
    $playback_options['scale']   = $_MG_CONF['swf_scale'];
    $playback_options['wmode']   = $_MG_CONF['swf_wmode'];
    $playback_options['allowscriptaccess'] = $_MG_CONF['swf_allowscriptaccess'];
    $playback_options['bgcolor']    = $_MG_CONF['swf_bgcolor'];
    $playback_options['swf_version'] = $_MG_CONF['swf_version'];
    $playback_options['flashvars']   = $_MG_CONF['swf_flashvars'];

    $poResult = DB_query("SELECT * FROM {$_TABLES['mg_playback_options']} WHERE media_id='" . addslashes($I['media_id']) . "'");
    while ( $poRow = DB_fetchArray($poResult) ) {
        $playback_options[$poRow['option_name']] = $poRow['option_value'];
    }
    if (isset($_MG_USERPREFS['playback_mode']) && $_MG_USERPREFS['playback_mode'] != -1 ) {
        $playback_type = $_MG_USERPREFS['playback_mode'];
    } else {
        $playback_type = $MG_albums[$aid]->playback_type;
    }

    if ( isset($I['resolution_x']) && $I['resolution_x'] > 0 ) {
        $resolution_x = $I['resolution_x'];
        $resolution_y = $I['resolution_y'];
    } else {
        if ( $I['media_resolution_x'] == 0 && $I['remote_media'] == 0 ) {
            require_once $_CONF['path'] . 'plugins/mediagallery/lib/getid3/getid3.php';
            // Needed for windows only
            define('GETID3_HELPERAPPSDIR', 'C:/helperapps/');

            $getID3 = new getID3;
            // Analyze file and store returned data in $ThisFileInfo
            $ThisFileInfo = $getID3->analyze($_MG_CONF['path_mediaobjects'] . 'orig/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext']);
            getid3_lib::CopyTagsToComments($ThisFileInfo);
            if ( $ThisFileInfo['video']['resolution_x'] < 1 || $ThisFileInfo['video']['resolution_y'] < 1 ) {
                if (isset($ThisFileInfo['meta']['onMetaData']['width']) && isset($ThisFileInfo['meta']['onMetaData']['height']) ) {
                    $resolution_x = $ThisFileInfo['meta']['onMetaData']['width'];
                    $resolution_y = $ThisFileInfo['meta']['onMetaData']['height'];
                } else {
                    $resolution_x = -1;
                    $resolution_y = -1;
                }
            } else {
                $resolution_x = $ThisFileInfo['video']['resolution_x'];
                $resolution_y = $ThisFileInfo['video']['resolution_y'];
            }
            if ( $resolution_x != 0 ) {
                $sql = "UPDATE " . $_TABLES['mg_media'] . " SET media_resolution_x=" . intval($resolution_x) . ",media_resolution_y=" . intval($resolution_y) . " WHERE media_id='" . addslashes($I['media_id']) . "'";
                DB_query( $sql );
            }
        } else {
            $resolution_x = 320; //$I['media_resolution_x'];
            $resolution_y = 240; //$I['media_resolution_y'];
        }
    }

    switch ($playback_type) {
        case 0 :                    // Popup Window
            $resolution_x = $playback_options['width'];
            $resolution_y = $playback_options['height'];
            if ( $resolution_x < 1 || $resolution_y < 1 ) {
                $resolution_x = 480;
                $resolution_y = 320;
            } else {
                $resolution_x = $resolution_x + 40;
                $resolution_y = $resolution_y + 40;
            }
            if ( $I['mime_type'] == 'video/x-flv' && $_MG_CONF['use_flowplayer'] != 1) {
                $resolution_x = $resolution_x + 60;
                if ( $resolution_x < 590 ) {
                    $resolution_x = 590;
                }
                $resolution_y = $resolution_y + 80;
                if ( $resolution_y < 500 ) {
                    $resolution_y = 500;
                }
            }
            if ( $I['media_type'] == 5 ) {
                $resolution_x = 460;
                $resolution_y = 380;
            }

            $u_pic = "javascript:showVideo('" . $_MG_CONF['site_url'] . "/video.php?n=" . $I['media_id'] . "'," . $resolution_y . "," . $resolution_x . ")";
            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/flv.png';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'flv.png');
            }
            break;
        case 1: // download
            $u_pic = $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'];
            $raw_link_url = $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'];
            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/flv.png';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'flv.png');
            }
            break;
        case 3: // mms - not supported for flash
        case 2 :    // inline
            $u_image = '';
            // Initialize the flvpopup.thtml template

            $V = MG_templateInstance( MG_getTemplatePath($aid) );
            $V->set_file('video','view_flv.thtml');
            $V->set_var('xhtml',XHTML);

            // now the player specific items.
            $F = MG_templateInstance( MG_getTemplatePath($aid) );
            if ($_MG_CONF['use_flowplayer'] == 1 ) {    // FlowPlayer Setup
                $F->set_file(array('player' => 'flvfp.thtml'));
            } else {
                $F->set_file(array('player' => 'flvmg.thtml'));
            }
            $F->set_var('xhtml',XHTML);

            if ( $playback_options['play'] == 1 ) {  // auto start
                $playButton = '';
                $playButtonMG = '';
                $autoplay   = 'true';
            } else {
                if ( $I['media_tn_attached'] == 1 ) {
                    $playImage = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                    $playButtonMG = 'flashvars.thumbUrl="' . $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg";';
                } else {
                    $playImage = $_MG_CONF['site_url'] . MG_getImageFile('blank_blk.jpg');
                    $playButtonMG = '';
                }
                $playButton = "{ url: '" . $playImage . "', overlayId: 'play' },";
                $autoplay = 'false';
            }
            if ( $I['remote_media'] == 1 ) {
                $urlParts = array();
                $urlParts = parse_url($I['remote_url']);

                $pathParts = array();
                $pathParts = explode('/',$urlParts['path']);

                $ppCount = count($pathParts);
                $pPath = '';
                for ($I=1; $I<$ppCount-1;$I++) {
                    $pPath .= '/' . $pathParts[$I];
                }
                $videoFile = $pathParts[$ppCount-1];

                $pos = strrpos($videoFile, '.');
                if($pos === false) {
                    $basefilename = $videoFile;
                } else {
                    $basefilename = substr($videoFile,0,$pos);
                }
                $videoFile            = $basefilename;
                $streamingServerURL   = "streamingServerURL: '" . $urlParts['scheme'] . '://' . $urlParts['host'] . $pPath . "',";
                $streamingServer      = "streamingServer: 'fms',";
//              $streamingServerURLmg = "streamingServerUrl=" . $urlParts['scheme'] . '://' . $urlParts['host'] . $pPath . "&";
                $streamingServerURLmg = 'flashvars.streamingServerUrl="' . $urlParts['scheme'] . '://' . $urlParts['host'] . $pPath . '";';
            } else {
                $streamingServerURL   = '';
                $streamingServerURLmg = '';
                $streamingServer      = '';
                $videoFile            = urlencode($_MG_CONF['mediaobjects_url'] . '/orig/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext']);
            }
            $width  = $playback_options['width'];
            $height = $playback_options['height'];
            if ( $MG_albums[$aid]->allow_download == 1 ) {
                $allowDl = 'true';
            } else {
                $allowDl = 'false';
            }
            if ( $I['media_title'] != '' && $I['media_title'] != ' ') {
                $title = urlencode($I['media_title']);
            } else {
                $title = urlencode($I['media_original_filename']);
            }

            if ($_MG_CONF['use_flowplayer'] == 1 ) {
                $resolution_x = $width;
                $resolution_y = $height;
            } else {
                $resolution_x = $resolution_x + 60;
                $resolution_y = $resolution_y + 190;
                if ( $resolution_x < 565 ) {
                    $resolution_x = 565;
                }
            }
            $id  = 'id'  . rand();
            $id2 = 'idtwo' . rand();
            $F->set_var(array(
                'site_url'      => $_MG_CONF['site_url'],
                'lang_noflash'  => $LANG_MG03['no_flash'],
                'play'          => $autoplay,
                'autoplay'      => $autoplay,
                'menu'          => ($playback_options['menu'] ? 'true' : 'false'),
                'loop'          => ($playback_options['loop'] ? 'true' : 'false'),
                'scale'         => $playback_options['scale'],
                'wmode'         => $playback_options['wmode'],
                'width'         => $width,
                'height'        => $height,
                'allowDl'       => $allowDl,
                'title'         => $title,
                'streamingServerURL'    => $streamingServerURL,
                'videoFile'             => $videoFile,
                'playButton'            => $playButton,
                'streamingServerURLmg'  => $streamingServerURLmg,
                'playButtonMG'          => $playButtonMG,
                'id'            => $id,
                'id2'           => $id2,
                'lang_download' => $LANG_MG03['download'],
                'lang_large'    => $LANG_MG03['large'],
                'lang_normal'   => $LANG_MG03['normal'],
                'resolution_x'  => $resolution_x,
                'resolution_y'  => $resolution_y,
            ));
            $F->parse('output','player');
            $flv_player = $F->finish($F->get_var('output'));

            $V->set_var(array(
                'site_url'      => $_MG_CONF['site_url'],
                'lang_noflash'  => $LANG_MG03['no_flash'],
                'id'            => $id,
                'id2'           => $id2,
                'resolution_x'  => $resolution_x,
                'resolution_y'  => $resolution_y,
                'flv_player'    => $flv_player,
            ));
            $V->parse('output','video');
            $u_image .= $V->finish($V->get_var('output'));
//            return $u_image;
            return array($u_image,'',$resolution_x,$resolution_y,'');
            break;
    }

    $imageWidth  = $media_size_disp[0];
    $imageHeight = $media_size_disp[1];

    //frame
    $F = new Template($_MG_CONF['template_path']);
    $F->set_var('media_frame',$MG_albums[$aid]->displayFrameTemplate);
    $F->set_var(array(
        'media_link_start'  =>  '<a href="' . $u_pic . '">',
        'media_link_end'    =>  '</a>',
        'url_media_item'    =>  $u_pic,
        'media_thumbnail'   =>  $u_image,
        'media_size'        =>  'width="' . $imageWidth . '" height="' . $imageHeight . '"',
        'media_height'      =>  $imageHeight,
        'media_width'       =>  $imageWidth,
        'border_width'      =>  $imageWidth  + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'border_height'     =>  $imageHeight + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'media_title'       =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
        'media_tag'         =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
        'frWidth'           =>  $imageWidth  - $MG_albums[$aid]->dfrWidth,
        'frHeight'          =>  $imageHeight - $MG_albums[$aid]->dfrHeight,
        'xhtml'             =>  XHTML,
    ));
    $F->parse('media','media_frame');
    $retval .= $F->finish($F->get_var('media'));
    return array($retval,$u_image,$imageWidth,$imageHeight,$u_pic);
//    return $retval;
}

function MG_displayMP3( $aid, $I, $full ) {
    global $_TABLES, $_CONF, $_MG_CONF, $_MG_USERPREFS, $MG_albums, $LANG_MG03;

    $retval = '';

    // set the default playback options...

    $playback_options['autostart']          = $_MG_CONF['mp3_autostart'];
    $playback_options['autostart_tf']       = ($_MG_CONF['mp3_autostart'] ? 'true' : 'false');
    $playback_options['enablecontextmenu']  = $_MG_CONF['mp3_enablecontextmenu'];
    $playback_options['enablecontextmenu_tf'] = ($_MG_CONF['mp3_enablecontextmenu'] ? 'true' : 'false');
    $playback_options['showstatusbar']      = $_MG_CONF['mp3_showstatusbar'];
    $playback_options['uimode']             = $_MG_CONF['mp3_uimode'];
    $playback_options['loop']               = $_MG_CONF['mp3_loop'];

    $poResult = DB_query("SELECT * FROM {$_TABLES['mg_playback_options']} WHERE media_id='" . addslashes($I['media_id']) . "'");
    while ( $poRow = DB_fetchArray($poResult) ) {
        $playback_options[$poRow['option_name']] = $poRow['option_value'];
        $playback_options[$poRow['option_name']. '_tf'] = ( $poRow['option_value'] ? 'true' : 'false');
    }

    if (isset($_MG_USERPREFS['playback_mode']) && $_MG_USERPREFS['playback_mode'] != -1 ) {
        $playback_type = $_MG_USERPREFS['playback_mode'];
    } else {
        $playback_type = $MG_albums[$aid]->playback_type;
    }
    $u_tn = '';

    $_MG_USERPREFS['mp3_player'] = 2;
    $_MG_CONF['mp3_player'] = 2;

    switch ($playback_type) {
        case 0 :                    // Popup Window
            $win_height = 320;
            $win_width = 600;

            $u_pic = "javascript:showVideo('" . $_MG_CONF['site_url'] . "/video.php?n=" . $I['media_id'] . "'," . $win_height . "," . $win_width . ")";
            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/audio.png';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'audio.png');
            }
            break;
        case 1: // download
            $u_pic = $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'];
            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/audio.png';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'audio.png');
            }
            break;
        case 2 :    // inline
            if ( $I['media_tn_attached'] == 1 ) {
                $u_tn = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
                $border_width = $media_size_disp[0] + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18);
                $u_pic = '<div class=out style="width:' . $border_width . 'px"><div class="in ltin tpin"><img src="' . $u_tn . '"' . XHTML . '></div></div>';
                $playback_options['height'] = 50;
                $playback_options['width']  = 300;
            } else {
                $u_pic='';
                $playback_options['height'] = 50;
                $playback_options['width']  = 300;
            }
            $win_width = $playback_options['width'];
            $win_height = $playback_options['height'];

            $V = MG_templateInstance( MG_getTemplatePath($aid) );

            $tfile = 'view_mp3_swf.thtml';
            if ( $I['mime_type'] == 'audio/x-ms-wma' ) {
                $tfile = 'view_mp3_wmp.thtml';
            }
            $V->set_var('xhtml',XHTML);

            require_once $_CONF['path'] . 'plugins/mediagallery/lib/getid3/getid3.php';
            $getID3 = new getID3;
            // Analyze file and store returned data in $ThisFileInfo
            $ThisFileInfo = $getID3->analyze($_MG_CONF['path_mediaobjects'] . 'orig/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext']);
            getid3_lib::CopyTagsToComments($ThisFileInfo);

            if ( isset($ThisFileInfo['tags']['id3v1']['title'][0]) ) {
                $mp3_title = str_replace(' ','+',$ThisFileInfo['tags']['id3v1']['title'][0]);
            } else {
                if ( isset($ThisFileInfo['tags']['id3v2']['title'][0] ) ) {
                    $mp3_title = str_replace(' ','+',$ThisFileInfo['tags']['id3v2']['title'][0]);
                } else {
                    $mp3_title = str_replace(' ','+',$I['media_original_filename']);
                }
            }
            if ( isset($ThisFileInfo['tags']['id3v1']['artist']) ) {
                $mp3_artist = $ThisFileInfo['tags']['id3v1']['artist'];
            } else {
                $mp3_artist = '';
            }

            $S = MG_templateInstance( MG_getTemplatePath($aid) );
            $S->set_file(array('swf' => 'swfobject.thtml'));
            $S->set_var(array(
                'site_url'  => $_MG_CONF['site_url'],
                'xhtml'     => XHTML,
            ));
            $S->parse('output','swf');
            $u_image = $S->finish($S->get_var('output'));

            $V->set_file (array ('video' => $tfile));
            $V->set_var(array(
                'u_pic'             =>  $u_pic,
                'u_tn'              =>  $u_tn,
                'autostart'         => ($playback_options['autostart'] ? 'true' : 'false'),
                'enablecontextmenu' => ($playback_options['enablecontextmenu'] ? 'true' : 'false'),
                'stretchtofit'      => isset($playback_options['stretchtofit']) ? ($playback_options['stretchtofit'] ? 'true' : 'false') : 'false',
                'showstatusbar'     => ($playback_options['showstatusbar'] ? 'true' : 'false'),
                'loop'              => ($playback_options['loop'] ? 'true' : 'false'),
                'playcount'         => ($playback_options['loop'] ? '9999' : '1'),
                'uimode'            => $playback_options['uimode'],
                'height'            => $playback_options['height'],
                'width'             => $playback_options['width'],
                'movie'             => $_MG_CONF['mediaobjects_url'] . '/orig/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext'],
                'site_url'          => $_MG_CONF['site_url'],
                'mp3_title'         => $mp3_title,
                'mp3_artist'        => $mp3_artist,
                'allow_download'    => ($MG_albums[$aid]->allow_download ? 'true' : 'false'),
                'lang_artist'       => $LANG_MG03['artist'],
                'lang_album'        => $LANG_MG03['album'],
                'lang_song'         => $LANG_MG03['song'],
                'lang_track'        => $LANG_MG03['track'],
                'lang_genre'        => $LANG_MG03['genre'],
                'lang_year'         => $LANG_MG03['year'],
                'lang_download'     => $LANG_MG03['download'],
                'lang_info'         => $LANG_MG03['info'],
                'lang_noflash'      => $LANG_MG03['no_flash'],
                'swf_version'       => '9',
            ));
            $V->parse('output','video');
            $u_image .= $V->finish($V->get_var('output'));
            return array($u_image,'',$win_width,$win_height,'');
            break;
        case 3: // use mms links
            $mms_path = preg_replace("/http/i",'mms',$_MG_CONF['mediaobjects_url']);
            $u_pic = $mms_path . '/orig/'.  $I['media_filename'][0] . '/' . $I['media_filename'] . '.' . $I['media_mime_ext'];

            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/audio.png';
                $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'audio.png');
            }
            break;
    }

    $imageWidth  = $media_size_disp[0];
    $imageHeight = $media_size_disp[1];

    $F = new Template($_MG_CONF['template_path']);
    $F->set_var('media_frame',$MG_albums[$aid]->displayFrameTemplate);
    $F->set_var(array(
        'media_link_start'  =>  '<a href="' . $u_pic . '">',
        'media_link_end'    =>  '</a>',
        'url_media_item'    =>  $u_pic,
        'media_thumbnail'   =>  $u_image,
        'media_size'        =>  'width="' . $imageWidth . '" height="' . $imageHeight . '"',
        'media_height'      =>  $imageHeight,
        'media_width'       =>  $imageWidth,
        'border_width'      =>  $imageWidth  + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'border_height'     =>  $imageHeight + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'media_title'       =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
        'media_tag'         =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
        'frWidth'           =>  $imageWidth  - $MG_albums[$aid]->dfrWidth,
        'frHeight'          =>  $imageHeight - $MG_albums[$aid]->dfrHeight,
        'xhtml'             =>  XHTML,
    ));
    $F->parse('media','media_frame');
    $retval = $F->finish($F->get_var('media'));
    return array($retval,$u_image,$imageWidth,$imageHeight,$u_pic);
}

function MG_displayOGG( $aid, $I, $full ) {
    global $_TABLES, $_CONF, $_MG_CONF, $MG_albums;

    $retval = '';

    $u_pic = $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'];

    if ( $I['media_tn_attached'] == 1 ) {
        $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
        $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
    } else {
        $u_image     = $_MG_CONF['mediaobjects_url'] . '/audio.png';
        $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'audio.png');
    }

    $imageWidth  = $media_size_disp[0];
    $imageHeight = $media_size_disp[1];

    //frame
    $F = new Template($_MG_CONF['template_path']);
    $F->set_var('media_frame',$MG_albums[$aid]->displayFrameTemplate);
    $F->set_var(array(
        'media_link_start'  =>  '<a href="' . $u_pic . '">',
        'media_link_end'    =>  '</a>',
        'url_media_item'    =>  $u_pic,
        'media_thumbnail'   =>  $u_image,
        'media_size'        =>  'width="' . $imageWidth . '" height="' . $imageHeight . '"',
        'media_height'      =>  $imageHeight,
        'media_width'       =>  $imageWidth,
        'border_width'      =>  $imageWidth  + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'border_height'     =>  $imageHeight + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'media_title'       =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
        'media_tag'         =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
        'frWidth'           =>  $imageWidth  - $MG_albums[$aid]->dfrWidth,
        'frHeight'          =>  $imageHeight - $MG_albums[$aid]->dfrHeight,
        'xhtml'             =>  XHTML,
    ));
    $F->parse('media','media_frame');
    $retval = $F->finish($F->get_var('media'));
    return $retval;
}

function MG_displayGeneric( $aid, $I, $full ) {
    global $_TABLES, $_CONF, $_MG_CONF, $MG_albums;

    $retval = '';

    $u_pic = $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'];
    if ( $I['media_tn_attached'] == 1 ) {
        $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
        $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
    } else {
        switch ( $I['mime_type'] ) {
            case 'application/pdf' :
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/pdf.png';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'pdf.png');
                break;
            case 'application/zip' :
            case 'application/x-compressed' :
            case 'application/x-gzip' :
            case 'application/x-gzip' :
            case 'multipart/x-gzip' :
            case 'application/arj' :
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/zip.png';
                $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'zip.png');
                break;
            default :
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/generic.png';
                $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'generic.png');
                break;
        }
    }

    $imageWidth  = $media_size_disp[0];
    $imageHeight = $media_size_disp[1];

    $F = new Template($_MG_CONF['template_path']);
    $F->set_var('media_frame',$MG_albums[$aid]->displayFrameTemplate);
    $F->set_var(array(
        'media_link_start'  =>  '<a href="' . $u_pic . '">',
        'media_link_end'    =>  '</a>',
        'url_media_item'    =>  $u_pic,
        'media_thumbnail'   =>  $u_image,
        'media_size'        =>  'width="' . $imageWidth . '" height="' . $imageHeight . '"',
        'media_height'      =>  $imageHeight,
        'media_width'       =>  $imageWidth,
        'border_width'      =>  $imageWidth  + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'border_height'     =>  $imageHeight + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'media_title'       =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
        'media_tag'         =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
        'frWidth'           =>  $imageWidth  - $MG_albums[$aid]->dfrWidth,
        'frHeight'          =>  $imageHeight - $MG_albums[$aid]->dfrHeight,
        'xhtml'             =>  XHTML,
    ));
    $F->parse('media','media_frame');
    $retval = $F->finish($F->get_var('media'));
    return array($retval,$u_image,$imageWidth,$imageHeight,$u_pic);
}


function MG_displayTGA($aid,$I,$full,$mediaObject) {
    global $_CONF, $_MG_CONF, $MG_albums, $_USER;

    $retval = '';
    $media_link_start = '';
    $media_link_end   = '';

    $media_size_disp = @getimagesize($_MG_CONF['path_mediaobjects'] . 'disp/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.jpg');

    if ( $MG_albums[$aid]->full == 2 || $_MG_CONF['discard_original'] == 1 || ( $MG_albums[$aid]->full == 1 && $_USER['uid'] > 1 )) {
        $u_pic = '#';
        $media_link_start = '';
    } else {
        $media_link_start =
        $media_link_start = '<a href="' . $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'] . '">';
        $media_link_end = '</a>';
        $u_pic      = $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'] . '"';
    }
    $u_image    = $_MG_CONF['mediaobjects_url'] . '/disp/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.jpg';

    $imageWidth  = $media_size_disp[0];
    $imageHeight = $media_size_disp[1];

    $F = new Template($_MG_CONF['template_path']);
    $F->set_var('media_frame',$MG_albums[$aid]->displayFrameTemplate);
    $F->set_var(array(
        'media_link_start'  => $media_link_start,
        'media_link_end'    => $media_link_end,
        'url_media_item'    =>  $u_pic,         // FIXME! Is this right or does it need the < ahref stuff
        'media_thumbnail'   =>  $u_image,
        'media_size'        =>  'width="' . $imageWidth . '" height="' . $imageHeight . '"',
        'media_height'      =>  $imageHeight,
        'media_width'       =>  $imageWidth,
        'border_width'      =>  $imageWidth  + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'border_height'     =>  $imageHeight + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'media_title'       =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
        'media_tag'         =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
        'frWidth'           =>  $imageWidth  - $MG_albums[$aid]->dfrWidth,
        'frHeight'          =>  $imageHeight - $MG_albums[$aid]->dfrHeight,
        'xhtml'             =>  XHTML,
    ));
    $F->parse('media','media_frame');
    $retval = $F->finish($F->get_var('media'));
    return array($retval,$u_image,$imageWidth,$imageHeight,$u_pic);
}

function MG_displayPSD($aid,$I,$full,$mediaObject) {
    global $_CONF, $_MG_CONF, $MG_albums, $_USER;

    $retval = '';
    $media_link_start = '';
    $media_link_end   = '';

    $media_size_disp = @getimagesize($_MG_CONF['path_mediaobjects'] . 'disp/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.jpg');

    if ( $MG_albums[$aid]->full == 2 || $_MG_CONF['discard_original'] == 1 || ( $MG_albums[$aid]->full == 1 && $_USER['uid'] > 1 )) {
        $u_pic = '';
        $media_link_start = '';
    } else {
        $u_pic      = $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'] . '"';
        $media_link_start = '<a href="' . $_MG_CONF['site_url'] . '/download.php?mid=' . $I['media_id'] . '">';
        $media_link_end   = '</a>';
    }
    $u_image    = $_MG_CONF['mediaobjects_url'] . '/disp/' . $I['media_filename'][0] . '/' . $I['media_filename'] . '.jpg';

    $imageWidth  = $media_size_disp[0];
    $imageHeight = $media_size_disp[1];
    $F = new Template($_MG_CONF['template_path']);
    $F->set_var('media_frame',$MG_albums[$aid]->displayFrameTemplate);
    $F->set_var(array(
        'media_link_start'  =>  $media_link_start,
        'media_link_end'    =>  $media_link_end,
        'url_media_item'    =>  $u_pic,
        'media_thumbnail'   =>  $u_image,
        'media_size'        =>  'width="' . $imageWidth . '" height="' . $imageHeight . '"',
        'media_height'      =>  $imageHeight,
        'media_width'       =>  $imageWidth,
        'border_width'      =>  $imageWidth  + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'border_height'     =>  $imageHeight + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'media_title'       =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
        'media_tag'         =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
        'frWidth'           =>  $imageWidth  - $MG_albums[$aid]->dfrWidth,
        'frHeight'          =>  $imageHeight - $MG_albums[$aid]->dfrHeight,
        'xhtml'             =>  XHTML,
    ));
    $F->parse('media','media_frame');
    $retval = $F->finish($F->get_var('media'));
    return array($retval,$u_image,$imageWidth,$imageHeight,$u_pic);
}

function MG_displayEmbed($aid,$I,$full,$mediaObject) {
    global $_CONF, $_MG_CONF, $MG_albums, $_USER;

    $retval = '';

    $playback_type = $MG_albums[$aid]->playback_type;

    switch ($playback_type) {
        case 0 :                    // Popup Window
            if ( $I['media_type'] == 5 ) {
                $resolution_x = 460;
                $resolution_y = 380;
            }
            if (preg_match("/youtube/i", $I['remote_url'])) {
                $default_thumbnail = 'youtube.png';
            } else if (preg_match("/google/i", $I['remote_url'])) {
                $default_thumbnail = 'googlevideo.png';
            } else {
                $default_thumbnail = 'remote.png';
            }
            $u_pic = "javascript:showVideo('" . $_MG_CONF['site_url'] . "/video.php?n=" . $I['media_id'] . "'," . $resolution_y . "," . $resolution_x . ")";
            if ( $I['media_tn_attached'] == 1 ) {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $I['media_filename'][0] . '/tn_' . $I['media_filename'] . '.jpg');
            } else {
                $u_image     = $_MG_CONF['mediaobjects_url'] . '/' . $default_thumbnail; // remote.png';
                $media_size_orig = $media_size_disp  = @getimagesize($_MG_CONF['path_mediaobjects'] . '' . $default_thumbnail); // remote.png');
            }
            break;
        case 1:     // download - not supported for embedded video
        case 3:     // mms - not supported for embedded video
        case 2 :    // inline
            $F = MG_templateInstance( MG_getTemplatePath($aid) );
            $F->set_file('media_frame','embed.thtml');
            $F->set_var(array(
                'embed_string'      =>  $I['remote_url'],
                'media_title'       =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
                'media_tag'         =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
                'xhtml'             =>  XHTML,
            ));
            $F->parse('media','media_frame');
            $retval = $F->finish($F->get_var('media'));
            return array($retval,'',$resolution_x,$resolution_y,'');
    }
    $imageWidth  = $media_size_orig[0];
    $imageHeight = $media_size_orig[1];
    //frame
    $F = new Template($_MG_CONF['template_path']);
    $F->set_var('media_frame',$MG_albums[$aid]->displayFrameTemplate);
    $F->set_var(array(
        'media_link_start'  =>  '<a href="' . $u_pic . '">',
        'media_link_end'    =>  '</a>',
        'url_media_item'    =>  $u_pic,
        'media_thumbnail'   =>  $u_image,
        'media_size'        =>  'width="' . $imageWidth . '" height="' . $imageHeight . '"',
        'media_height'      =>  $imageHeight,
        'media_width'       =>  $imageWidth,
        'border_width'      =>  $imageWidth  + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'border_height'     =>  $imageHeight + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        'media_title'       =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
        'media_tag'         =>  (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
        'frWidth'           =>  $imageWidth  - $MG_albums[$aid]->dfrWidth,
        'frHeight'          =>  $imageHeight - $MG_albums[$aid]->dfrHeight,
        'xhtml'             =>  XHTML,
    ));
    $F->parse('media','media_frame');
    $retval .= $F->finish($F->get_var('media'));
    return array($retval,$u_image,$imageWidth,$imageHeight,$u_pic);
}


function MG_displayJPG($aid, $I, $full, $mid, $sortOrder, $sortID=0, $spage=0)
{
    global $_CONF, $_MG_CONF, $MG_albums, $_USER;

    $retval = '';
    $tmpstr = $I['media_filename'][0] . '/' . $I['media_filename'];
    $media_size_disp = @getimagesize($_MG_CONF['path_mediaobjects'] . 'disp/' . $tmpstr . '.' . $I['media_mime_ext']);

    if ($I['remote_media'] == 1) {
        if ($I['media_resolution_x'] != 0 && $I['media_resolution_y'] != 0) {
            $media_size_disp[0] = $I['media_resolution_x'];
            $media_size_disp[1] = $I['media_resolution_y'];
        } else {
            $media_size_disp = @getimagesize($I['remote_url']);
            if ($media_size_disp == false) {
                $media_size_disp[0] = 0;
                $media_size_disp[1] = 0;
            }
        }
    }

    if ($media_size_disp == false && $I['remote_media'] == 0) {
        $media_size_disp = @getimagesize($_MG_CONF['path_mediaobjects'] . 'disp/' . $tmpstr . '.jpg');
    }
    $media_size_orig = @getimagesize($_MG_CONF['path_mediaobjects'] . 'orig/' . $tmpstr . '.' . $I['media_mime_ext']);

    $media_link_start = '';
    $media_link_end   = '';
    if ($media_size_orig == false || $MG_albums[$aid]->full == 2 || $_MG_CONF['discard_original'] == 1
        || ( $MG_albums[$aid]->full == 1 && (!isset($_USER['uid']) || $_USER['uid'] < 2 ) )) {
        $u_pic = '#';
        $raw_link_url = '';
    } else {
        if ($full == 0 && $_MG_CONF['full_in_popup']) {
            $popup_x = $media_size_orig[0] + 75;
            $popup_y = $media_size_orig[1] + 100;
            $u_pic = 'javascript:showVideo(\'' . $_MG_CONF['site_url'] . '/popup.php?s=' . $mid 
                   . '&amp;sort=' . $sortOrder . '\',' . $popup_y . ',' . $popup_x . ')';
        } else {
            $f = $full ? '0' : '1';
            if ($_MG_CONF['click_image_and_go_next']) {
                $f = $full ? '1' : '0';
            }
            $u_pic = $_MG_CONF['site_url'] . '/media.php?f=' . $f . '&amp;s=' . $mid . '&amp;i=' . $sortID . '&amp;p=' . $spage;
        }
        $media_link_start = '<a href="' . $u_pic . '">';
        $media_link_end   = '</a>';
        $raw_link_url = $u_pic;
    }

    if ($full == 1) {
        $u_image = $_MG_CONF['mediaobjects_url'] . '/orig/' . $tmpstr . '.' . $I['media_mime_ext'];
    } else {
        if ($media_size_disp == false && !$I['remote_media']) {
            $u_image = $_MG_CONF['mediaobjects_url'] . '/missing.png';
            $media_size_disp[0] = 200;
            $media_size_disp[1] = 150;
        } else {
            if ($I['remote_media'] == 1 ) {
                $u_image = $I['remote_url'];
            } else {
                $u_image = $_MG_CONF['mediaobjects_url'] . '/disp/' . $tmpstr . '.jpg';
                if (file_exists($_MG_CONF['path_mediaobjects'] . 'disp/' . $tmpstr . '.' . $I['media_mime_ext'])) {
                    $u_image =  $_MG_CONF['mediaobjects_url'] . '/disp/' . $tmpstr . '.' . $I['media_mime_ext'];
                }
            }
        }
    }
    if ($media_size_orig == false) {
        $media_size_orig[0] = 200;
        $media_size_orig[1] = 150;
    }

    $imageWidth  = $full ? $media_size_orig[0] : $media_size_disp[0];
    $imageHeight = $full ? $media_size_orig[1] : $media_size_disp[1];

    $F = new Template($_MG_CONF['template_path']);
    $F->set_var('media_frame', $MG_albums[$aid]->displayFrameTemplate);
    $F->set_var(array(
        'url_media_item'   => $u_pic,
        'media_link_start' => $media_link_start,
        'media_link_end'   => $media_link_end,
        'media_thumbnail'  => $u_image,
        'media_size'       => ($imageWidth != 0 && $imageHeight != 0 ) ? 'width="' . $imageWidth . '" height="' . $imageHeight . '"' : '',
        'media_height'     => $imageHeight,
        'media_width'      => $imageWidth,
        'media_title'      => (isset($I['media_title']) && $I['media_title'] != ' ') ? PLG_replaceTags($I['media_title']) : '',
        'media_tag'        => (isset($I['media_title']) && $I['media_title'] != ' ') ? strip_tags($I['media_title']) : '',
        'frWidth'          => $imageWidth  - $MG_albums[$aid]->dfrWidth,
        'frHeight'         => $imageHeight - $MG_albums[$aid]->dfrHeight,
        'xhtml'            => XHTML,
    ));
    if ($imageWidth > 0 && $imageHeight > 0) {
        $F->set_var(array(
            'border_width'  => $imageWidth  + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
            'border_height' => $imageHeight + (($MG_albums[$aid]->display_skin == 'mgShadow') ? 12 : 18),
        ));
    }
    $retval = $F->finish($F->parse('media', 'media_frame'));
    return array($retval, $u_image, $imageWidth, $imageHeight, $raw_link_url);
}


function MG_displayMediaImage($mediaObject, $full, $sortOrder, $comments, $sortID=0, $spage=0)
{
    global $MG_albums, $_POST, $_TABLES, $_CONF, $_MG_CONF, $LANG_MG00, $LANG_MG01, $LANG_MG03, $LANG_MG04,
           $LANG_ACCESS, $LANG01, $album_jumpbox, $_USER, $_MG_USERPREFS,
           $_DB_dbms, $mgLightBox, $LANG04, $ratedIds;

    $retval = '';

    $aid  = DB_getItem($_TABLES['mg_media_albums'], 'album_id', 'media_id="' . addslashes($mediaObject) . '"');

    $pid = 0;
    if (isset($MG_albums[$aid]->pid)) {
        $pid = $MG_albums[$aid]->pid;
    }
    $aOffset = -1;
    if (@method_exists($MG_albums[$aid],'getOffset')) {
        $aOffset = $MG_albums[$aid]->getOffset();
    }
    if ($aOffset == -1 || $MG_albums[$aid]->access == 0) {
        $retval = COM_startBlock ($LANG_ACCESS['accessdenied'], '', COM_getBlockTemplate ('_msg_block', 'header'))
                 . '<br'.XHTML.'>' . $LANG_MG00['access_denied_msg']
                 . COM_endBlock (COM_getBlockTemplate('_msg_block', 'footer'));
        return array($LANG_MG00['access_denied_msg'], $retval);
    }

    $mid = $mediaObject;

    $orderBy = MG_getSortOrder($aid, $sortOrder);

    if ( $_DB_dbms == "mssql" ) {
        $sql = "SELECT *,CAST(media_desc AS TEXT) AS media_desc FROM {$_TABLES['mg_media_albums']} as ma LEFT JOIN " . $_TABLES['mg_media'] . " as m " .
                " ON ma.media_id=m.media_id WHERE ma.album_id=" . $aid . $orderBy;
    } else {
        $sql = "SELECT * FROM {$_TABLES['mg_media_albums']} as ma LEFT JOIN " . $_TABLES['mg_media'] . " as m " .
                " ON ma.media_id=m.media_id WHERE ma.album_id=" . $aid . $orderBy;
    }
    $result = DB_query( $sql );
    $nRows = DB_numRows( $result );

    $total_media = $nRows;
    $media = array();
    while ( $row = DB_fetchArray($result) ) {
        $media[] = $row;
        $ids[] = $row['media_id'];
    }

    $key = array_search($mid,$ids);
    if ( $key === false ) {
        $retval  = COM_startBlock ($LANG_ACCESS['accessdenied'], '',COM_getBlockTemplate ('_msg_block', 'header'))
                 . '<br'.XHTML.'>' . $LANG_MG00['access_denied_msg']
                 . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        return array($LANG_MG00['access_denited_msg'], $retval);
    }

    $mediaObject = $key;

    if ( $MG_albums[$aid]->full == 2 || $_MG_CONF['discard_original'] == 1 || ( $MG_albums[$aid]->full == 1 && $_USER['uid'] > 1 )) {
        $full = 0;
    }
    if ( $full )
        $disp = 'orig';
    else
        $disp = 'disp';

    if ( $MG_albums[$aid]->enable_comments == 0 ) {
        $comments = 0;
    }

    if ( $sortID > 0 ) {
        $MG_albums[$aid]->enable_slideshow = 0;
    }


    require_once $_CONF['path'] . 'plugins/mediagallery/include/classFrame.php';
    $nFrame = new mgFrame();
    $nFrame->constructor( $MG_albums[$aid]->display_skin );
    $MG_albums[$aid]->displayFrameTemplate = $nFrame->getTemplate();
    $MG_albums[$aid]->dfrWidth = $nFrame->frame['wHL'] + $nFrame->frame['wHR'];
    $MG_albums[$aid]->dfrHeight = $nFrame->frame['hVT'] + $nFrame->frame['hVB'];
    $themeCSS = $nFrame->getCSS();

    $T = MG_templateInstance( MG_getTemplatePath($aid) );
    switch ( $media[$mediaObject]['media_type'] ) {
        case '0':       // image
            $T->set_file('page','view_image.thtml');
            break;
        case '1' :      // video
        case '5' :      // embedded video
            $T->set_file('page','view_video.thtml');
            break;
        case '2' :      // audio
            $T->set_file('page','view_audio.thtml');
            break;
        default:
            $T->set_file('page','view_image.thtml');
            break;
    }
    $T->set_file('shutterfly', 'digibug.thtml');
    $T->set_var('header', $LANG_MG00['plugin']);
    $T->set_var('site_url',$_MG_CONF['site_url']);
    $T->set_var('plugin','mediagallery');
    $T->set_var('xhtml', XHTML);

    // construct the album jumpbox...
    $album_jumpbox = '';
    if (!$_MG_CONF['hide_jumpbox_on_mediaview']) {
        $level = 0; // no use?
        $album_jumpbox = '<form name="jumpbox" action="' . $_MG_CONF['site_url'] . '/album.php' . '" method="get"><div>';
        $album_jumpbox .= $LANG_MG03['jump_to'] . ':&nbsp;<select name="aid" onchange="forms[\'jumpbox\'].submit()">';
        $MG_albums[0]->buildJumpBox($aid);
        $album_jumpbox .= '</select>';
        $album_jumpbox .= '&nbsp;<input type="submit" value="' . $LANG_MG03['go'] . '"' . XHTML . '>';
        $album_jumpbox .= '<input type="hidden" name="page" value="1"' . XHTML . '>';
        $album_jumpbox .= '</div></form>';
    }

    // Update the views count... But only for non-admins

    if (!$MG_albums[0]->owner_id/*SEC_hasRights('mediagallery.admin')*/) {
        $media_views = $media[$mediaObject]['media_views'] + 1;
        DB_query("UPDATE " . $_TABLES['mg_media'] . " SET media_views=" . $media_views . " WHERE media_id='" . addslashes($media[$mediaObject]['media_id']) . "'");
    }

    $columns_per_page   = ($MG_albums[$aid]->display_columns == 0 ? $_MG_CONF['ad_display_columns'] : $MG_albums[$aid]->display_columns);
    $rows_per_page      = ($MG_albums[$aid]->display_rows == 0 ? $_MG_CONF['ad_display_rows'] : $MG_albums[$aid]->display_rows);

    if (isset($_MG_USERPREFS['display_rows']) && $_MG_USERPREFS['display_rows'] > 0 ) {
        $rows_per_page = $_MG_USERPREFS['display_rows'];
    }
    if (isset($_MG_USERPREFS['display_columns'] ) && $_MG_USERPREFS['display_columns'] > 0 ) {
        $columns_per_page = $_MG_USERPREFS['display_columns'];
    }
    $media_per_page     = $columns_per_page * $rows_per_page;

    if ( $MG_albums[$aid]->albums_first ) {
        $childCount = $MG_albums[$aid]->getChildCount();
        $page = intval(($mediaObject + $childCount) / $media_per_page) + 1;
    } else {
        $page = intval(($mediaObject)  / $media_per_page) + 1;
    }

    /*
     * check to see if the original image exists, if not fall back to full image
     */

    $media_size_orig = @getimagesize($_MG_CONF['path_mediaobjects'] . 'orig/' . $media[$mediaObject]['media_filename'][0] . '/' . $media[$mediaObject]['media_filename'] . '.' . $media[$mediaObject]['media_mime_ext']);

    if ($media_size_orig == false ) {
        $full = 0;
        $disp = 'disp';
    }

//    $aOffset = $MG_albums[$aid]->getOffset();
    $aPage = intval(($aOffset)  / ($_MG_CONF['album_display_columns'] * $_MG_CONF['album_display_rows'])) + 1;
    $birdseed = '<a href="' . $_CONF['site_url'] . '/index.php">' . $LANG_MG03['home'] . '</a> '
              . ($_MG_CONF['gallery_only'] == 1 ? '' : $_MG_CONF['seperator'] . ' <a href="' . $_MG_CONF['site_url'] . '/index.php?page=' . $aPage . '">' . $_MG_CONF['menulabel'] . '</a> ');
    if ($sortID > 0) {
        $birdseed .= $_MG_CONF['seperator'] . '<a href="' . $_MG_CONF['site_url'] . '/search.php?id=' . $sortID . '&amp;page=' . $spage . '">' . $LANG_MG03['search_results'] . '</a>';  $MG_albums[$aid]->getPath(1,$sortOrder,$page) . '</a>';
        $album_link = '<a href="' . $_MG_CONF['site_url'] . '/search.php?id=' . $sortID . '&amp;page=' . $spage . '">';
    } else {
        $birdseed .= $MG_albums[$aid]->getPath(1,$sortOrder,$page) . '</a>';
        $album_link = '<a href="' . $_MG_CONF['site_url'] . '/album.php?aid=' . $aid . '&amp;page=' . $page . '&amp;sort=' . $sortOrder . '">';
    }

    mg_usage('media_view',$MG_albums[$aid]->title, $media[$mediaObject]['media_title'],$media[$mediaObject]['media_id']);

    // hack for tga files...
    if ( $media[$mediaObject]['mime_type'] == 'image/x-targa' || $media[$mediaObject]['mime_type'] == 'image/tga' ) {
        $full = 0;
        $disp = 'disp';
    }

    $prevLink = '';
    $nextLink = '';
    $pagination = '';
    $base_url = $_MG_CONF['site_url'] . "/media.php?f=" . ($full ? '1' : '0') . "&amp;sort=" . $sortOrder;
    if ($sortID <= 0) {
        list($prevLink, $nextLink) = MG_getNextandPrev($base_url, $nRows, $mediaObject, $media);
        // generate pagination routine
        if (!empty($prevLink)) {
            $pagination .= '<a href="' . $prevLink  . '">' . $LANG_MG03['previous'] . '</a>';
        }
        if (!empty($nextLink)) {
            $pagination .= (!empty($prevLink)) ? '&nbsp;&nbsp;&nbsp;' : '';
            $pagination .= '<a href="' . $nextLink  . '">' . $LANG_MG03['next'] . '</a>';
        }
        $pagination .= LB;
    }

    // hack for testing...>>>
    $media_id = $media[$mediaObject]['media_id'];
    if ($_MG_CONF['click_image_and_go_next']) {
        $nextObject = MG_getNextitem($nRows, $mediaObject);
        if ($nextObject !== '') {
            $media_id = $media[MG_getNextitem($nRows, $mediaObject)]['media_id'];
        }
    }
    $vf = $full;

    if ($media[$mediaObject]['media_type'] == '0') { // image
        $switch_viewsize_link = '<a href="' . $_MG_CONF['site_url'] . "/media.php?f=" . ($full ? '0' : '1') . "&amp;sort=" . $sortOrder
                              . '&amp;s=' . $media[$mediaObject]['media_id'] . '">' . ($full ? $LANG_MG03['normal_size'] : $LANG_MG03['full_size']) . '</a>';
    }

    // hack for testing...<<<

    switch ($media[$mediaObject]['mime_type']) {
        case 'image/gif' :
        case 'image/jpeg' :
        case 'image/jpg' :
        case 'image/png' :
        case 'image/bmp' :
            list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                = MG_displayJPG($aid,$media[$mediaObject],$vf, $media_id, $sortOrder,$sortID,$spage);
            break;
        case 'video/x-ms-asf' :
        case 'video/x-ms-asf-plugin' :
        case 'video/avi' :
        case 'video/msvideo' :
        case 'video/x-msvideo' :
        case 'video/avs-video' :
        case 'video/x-ms-wmv' :
        case 'video/x-ms-wvx' :
        case 'video/x-ms-wm' :
        case 'application/x-troff-msvideo' :
        case 'application/x-ms-wmz' :
        case 'application/x-ms-wmd' :
            list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                = MG_displayASF($aid,$media[$mediaObject],$full);
            break;
        case 'audio/x-ms-wma' :
            list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                = MG_displayMP3($aid,$media[$mediaObject],$full);
            break;
        case 'video/mpeg' :
        case 'video/x-mpeg' :
        case 'video/x-mpeq2a' :
            if ( $_MG_CONF['use_wmp_mpeg'] == 1 ) {
                list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                    = MG_displayASF($aid,$media[$mediaObject],$full);
                break;
            }
        case 'video/x-motion-jpeg' :
        case 'video/quicktime' :
        case 'video/x-qtc' :
        case 'video/x-m4v' :
            if ($media[$mediaObject]['media_mime_ext'] == 'mp4' && isset($_MG_CONF['play_mp4_flv']) && $_MG_CONF['play_mp4_flv'] == true) {
                list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                    = MG_displayFLV($aid,$media[$mediaObject],$full);
            } else {
                list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                    = MG_displayMOV($aid,$media[$mediaObject],$full);
            }
            break;
        case 'embed' :
            list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                = MG_displayEmbed($aid,$media[$mediaObject],$full,$mediaObject);
            break;
        case 'application/x-shockwave-flash' :
            list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                = MG_displaySWF($aid,$media[$mediaObject],$full);

            break;
        case 'video/x-flv' :
            list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                = MG_displayFLV($aid,$media[$mediaObject],$full);
            break;
        case 'audio/mpeg' :
        case 'audio/x-mpeg' :
        case 'audio/mpeg3' :
        case 'audio/x-mpeg-3' :
            list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                = MG_displayMP3($aid,$media[$mediaObject],$full);
            break;
        case 'application/ogg' :
        case 'application/x-ogg' :
            list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                = MG_displayOGG($aid,$media[$mediaObject],$full);
            break;
        case 'image/x-targa' :
        case 'image/tga' :
        case 'image/tiff' :
            list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                = MG_displayTGA($aid,$media[$mediaObject],$full,$mediaObject);
            break;
        case 'image/photoshop' :
        case 'image/x-photoshop' :
        case 'image/psd' :
        case 'application/photoshop' :
        case 'application/psd' :
            list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                = MG_displayPSD($aid,$media[$mediaObject],$full,$mediaObject);
            break;
        default :
            switch( $media[$mediaObject]['media_mime_ext']) {
                case 'jpg' :
                case 'gif' :
                case 'png' :
                case 'bmp' :
                    list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                        = MG_displayJPG($aid,$media[$mediaObject],$vf, $media_id, $sortOrder,$sortID,$spage);
                    break;
                case 'asf' :
                    list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                        = MG_displayASF($aid,$media[$mediaObject],$full);
                    break;
                default :
                    list($u_image,$raw_image,$raw_image_width,$raw_image_height,$raw_link_url)
                        = MG_displayGeneric($aid,$media[$mediaObject],$full, $media_id, $sortOrder);
                    break;
            }
    }

    $mid = $media[$mediaObject]['media_id'];

    if ( $_MG_CONF['use_upload_time'] == 1 ) {
        $media_date = MG_getUserDateTimeFormat( $media[$mediaObject]['upload_time'] );
    } else {
        $media_date = MG_getUserDateTimeFormat( $media[$mediaObject]['media_time'] );
    }

    $rating_box = '';
    if ($MG_albums[$aid]->enable_rating > 0) {
        require_once $_CONF['path'] . 'plugins/mediagallery/include/lib-rating.php';
        $rating_box = MG_getRatingBar($aid, $media[$mediaObject]['media_user_id'], $media[$mediaObject]['media_id'],
                                            $media[$mediaObject]['media_votes'],   $media[$mediaObject]['media_rating'], '');
    }
    $T->set_var('rating_box', $rating_box);

    if ( $MG_albums[$aid]->allow_download ) {
        $T->set_var('download', '<a href="' . $_MG_CONF['site_url'] . '/download.php?mid=' . $media[$mediaObject]['media_id'] . '">'
                              . $LANG_MG01['download'] . '</a>');
    }
    if ( $media[$mediaObject]['media_type'] == 0 && $MG_albums[$aid]->enable_shutterfly ) {
        $media_size_orig = false;
        $media_size_tn   = false;
        $tmpstr = $media[$mediaObject]['media_filename'][0] . '/' . $media[$mediaObject]['media_filename'];
        if ( $_MG_CONF['discard_original'] == 1 ) {
            foreach ($_MG_CONF['validExtensions'] as $ext ) {
                if ( file_exists($_MG_CONF['path_mediaobjects'] . 'disp/' . $tmpstr . $ext) ) {
                    $sf_picture = $_MG_CONF['mediaobjects_url'] . '/disp/' . $tmpstr . $ext;
                    $media_size_orig = @getimagesize($_MG_CONF['path_mediaobjects'] . 'disp/' . $tmpstr . $ext);
                    break;
                }
            }
        } else {
            foreach ($_MG_CONF['validExtensions'] as $ext ) {
                if ( file_exists($_MG_CONF['path_mediaobjects'] . 'orig/' . $tmpstr . $ext) ) {
                    $sf_picture = $_MG_CONF['mediaobjects_url'] . '/orig/' . $tmpstr . $ext;
                    $media_size_orig = @getimagesize($_MG_CONF['path_mediaobjects'] . 'orig/' . $tmpstr . $ext);
                    break;
                }
            }
        }

        foreach ($_MG_CONF['validExtensions'] as $ext ) {
            if ( file_exists($_MG_CONF['path_mediaobjects'] . 'tn/' . $tmpstr . $ext) ) {
                $tnImage = $_MG_CONF['mediaobjects_url'] . '/tn/' . $tmpstr . $ext;
                $media_size_tn = @getimagesize($_MG_CONF['path_mediaobjects'] . 'tn/' . $tmpstr . $ext);
                break;
            }
        }

        if ( $media_size_orig != false && $media_size_tn != false ) {
            $T->set_var(array(
                'sf_height'             =>  $media_size_orig[1],
                'sf_width'              =>  $media_size_orig[0],
                'sf_tn_height'          =>  $media_size_tn[1],
                'sf_tn_width'           =>  $media_size_tn[0],
                'sf_thumbnail'          =>  $tnImage,
                'sf_picture'            =>  $sf_picture,
                'sf_title'              =>  $media[$mediaObject]['media_title'],
                'lang_print_digibug'    =>  $LANG_MG03['print_digibug'],
                'lang_print_shutterfly' => $LANG_MG03['print_shutterfly'],
            ));
            $T->parse('shutterfly_submit','shutterfly');

        }
    }

    if ($MG_albums[$aid]->access == 3 || ($_MG_CONF['allow_user_edit'] == true && isset($_USER['uid']) && $media[$mediaObject]['media_user_id'] == $_USER['uid'])) {
        $edit_item = '<a href="' . $_MG_CONF['site_url'] . '/admin.php?mode=mediaedit&amp;s=1&amp;album_id=' . $aid . '&amp;mid=' . $mid . '">' . $LANG_MG01['edit'] . '</a>';
    } else {
        $edit_item = '';
    }

    $media_desc = PLG_replaceTags(nl2br($media[$mediaObject]['media_desc']));
    if ( strlen($media_desc) > 0 ) {
//        $media_desc .= '<br' . XHTML . '><br' . XHTML . '>';
        $media_desc = '<p style="margin:5px">'.$media_desc.'</p>';
    }

    // start of the lightbox slideshow code

    if ( $MG_albums[$aid]->enable_slideshow == 2 ) {
        $mgLightBox = 1;
        $lbSlideShow  = '<noscript><div class="pluginAlert">' . $LANG04[150] . '</div></noscript>' . LB;
        $lbSlideShow .= '<script type="text/javascript">' . LB;
        $lbSlideShow .= 'function openGallery1() {' . LB;
        $lbSlideShow .= '    return loadXMLDoc("' . $_MG_CONF['site_url'] . '/lightbox.php?aid=' . $aid . '");';
        $lbSlideShow .= '}' . LB;
        $lbSlideShow .= '</script>' . LB;
        $T->set_var('lbslideshow',$lbSlideShow);
    } else {
        $T->set_var('lbslideshow','');
    }

    // end of the lightbox slideshow code

    switch ( $MG_albums[$aid]->enable_slideshow ) {
        case 0 :
            $url_slideshow = '';
            break;
        case 1 :
            $url_slideshow = '<a href="' . $_MG_CONF['site_url'] . '/slideshow.php?aid=' . $aid . '&amp;sort=' . $sortOrder . '">' . $LANG_MG03['slide_show'] . '</a>';
            break;
        case 2:
            $lbss_count = DB_count($_TABLES['mg_media'],'media_type',0);
            $sql = "SELECT COUNT(m.media_id) as lbss_count FROM {$_TABLES['mg_media_albums']} as ma INNER JOIN " . $_TABLES['mg_media'] . " as m " .
                                " ON ma.media_id=m.media_id WHERE m.media_type = 0 AND ma.album_id=" . $aid;
            $res = DB_query($sql);
            list($lbss_count) = DB_fetchArray($res);

            if ( $lbss_count != 0 ) {
                $url_slideshow = '<span id="mgslideshow" class="jsenabled_show" style="display:none"><a href="#" onclick="return openGallery1()">' . $LANG_MG03['slide_show'] . '</a></span>';
            } else {
                $MG_albums[$aid]->enable_slideshow = 0;
                $mgLightBox = 0;
            }
            break;
        case 3:
            $url_slideshow = '<a href="' . $_MG_CONF['site_url'] . '/fslideshow.php?aid=' . $aid . '&amp;src=disp">' . $LANG_MG03['slide_show'] . '</a>';
            break;
        case 4:
            $url_slideshow = '<a href="' . $_MG_CONF['site_url'] . '/fslideshow.php?aid=' . $aid . '&amp;src=orig">' . $LANG_MG03['slide_show'] . '</a>';
            break;
    }

    $T->set_var(array(
        'birdseed'      =>  $birdseed,
        'slide_show'    =>  isset($url_slideshow) ? $url_slideshow : '', //$MG_albums[$aid]->enable_slideshow ? '<a href="' . $_MG_CONF['site_url'] . '/slideshow.php?aid=' . $aid . '&amp;sort=' . $sortOrder . '">' . $LANG_MG03['slide_show'] . '</a>' : '',
        'image_detail'  =>  $u_image,
        'border_height' =>  $raw_image_height + 30,
        'border_width'  =>  $raw_image_width + 30,
        'media_title'   =>  (isset($media[$mediaObject]['media_title']) && $media[$mediaObject]['media_title'] != ' ' ) ? PLG_replaceTags($media[$mediaObject]['media_title']) : '',
        'album_title'   =>  ($sortID > 0 ? $LANG_MG03['search_results'] : $MG_albums[$aid]->title),
        'media_desc'    =>  (isset($media[$mediaObject]['media_desc']) && $media[$mediaObject]['media_desc'] != ' ' ) ? $media_desc : '',
        'media_time'    =>  $media_date[0],
        'media_views'   =>  ($MG_albums[$aid]->enable_views ? $media[$mediaObject]['media_views'] : ''),
        'media_comments' => ($MG_albums[$aid]->enable_comments ? $media[$mediaObject]['media_comments'] : ''),
        'pagination'    =>  $pagination,
        'media_number'  =>  sprintf("%s %d %s %d", $LANG_MG03['image'], $mediaObject + 1 , $LANG_MG03['of'], $total_media ),
        'jumpbox'       =>  $album_jumpbox,
        'edit_item'     =>  $edit_item,
        'site_url'      =>  $_MG_CONF['site_url'],
        'lang_prev'     =>  $LANG_MG03['previous'],
        'lang_next'     =>  $LANG_MG03['next'],
        'next_link'     =>  $nextLink,
        'prev_link'     =>  $prevLink,
        'image_height'  =>  $raw_image_height,
        'image_width'   =>  $raw_image_width,
        'left_side'     =>  intval( $raw_image_width / 2 ) - 1,
        'right_side'    =>  intval( $raw_image_width / 2 ),
        'raw_image'     =>  $raw_image,
        'raw_link_url'  =>  $raw_link_url,
        'album_link'    =>  $MG_albums[$aid]->getPath(1,$sortOrder,$page),
        'item_number'   =>  $mediaObject + 1,
        'total_items'   =>  $total_media,
        'lang_of'       =>  $LANG_MG03['of'],
        'album_link'    =>  $album_link,
        'switch_size_link' =>  $switch_viewsize_link,
    ));
    $getid3link = '';
    $getid3linkend = '';

    $T->set_var(array(
        'getid3'    => $getid3link,
        'getid3end' => $getid3linkend,
    ));
    if ( $getid3link != '' ) {
        $T->set_var('media_properties',$LANG_MG03['media_properties']);
    } else {
        $T->set_var('media_properties','');
    }

    if ( $MG_albums[$aid]->enable_keywords == 1 && !empty($media[$mediaObject]['media_keywords'])) {
        $kwText = '';
        $keyWords = array();
        $keyWords = explode(' ',$media[$mediaObject]['media_keywords']);
        $numKeyWords = count($keyWords);
        for ( $i=0;$i<$numKeyWords;$i++ ) {
            $keyWords[$i] = str_replace('"',' ',$keyWords[$i]);
            $searchKeyword = $keyWords[$i];
            $keyWords[$i] = str_replace('_',' ',$keyWords[$i]);
            $kwText .= '<a href="' . $_MG_CONF['site_url'] . '/search.php?mode=search&amp;swhere=1&amp;keywords=' . $searchKeyword . '&amp;keyType=any">' . $keyWords[$i] . '</a>';
        }
        $T->set_var(array(
            'media_keywords'    => $kwText,
            'lang_keywords'     => $LANG_MG01['keywords']
        ));
    } else {
        $T->set_var(array(
            'media_keywords'    => '',
            'lang_keywords'     => '',
         ));
    }

    if ( $media[$mediaObject]['media_user_id'] == '' || !isset($media[$mediaObject]['media_user_id'] ) ) {
        $media[$mediaObject]['media_user_id'] = 0;
    }
    if ($_CONF['show_fullname']) {
        $displayname = 'fullname';
    } else {
        $displayname = 'username';
    }
    $owner_name = DB_getItem ($_TABLES['users'],$displayname, "uid = {$media[$mediaObject]['media_user_id']}");
    if ( empty($owner_name) || $owner_name == '') {
         $owner_name = DB_getItem ($_TABLES['users'],'username', "uid = {$media[$mediaObject]['media_user_id']}");
         if (empty($owner_name) || $owner_name == '' ) {
            $owner_name = 'unknown';
        }
    }
    if ( $owner_name != 'unknown' ) {
        $owner_link = '<a href="' . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $media[$mediaObject]['media_user_id'] . '">' . $owner_name . '</a>';
    } else {
        $owner_link = $owner_name;
    }
    $T->set_var('owner_username',$owner_link);

    if ( ($MG_albums[$aid]->exif_display==2 || $MG_albums[$aid]->exif_display==3) && $media[$mediaObject]['media_type']==0 ) {
        require_once $_CONF['path'] . 'plugins/mediagallery/include/lib-exif.php';

        $haveEXIF = MG_haveEXIF($media[$mediaObject]['media_id']);
        if ( $haveEXIF ) {
            $T->set_var(array(
                'property'      =>  $_MG_CONF['site_url'] . '/property.php?mid=' . $media[$mediaObject]['media_id'],
                'lang_property' =>  $LANG_MG04['exif_header'],
            ));
        }
    }

    if ($MG_albums[0]->owner_id || $_MG_CONF['enable_media_id'] == 1) {
        $T->set_var(array(
            'media_id'  => $media[$mediaObject]['media_id']
        ));
    }

    // Language specific vars

    $T->set_var(array(
        'lang_comments'     => ($MG_albums[$aid]->enable_comments ? $LANG_MG03['comments'] : ''),
        'lang_views'        => ($MG_albums[$aid]->enable_views ? $LANG_MG03['views'] : ''),
        'lang_title'        => $LANG_MG01['title'],
        'print_shutterfly'  => $LANG_MG03['print_shutterfly'],
        'lang_uploaded_by'  => $LANG_MG01['uploaded_by'],
        'album_id'          => $aid,
        'lang_search'       => $LANG_MG01['search'],
    ));

    if ( ($MG_albums[$aid]->exif_display == 1 || $MG_albums[$aid]->exif_display == 3) && ($media[$mediaObject]['media_type'] == 0) ) {
        require_once $_CONF['path'] . 'plugins/mediagallery/include/lib-exif.php';
        $haveEXIF = MG_haveEXIF($media[$mediaObject]['media_id']);
        if ($haveEXIF) {
            $T->set_var('exif_info', MG_readEXIF($media[$mediaObject]['media_id'],2));
        }
    }

    if ( $sortID == 0 ) {

        if ( ($MG_albums[$aid]->enable_postcard == 1 && isset($_USER['uid']) && $_USER['uid'] > 1 ) || ($MG_albums[$aid]->enable_postcard == 2)  ) {
            if ( $media[$mediaObject]['media_type'] == 0 ) {
                $postcard_url = $_MG_CONF['site_url'] . '/postcard.php?mode=edit&amp;mid=' . $media[$mediaObject]['media_id'];
                $postcard_link = '<a href="' . $postcard_url . '"><img src="' . MG_getImageFile('icon_envelopeSmall.gif') . '" alt="' . $LANG_MG03['send_postcard'] . '" style="border:none;vertical-align:middle;"' . XHTML . '></a>';
                $T->set_var('postcard_link', $postcard_link);
                $T->set_var('postcard_url', $postcard_url);
                $T->set_var('lang_postcard', $LANG_MG03['postcard']);
            }
        }
    }
    PLG_templateSetVars( 'mediagallery', $T);

    $T->parse('output','page');

    $retval .= $T->finish($T->get_var('output'));

    if ($comments) {
        // glFusion Comment support
        $mid = $media[$mediaObject]['media_id'];
        if ($MG_albums[$aid]->enable_comments == 1) {
            require_once $_CONF['path_system'] . 'lib-comment.php';
            if ($MG_albums[$aid]->access == 3 || $MG_albums[0]->owner_id) {
                $delete_option = true;
            } else {
                $delete_option = false;
            }
            if (DB_count($_TABLES['comments'],'sid',$mid) > 0 || $_MG_CONF['commentbar']) {
                $cid = $mid;
                $page = isset($_GET['page']) ? COM_applyFilter($_GET['page'],true) : 0;
                if (isset($_POST['order'])) {
                    $comorder = $_POST['order'] == 'ASC' ? 'ASC' : 'DESC';
                } elseif (isset($_GET['order'])) {
                    $comorder = $_GET['order'] == 'ASC' ? 'ASC' : 'DESC';
                } else {
                    $comorder = 'DESC';
                }
                if (isset($_POST['mode'])) {
                    $commode = COM_applyFilter($_POST['mode']);
                } elseif (isset($_GET['mode'])) {
                    $commode = COM_applyFilter($_GET['mode']);
                } else {
                    $commode = 'flat';
                }
                $commentbar = CMT_userComments ($cid,$media[$mediaObject]['media_title'],
                              'mediagallery',$comorder,$commode,0,$page,false,$delete_option);
                $retval .= $commentbar;
            } else {
                $retval .= ' <center><a href="' . $_CONF['site_url'] . '/comment.php?sid=' . $mid . '&amp;title=' . $title . '&amp;pid=0&amp;type=mediagallery' . '">' . $LANG01[60] . '</a></center>';
            }
        }
    }

    return array(strip_tags($media[$mediaObject]['media_title']),$retval,$themeCSS,$aid);
}
?>