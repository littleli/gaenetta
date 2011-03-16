<?php

class RequiredValidator extends Validator {
  
  public function canContinue() {
  	return false; 
  }

  public function validate($field, $value, $result) {
    if ($value == NULL || $value === "") {
      $result->rejectValue($field, "Hodnota '$field' je povinný údaj.", $value);
      return false;
    }
    return true;
  }
}
