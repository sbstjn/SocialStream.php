<?php

/**
 * SocialStream service provider for Pinboard.in
 */
class PinboardStream extends SocialStreamBase {
  private $token;

  public function __construct($token) {
    $this->token = array_shift($token);
    $this->request = new SocialRequest($this->url());
  }

  protected function url() {
    return 'https://api.pinboard.in/v1/posts/recent?auth_token=' . $this->token;
  }

  protected function format($data) {
    $xml = simplexml_load_string($data);
    $tmp = array();
    
    foreach ($xml->post as $link) {
      $obj = new SocialObject();
      
      $obj->setName($link->attributes()->description);
      $obj->setLink($link->attributes()->href);
      $obj->setDate($link->attributes()->time);
      
      array_push($tmp, $obj);
    }
    
    return $tmp;
  }
}