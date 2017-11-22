<?php
// +---------------------------------------------------------------------------+
// | nmoxtopicown Geeklog Plugin 1.0                                           |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
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

require_once("../../../lib-common.php");

class nmoxtopicown{
	function listup(){
		global $_TABLES,$LANG_NMOXTOPICOWN;
		$html="
		<div class='block-center'>
		<h2>".$LANG_NMOXTOPICOWN["nmoxtopicown"]."</h2>
		";
		//更新完了メッセージ
		if(isset($_GET["msg"]) and !empty($_GET["msg"])){
			$html.="<div>".$LANG_NMOXTOPICOWN["done"]."</div>";
		}
		
		$html.="
		<form action='index.php' method='post'>
		<table style='padding-bottom:32px'>
		";
		$n=1;
		$users=array();
		$rsu=DB_query("select * from ".$_TABLES["users"]);
		while($rcu=DB_fetchArray($rsu)){
			$users[$n]=array("uid"=>$rcu["uid"],"username"=>$rcu["username"]);
			$n++;
		}
		$n=1;
		$rs=DB_query("select * from ".$_TABLES["topics"]);
		while($rc=DB_fetchArray($rs)){
			$html.="
			<tr>
			<td>".$rc["topic"]."
			<input type='hidden' name='id".$n."' value='".$rc["tid"]."'".XHTML."></td>
			<td><select name='n".$n."'>
			";
			foreach($users as $user){
				$html.="<option value='".$user["uid"]."'".($user["uid"]==$rc["owner_id"]?" selected":"").">".$user["username"]."</option>";
			}
			$html.="</select></td>
			<td><input type='checkbox' name='touser".$n."' value='1'".XHTML.">".$LANG_NMOXTOPICOWN["change_writer"]."
			</td>
			</tr>
			";
			$n++;
		}
		$html.="
		</table>
		<div>
			<input type='hidden' name='mode' value='dbset'".XHTML.">
			<input type='hidden' name='".CSRF_TOKEN."' value='".SEC_createToken()."'".XHTML.">
			<input type='submit' value='".$LANG_NMOXTOPICOWN["ok"]."'".XHTML.">
		</div>
		</form>
		".$LANG_NMOXTOPICOWN["message_caution"]."
		</div>
		";
		return $html;
	}
	function dbset(){
		global $_TABLES;
		for($n=1;$n<1000;$n++){
			if(isset($_POST["n".$n])){
				$rs=DB_query("update ".$_TABLES["topics"]." set owner_id='".$_POST["n".$n]."' where tid='".$_POST["id".$n]."'");
				$rs=DB_query("update ".$_TABLES["stories"]." set owner_id='".$_POST["n".$n]."' where tid='".$_POST["id".$n]."'");
				if($_POST["touser".$n]==1){
					$rs=DB_query("update ".$_TABLES["stories"]." set uid='".$_POST["n".$n]."' where tid='".$_POST["id".$n]."'");
				}
			}else{
				break;
			}
		}
		header("location:index.php?msg=done");
	}
}

//CSRF対策
if (version_compare(VERSION, '1.5.0') < 0) {
	if (!function_exists('SEC_checkToken')) {
		function SEC_checkToken() {
			return true;
		}
		function SEC_createToken(){
			return true;
		}
	}
}

//管理権限をチェックしてNGなら退出
if(!SEC_hasRights('nmoxtopicown.edit')) {
	COM_errorLog("Someone has tried to illegally access the nmoxtopicown page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR",1);
	$display=COM_siteHeader(1);
	$display.="<div style='margin:50px;'>You can not access this page.</div>";
	$display.=COM_siteFooter(1);
	echo $display;
	exit;
}

$cl=new nmoxtopicown;
if(isset($_POST["mode"])){
	$mode=$_POST["mode"];
}else{
	$mode="";
}
switch($mode){
	case "dbset":
		if(SEC_checkToken()===false){
			exit("あなたのアクセスは攻撃の可能性があるとみなされました。");
		}
		$html=$cl->dbset();
		break;
	default:
		$html=$cl->listup();
}

$display=COM_siteHeader(1);
$display.=$html;
$display.=COM_siteFooter(1);
echo $display;
?>