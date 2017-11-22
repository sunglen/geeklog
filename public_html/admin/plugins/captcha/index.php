<?php
// +---------------------------------------------------------------------------+
// | CAPTCHA v4 Plugin                                                         |
// +---------------------------------------------------------------------------+
// | Admin Interface to CAPTCHA Plugin.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by the following authors:                              |
// |                                                                           |
// | Author: mevans@ecsnet.com                                                 |
// |         Hiroron       - hiroron AT hiroron DOT com                        |
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

require_once('../../../lib-common.php');

// Only let admin users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the CAPTCHA Administration page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: " . $_SERVER['REMOTE_ADDR'],1);
    $display  = COM_siteHeader();
    $display .= COM_startBlock($LANG27[12]);
    $display .= $LANG27[12];
    $display .= COM_endBlock();
    $display .= COM_siteFooter(true);
    COM_output($display);
    exit;
}

function CP_array_sort($array, $key) {
    for ($i=0;$i<sizeof($array);$i++) {
        $sort_values[$i] = $array[$i][$key];
    }
    asort($sort_values);
    reset($sort_values);
    while (list($arr_key, $arr_val) = each($sort_values)) {
        $sorted_arr[] = $array[$arr_key];
    }
    return $sorted_arr;
}

function CP_getplugin_label() {
    global $_PLUGINS;

    $plugin = array();
    $cnt = 0;
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_captcha_label_' . $pi_name;
        if (function_exists($function)) {
            $plugin[$cnt]['pi_name'] = $pi_name;
            $plugin[$cnt]['label'] = $function();
            $cnt++;
        }
    }
    return $plugin;
}

function CP_getsisterpack_files($packdir, $ext, $cutext=true) {
    $files = array();
    if ($dir = @opendir( $packdir )) {
        while(($file = readdir($dir)) !== false) {
            if (is_file($packdir.'/'.$file)) {
                $pparts = pathinfo($packdir.'/'.$file);
                if ($pparts['extension'] == $ext) {
                    $filename = $file;
                    if ($cutext) {
                        $filename = basename($file, '.'.$ext);
                    }
                    array_push($files, $filename);
                }
            }
        }
        closedir($dir);
    }
    return $files;
}

$CP_config_auth_sister = array();

function CP_load_auth_sister_setting() {
    global $_CONF, $CP_config_auth_sister;

    if ( file_exists($_CONF['path'] . 'plugins/captcha/class/auth_sister/config.inc.php') ) {
        require($_CONF['path'] . 'plugins/captcha/class/auth_sister/config.inc.php');
        $CP_config_auth_sister['sister_mes_a'] = $auth_sister_mes_a;
        $CP_config_auth_sister['sister_mes_b'] = $auth_sister_mes_b;
        $CP_config_auth_sister['sister_len_min'] = $auth_sister_len_min;
        $CP_config_auth_sister['sister_len_max'] = $auth_sister_len_max;
        $CP_config_auth_sister['sister_outlen'] = $auth_sister_outlen;
        
        $sisterpack_dir = $_CONF['path'] . 'plugins/captcha/class/auth_sister/'.$auth_sister_load;
        
        if ( file_exists($sisterpack_dir.'/config.inc.php') ) {
            require($sisterpack_dir.'/config.inc.php');
            $CP_config_auth_sister['sister_image'] = $auth_sister_image;
            $CP_config_auth_sister['sister_font'] = $auth_sister_font;
            $CP_config_auth_sister['sister_fsize'] = $auth_sister_fsize;
            $CP_config_auth_sister['sister_fx'] = $auth_sister_fx;
            $CP_config_auth_sister['sister_fy'] = $auth_sister_fy;

            // Sister Image Set
            $sisterimages = CP_getsisterpack_files($sisterpack_dir,'png',false);
            $set_select = '<select name="sister_image" id="sister_image">';
            for ( $i=0; $i < count($sisterimages); $i++ ) {
                $set_select .= '<option value="'.$sisterimages[$i].'"'.($sisterimages[$i] == $auth_sister_image ? ' SELECTED ': '').'>'.$sisterimages[$i].'</option>';
            }
            $set_select .= '</select>';
            $CP_config_auth_sister['set_select_sister_image'] = $set_select;

            // Sister Font Set
            $sisterfonts = CP_getsisterpack_files($sisterpack_dir,'ttf');
            $set_select = '<select name="sister_font" id="sister_font">';
            for ( $i=0; $i < count($sisterfonts); $i++ ) {
                $set_select .= '<option value="'.$sisterfonts[$i].'"'.($sisterfonts[$i] == $auth_sister_font ? ' SELECTED ': '').'>'.$sisterfonts[$i].'</option>';
            }
            $set_select .= '</select>';
            $CP_config_auth_sister['set_select_sister_font'] = $set_select;

        }
        if ( file_exists($sisterpack_dir.'/words.txt') ) {
            $array_data = file($sisterpack_dir.'/words.txt');
            $CP_config_auth_sister['sister_words'] = join("",$array_data);
        }
        if ( file_exists($_CONF['path_html'].'captcha/auth_sister.css') ) {
            $array_data = file($_CONF['path_html'].'captcha/auth_sister.css');
            $CP_config_auth_sister['sister_css'] = join("",$array_data);
        }
    }
}

