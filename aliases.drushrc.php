<?php
require_once('aliases.class.php');

$aliases = new LocalBuildDrushAliases();

$aliases = $GLOBALS['bonnier_drush_aliases'] = $aliases->getAliases();