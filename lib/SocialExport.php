<?php

class SocialExport {
  
  static function asJSON($data) {
    $tmp = array();
    
    foreach ($data as $item) {
      array_push($tmp, array(
        'name' => $item->name(),
        'link' => $item->link(),
        'date' => $item->dateString(),
        'type' => $item->type(),
      ));
    }
    
    return json_encode($tmp);
  }
  
  static function asYAML($data) {
    $yml = '';
    
    foreach ($data as $item) {
      $cur = "- name: \"" . addslashes($item->name()) . "\"\n" . 
             "  link: \"" . addslashes($item->link()) . "\"\n" . 
             "  date: \"" . addslashes($item->dateString()) . "\"\n" . 
             "  type: \"" . addslashes($item->type()) . "\"\n"; 
             
      $yml = $yml . $cur;
    }
    
    return $yml;
  }
  
}