function CP_save_auth_sister_setting() {
    global $_CONF, $CP_config_auth_sister;
    
    $conf1 = $_CONF['path'] . 'plugins/captcha/class/auth_sister/config.inc.php';
    if ( file_exists($conf1) ) {
        if ( is_writable($conf1) ) {
            $data = file($conf1);
            $fp = fopen($conf1, "wb");
            if ($fp) {
                foreach ($data as $row) {
                    $rep = false;
                    foreach ($CP_config_auth_sister as $key => $val) {
                        if (strpos($row, '$auth_'.$key) === 0) {
                            //$comment = preg_replace('/[^;]+(.*)/', '\1', $row);
                            switch( $key ) {
                                case 'sister_mes_a':
                                case 'sister_mes_b':
                                    $str = '$auth_'.$key." = '".$val."';\n";
                                    break;
                                case 'sister_len_min':
                                case 'sister_len_max':
                                    $str = '$auth_'.$key." = ".$val.";\n";
                                    break;
                                case 'sister_outlen':
                                    $str = '$auth_'.$key.' = "'.$val.'";'."\n";
                                    break;
                            }
                            fwrite($fp, $str);
                            $rep = true;
                            break;
                        }
                    }
                    if ($rep == false) {
                        fwrite($fp, $row);
                    }
                }
                fclose($fp);
            }
            require($conf1);
            $sisterpack_dir = $_CONF['path'] . 'plugins/captcha/class/auth_sister/'.$auth_sister_load;
            $conf2 = $sisterpack_dir.'/config.inc.php';
            if ( file_exists($conf2) ) {
                if ( is_writable($conf2) ) {
                    
                    // new sister image upload
                    $new_sister_image = '';
                    $upfile = array();
                    $upfile = $_FILES['new_sister_image'];
                    if ( isset($upfile['tmp_name']) && $upfile['tmp_name'] != '' ) {
                        $rc = move_uploaded_file($upfile['tmp_name'], $sisterpack_dir.'/'.$upfile['name']);
                        chmod ($sisterpack_dir.'/'.$upfile['name'] , 0644);
                        $new_sister_image = $upfile['name'];
                    }
                    // new font upload
                    $new_sister_font = '';
                    $upfile = array();
                    $upfile = $_FILES['new_sister_font'];
                    if ( isset($upfile['tmp_name']) && $upfile['tmp_name'] != '' ) {
                        $rc = move_uploaded_file($upfile['tmp_name'], $sisterpack_dir.'/'.$upfile['name']);
                        chmod ($sisterpack_dir.'/'.$upfile['name'] , 0644);
                        $new_sister_font = basename($upfile['name'],'.ttf');
                    }
                    
                    $data = file($conf2);
                    $fp = fopen($conf2, "wb");
                    if ($fp) {
                        foreach ($data as $row) {
                            $rep = false;
                            foreach ($CP_config_auth_sister as $key => $val) {
                                if (strpos($row, '$auth_'.$key) === 0) {
                                    switch( $key ) {
                                        case 'sister_image':
                                            if ($new_sister_image != '') {
                                                $str = '$auth_'.$key." = '".$new_sister_image."';\n";
                                            } else {
                                                $str = '$auth_'.$key." = '".$val."';\n";
                                            }
                                            break;
                                        case 'sister_font':
                                            if ($new_sister_font != '') {
                                                $str = '$auth_'.$key." = '".$new_sister_font."';\n";
                                            } else {
                                                $str = '$auth_'.$key." = '".$val."';\n";
                                            }
                                            break;
                                        case 'sister_fsize':
                                        case 'sister_fx':
                                        case 'sister_fy':
                                            $str = '$auth_'.$key." = ".$val.";\n";
                                            break;
                                    }
                                    fwrite($fp, $str);
                                    $rep = true;
                                    break;
                                }
                            }
                            if ($rep == false) {
                                fwrite($fp, $row);
                            }
                        }
                        fclose($fp);
                    }
                }
            }
            // words
            if ( isset($CP_config_auth_sister['sister_words']) && $CP_config_auth_sister['sister_words'] != '' ) {
                if ( file_exists($sisterpack_dir.'/words.txt') ) {
                    if ( is_writable($sisterpack_dir.'/words.txt') ) {
                        $fp = fopen($sisterpack_dir.'/words.txt',"wb");
                        if ($fp) { fwrite($fp, $CP_config_auth_sister['sister_words']); }
                        fclose($fp);
                    }
                }
            }
            // css
            if ( isset($CP_config_auth_sister['sister_css']) && $CP_config_auth_sister['sister_css'] != '' ) {
                if ( file_exists($_CONF['path_html'].'captcha/auth_sister.css') ) {
                    if ( is_writable($_CONF['path_html'].'captcha/auth_sister.css') ) {
                        $fp = fopen($_CONF['path_html'].'captcha/auth_sister.css',"wb");
                        if ($fp) { fwrite($fp, $CP_config_auth_sister['sister_css']); }
                        fclose($fp);
                    }
                }
            }
        }
    }
}

