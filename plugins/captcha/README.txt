====== CAPTCHA - 画像認証プラグイン(妹認証付) ======
                                                            2008/09/15
                              hiroron - [ hiroron AT hiroron DOT com ]
                                                            ver: 4.0.1

===== captcha - 画像認証プラグイン ======

Geeklog1.4.1用でGeeklog本体と対応プラグインで画像認証を使えます。
画像認証を使うことで、サイトのセキュリティをあげることができ、スパマー
をブロックするのに役立ちます。
画像認証の方法は、固定画像からランダムに選択して表示、ImageMagickでラ
ンダム作成して表示、GDライブラリでランダムに作成して表示、GDライブラリ
を使う妹認証で表示することができます。

  * 認証画像作成方法
    * GDライブラリ
    * GDライブラリ(妹認証)
    * ImageMagick
    * 固定画像を使用

  * 画像認証Geeklog本体機能
    * アカウント登録
    * コメント投稿
    * ユーザへメール送信
    * 記事をメール送信
    * 記事投稿

  * 対象
    * ゲストユーザのみ対象とする
    * すべてのリモートユーザを対象とする

  * 画像認証対応プラグイン
    * 掲示板(FORUM) 2.6 以上
    * メディアギャラリー(Media Gallery) 1.5.0 以上
    * CATPCHA連携に対応していればどのプラグインでも可能になりました。

※プラグインのCATPCHA連携についてはこのドキュメントにある「自作プラグ
インでCATPCHAと連携する」をご覧下さい

※妹認証はこのドキュメントにある「妹認証について」をご覧下さい



==== お勧めインストール方法(Windows限定) ====

wkyGeeklogInstallerを使ってのインストールをお勧めいたします。

wkyGeeklogInstaller(以下wGI)は簡単にGeeklogをインストールできるソフトです。
プラグインやテーマのインストールにも対応し、レシピと呼ばれる、インストール用の
設定などが書いてある専用ファイルをダウンロードして取得し、wGIを起動してから、
その画面にドラッグ＆ドロップするだけでインストールができます。

wkyGeeklogInstallerダウンロード
http://hiroron.com/filemgmt/viewcat.php?cid=3
※最新バージョンのものを選んでダウンロード下さい

captchaプラグインインストール用レシピダウンロード
http://hiroron.com/filemgmt/index.php?id=53



==== インストール手順 ====

 * public_html,admin ディレクトリ以外のディレクトリとファイルを非公開ディレクトリの plugins/captcha を作成し、その中へコピーします。
 * public_html ディレクトリを公開ディレクトリの captcha を作成し、コピーします。
 * admin ディレクトリを公開ディレクトリの admin/plugins/captcha を作成し、コピーします。
 * 属性の書き込み権限を次のものに付加します。
   * ディレクトリ
     * 非公開ディレクトリの plugins/captcha/class/auth_sister/reiya
   * ファイル
     * 非公開ディレクトリの plugins/captcha/class/auth_sister/config.inc.php
     * 非公開ディレクトリの plugins/captcha/class/auth_sister/reiya/config.inc.php
     * 非公開ディレクトリの plugins/captcha/class/auth_sister/reiya/words.txt
     * 公開ディレクトリの captcha/auth_sister.css
 * 管理者権限をもつユーザでログインし、プラグインからインストールします。

以上までで問題がでなければインストールは終わりです。



==== アンインストール方法 ====

=== 手順の説明 ===

 * 管理者権限をもつユーザでログインし、プラグインからアンインストールします。
 * アンインストールが無事できたら、インストール時に配置したディレクトリやファイルを削除します。

以上でアンインストールは完了です。



==== カスタマイズ方法(設定) ====

=== CAPTCHAプラグインの管理画面でのカスタマイズ ===

