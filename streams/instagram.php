<?php

/**
 * SocialStream service provider for Pinboard.in
 */
class InstagramStream extends SocialStreamBase {
  private $user;
  private $key;

  public function __construct($data) {
    $this->user = array_shift($data);
    $this->key = array_shift($data);
    $this->request = new SocialRequest($this->url());
  }

  protected function url() {
    return 'https://api.instagram.com/v1/users/' . $this->user . '/media/recent?access_token=' . $this->key;
  }

  protected function format($data) {
    $jsn = json_decode($data, true);
    $tmp = array();

    foreach ($jsn['data'] as $image) {
      $obj = new SocialObject();
      
      $obj->setName($image['images']['thumbnail']['url']);
      $obj->setLink($image['link']);
      $obj->setDate(date('Y-m-d H:i:s', $image['created_time']));
      
      array_push($tmp, $obj);
    }

    return $tmp;
  }
}