$msg = '';

if ( isset($_POST['mode']) ) {
    $mode = $_POST['mode'];
} else {
    $mode = '';
}

if ( $mode == $LANG_CP00['cancel'] && !empty($LANG_CP00['cancel']) ) {
    header('Location:' . $_CONF['site_admin_url'] . '/moderation.php');
    exit;
}

// Create integration other plugin
$other_plugins = CP_getplugin_label();

if ( $mode == $LANG_CP00['save'] && !empty($LANG_CP00['save']) ) {
    $settings['anonymous_only']         = $_POST['anononly'] == 'on' ? 1 : 0;
    $settings['remoteusers']            = $_POST['remoteusers'] == 'on' ? 1 : 0;
    $settings['enable_comment']         = $_POST['comment'] == 'on' ? 1 : 0;
    $settings['enable_story']           = $_POST['story'] == 'on' ? 1 : 0;
    $settings['enable_registration']    = $_POST['registration'] == 'on' ? 1 : 0;
    $settings['enable_contact']         = $_POST['contact'] == 'on' ? 1 : 0;
    $settings['enable_emailstory']      = $_POST['emailstory'] == 'on' ? 1 : 0;
    $settings['enable_forum']           = $_POST['forum'] == 'on' ? 1 : 0;
    $settings['enable_mediagallery']    = $_POST['mediagallery'] == 'on' ? 1: 0;

    $settings['gfxDriver']              = COM_applyFilter($_POST['gfxdriver']);
    $settings['gfxFormat']              = COM_applyFilter($_POST['gfxformat']);
    $settings['gfxPath']                = addslashes($_POST['gfxpath']);
    $settings['debug']                  = $_POST['debug'] == 'on' ? 1 : 0;
    $settings['imageset']               = COM_applyFilter($_POST['imageset']);

    // integration other plugin
    if (count($other_plugins) > 0) {
        foreach ($other_plugins as $oplugin) {
            $opi_name = $oplugin['pi_name'];
            $settings['enable_'.$opi_name] = $_POST[$opi_name] == 'on' ? 1: 0;
        }
    }

    foreach($settings AS $option => $value ) {
        $value = addslashes($value);
        DB_save($_TABLES['cp_config'],"config_name,config_value","'$option','$value'");
        $_CP_CONF[$option] = stripslashes($value);
    }
    
    // write auth sister setting
    foreach (array('sister_mes_a','sister_mes_b','sister_len_min','sister_len_max','sister_outlen','sister_image','new_sister_image','sister_font','new_sister_font','sister_fsize','sister_fx','sister_fy','sister_words','sister_css') as $key) {
        switch($key) {
            case 'sister_words':
            case 'sister_css':
                if ( get_magic_quotes_gpc() == 1 ) {
                    $val = stripslashes( $_POST[$key] );
                } else {
                    $val = $_POST[$key];
                }
                break;
            default:
                $val = addslashes($_POST[$key]);
                break;
        }
        if ($val != '') {
            $CP_config_auth_sister[$key] = $val;
        }
    }
    CP_save_auth_sister_setting();
    
    $msg = $LANG_CP00['success'];
}


