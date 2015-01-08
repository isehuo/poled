<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: home_space.php 33660 2013-07-29 07:51:05Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$dos = array('album','pic');

$do = $_GET['do'];
$diymode = 0;

list($seccodecheck, $secqaacheck) = seccheck('publish');

require_once libfile('photo/'.$do, 'include');

?>