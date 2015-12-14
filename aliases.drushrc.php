<?php

$settings['memcache'] = array('unix:///var/run/memcached/memcached_sitelist.sock');

require_once('aliases.class.php');

$memcache = new Memcache();
$memcache->addServer($settings['memcache'][0], 0);
$drush_aliases = $memcache->get('drush_aliases');

if (!empty($drush_aliases)) {
  $aliases = $drush_aliases;
}
else{
  $aliases = new LocalBuildDrushAliases();
  
  $aliases = $GLOBALS['bonnier_drush_aliases'] = $aliases->getAliases();
  $memcache->set('drush_aliases', $aliases, 0, 3600 * 24);
}

