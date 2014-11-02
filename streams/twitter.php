<?php

/**
 * SocialStream service provider for Pinboard.in
 */
class TwitterStream extends SocialStreamBase {
  private $username;
  private $consumerKey;
  private $consumerSecret;
  private $accessToken;
  private $accessSecret;

  public function __construct($data) {
    $this->username = array_shift($data);
    $this->consumerKey = array_shift($data);
    $this->consumerSecret = array_shift($data);
    $this->accessToken = array_shift($data);
    $this->accessSecret = array_shift($data);
    
    $this->request = new SocialRequest($this->url());
    $this->request->setHeader($this->prepareHeader());
  }
  
  private function prepareHeader() {
    $oauth_hash = '';
    $oauth_hash .= 'oauth_consumer_key=' . $this->consumerKey . '&';
    $oauth_hash .= 'oauth_nonce=' . time() . '&';
    $oauth_hash .= 'oauth_signature_method=HMAC-SHA1&';
    $oauth_hash .= 'oauth_timestamp=' . time() . '&';
    $oauth_hash .= 'oauth_token='. $this->accessToken . '&';
    $oauth_hash .= 'oauth_version=1.0';
    
    $base = 'GET&' . rawurlencode('https://api.twitter.com/1.1/statuses/user_timeline.json') . '&' . rawurlencode($oauth_hash);
    $key = rawurlencode($this->consumerSecret) . '&' . rawurlencode($this->accessSecret);
    
    $signature = rawurlencode(base64_encode(hash_hmac('sha1', $base, $key, true)));
    
    $oauth_header = '';
    $oauth_header .= 'oauth_consumer_key="' . $this->consumerKey. '", ';
    $oauth_header .= 'oauth_nonce="' . time() . '", ';
    $oauth_header .= 'oauth_signature="' . $signature . '", ';
    $oauth_header .= 'oauth_signature_method="HMAC-SHA1", ';
    $oauth_header .= 'oauth_timestamp="' . time() . '", ';
    $oauth_header .= 'oauth_token="' . $this->accessToken . '", ';
    $oauth_header .= 'oauth_version="1.0", ';
    
    return array("Authorization: Oauth {$oauth_header}", 'Expect:');
  }

  protected function url() {
    return 'https://api.twitter.com/1.1/statuses/user_timeline.json';
  }

  protected function format($data) {
    $jsn = json_decode($data, true);
    $tmp = array();

    foreach ($jsn as $tweet) {
      $obj = new SocialObject();
      
      $obj->setName(preg_replace('/\s+/', ' ', preg_replace( "/\r|\n/", " ", $tweet['text'])));
      $obj->setLink('https://twitter.com/' . $this->username . '/status/' . $tweet['id_str']);
      $obj->setDate($tweet['created_at']);
      
      array_push($tmp, $obj);
    }

    return $tmp;
  }
}