<?php
//
// +---------------------------------------------------------------------------+
// | nmoxqrblock Geeklog Plugin 1.0                                       |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by nmox                                                |
// |                                                                           |
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
// +---------------------------------------------------------------------------+
//

$_NMOXQRBLOCK['version'] = '1.1.1';

$_NMOXQRBLOCK['hidenmoxqrblockmenu']=0;
$_NMOXQRBLOCK["size"]=80;//表示サイズ（ピクセル）　小さくしすぎた場合は携帯電話で読めない場合があります。
$_NMOXQRBLOCK["type"]="J";//J=jpeg P=png
$_NMOXQRBLOCK['nmoxqrblock'] = $LANG_NMOXQRBLOCK['nmoxqrblock'];

$_TABLES['nmoxqrblock']  = $_DB_table_prefix . 'nmoxqrblock';

?>
