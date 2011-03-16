<?php 

class DateValidator extends Validator {

  private $format;
  private $canContinue;
  private $_date;

  public __construct($format, $canContinue = true) {
    $this->format = $format;
    $this->canContinue = $canContinue;
  }

  public function validate($field, $value, $result) {
    $this->convert($value);
    if ($this->_date["error_count"] === 0) {
      return true;
    }    
    $result->rejectValue($field, "Hodnota pole '$field' neodpovídá očekávanému formátu", $value);
    return false;
  }
  
  public function canContinue() {
    return $this->canContinue;
  }
  
  public function canConvert() {
    return true;
  }
  
  public function convert($value) {
    $this->_date = date_parse_from_format($this->format, $value);
	return $this->_date;
  }
}
