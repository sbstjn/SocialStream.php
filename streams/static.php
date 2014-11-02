<?php

/**
 * SocialStream service provider for Pinboard.in
 */
class StaticStream extends SocialStreamBase {
  private $token;

  public function __construct($file) {
    $this->file = array_shift($file);
    $this->request = new SocialRequest($this->url());
  }

  protected function url() {
    return $this->file;
  }

  protected function format($data) {
    $jsn = json_decode($data, true);
    $tmp = array();

    foreach ($jsn as $set) {
      $obj = new SocialObject();

      $obj->setName($set['Name']);
      $obj->setLink($set['Link']);
      $obj->setDate($set['Date']);

      array_push($tmp, $obj);
    }

    return $tmp;
  }
}