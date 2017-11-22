<?php
// +-------------------------------------------------------------------------+
// | File Management Plugin for Geeklog - by portalparts www.portalparts.com |
// +-------------------------------------------------------------------------+
// | Filemgmt plugin - version 1.5                                           |
// | Date: Mar 18, 2006                                                      |
// +-------------------------------------------------------------------------+
// | Copyright (C) 2004 by Consult4Hire Inc.                                 |
// | Author:                                                                 |
// | Blaine Lang                 -    blaine@portalparts.com                 |
// |                                                                         |
// | Based on:                                                               |
// | myPHPNUKE Web Portal System - http://myphpnuke.com/                     |
// | PHP-NUKE Web Portal System - http://phpnuke.org/                        |
// | Thatware - http://thatware.org/                                         |
// +-------------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or           |
// | modify it under the terms of the GNU General Public License             |
// | as published by the Free Software Foundation; either version 2          |
// | of the License, or (at your option) any later version.                  |
// |                                                                         |
// | This program is distributed in the hope that it will be useful,         |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                    |
// | See the GNU General Public License for more details.                    |
// |                                                                         |
// | You should have received a copy of the GNU General Public License       |
// | along with this program; if not, write to the Free Software Foundation, |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.         |
// |                                                                         |
// +-------------------------------------------------------------------------+
//
//@@@@@20080129update datetime format multilang 20080118 hiroron 

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.php') !== false) {
    die ('This file can not be used on its own.');
}

function newdownloadgraphic($time, $status) {
    global $_CONF;

    $count = 7;
    $startdate = (time()-(86400 * $count));
    if ($startdate < $time) {
        if($status==1){
            $functionretval = '&nbsp;<img src="' . $_CONF['site_url'] . '/filemgmt/images/newred.gif" alt="' . _MD_NEWTHISWEEK . '"' . XHTML . '>';
        }elseif($status==2){
            $functionretval = '&nbsp;<img src="' . $_CONF['site_url'] . '/filemgmt/images/update.gif" alt="' . _MD_UPTHISWEEK . '"' . XHTML . '>';
            }
        }
        return $functionretval;
}

function popgraphic($hits) {
        global $_CONF, $mydownloads_popular;

        if ($hits >= $mydownloads_popular) {
            $functionretval = '&nbsp;<img src="' . $_CONF['site_url'] . '/filemgmt/images/pop.gif" alt="' . _MD_POPULAR . '"' . XHTML . '>';
        }
        return $functionretval;
}

//updates rating data in itemtable for a given item
function updaterating($sel_id){
    global $_FM_TABLES;
    $voteresult = DB_query("select rating FROM {$_FM_TABLES['filemgmt_votedata']} WHERE lid = '$sel_id'");
    $votesDB = DB_numROWS($voteresult);
    $totalrating = 0;
    if ($votesDB > 0) {
           while(list($rating)=DB_fetchARRAY($voteresult)){
            $totalrating += $rating;
        }
        $finalrating = $totalrating/$votesDB;
    }
    $finalrating = number_format($finalrating, 4);
    DB_query("UPDATE {$_FM_TABLES['filemgmt_filedetail']} SET rating='$finalrating', votes='$votesDB' WHERE lid = '$sel_id'");
}

//returns the total number of items in items table that are accociated with a given table $table id
function getTotalItems($sel_id, $status=''){
    global $_FM_TABLES,$mytree;
    $count = 0;
    $arr = array();
    $sql = "SELECT count(*) from {$_FM_TABLES['filemgmt_filedetail']} a ";
    $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid ";
    $sql .= "WHERE  a.cid='$sel_id' and a.status='$status' $mytree->filtersql";
    list($thing) = DB_fetchArray(DB_query($sql));
    $count = $thing;
    $arr = $mytree->getAllChildId($sel_id);
    $size = sizeof($arr);
    for($i=0;$i<$size;$i++){
        $sql = "SELECT count(*) from {$_FM_TABLES['filemgmt_filedetail']} a ";
        $sql .= "LEFT JOIN {$_FM_TABLES['filemgmt_cat']} b ON a.cid=b.cid ";
        $sql .= "WHERE  a.cid='{$arr[$i]}}'and a.status='$status' $mytree->filtersql";
        list($thing) = DB_fetchArray(DB_query($sql));
        $count += $thing;
    }
    return $count;
}

