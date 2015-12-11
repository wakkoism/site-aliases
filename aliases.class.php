<?php
require_once('/opt/httpd/htdocs/bonnier_drupal_shared_assets/drush_config/aliases.drushrc.php');


class LocalBuildDrushAliases extends BonnierBuildDrushAliases
{
  public function __construct($url = 'http://dev-sitelist.bonniercorp.local/api/sites?format=drush_aliases') {
    parent::__construct($url);
  }
}
