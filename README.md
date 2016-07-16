# site-aliases

- Create a symlink alias to ~/.drush using ln -s ~/.drush/aliases.drushrc.php path/to/this/aliases.drushrc.php
- Create a ~/.drush/local.aliases.drushrc.php
- Add in entry 
    $alises['example.local'] = array(
      'root' => '/var/www/local.sandcastle.example.com/public',
      'uri' => 'http://www.example.com',
      'path-aliases' => array(
        '%site' => 'sites/example.com',
    ),
   );
- Inside aliases.settings.php
    define('MEMCACHE_DRUSH_ALIASES', 'localhost');
    define('MEMCACHE_PORT_DRUSH_ALIASES', 11211);
    define('REMOTE_USER', 'loginusername');
    define('SITELIST_URL', 'http://sitelist.example.com/api/sites?format=drush_aliases');