次のような設定が管理画面から行えます。

   * CAPTCHAコンフィギュレーション
     * グラフィックドライバー
     * 固定画像セット
     * グラフィックフォーマット
     * ImageMagick変換ユーティリティへのフルパス
     * デバッグ
   * CAPTCHA設定
     * ゲストユーザのみ対象とする
     * すべてのリモートユーザを対象とする
     * コメント
     * 記事投稿
     * アカウント登録
     * コンタクト
     * 記事メール送信
     * 掲示板
     * メディアギャラリ(Postcards)
     * その他対応プラグインが入っている場合には自動で出てきます
   * 妹認証の設定
     * メッセージ先頭に付加する文字列
     * メッセージ最後に付加する文字列
     * 回答文の最小文字数
     * 回答文の最大文字数
     * 文字数範囲外のエラー文
   * 妹(パッケージ)の設定
     * 妹画像ファイル
     * あたらしく妹画像をアップロードする
     * TTFフォント
     * あたらしくTTFフォントをアップロードする
     * 文字サイズ
     * 文字のX座標
     * 文字のY座標
     * 妹の辞書
     * 妹のスタイルシート


=== captcha/config.php のカスタマイズ ===

非公開ディレクトリ/plugins/captcha/config.php の各変数の値を、
コメントにしたがって変更することで設定をカスタマイズできます。

   // セッションの有効期間 (900 = 15分)
   $_CP_CONF['expire'] = 900;


=== 妹認証のカスタマイズ ===

妹認証についてのカスタマイズは、妹追加や質問文の辞書作成などが行えます。

妹の辞書の作り方。
   非公開ディレクトリの plugins/captcha/class/auth_sister/reiya/words.txt
   ※reiyaはパッケージフォルダなので適切に読みかえてください。

   \t=Tab \n=改行
   書式：質問文\t認証成功文\t失敗文\t正解文字列\t処理モード\t逆処理スイッチ(1:on)\n
   ---処理モード---
   未指定or0:入力されたすべての文字列を含む
   1:正規表現による
   2:完全一致

   ---使用可能マクロ---
   乱数・・・[rand]
   乱数(平仮名)・・・[rand_kana]
   乱数(漢字)・・・[rand_kan]
   乱数(漢字画数)・・・[rand_kankaku]

   ex) 0.35αデモの辞書ファイル

れいにゃ大好きって言って(完全一致・新機能)\tれいにゃもおにーちゃんのこと大好き♪\t（怒）\tれいにゃ大好き\t2
おにーちゃん私の煎餅たべたでしょー(部分一致)\tいいよ、別に♪\t嘘つき！\tごめんよごめんねすまんかった悪かったすまなかった俺のプリン食べただろれいにゃ大好き
れいにゃ大好きって言わないで(完全不一致・新)\t認証成功だよ\t言わないでっていったでしょ\tれいにゃ大好き\t2\t1
[rand]を漢字にして(乱数+漢字乱数マクロ・新)\tよくできたねー\t間違ったね\t[rand_kan]\t2
[rand_kan]を数字にして(乱数+漢字乱数マクロ・新)\tよくできたねー\t間違ったね\t[rand]\t2
[rand_kana]を漢字にして(乱数+かな乱数マクロ・新)\tよくできたねー\t間違ったね\t[rand_kan]\t2
[rand]を二回言え！(乱数マクロ・新)\tよくできたねっ\tばーか！\t[rand][rand]\t2
それぞれ「[rand_kankaku]」の画数をかけ！0は0。(新)\tすごいすごーい！\tぶっぶー\t[rand]\t

この書式でいくつでも追加できます。空行はエラーになりますのでないようにしてください
※セキュリティ設定により、初期の状態では2～10文字以内の文字列でしか回答できません。

詳しくは妹認証サイトをご覧下さい。
http://www.okanesuita.org/auth_sister/
※ぜひこの下にある「妹認証について」もお読みください。



==== 自作プラグインでCATPCHAと連携する ====

自作のプラグインへ画像認証の機能を付けたい場合は、このCATPCHAプラグイ
ンと連携することが可能です。連携は次のような４つのステップで簡単に行う
ことができます。

