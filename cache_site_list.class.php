<?php

namespace Site;

class SiteList
{
  private $filepath;
  private $files = array();
  private $aliases = array();
  private $fileOutput = 'site_list.txt';

  public function __construct()
  {
    $this->filepath = $_SERVER['HOME'] . '/.drush';
    $this->readFile();
  }
  public function readFile()
  {
    if ($handle = opendir($this->filepath)) {
      while (false != ($entry = readdir($handle))) {
        $pattern = '/aliases.drushrc.php$/';
        if (preg_match($pattern, $entry, $match)) {
          $this->files[] = $entry;
        }
      }
    }
    closedir($handle);

  }
  public function fetchList()
  {

    $this->files = array_unique($this->files);

    foreach ($this->files as $file) {

      include_once $this->filepath . '/' . $file;
      $this->aliases = array_merge($this->aliases, $aliases);
    }
    return $this->aliases;
  }
  public function buildList()
  {
    $localhost = gethostname();
    $output = '';
    $aliases = $this->fetchList();

    foreach ($aliases as $key => $alias) {
      if (!isset($alias['remote-host']) && isset($alias['path-aliases']['%site'])) {
        $output .= $key . '|' . $alias['root'] . '/' . $alias['path-aliases']['%site'] . "\n";
      }
    }
    if (!empty($output) && ($handle = @fopen($this->fileOutput, 'w'))) {
      fwrite($handle, $output);
      fclose($handle);
    }
  }
}
