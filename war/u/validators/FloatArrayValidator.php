<?php

class FloatArrayValidator extends ArrayValidator {

  function __construct($optional = false) {
    parent::__construct($optional);
  }
  
  function isCorrectType(&$array) {
    foreach ($array as $value) {
      if (!is_numeric($value)) {
        return false;
      }
      $n = $value + 0;
      if (!is_int($n) && !is_float($n)) return false;      
    }
    return true;
  }  
  
  function convertItem($item) {
    return (float) $item;
  }
}
