<?php

require_once('cache_site_list.class.php');

use \Site\SiteList;

$siteList = new SiteList();

$siteList->buildList();

