<?php

class MaxValidator extends Validator {

  private $max;

  public function __construct($max) {
    $this->max = $max;
  }

  public function validate($field, $value, $result) {
    $max = $this->max;
    if ($value > $max) {
      $result->rejectValue($field, "Hodnota pole $field je větší než $max");
      return false;
    }
    return true;
  }
}
