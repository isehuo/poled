<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: home.php 32932 2013-03-25 06:53:01Z zhangguosheng $
 */

define('APPTYPEID', 1);
define('CURSCRIPT', 'photo');

#if(!empty($_GET['mod']) && ($_GET['mod'] == 'misc' || $_GET['mod'] == 'invite')) {
	define('ALLOWGUEST', 1);
#}

require_once './source/class/class_core.php';
require_once './source/function/function_home.php';

$discuz = C::app();

$cachelist = array('magic','userapp','usergroups', 'diytemplatenamehome');
$discuz->cachelist = $cachelist;
$discuz->init();

$space = array();

$dos = array('album','pic');

$_GET['do'] = (!empty($_GET['do']) && in_array($_GET['do'], $dos))?$_GET['do']:'album';

$mod = getgpc('mod');
if(!in_array($mod, array('photo'))) {
	$mod = 'index';
}

$curmod = $mod;
define('CURMODULE', $curmod);
runhooks($_GET['do']);

require_once libfile('photo/'.$mod, 'module');
?>