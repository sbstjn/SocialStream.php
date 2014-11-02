<?php

/**
 * Request data from service
 */
class SocialRequest {
  private $url;
  private $header;
  
  /**
   * Initialize SocialRequest item with URL
   */
  public function __construct($url) {
    $this->url = $url;
    
    return $this;
  }
  
  /**
   * Set HTTP header for custom requests
   */
  public function setHeader($header) {
    $this->header = $header;
  }
  
  /**
   * Set URL
   */
  public function setURL($url) {
    $this->url = $url;
    
    return $this;
  }
  
  /**
   * Get the data
   */
  public function get($date = null) {
    if (!$this->header) {
      return file_get_contents($this->url);
    } else {
      $curl_request = curl_init();
      curl_setopt($curl_request, CURLOPT_HTTPHEADER, $this->header);
      curl_setopt($curl_request, CURLOPT_HEADER, false);
      curl_setopt($curl_request, CURLOPT_URL, $this->url);
      curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
      $response = curl_exec($curl_request);
      curl_close($curl_request);
      
      return $response;
    }
  }
}