※サンプルとしてwkymlmguserプラグインのコードを使います。


=== STEP1)CAPTCHA用関数でプラグイン名を返す ===

自作プラグインの functions.inc ファイルへCAPTCHAプラグインの管理画面で
有効/無効を切り替えるチェックボックスにプラグインの表示名を返す関数
 plugin_captcha_label_<プラグイン名> を作成します。

サンプル(wkymlmguserプラグイン - functions.inc)
<code>
function plugin_captcha_label_wkymlmguser ()
{
    global $LANG_WMMA;
    return $LANG_WMMA['display_name'];
}
</code>


=== STEP2)テンプレートファイルに置き換え文字列{captcha}を埋め込む ===

次に画像認証をつけるテンプレートファイルのフォームの送信ボタンの手前あ
たりに {captcha} という置き換え文字列を追加します。

サンプル(wkymlmguserプラグイン - index.thtml)
<code>
<form action="{site_url}/wkymlmguser/index.php" method="post" id="wkymlmguser" class="compact">
<fieldset>
<legend>{title}</legend>
<p class="message">{message}</p>
<dl>
 <dt><label for="mail">{label_mail}</label></dt>
 <dd><input type="text" size="32" maxlength="96" name="mail" id="mail" value="{mail}"></dd>
 <dt><label for="remail">{label_remail}</label></dt>
 <dd><input type="text" size="32" maxlength="96" name="remail" id="remail" value="{remail}"></dd>
 <dd>{alert}</dd>
</dl>
</fieldset>
{captcha}
<ul class="submit">
 <li><input type="submit" value="{label_submit}"></li>
 <li><input type="hidden" name="mode" value="{mode}"></li>
</ul>
</form>
</code>


=== STEP3)置き換え文字列{captcha}を処理して出力する関数を埋め込む ===

先ほどの{captcha}を含むテンプレートファイルを処理してHTMLを出力する場
所へ、{captcha}を処理する PLG_templateSetVars (<プラグイン名>, $T); を
追加します

サンプル(wkymlmguserプラグイン - index.php)
<code>
function create_html ($msg = '') {
    global $_CONF, $LANG_WMMA, $LANG04;
    $retval = '';
    if (!empty($msg)) {
        $retval .= COM_startBlock( $LANG04[21], '', COM_getBlockTemplate ('_msg_block', 'header'))
                 . $msg
                 . COM_endBlock( COM_getBlockTemplate('_msg_block', 'footer') );
    }
    $mail = isset($_POST['mail']) ? $_POST['mail'] : '';
    $remail = isset($_POST['remail']) ? $_POST['remail'] : '';
    $T = new Template( $_CONF['path'] . 'plugins/wkymlmguser/templates' );
    $T->set_file( 'page', 'index.thtml' );
    $T->set_var( 'site_url', $_CONF['site_url'] );
    $T->set_var( 'mode', $LANG_WMMA['create_from_mode_exec'] );
    $T->set_var( 'title', $LANG_WMMA['create_from_title'] );
    $T->set_var( 'message', $LANG_WMMA['create_from_msg'] );
    $T->set_var( 'label_mail', $LANG_WMMA['create_from_input_mail'] );
    $T->set_var( 'label_remail', $LANG_WMMA['create_from_input_remail'] );
    $T->set_var( 'label_submit', $LANG_WMMA['create_from_input_submit'] );
    $T->set_var( 'mail',  $mail);
    $T->set_var( 'remail',  $remail);
    $T->set_var( 'alert', $LANG_WMMA['create_from_alert'] );
    PLG_templateSetVars ('wkymlmguser', $T);
    $T->parse( 'output', 'page' );
    $retval .= $T->finish( $T->get_var( 'output' ) );
    return $retval;
}
</code>


=== STEP4)画像認証のチェック処理を埋め込む ===

最後に、画像認証が認証/未認証かをチェックする関数
 PLG_itemPreSave (<プラグイン名>,''); を追加して、
戻り値に値があるときはそれをエラーとして表示してその後の処理を
行わないようにします。

