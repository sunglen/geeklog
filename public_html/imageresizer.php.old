<?php
/**
 * 画像縮小プロキシスクリプト
 * 
 * imageresizer.php?image=imagename&size=size&quality=quality
 * imagename: イメージのurl
 * size: リサイズ後のサイズ
 * quality: jpegのクオリティ
 * site_url: サイトのurl
 *
 * sizeで指定された大きさより縦横いずれかが大きければsizeにあわせて縮小する。
 * アスペクト比は保存される。
 * 縦横どちらもsizeより小さければJpegへの変換だけを行う。
 * イメージが相対urlの場合、site_urlを追加する。
 */

require_once dirname(__FILE__) . '/lib-common.php';

while (@ob_end_clean()) {
}

define('RESIZER', basename(__FILE__));

/**
 * 画像の縮小用パラメータ
 */
$size = 160;
$quality = 50;

if (isset ($_GET['image'])) {
	$image = $_GET['image'];
} else {
	COM_errorLog(RESIZER . ': No image file specified.');
	exit(1);
}

if (isset ($_GET['size'])) {
	$size = COM_applyFilter($_GET['size'], TRUE);
}

if (isset ($_GET['quality'])) {
	$quality = COM_applyFilter($_GET['quality'], TRUE);
}

# if (isset ($_GET['site_url'])) {
# 	$site_url = $_GET['site_url'];
#  }

$site_url  = $_CONF['site_url'];
$path_html = $_CONF['path_html'];

$is_remote = FALSE;
$org_image = $image;

// 相対URLの場合、site_urlを追加する
if (!preg_match("!^https*?:\/\/!", $image)) {
	$image = $site_url . $image;
} 

// 自サイトの場合は、URI --> パス変換
if (strcasecmp($site_url, substr($image, 0, strlen($site_url))) === 0) {
	$image = realpath($path_html . str_replace($site_url . '/' ,'', $image));
} else {
	// 他サイトかつ、allow_url_fopen = FALSEの場合は、PEARのHTTP_Requestクラス
	// でローカルにファイルを取得する
	if (!@ini_get('allow_url_fopen')) {
		require_once 'HTTP/Request.php';
		
		$req =& new HTTP_Request($image);
		
		$req->setMethod(HTTP_REQUEST_METHOD_GET);
		if (!PEAR::isError($req->sendRequest())) {
			$code = (int) $req->getResponseCode();
			if (($code === 200) OR ($code === 304)) {
				$result = $req->getResponseBody();
				$image = tempnam($_CONF['path_data'], 'img');
				if ($image === FALSE) {
					COM_errorLog(RESIZER . ': Cannot create a temporary file in data directory.');
					exit(1);
				}
				
				$fp = @fopen($image, 'wb');
				if ($fp !== FALSE) {
					fwrite($fp, $result);
					fclose($fp);
					$is_remote = TRUE;
				} else {
					COM_errorLog(RESIZER . ': Cannot open a temporary file in data directory.');
					exit(1);
				}
			} else {
				COM_errorLog(RESIZER . ': Cannot get a remote image.  Error ' . $code);
				exit(1);
			}
		} else {
			COM_errorLog(RESIZER . ': Cannot get a remote image.  Error ' . $req->getResponseCode());
			exit(1);
		}
	}
}

// 元イメージのサイズを取得
list($s_width, $s_height) = getimagesize($image);

// 画像ファイル名の後にクエリストリングがついている場合を考慮して、パターンに
// (\?.*)? を追加。
if (preg_match('/\.jpe?g(\?.*)?$/i', $org_image)) {
	$src_img = imagecreatefromjpeg($image);
} else if (preg_match('/\.gif(\?.*)?$/i', $org_image)) {
	$src_img = imagecreatefromgif($image);
} else if (preg_match('/\.png(\?.*)?$/i', $org_image)) {
	$src_img = imagecreatefrompng($image);
} else {
	COM_errorLog(RESIZER . ': Image format is not supported.');
	exit(1);
}

if ($is_remote) {
	@unlink($image);
}

if (!$src_img) {
	COM_errorLog(RESIZER . ': Cannot read image.');
	exit(1);
} else if (!is_resource($src_img)) {
	COM_errorLog(RESIZER . ': This is not image resource.');
	exit(1);
}

// 画像の縮小(GDを使用)
if ($s_width > $size || $s_height > $size) {
	if ($s_width > $s_height) {
		$height = intval(($s_height / $s_width) * $size);
		$width = $size;
	} else {
		$width = intval(($s_width / $s_height) * $size);
		$height = $size;
	}
	$dst_img = imagecreatetruecolor($width, $height);

	if (is_resource($dst_img)) {
		imagefill($dst_img, 0, 0, imagecolorallocate($dst_img, 255, 255, 255));
		if (!@imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $width, $height, 
								$s_width, $s_height)) {
			COM_errorLog(RESIZER . ': Cannot copy image.');
			exit(1);
		}
	} else {
		COM_errorLog(RESIZER . ': Cannot create image.');
		exit(1);
	}
	
    mb_http_output('pass');
	header('Content-Type: image/jpeg');
	imagejpeg($dst_img, NULL, $quality);
	imagedestroy($dst_img);
} else {
    mb_http_output('pass');
	header('Content-Type: image/jpeg');
	imagejpeg($src_img, NULL, $quality);
	imagedestroy($src_img);
}
