<?php

class NumericValidator extends Validator {

  private $optional;
  
  public function __construct($optional = false) {
    $this->optional = $optional;
  }
  
  public function canContinue() { 
  	return false;
  }

  public function validate($field, $value, $result) {
    if (is_numeric($value)) return true;
    if (empty($value) && $this->optional) return true;
    $result->rejectValue($field, "Hodnota '$field' musí být číslo.", $value);
    return false;
  }
  
  public function canConvert() { 
  	return true;
  }
  
  public function convert($value) {
    if (is_numeric($value)) return $value + 0;
	if (empty($value) && $this->optional) return NULL;
	return $value;
  }
}
