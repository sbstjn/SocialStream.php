<?php

/**
 * SocialStream service provider for Pinboard.in
 */
class LastfmStream extends SocialStreamBase {
  private $user;
  private $key;

  public function __construct($data) {
    $this->user = array_shift($data);
    $this->key = array_shift($data);
    $this->request = new SocialRequest($this->url());
  }

  protected function url() {
    return 'http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=' . $this->user . '&api_key=' . $this->key . '&format=json';
  }

  protected function format($data) {
    $jsn = json_decode($data, true);
    $tmp = array();
    
    foreach ($jsn['recenttracks']['track'] as $track) {
      $obj = new SocialObject();
      
      if (!isset($track['date'])) {
        continue;
      }
      
      $obj->setName($track['artist']['#text'] . " - " . $track['name']);
      $obj->setLink($track['url']);
      $obj->setDate($track['date']['#text']);
      
      array_push($tmp, $obj);
    }
    
    return $tmp;
  }
}