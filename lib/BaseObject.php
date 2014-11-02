<?php

/**
 * Basic SocialStream object
 */
class SocialStreamBase {
  protected $request;
  
  public function __construct($data) {

  }

  /**
   * Get data from service
   */
  public function get($date) {
    $itms = $this->format($this->request->get());
    $data = array();
    $date = new SocialDateTime($date);
    
    foreach ($itms as $item) {
      if ($item->date() > $date) {
        array_push($data, $item);
      }
    }
    
    return $data;
  }
}
