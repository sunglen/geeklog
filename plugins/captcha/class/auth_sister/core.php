<?php
//Copyright (C) 2008 菅礼紗(http://www.okanesuita.org/).

//妹★関数-----------------------------------------------------------

//セッション初期化
function auth_session_start(){
	require('config.inc.php');
	if($ses_name) {session_name($ses_name);}
	if($ses_dir) {session_save_path($ses_dir);}
	session_start();
}

//妹ヘッダを挿入します
function auth_sister_header(){
	require('config.inc.php');
	require(''.$auth_sister_load.'/config.inc.php');
	return $auth_sister_header;
}

//妹認証の初期化
function auth_sister_load(){
    global $_CONF;
	require('config.inc.php');

	$loc = $_CONF['path'] . 'plugins/captcha/class/auth_sister/'.$auth_sister_load.'/words.txt';//辞書ファイル読み込み
	//ファイル存在する場合は続行
	if(file_exists($loc)){
		$lines = file($loc, FILE_IGNORE_NEW_LINES);
		$cnt = count($lines); //行数カウント
		$cnt--;
		$point = mt_rand(0, $cnt); //乱数発生
		//質問文	正解メッセージ	不正解メッセージ	正解文	正解文の処理モード	逆処理スイッチ
		//↓回答文の処理モード
		//未指定・0:入力されたすべての文字列を含む
		//1:正規表現による
		//2:完全一致
		list(
		$_SESSION['auth_sister_question'],//質問文
		$_SESSION['auth_sister_res_true'],//正解メッセージ
		$_SESSION['auth_sister_res_false'],//不正解メッセージ
		$_SESSION['auth_sister_answer'],//正解文
		$_SESSION['auth_sister_anmode'],//正解文の処理モード
		$_SESSION['auth_sister_rebirth']//逆処理スイッチ(0=OFF/1=ON)
		)=explode("\t",$lines[$point]);//各変数に読み出し
		
		$_SESSION['auth_sister_ticket'] = true;	//画像読込権
		$_SESSION['auth_sister_authID'] = uniqid(rand());	//AuthID発行
		
		//以下マクロ処理だよ！
		//乱数発生だよ！
		$ran = rand(1,9999);
		//乱数を平仮名にしちゃうよ！
		$ranran = $ran;
		$ranran = str_replace("0","れい"	,$ranran);
		$ranran = str_replace("1","いち"	,$ranran);
		$ranran = str_replace("2","に"  	,$ranran);
		$ranran = str_replace("3","さん"	,$ranran);
		$ranran = str_replace("4","よん"  	,$ranran);
		$ranran = str_replace("5","ご"  	,$ranran);
		$ranran = str_replace("6","ろく"	,$ranran);
		$ranran = str_replace("7","なな"	,$ranran);
		$ranran = str_replace("8","はち"	,$ranran);
		$ranran = str_replace("9","きゅう"	,$ranran);
		//乱数を漢字にしちゃおうかな！
		$kanran = $ran;
		$kanran = str_replace("0","零"	,$kanran);
		$kanran = str_replace("1","一"	,$kanran);
		$kanran = str_replace("2","二" 	,$kanran);
		$kanran = str_replace("3","三"	,$kanran);
		$kanran = str_replace("4","四"	,$kanran);
		$kanran = str_replace("5","五" 	,$kanran);
		$kanran = str_replace("6","六"	,$kanran);
		$kanran = str_replace("7","七"	,$kanran);
		$kanran = str_replace("8","八"	,$kanran);
		$kanran = str_replace("9","九"	,$kanran);
		//こんどは画数だぞ！
		$kankaku = $ran;
		$kankaku = str_replace("0","0"	,$kankaku);
		$kankaku = str_replace("1","一"	,$kankaku);
		$kankaku = str_replace("2","七" ,$kankaku);
		$kankaku = str_replace("3","川"	,$kankaku);
		$kankaku = str_replace("4","六"	,$kankaku);
		$kankaku = str_replace("5","四" ,$kankaku);
		$kankaku = str_replace("6","竹"	,$kankaku);
		$kankaku = str_replace("7","初"	,$kankaku);
		$kankaku = str_replace("8","松"	,$kankaku);
		$kankaku = str_replace("9","音"	,$kankaku);
		//[rand]
		$_SESSION['auth_sister_question'] = str_replace("[rand]", $ran, $_SESSION['auth_sister_question']);
		$_SESSION['auth_sister_answer'] = str_replace("[rand]", $ran, $_SESSION['auth_sister_answer']);
		//[rand_kana]
		$_SESSION['auth_sister_question'] = str_replace("[rand_kana]", $ranran, $_SESSION['auth_sister_question']);
		$_SESSION['auth_sister_answer'] = str_replace("[rand_kana]", $ranran, $_SESSION['auth_sister_answer']);
		//[rand_kan]
		$_SESSION['auth_sister_question'] = str_replace("[rand_kan]", $kanran, $_SESSION['auth_sister_question']);
		$_SESSION['auth_sister_answer'] = str_replace("[rand_kan]", $kanran, $_SESSION['auth_sister_answer']);		
		//[rand_kankaku]
		$_SESSION['auth_sister_question'] = str_replace("[rand_kankaku]", $kankaku, $_SESSION['auth_sister_question']);
	}
}


