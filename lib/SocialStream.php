<?php

require_once dirname(__FILE__) . '/BaseObject.php';
require_once dirname(__FILE__) . '/SocialObject.php';
require_once dirname(__FILE__) . '/SocialRequest.php';
require_once dirname(__FILE__) . '/SocialExport.php';

/**
 * SocialStream
 */
class SocialStream {
  private $streams = array();
  private $stream = array();
  
  /**
   * Configure web service
   */
  public function configure() {
    $data = func_get_args();    
    $name = strtolower(array_shift($data));
  
    if (stristr($name, ':')) {
      list($name, $nick) = explode(':', $name);
    } else {
      $nick = $name;
    }
    
    $clob = ucfirst($name) . 'Stream';
    require_once dirname(__FILE__) . '/../streams/' . $name . '.php';
  
    $this->streams[$nick] = new $clob($data);
  }

  /**
   * Add SocialObject to stream
   */  
  private function add($service, $data) {
    foreach ($data as $item) {
      $this->stream[] = $item->setType($service);
    }
  }
  
  /**
   * Fetch data from configured streams
   */
  private function fetch($date) {
    foreach ($this->streams as $name => &$obj) {
      $this->add($name, $obj->get($date));
    }
  }
  
  /**
   * Sort fetched items
   */
  private function sort() {
    usort($this->stream, function($a, $b) {
      return $a->date() > $b->date() ? -1 : 1;
    });
  }
  
  /**
   * Get array of recent events aka THE SocialStream
   */
  public function get($date = null) {
    $this->fetch($date);
    $this->sort();
    
    return $this->stream;
  }
  
  /**
   * Format SocialStream to JSON data
   */
  static function asJSON($data) {
    return SocialExport::asJSON($data);
  }
  
  /**
   * Format SocialStream to YAML data
   */ 
  static function asYAML($data) {
    return SocialExport::asYAML($data);
  }
}

