<?php

class MinValidator extends Validator {

  private $min;

  public __construct($min) {
    $this->min = $min;
  }

  public function validate($field, $value, $result) {
    $min = $this->min;
    if ($value < $min) {
	  $result->rejectValue($field, "Hodnota $value je menší než požadovan hodnota $min");
      return false;
    }
    return true;
  }	
}