$display = '';
$display = COM_siteHeader();

// Create template
if ( is_dir( $_CONF['path_layout'] . 'captcha/admin' ) ) {
    $T = new Template($_CONF['path_layout'] . 'captcha/admin');
} else {
    $T = new Template($_CONF['path'] . 'plugins/captcha/templates/admin');
}
$T->set_file (array (
    'setting' => 'setting.thtml',
    'integrationitem' => 'integrationitem.thtml'
    ));

// Create navibar
require_once ($_CONF['path_system'] . 'classes/navbar.class.php');
$navbar = new navbar;
$navbar->add_menuitem($LANG_CP00["setting_general"],     'showhideEditorDiv("page01",0);return false;',true);
$navbar->add_menuitem($LANG_CP00["setting_auth_sister"], 'showhideEditorDiv("page02",1);return false;',true);
$navbar->add_menuitem($LANG_CP00["setting_all"],         'showhideEditorDiv("all",2)   ;return false;',true);
$navbar->set_selected($LANG_CP00["setting_general"]);

// Create imageset
$imageset = array();
$i = 0;
$directory = $_CONF['path'] . 'plugins/captcha/images/static/';

$dh = @opendir($directory);
while ( ( $file = @readdir($dh) ) != false ) {
    if ( $file == '..' || $file == '.' ) {
        continue;
    }
    $imagedir = $directory . $file;
    if (@is_dir($imagedir)) {
        if ( file_exists($imagedir . '/' . 'imageset.inc') ) {
            include ( $imagedir . '/' . 'imageset.inc');
            $imageset[$i]['dir'] = $file;
            $imageset[$i]['name'] = $staticimageset['name'];
            $i++;
        }
    }
}
@closedir($dh);

$sImageSet = CP_array_sort($imageset,'name');
$set_select = '<select name="imageset" id="imageset">';
for ( $i=0; $i < count($sImageSet); $i++ ) {
    $set_select .= '<option value="' . $sImageSet[$i]['dir'] . '"' . ($_CP_CONF['imageset'] == $sImageSet[$i]['dir'] ? ' SELECTED ': '') .'>' . $sImageSet[$i]['name'] .  '</option>';
}
$set_select .= '</select>';

