<?php

class IntegerArrayValidator extends ArrayValidator {

  function __construct($optional = false) {
    parent::__construct($optional);
  }
  
  function isCorrectType(&$array) {
    foreach ($array as $value) {
      if (!is_numeric($value)) {
        return false;
      }
      if (!is_int($value + 0)) {
        return false;
      }
    }
    return true;
  }  
  
  function convertItem($item) {
    return (int) $item;
  }
}
