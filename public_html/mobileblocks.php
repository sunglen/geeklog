<?php

/**
 * 携帯用ブロック表示スクリプト
 * 
 * mobileblocks.php?bid=ブロックID
 * bid: ブロックID
 *
 * bidに表示するブロックIDを指定する。
 * bidが指定されていなければブロックの一覧を表示する。
 */

require_once('lib-common.php');

function stripListTag($content) {
    $search = array(
        '@<ul([^>]*)>@i',
        '@</ul>@i',
        '@<li([^>]*)>@i',
        '@</li>@i',
        '@<div class="aligncenter">\s*<div class="block-divider">\s*</div>\s*</div>@i',
    );
    $replace = array(
        '',
        '',
        '<div$1>□',
        '</div>',
        '<hr' . XHTML . '>' . LB,
    );
    $content = preg_replace($search, $replace, $content);
    return $content;
}

$display = COM_siteHeader();
if (isset ($_GET['bid'])) {
    $bid = COM_applyFilter($_GET['bid'], true);
    $block = CUSTOM_MOBILE_getBlock($bid);
    if ($block) {
        $content = COM_formatBlock($block);
        if (in_array($block['name'], array('admin_block', 'user_block', 'section_block', 'whats_new_block'))) {
            $content = stripListTag($content);
        }
        $display .= $content;
    }
} else {
    $display .= '<kana>' . CUSTOM_MOBILE_blockMenu() . '</kana>';
}

$display .= COM_siteFooter();
echo $display;
?>
