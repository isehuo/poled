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
$id = empty($_GET['id'])?0:intval($_GET['id']);
$picid = empty($_GET['picid'])?0:intval($_GET['picid']);

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;

loadcache('albumcategory');
$category = $_G['cache']['albumcategory'];

$perpage = 12;
$perpage = mob_perpage($perpage);

$start = ($page-1)*$perpage;

ckstart($start, $perpage);

$default = array();
$f_index = '';
$list = array();
$pricount = 0;
$picmode = 0;

$theurl = 'photo.php?do=album&catid='.$_GET['catid'];

$actives = array($_GET['view'] =>' class="a"');

$wheresql = '1';

$orderactives = array('dateline' => ' class="a"');


if($searchkey = stripsearchkey($_GET['searchkey'])) {
	$sqlSearchKey = $searchkey;
	$searchkey = dhtmlspecialchars($searchkey);
}

$catid = empty($_GET['catid'])?0:intval($_GET['catid']);

$count = C::t('home_album')->fetch_all_by_search(3, $uids, $sqlSearchKey, true, $catid, 0, 0, '');

if($count) {
	$query = C::t('home_album')->fetch_all_by_search(1, $uids, $sqlSearchKey, true, $catid, 0, 0, '', '', 'updatetime', 'DESC', $start, $perpage, $f_index);
	foreach($query as $value) {
		if($value['friend'] != 4) {
			$value['pic'] = pic_cover_get($value['pic'], $value['picflag']);
		} elseif ($value['picnum']) {
			$value['pic'] = STATICURL.'image/common/nopublish.gif';
		} else {
			$value['pic'] = '';
		}
		$list[] = $value;
	}
}

$multi = multi($count, $perpage, $page, $theurl);

dsetcookie('home_diymode', $diymode);

$navtitle = "钢管舞图片". C::t('home_album_category')->fetch_catname_by_catid($catid);

$metakeywords = $navtitle. ", 钢管舞美女图片";
$metadescription = "提供美女钢管舞、欧美钢管舞、钢管舞技巧等图片展示，欢迎分享自己学习钢管舞的自拍图片。";
include_once template("diy:photo/album");
// print_r($_G['setting']['output']['preg']);
// print_r($_G['setting']['rewriterule']["photo_pic"]);
?>