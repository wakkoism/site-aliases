<?php
require_once('aliases.settings.php');
$memcache = new Memcache();
$memcache->addServer(MEMCACHE_DRUSH_ALIASES, MEMCACHE_PORT_DRUSH_ALIASES);
$drush_aliases = $memcache->get('drush_aliases');
if (!empty($drush_aliases)) {
  $aliases = $drush_aliases;
}
else{
  require_once('aliases.class.php');
  $aliases = new LocalBuildDrushAliases(SITELIST_URL);
  $aliases = $GLOBALS['bonnier_drush_aliases'] = $aliases->getAliases();
  foreach ($aliases as $name => &$alias) {
    if (isset($alias['remote-host']) && defined('REMOTE_USER')) {
      $alias['remote-user'] = REMOTE_USER;
    }
  }
  $memcache->set('drush_aliases', $aliases, 0, 3600 * 24);
}
