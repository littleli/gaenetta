<?php

final class StringArrayValidator extends ArrayValidator {
  
  public function __construct($optional = false) {
    parent::__construct($optional);
  }
  
  function isCorrectType(&$array) {
    foreach ($array as $value) {
      if (!is_string($value)) {
        return false;
      }
    }
    return true;
  }  
  
  function convertItem($item) {
    return "$item";
  }  
}
