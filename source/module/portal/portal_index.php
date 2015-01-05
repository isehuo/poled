<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: portal_index.php 31313 2012-08-10 03:51:03Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

list($navtitle, $metadescription, $metakeywords) = get_seosetting('portal');
if(!$navtitle) {
	$navtitle = $_G['setting']['navs'][1]['navname'];
	$nobbname = false;
} else {
	$nobbname = true;
}
if(!$metakeywords) {
	$metakeywords = $_G['setting']['navs'][1]['navname'];
}
if(!$metadescription) {
	$metadescription = $_G['setting']['navs'][1]['navname'];
}

if(isset($_G['makehtml'])){
	helper_makehtml::portal_index();
}

$fe_focuslist = array();
$fe_focuslist[] = array(
    'title' => "成教量身定做",
    'desc' => '<p>为早教、幼教、成教量身定做<br />与行业团体、领袖精诚合作，保障我们的系统符合行业现在与未来<br />基于互联网思维管理教育机构</p>',
    'pic' => 'http://a.hiphotos.baidu.com/image/w%3D2048%3Bq%3D90/sign=d1d88b19df54564ee565e33987e6a7f3/29381f30e924b899318dce326c061d950a7bf603.jpg',
    'pic_thum' => '',
    'bgcolor' => '#05b8e0'
);

$fe_focuslist[] = array(
    'title' => "成教量身定做",
    'desc' => '<p>为早教、幼教、成教量身定做<br />与行业团体、领袖精诚合作，保障我们的系统符合行业现在与未来<br />基于互联网思维管理教育机构</p>',
    'pic' => 'http://a.hiphotos.baidu.com/image/w%3D2048%3Bq%3D90/sign=d1d88b19df54564ee565e33987e6a7f3/29381f30e924b899318dce326c061d950a7bf603.jpg',
    'pic_thum' => '',
    'bgcolor' => '#ff6600'
);

$fe_focuslist[] = array(
    'title' => "成教量身定做",
    'desc' => '<p>为早教、幼教、成教量身定做<br />与行业团体、领袖精诚合作，保障我们的系统符合行业现在与未来<br />基于互联网思维管理教育机构</p>',
    'pic' => 'http://a.hiphotos.baidu.com/image/w%3D2048%3Bq%3D90/sign=d1d88b19df54564ee565e33987e6a7f3/29381f30e924b899318dce326c061d950a7bf603.jpg',
    'pic_thum' => '',
    'bgcolor' => '#0288ce'
);

$fe_focuslist[] = array(
    'title' => "成教量身定做",
    'desc' => '<p>为早教、幼教、成教量身定做<br />与行业团体、领袖精诚合作，保障我们的系统符合行业现在与未来<br />基于互联网思维管理教育机构</p>',
    'pic' => 'http://a.hiphotos.baidu.com/image/w%3D2048%3Bq%3D90/sign=d1d88b19df54564ee565e33987e6a7f3/29381f30e924b899318dce326c061d950a7bf603.jpg',
    'pic_thum' => '',
    'bgcolor' => '#669900'
);


include_once template('diy:portal/index');
?>