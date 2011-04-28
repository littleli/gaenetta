<?php

abstract class ArrayValidator extends Validator {

  private $optional;
  
  public function __construct($optional = false) {
    $this->optional = $optional;
  }
  
  public function canContinue() {
    return $this->optional;
  }
  
  public function validate($field, $value, $result) {    
    if (is_array($value)) {
      if ($this->optional && empty($value)) return true;
      if ($this->isCorrectType($value)) return true;
    }
    $result->rejectValue($field, "Hodnoty [$field] nejsou v pořádku", $value);
    return false;
  }
  
  public function canConvert() { return true; }
  
  public function convert($array) {
    $list = new Java('java.util.ArrayList', count($array));
    foreach ($array as $item) {
      $list->add($this->convertItem($item));
    }
    return $list;
  }
 
  abstract protected function convertItem($item);
  abstract protected function isCorrectType(&$array);
}