// Create integration other plugin
if ( count($other_plugins) > 0 ) {
    foreach($other_plugins as $oplugin) {
        $opi_name = $oplugin['pi_name'];
        $T->set_var( 'integration_name', $opi_name );
        $T->set_var( 'integration_label', $oplugin['label'] );
        $T->set_var( 'integration_checked', ($_CP_CONF['enable_'.$opi_name] ? ' CHECKED=CHECKED' : '') );
        
        $T->parse( 'integration_elements', 'integrationitem', true );
    }
}

// Create auth_sister Set
CP_load_auth_sister_setting();


$T->set_var(array(
    'site_admin_url'            => $_CONF['site_admin_url'],
    'site_url'                  => $_CONF['site_url'],
    'navlist'                   => $navbar->generate(),
    'anonchecked'               => ($_CP_CONF['anonymous_only'] ? ' CHECKED=CHECKED' : ''),
    'remotechecked'             => ($_CP_CONF['remoteusers'] ? ' CHECKED=CHECKED' : ''),
    'commentchecked'            => ($_CP_CONF['enable_comment'] ? ' CHECKED=CHECKED' : ''),
    'storychecked'              => ($_CP_CONF['enable_story'] ? ' CHECKED=CHECKED' : ''),
    'registrationchecked'       => ($_CP_CONF['enable_registration'] ? ' CHECKED=CHECKED' : ''),
    'contactchecked'            => ($_CP_CONF['enable_contact'] ? ' CHECKED=CHECKED' : ''),
    'emailstorychecked'         => ($_CP_CONF['enable_emailstory'] ? ' CHECKED=CHECKED' : ''),
    'forumchecked'              => ($_CP_CONF['enable_forum'] ? ' CHECKED=CHECKED' : ''),
    'mediagallerychecked'       => ($_CP_CONF['enable_mediagallery'] ? ' CHECKED=CHECKED' : ''),
    'gdselected'                => ($_CP_CONF['gfxDriver'] == 0 ? ' SELECTED=SELECTED' : ''),
    'gdsisterselected'          => ($_CP_CONF['gfxDriver'] == 1 ? ' SELECTED=SELECTED' : ''),
    'imselected'                => ($_CP_CONF['gfxDriver'] == 2 ? ' SELECTED=SELECTED' : ''),
    'noneselected'              => ($_CP_CONF['gfxDriver'] == 3 ? ' SELECTED=SELECTED' : ''),

    'jpgselected'               => ($_CP_CONF['gfxFormat'] == 'jpg' ? ' SELECTED=SELECTED' : ''),
    'pngselected'               => ($_CP_CONF['gfxFormat'] == 'png' ? ' SELECTED=SELECTED' : ''),

    'gfxpath'                   => $_CP_CONF['gfxPath'],

    'debugchecked'              => ($_CP_CONF['debug'] ? ' CHECKED=CHECKED' : ''),

    'lang_overview'             => $LANG_CP00['captcha_info'],
    'lang_view_logfile'         => $LANG_CP00['view_logfile'],
    'lang_admin'                => $LANG_CP00['admin'],
    'lang_settings'             => $LANG_CP00['enabled_header'],
    'lang_anonymous_only'       => $LANG_CP00['anonymous_only'],
    'lang_enable_comment'       => $LANG_CP00['enable_comment'],
    'lang_enable_story'         => $LANG_CP00['enable_story'],
    'lang_enable_registration'  => $LANG_CP00['enable_registration'],
    'lang_enable_contact'       => $LANG_CP00['enable_contact'],
    'lang_enable_emailstory'    => $LANG_CP00['enable_emailstory'],
    'lang_enable_forum'         => $LANG_CP00['enable_forum'],
    'lang_enable_mediagallery'  => $LANG_CP00['enable_mediagallery'],
    'lang_save'                 => $LANG_CP00['save'],
    'lang_cancel'               => $LANG_CP00['cancel'],
    'lang_gfx_driver'           => $LANG_CP00['gfx_driver'],
    'lang_gfx_format'           => $LANG_CP00['gfx_format'],
    'lang_convert_path'         => $LANG_CP00['convert_path'],
    'lang_gd_libs'              => $LANG_CP00['gd_libs'],
    'lang_gd_sister_libs'       => $LANG_CP00['gd_sister_libs'],
    'lang_imagemagick'          => $LANG_CP00['imagemagick'],
    'lang_static_images'        => $LANG_CP00['static_images'],
    'lang_debug'                => $LANG_CP00['debug'],
    'lang_configuration'        => $LANG_CP00['configuration'],
    'lang_integration'          => $LANG_CP00['integration'],
    'lang_imageset'             => $LANG_CP00['image_set'],
    'lang_remoteusers'          => $LANG_CP00['remoteusers'],
    'selectImageSet'            => $set_select,
    'lang_msg'                  => $msg,
    'version'                   => $_CP_CONF['version'],
    's_form_action'             => $_CONF['site_admin_url'] . '/plugins/captcha/index.php',
    'val_sister_mes_a'          => $CP_config_auth_sister['sister_mes_a'],
    'val_sister_mes_b'          => $CP_config_auth_sister['sister_mes_b'],
    'val_sister_len_min'        => $CP_config_auth_sister['sister_len_min'],
    'val_sister_len_max'        => $CP_config_auth_sister['sister_len_max'],
    'val_sister_outlen'         => $CP_config_auth_sister['sister_outlen'],
    'val_sister_image'          => $CP_config_auth_sister['sister_image'],
    'selectSisterImage'         => $CP_config_auth_sister['set_select_sister_image'],
    'val_sister_font'           => $CP_config_auth_sister['sister_font'],
    'selectSisterFont'          => $CP_config_auth_sister['set_select_sister_font'],
    'val_sister_fsize'          => $CP_config_auth_sister['sister_fsize'],
    'val_sister_fx'             => $CP_config_auth_sister['sister_fx'],
    'val_sister_fy'             => $CP_config_auth_sister['sister_fy'],
    'val_sister_words'          => $CP_config_auth_sister['sister_words'],
    'val_sister_css'            => $CP_config_auth_sister['sister_css'],
    'lang_auth_sister'          => $LANG_CP10['auth_sister'],
    'lang_auth_sister_package'  => $LANG_CP10['auth_sister_package'],
    'lang_sister_mes_a'         => $LANG_CP10['sister_mes_a'],
    'lang_sister_mes_b'         => $LANG_CP10['sister_mes_b'],
    'lang_sister_len_min'       => $LANG_CP10['sister_len_min'],
    'lang_sister_len_max'       => $LANG_CP10['sister_len_max'],
    'lang_sister_outlen'        => $LANG_CP10['sister_outlen'],
    'lang_sister_image'         => $LANG_CP10['sister_image'],
    'lang_new_sister_image'     => $LANG_CP10['new_sister_image'],
    'lang_sister_font'          => $LANG_CP10['sister_font'],
    'lang_new_sister_font'      => $LANG_CP10['new_sister_font'],
    'lang_sister_fsize'         => $LANG_CP10['sister_fsize'],
    'lang_sister_fx'            => $LANG_CP10['sister_fx'],
    'lang_sister_fy'            => $LANG_CP10['sister_fy'],
    'lang_sister_words'         => $LANG_CP10['sister_words'],
    'lang_sister_css'           => $LANG_CP10['sister_css'],
    'xhtml'                     => XHTML,
));


$T->parse('output', 'setting');
$display .= $T->finish($T->get_var('output'));
$display .= COM_siteFooter();
COM_output($display);

?>