サンプル(wkymlmguserプラグイン - index.php)
<code>
$mode='';
COM_setArgNames (array ('mode'));
$mode = COM_applyFilter(COM_getArgument ('mode'));
if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];
    $mail = $_POST['mail'];
    $remail = $_POST['remail'];
    $msg = '';
    if (!COM_isemail($mail)) {
        $msg = $LANG_WMMA['mail_not_mail'];
    }
    if (empty($msg) && $mail != $remail) {
        $msg = $LANG_WMMA['mail_not_match'];
    }
    if (empty($msg) && $mode == $LANG_WMMA['create_from_mode_exec']) {
        $msg = PLG_itemPreSave ('wkymlmguser',$mail);
    }
    if (empty($msg) && $mode == $LANG_WMMA['delete_from_mode_exec']) {
        $count = DB_count($_TABLES['wkymlmguser'],'email', $mail);
        if ($count <= 0) {
            $msg = $LANG_WMMA['mail_not_db_match'];
        }
    }
}

$display = COM_siteHeader();
if ($mode == $LANG_WMMA['create_from_mode_exec'] && empty($msg)) {
    $count = DB_count($_TABLES['wkymlmguser'],'email', $mail);
    if ($count < 1) {
        $regdate = strftime ('%Y-%m-%d %H:%M:%S', time ());
        $result = DB_save($_TABLES['wkymlmguser'],'email,regdate', "'$mail','$regdate'");
    }
    $display .= create_end_html();
} elseif ($mode == $LANG_WMMA['delete_from_mode_exec'] && empty($msg)) {
    $count = DB_count($_TABLES['wkymlmguser'],'email', $mail);
    if ($count > 0) {
        $result = DB_delete($_TABLES['wkymlmguser'],'email', "$mail");
    }
    $display .= delete_end_html();
} elseif ($mode == $LANG_WMMA['delete_from_mode'] || ($mode == $LANG_WMMA['delete_from_mode_exec'] && $msg)) {
    $display .= delete_html($msg);
} else {
    $display .= create_html($msg);
}
$display .= COM_siteFooter();

echo $display;
</code>

以上で連携は終わりです。



==== 妹認証について ====

CAPTCHAプラグインに組み込まれている妹認証は作者の許可を得ております。
組み込まれている妹認証のバージョンは Ver.0.35α です。

妹認証作者：菅礼紗 - www.okanesuita.org
　「ありがとうございます。」
この場を借りてお礼申し上げます。

以下、配布サイトより

　“妹認証のコンセプトは「人間的対話による認証」です。
　　これは相手が人間かどうなのかを判断する目的で開発されました。”

質問文は妹の辞書を変更することで自由に作成可能です。
詳しくは妹認証サイトの「導入方法」をご覧下さい。
http://www.okanesuita.org/auth_sister/

※妹認証のライセンスについては妹認証配布サイトをご覧下さい


妹認証にはフォントが含まれていませんが、プラグイン化するにあたり
「みかちゃん」フォントを同梱されていただいております。

フォント提供：みかちゃん - www001.upp.so-net.ne.jp/mikachan/
　「ありがとうございます。」
この場を借りてお礼申し上げます。



==== CAPTCHAプラグイン 4.0.0 について ====

CAPTCHAプラグイン 4.0.0 は gllabs.org(閉鎖)製作のCAPTCHAプラグイン 3.0.2 
を元に作成されていただきました。
　「ありがとうございます。」
この場を借りてお礼申し上げます。
4.0.0は管理画面のブラッシュアップと機能拡張＆機能追加を施しています。

なお、CAPTCHA生成(GDライブラリ、ImageMagick、固定画像を使用)には、
pascal-rehfeldt.com のクラスを使わせていただいております。
　「ありがとうございます。」
この場を借りてお礼申し上げます。



==== 変更履歴 ====

2008/09/15   4.0.1  XHTML対応
2008/08/21   4.0.0  初リリース(初公開)
