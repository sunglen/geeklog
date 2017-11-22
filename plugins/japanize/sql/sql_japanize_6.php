<?php
// +---------------------------------------------------------------------------+
// | 日本語サンプルアンケート追加する                                          |
// +---------------------------------------------------------------------------+
// $Id: sql_japanize6.php
// もし万一エンコードの種類が  utf-8でない場合は、utf-8に変換してください。
// 最終更新日　2010/04/09 tsuchi AT geeklog DOT jp GL1.7.0用


// 初期日本語サンプルアンケートdelete
$_SQL[] = "
    DELETE FROM {$_TABLES['pollanswers']} Where pid='geeklogfeaturepolljp'
    ";
$_SQL[] = "
    DELETE FROM {$_TABLES['pollquestions']} Where pid='geeklogfeaturepolljp'
    ";
$_SQL[] = "
    DELETE FROM {$_TABLES['polltopics']} Where pid='geeklogfeaturepolljp'
    ";
$_SQL[] = "
    DELETE FROM {$_TABLES['pollvoters']} Where pid='geeklogfeaturepolljp'
    ";

// 初期日本語サンプルアンケート質問１の答え
$_SQL[] = "
    INSERT INTO {$_TABLES['pollanswers']}
    (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES (
    'geeklogfeaturepolljp', 0, 1, '日本語化をプラグインで実現', 0, '')
    ";

$_SQL[] = "
    INSERT INTO {$_TABLES['pollanswers']}
    (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES (
    'geeklogfeaturepolljp', 0, 2, '携帯ハック', 0, '')
    ";

$_SQL[] = "
    INSERT INTO {$_TABLES['pollanswers']}
    (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES (
    'geeklogfeaturepolljp', 0, 3, 'すぐに日本語サイトになるインストーラ', 0, '')
    ";

$_SQL[] = "
    INSERT INTO {$_TABLES['pollanswers']}
    (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES (
    'geeklogfeaturepolljp', 0, 4, '翻訳されたドキュメント', 0, '')
    ";

$_SQL[] = "
    INSERT INTO {$_TABLES['pollanswers']}
    (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES (
    'geeklogfeaturepolljp', 0, 5, '1.4.1からテーマの移行を容易にするProfessionalCSS', 0, '')
    ";

$_SQL[] = "
    INSERT INTO {$_TABLES['pollanswers']}
    (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES (
    'geeklogfeaturepolljp', 0, 6, '文字化けしない日本語対応メール関数', 0, '')
    ";

$_SQL[] = "
    INSERT INTO {$_TABLES['pollanswers']}
    (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES (
    'geeklogfeaturepolljp', 0, 7, 'その他', 0, '')
    ";

// 初期日本語サンプルアンケート質問２の答え
$_SQL[] = "
    INSERT INTO {$_TABLES['pollanswers']}
    (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES (
    'geeklogfeaturepolljp', 1, 1, '直感的操作', 0, '')
    ";

$_SQL[] = "
    INSERT INTO {$_TABLES['pollanswers']}
    (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES (
    'geeklogfeaturepolljp', 1, 2, '権限設定が可能', 0, '')
    ";

$_SQL[] = "
    INSERT INTO {$_TABLES['pollanswers']}
    (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES (
    'geeklogfeaturepolljp', 1, 3, 'コミュニティ', 0, '')
    ";

$_SQL[] = "
    INSERT INTO {$_TABLES['pollanswers']}
    (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES (
    'geeklogfeaturepolljp', 1, 4, '拡張性', 0, '')
    ";

// 初期日本語サンプルアンケート質問
$_SQL[] = "
    INSERT INTO {$_TABLES['pollquestions']}
    (`qid`, `pid`, `question`) VALUES (
    0, 'geeklogfeaturepolljp', '日本語版でお気に入りの機能は何ですか？')
    ";

$_SQL[] = "
    INSERT INTO {$_TABLES['pollquestions']}
    (`qid`, `pid`, `question`) VALUES (
    1, 'geeklogfeaturepolljp', '一番の特徴は何ですか?')
    ";

// 初期日本語サンプルアンケートトピック
$_SQL[] = "
    INSERT INTO {$_TABLES['polltopics']}
    (`pid`, `topic`, `voters`, `questions`, `created`
    , `display`, `is_open`, `hideresults`, `commentcode`
    , `statuscode`, `owner_id`, `group_id`, `perm_owner`
    , `perm_group`, `perm_members`, `perm_anon`) VALUES (
    'geeklogfeaturepolljp'
    , 'Geeklogに関する意見をどうぞ'
    , 0
    , 2
    , NOW()
    , 1, 1, 1, 0, 0, 2, 8, 3, 2, 2, 2)
    ";


?>