//妹認証の表示セット 先に初期化しておくこと
function auth_sister_insert(){
	require('config.inc.php');
	require(''.$auth_sister_load.'/config.inc.php');
	
	$output = str_replace("[authID]", $_SESSION['auth_sister_authID'], $auth_sister_html);//AuthID挿入
	return $output;
}

//auth_sister_auth()は認証成功の場合true、失敗の場合はfalseを返します。
function auth_sister_auth(){
	require('config.inc.php');
	$auth = false;
	$select = false;
	
	$authid= $_SESSION['auth_sister_authID'];
	//---メソッド
	switch($auth_sister_method):
		case 0 :
			$select = $_POST[$authid];
			break;
		case 1 :
			$select = $_GET[$authid];
			break;
	endswitch;
	if($select){
		$select = mb_convert_encoding($select,"UTF-8","auto");//入力されたもの
		$answer	= mb_convert_encoding($_SESSION['auth_sister_answer'],"UTF-8","auto");//正解文
		$mode	= $_SESSION['auth_sister_anmode'];//処理モード
		
		$len = mb_strlen  ( $select  , "UTF-8");//入力文の文字数
		//文字数制限
		if(($len>=$auth_sister_len_min)&&($len<=$auth_sister_len_max)){
			//処理モード
			switch($mode):
				case 0://入力されたすべての文字列を含む
					if(mb_strstr($answer,$select,0,"UTF-8")) { $auth = true; }
					break;
				case 1://正規表現による
					if(mb_ereg($answer,$select))  { $auth = true; }
					break;
				case 2://完全一致
					if($answer==$select)  { $auth = true; }
					break;
				default://入力されたすべての文字列を含む
					if(mb_strstr($answer,$select,0,"UTF-8")) { $auth = true; }
			endswitch;
			//逆処理
			if($_SESSION['auth_sister_rebirth']==1){
				if($auth) { $auth = false; }
				else { $auth = true; }
			}
			//認証結果文
			if($auth){
				$_SESSION['auth_sister_res'] = $_SESSION['auth_sister_res_true'];
			} else {
				$_SESSION['auth_sister_res'] = $_SESSION['auth_sister_res_false'];
			}
		//文字数エラー
		} else {
			$_SESSION['auth_sister_res'] = $auth_sister_outlen;
			$auth = false;
		}
	} else {
    	$_SESSION['auth_sister_res'] = $auth_sister_outlen;
	}
return($auth);
}

//認証成功・失敗メッセージを返します
function auth_sister_res(){
	require('config.inc.php');
	$res = $auth_sister_mes_a.$_SESSION['auth_sister_res'].$auth_sister_mes_b;
return($res);
}


?>