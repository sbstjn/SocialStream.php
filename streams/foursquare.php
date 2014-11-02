<?php

/**
 * SocialStream service provider for Pinboard.in
 */
class FoursquareStream extends SocialStreamBase {
  private $token;

  public function __construct($token) {
    $this->token = array_shift($token);
    $this->request = new SocialRequest($this->url());
  }

  protected function url() {
    return 'https://api.foursquare.com/v2/users/self/checkins?oauth_token=' . $this->token . '&v=20120609';
  }

  protected function format($data) {
    $jsn = json_decode($data, true);
    $tmp = array();

    foreach ($jsn['response']['checkins']['items'] as $checkin) {
      $obj = new SocialObject();
      
      $obj->setName($checkin['venue']['name']);
      $obj->setLink('https://foursquare.com/venue/' . $checkin['venue']['id']);
      $obj->setDate(date('Y-m-d H:i:s', $checkin['createdAt']));
      
      array_push($tmp, $obj);
    }

    return $tmp;
  }
}