<?php

class RangeValidator extends Validator {

  private $min;
  private $max;

  public function __construct($min, $max) {
    $this->min = $min;
    $this->max = $max;
  }

  public function validate($field, $value, $result) {
    $min = $this->min;
    $max = $this->max;
    if ($value < $min || $value > $max) {
      $result->rejectValue($field, "Hodnota není v rozsahu $min..$max.", $value);
      return false;
    }
    return true;
  }
}
