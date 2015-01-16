<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: space_album.php 33249 2013-05-09 07:27:16Z kamichen $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$minhot = $_G['setting']['feedhotmin']<1?3:intval($_G['setting']['feedhotmin']);
$aid = empty($_GET['aid'])?0:intval($_GET['aid']);
$picid = empty($_GET['picid'])?0:intval($_GET['picid']);

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;

if(!$picid){
	$query = C::t('home_pic')->fetch_all_by_sql("p.albumid = ".$aid, "p.dateline desc", 0, 1, 0 , 0);
	if(count($query)){
		$picid = $query[0]['picid'];
	}else{
		exit();
	}
}

$pic = C::t('home_pic')->fetch_by_id_idtype($picid);

if(!$pic || ($pic['status'] == 1 && $_GET['modpickey'] != modauthkey($pic['picid']))) {
	showmessage('view_images_do_not_exist');
}

$picid = $pic['picid'];
$theurl = "home.php?mod=space&uid=$pic[uid]&do=$do&picid=$picid";

$album = array();
if($pic['albumid']) {
	$album = C::t('home_album')->fetch($pic['albumid']);
	if(!$album) {
		C::t('home_pic')->update_for_albumid($pic['albumid'], array('albumid' => 0));
	}
	
	if($album['catid'] && !$album['catname']) {
		$album['catname'] = C::t('home_album_category')->fetch_catname_by_catid($album['catid']);
		$album['catname'] = dhtmlspecialchars($album['catname']);
	}
}

$piclist = $list = $keys = array();
$keycount = 0;
$query = C::t('home_pic')->fetch_all_by_sql("albumid = ".$pic['albumid'], "dateline desc", 0, 0, 0, 0);

foreach($query as $value) {
	if($value['status'] == 0) {
		$keys[$value['picid']] = $keycount;
		$list[$keycount] = $value;
		$keycount++;
	}
}
$upid = $nextid = 0;
$nowkey = $keys[$picid];
$endkey = $keycount - 1;
if($endkey>4) {
	$newkeys = array($nowkey-2, $nowkey-1, $nowkey, $nowkey+1, $nowkey+2);
	if($newkeys[1] < 0) {
		$newkeys[0] = $endkey-1;
		$newkeys[1] = $endkey;
	} elseif($newkeys[0] < 0) {
		$newkeys[0] = $endkey;
	}
	if($newkeys[3] > $endkey) {
		$newkeys[3] = 0;
		$newkeys[4] = 1;
	} elseif($newkeys[4] > $endkey) {
		$newkeys[4] = 0;
	}
	$upid = $list[$newkeys[1]]['picid'];
	$nextid = $list[$newkeys[3]]['picid'];

	foreach ($newkeys as $nkey) {
		$piclist[$nkey] = $list[$nkey];
	}
} else {
	$newkeys = array($nowkey-1, $nowkey, $nowkey+1);
	if($newkeys[0] < 0) {
		$newkeys[0] = $endkey;
	}
	if($newkeys[2] > $endkey) {
		$newkeys[2] = 0;
	}
	$upid = $list[$newkeys[0]]['picid'];
	$nextid = $list[$newkeys[2]]['picid'];

	$piclist = $list;
}
foreach ($piclist as $key => $value) {
	$value['pic'] = pic_get($value['filepath'], 'album', $value['thumb'], $value['remote']);
	$piclist[$key] = $value;
}

$pic['pic'] = pic_get($pic['filepath'], 'album', $pic['thumb'], $pic['remote'], 0);
$pic['size'] = formatsize($pic['size']);

$perpage = 20;
$perpage = mob_perpage($perpage);

$start = ($page-1)*$perpage;

ckstart($start, $perpage);

$cid = empty($_GET['cid'])?0:intval($_GET['cid']);

$siteurl = getsiteurl();
$list = array();
$count = C::t('home_comment')->count_by_id_idtype($pic['picid'], 'picid', $cid);
if($count) {
	$query = C::t('home_comment')->fetch_all_by_id_idtype($pic['picid'], 'picid', $start, $perpage, $cid);
	foreach($query as $value) {
		$list[] = $value;
	}
}

$multi = multi($count, $perpage, $page, $theurl);

if(empty($album['albumname'])) $album['albumname'] = lang('space', 'default_albumname');

$pic_url = $pic['pic'];
if(!preg_match("/^(http|https)\:\/\/.+?/i", $pic['pic'])) {
	$pic_url = getsiteurl().$pic['pic'];
}
$pic_url2 = rawurlencode($pic['pic']);

$hash = md5($pic['uid']."\t".$pic['dateline']);
$picid = $pic['picid'];
$idtype = 'picid';

$maxclicknum = 0;
loadcache('click');
$clicks = empty($_G['cache']['click']['picid'])?array():$_G['cache']['click']['picid'];
foreach ($clicks as $key => $value) {
	$value['clicknum'] = $pic["click{$key}"];
	$value['classid'] = mt_rand(1, 4);
	if($value['clicknum'] > $maxclicknum) $maxclicknum = $value['clicknum'];
	$clicks[$key] = $value;
}

$clickuserlist = array();
foreach(C::t('home_clickuser')->fetch_all_by_id_idtype($picid, $idtype, 0, 20) as $value) {
	$value['clickname'] = $clicks[$value['clickid']]['name'];
	$clickuserlist[] = $value;
}

$actives = array('me' =>' class="a"');

if($album['picnum']) {
	$sequence = $nowkey + 1;
}

$diymode = intval($_G['cookie']['home_diymode']);

$navtitle = $album['albumname'];
if($pic['title']) {
	$navtitle = $pic['title'].' - '.$navtitle;
}
$metakeywords = $pic['title'] ? $pic['title'] : $album['albumname'];
$metadescription = $pic['title'] ? $pic['title'] : $albumname['albumname'];


include_once template("diy:photo/pic");

?>