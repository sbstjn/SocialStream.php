<?php

/**
 * SocialDateTime
 */
class SocialDateTime {
  public $date;
  private $read;
  
  public function __construct($str) {
    $this->date = strtotime($str);
    $this->read = date('Y-m-d H:i:s', $this->date);
  }
  
  public function string() {
    return $this->read;
  }
}

/**
 * SocialObject
 */
class SocialObject {
  private $name;
  private $link;
  private $date;
  private $type;
  
  public function __construct() {
    
  }
  
  /**
   * Get date of event
   */
  public function date() {
    return $this->date;
  }
  
  /**
   * Get date as string
   */
  public function dateString() {
    return $this->date->string();
  }
  
  /**
   * Get name
   */
  public function name() {
    return $this->name;    
  }
  
  /**
   * Get link
   */
  public function link() {
    return $this->link;
  }
  
  /**
   * Get type
   */
  public function type() {
    return $this->type;
  }
  
  /**
   * Set service type of event
   */
  public function setType($type) {
    $this->type = (string)$type;
    
    return $this;
  }
  
  /**
   * Set name of event
   */
  public function setName($name) {
    $this->name = (string)$name;
    
    return $this;
  }
  
  /**
   * Set link of event
   */
  public function setLink($link) {
    $this->link = (string)$link;
    
    return $this;
  }
  
  /**
   * Set date of event
   */
  public function setDate($date) {
    $this->date = new SocialDateTime((string)$date);
    
    return $this;
  }
}

?>