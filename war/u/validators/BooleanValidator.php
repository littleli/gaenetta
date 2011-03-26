<?php

class BooleanValidator extends Validator {

  private $trueValue;
  private $optional;
  
  public function __construct($trueValue = true, $optional = false) {
    $this->trueValue = $trueValue;
    $this->optional = $optional;
  }
  
  public function setTrueValue($trueValue) {
    $this->trueValue = $trueValue;
  }
  
  public function validate($field, $value, $result) {
    if ($value == $this->trueValue) return true;
    if ($this->optional && empty($value)) return true;
    $result->rejectValue($field, "Pole [$field] musí být obsahovat hodnotu [${this->trueValue}]", $value);
    return false;
  }
  
  public function canContinue() { return false; }
  
  public function canConvert() { return true; }
  
  public function convert($value) {
    return $value == $this->trueValue;
  }
}