/*
* Function to display formatted times in user timezone
*/
function formatTimestamp($usertimestamp) {
    global $_CONF;
//@@@@ 2008/01/29 multilang 20080118 hiroron  -->
//  $datetime = date("M.d.y", $usertimestamp);
    $datetime = strftime($_CONF['shortdate'], $usertimestamp);
//@@@@ 2008/01/29 multilang 20080118 hiroron  <--

    return $datetime;
}


function PrettySize($size) {
    $mb = 1024*1024;
    if ( $size > $mb ) {
        $mysize = sprintf ("%01.2f",$size/$mb) . " MB";
    }
    elseif ( $size >= 1024 ) {
        $mysize = sprintf ("%01.2f",$size/1024) . " KB";
    }
    else {
        $mysize = sprintf(_MD_NUMBYTES,$size);
    }
    return $mysize;
}


function myTextForm($url , $value) {
    return "<form action='$url' method='post'><input type='submit' value='$value' /></form>\n";
}

function themecenterposts($title, $content) {
 $retval .= "<table border='0' cellpadding='3' cellspacing='5' width='100%'>"
    ."<tr>"
    ."<td><div class='indextitle'>$title</div><br /></td>"
    ."</tr>"
    ."<tr><td>$content</td>"
    ."</tr>"
    ."<tr><td style=\"text-align:right;\">&nbsp;</td>"
    ."</tr>"
    ."</table>";

 return $retval;
}

function redirect_header($url, $time=3, $message=''){
    $display = COM_siteHeader('menu');
    $display .= "<html><head>\n";
    $display .= "<meta http-equiv='Content-Type' content='text/html;' />\n";
    $display .= "<meta http-equiv='Refresh' content='$time; url=$url' />\n";
    $display .= "</head><body>\n";
    $display .= COM_startBlock();
    $display .= "";
    if ( $message!="" ) {
        $display .= "<h4>".$message."</h4>\n";
    }
    $display .= "\n";
    $display .= sprintf(_IFNOTRELOAD,$url);
    $display .= "\n";
    $display .= COM_endBlock();
    $display .= COM_siteFooter(false);
    echo $display;
}

//Reusable Link Sorting Functions
function convertorderbyin($orderby) {
        if ($orderby == "titleA")                       $orderby = "title ASC";
        if ($orderby == "dateA")                        $orderby = "date ASC";
        if ($orderby == "hitsA")                        $orderby = "hits ASC";
        if ($orderby == "ratingA")                      $orderby = "rating ASC";
        if ($orderby == "titleD")                       $orderby = "title DESC";
        if ($orderby == "dateD")                        $orderby = "date DESC";
        if ($orderby == "hitsD")                        $orderby = "hits DESC";
        if ($orderby == "ratingD")                      $orderby = "rating DESC";
        return $orderby;
}
function convertorderbytrans($orderby) {
        if ($orderby == "hits ASC")     $orderbyTrans = _MD_POPULARITYLTOM;
        if ($orderby == "hits DESC")    $orderbyTrans = _MD_POPULARITYMTOL;
        if ($orderby == "title ASC")    $orderbyTrans = _MD_TITLEATOZ;
       if ($orderby == "title DESC")    $orderbyTrans = _MD_TITLEZTOA;
        if ($orderby == "date ASC")     $orderbyTrans = _MD_DATEOLD;
        if ($orderby == "date DESC")    $orderbyTrans = _MD_DATENEW;
        if ($orderby == "rating ASC")   $orderbyTrans = _MD_RATINGLTOH;
        if ($orderby == "rating DESC")  $orderbyTrans = _MD_RATINGHTOL;
        return $orderbyTrans;
}
function convertorderbyout($orderby) {
        if ($orderby == "title ASC")    $orderby = "titleA";
        if ($orderby == "date ASC")     $orderby = "dateA";
        if ($orderby == "hits ASC")     $orderby = "hitsA";
        if ($orderby == "rating ASC")   $orderby = "ratingA";
        if ($orderby == "title DESC")   $orderby = "titleD";
        if ($orderby == "date DESC")    $orderby = "dateD";
        if ($orderby == "hits DESC")    $orderby = "hitsD";
        if ($orderby == "rating DESC")  $orderby = "ratingD";
        return $orderby;
}

function randomfilename() {

    $length=10;
    srand((double)microtime()*1000000);
    $possible_charactors = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $string = "";
    while(strlen($string)<$length) {
        $string .= substr($possible_charactors, rand()%(strlen($possible_charactors)),1);
    }
    return($string);
}


?>