<?php
$path = '/opt/httpd/htdocs/bonnier_drupal_shared_assets/drush_config/includes/';
require_once($path . 'DrushAliasesCache.interface.php');
require_once($path . 'DrushAliasesCacheMemcache.class.php');
require_once($path . 'BonnierBuildDrushAliases.class.php');

/**
 * @file
 * Builds Drush aliases list from site_list data of Bonnier sites.
 *
 * This script will try to strip the remote-host
 * attribute from each alias where the remote-host is the same as local host.
 * For example, if this script is run on devphp-53, the remote-host attribute
 * should stripped for sites that actually run on devphp-53. This ensures that
 * Drush commands using those aliases do not try to SSH into the remote-host,
 * because you are already on that host.
 */

$already_run = isset($GLOBALS['bonnier_drush_aliases']);

// Since this file gets loaded multiple times during Drush's bootstrap, we need
// logic to ensure we don't duplicate any work.
if ($already_run) {
  // Set our custom list of aliases to $aliases in global namespace, and that's
  // all Drush expects of us.
  $aliases = $GLOBALS['bonnier_drush_aliases'];
}

if (!$already_run) {
  // If memcache is not working, you can use a file on disk for cache storage.
  //$cache = new DrushAliasesCacheFile('/tmp/drush-aliases.cache');

  $cache = new DrushAliasesCacheMemcache();
  $url = 'http://sitelist.bonniercorp.local/api/sites?format=drush_aliases';
  $aliasBuilder = new BonnierBuildDrushAliases($url, $cache);

  $aliases = $GLOBALS['bonnier_drush_aliases'] = $aliasBuilder->getAliases();
}

class LocalBuildDrushAliases extends BonnierBuildDrushAliases
{
  public function __construct($url = 'http://dev-sitelist.bonniercorp.local/api/sites?format=drush_aliases')
  {
    // $this->setTryToStripRemoteHosts(false);
    parent::__construct($url);
  }
}
