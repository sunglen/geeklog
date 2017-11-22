<?php
/**
 * 画像縮小プロキシスクリプト
 * 
 * imageresizer.php?image=imagename&size=size&quality=quality
 * imagename: イメージのurl
 * size: リサイズ後のサイズ
 * quality: jpegのクオリティ
 * site_url: サイトのurl
 * type: 出力画像形式
 *
 * sizeで指定された大きさより縦横いずれかが大きければsizeにあわせて縮小する。
 * アスペクト比は保存される。
 * 縦横どちらもsizeより小さければJpegへの変換だけを行う。
 * イメージが相対urlの場合、site_urlを追加する。
 */

/**
 * 画像の縮小用パラメータ
 */
$size = 160;
$quality = 50;
$quality_png = 9; // 圧縮レベル。0 (圧縮しない) から 9 までの値。
$type = 'gif';

if (isset ($_GET['image'])) {
    $image = $_GET['image'];
} else {
    exit("no image file specified.");
}
if (isset ($_GET['size'])) {
    $size = $_GET['size'];
}
if (isset ($_GET['quality'])) {
    $quality = $_GET['quality'];
}
if (isset ($_GET['site_url'])) {
    $site_url = $_GET['site_url'];
}
if (isset ($_GET['type'])) {
    $type = strtolower($_GET['type']);
}


// 相対URLの場合、site_urlを追加する
if(!preg_match("!https*?:\/\/!", $image)) {
    $image = $site_url . $image;
 }
$image = str_replace($site_url . '/' ,'', $image);

// 元イメージのサイズを取得
list($s_width, $s_height) = getimagesize($image);

if (preg_match('/jpeg$/i', $image) || preg_match('/jpg$/i', $image)) {
    $src_img = imagecreatefromjpeg($image);
 } else if (preg_match('/gif$/i', $image)) {
    $src_img = imagecreatefromgif($image);
 } else if (preg_match('/png$/i', $image)) {
    $src_img = imagecreatefrompng($image);
 } else {
    exit("image format is not supported.");
 }

if(!$src_img) {
    exit("can't read image.");
 } else if(!is_resource($src_img)) {
    exit("this is not image resource.");
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
            exit("can't copy image.");
        }
    } else {
        exit("can't create image.");
    }
    mb_http_output("pass");
    if ($type == 'png') {
        header("Content-type: image/png");
        imagepng($dst_img, NULL, $quality_png);
    } else if ($type == 'gif') {
        header("Content-type: image/gif");
        imagegif($dst_img);
    } else {
        header("Content-type: image/jpeg");
        imagejpeg($dst_img, NULL, $quality);
    }
} else {
    mb_http_output("pass");
    if ($type == 'png') {
        header("Content-type: image/png");
        imagepng($src_img, NULL, $quality_png);
    } else if ($type == 'gif') {
        header("Content-type: image/gif");
        imagegif($src_img);
    } else {
        header("Content-type: image/jpeg");
        imagejpeg($src_img, NULL, $quality);
    }
}

?>