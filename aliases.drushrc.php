<?php
require_once('aliases.settings.php');
require_once('aliases.class.php');

$memcache = new Memcache();
$memcache->addServer(MEMCACHE_DRUSH_ALIASES, 0);
$drush_aliases = $memcache->get('drush_aliases');

if (!empty($drush_aliases)) {
  $aliases = $drush_aliases;
}
else{
  $aliases = new LocalBuildDrushAliases();

  $aliases = $GLOBALS['bonnier_drush_aliases'] = $aliases->getAliases();
  $memcache->set('drush_aliases', $aliases, 0, 3600 * 24);
}

