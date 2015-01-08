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

	$perpage = 20;
	$perpage = mob_perpage($perpage);

	$start = ($page-1)*$perpage;

	ckstart($start, $perpage);

	$_GET['friend'] = intval($_GET['friend']);

	$default = array();
	$f_index = '';
	$list = array();
	$pricount = 0;
	$picmode = 0;

	$gets = array(
		'mod' => 'space',
		'uid' => $space['uid'],
		'do' => 'album',
		'catid' => $_GET['catid'],
		'order' => $_GET['order'],
		'fuid' => $_GET['fuid'],
		'searchkey' => $_GET['searchkey'],
		'from' => $_GET['from']
	);
	$theurl = 'home.php?'.url_implode($gets);
	$actives = array($_GET['view'] =>' class="a"');

	$need_count = true;


	$wheresql = '1';

	if($_GET['order'] == 'hot') {
		$orderactives = array('hot' => ' class="a"');
		$picmode = 1;
		$need_count = false;

		$ordersql = 'p.dateline';

		$count = C::t('home_pic')->fetch_all_by_sql('p.'.DB::field('hot', $minhot, '>='), '', 0, 0, 1);
		if($count) {
			$query = C::t('home_pic')->fetch_all_by_sql('p.'.DB::field('hot', $minhot, '>='), 'p.dateline DESC', $start, $perpage);
			foreach($query as $value) {
				if($value['friend'] != 4 && ckfriend($value['uid'], $value['friend'], $value['target_ids']) && ($value['status'] == 0 || $value['uid'] == $_G['uid'] || $_G['adminid'] == 1)) {
					$value['pic'] = pic_get($value['filepath'], 'album', $value['thumb'], $value['remote']);
					$list[] = $value;
				} else {
					$pricount++;
				}
			}
		}

	} else {
		$orderactives = array('dateline' => ' class="a"');
	}


	if($need_count) {

		if($searchkey = stripsearchkey($_GET['searchkey'])) {
			$sqlSearchKey = $searchkey;
			$searchkey = dhtmlspecialchars($searchkey);
		}

		$catid = empty($_GET['catid'])?0:intval($_GET['catid']);

		$count = C::t('home_album')->fetch_all_by_search(3, $uids, $sqlSearchKey, true, $catid, 0, 0, '');

		if($count) {
			$query = C::t('home_album')->fetch_all_by_search(1, $uids, $sqlSearchKey, true, $catid, 0, 0, '', '', 'updatetime', 'DESC', $start, $perpage, $f_index);
			foreach($query as $value) {
				if($value['friend'] != 4 && ckfriend($value['uid'], $value['friend'], $value['target_ids'])) {
					$value['pic'] = pic_cover_get($value['pic'], $value['picflag']);
				} elseif ($value['picnum']) {
					$value['pic'] = STATICURL.'image/common/nopublish.gif';
				} else {
					$value['pic'] = '';
				}
				$list[] = $value;
			}
		}
	}

	$multi = multi($count, $perpage, $page, $theurl);

	dsetcookie('home_diymode', $diymode);

	if($_G['uid']) {
		$navtitle = lang('core', 'title_view_all').lang('core', 'title_album');
	} else {
		if($_GET['order'] == 'hot') {
			$navtitle = lang('core', 'title_hot_pic_recommend');
		} else {
			$navtitle = lang('core', 'title_newest_update_album');
		}
	}
	if($space['username']) {
		$navtitle = lang('space', 'sb_album', array('who' => $space['username']));
	}

	$metakeywords = $navtitle;
	$metadescription = $navtitle;
	include_once template("diy:photo/album");

?>