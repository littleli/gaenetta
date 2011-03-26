<?php

function strfirst($haystack, $needle) {
  return (strpos($haystack, $needle) === 0) ? true : false;
}

class Html {

  private $output = '';

  function __call($name, $args) {
    $len = count($args);
    $do = strfirst($name, '_');
    $element = '';
    $lo = '';

    if (strfirst($name, 'open_')) {
      return $this->opentag( substr($name, 5), array_shift($args));
    } elseif (strfirst($name, 'close_')) {
      return $this->closetag( substr($name, 6));
    } elseif (strfirst($name, '_open_')) {
      return $this->_opentag( substr($name, 6), array_shift($args));
    } elseif (strfirst($name, '_close_')) {
      return $this->_closetag( substr($name, 7));
    } elseif (strfirst($name, '_')) {
       $element = substr($name, 1); // return rest of the name after '_'
    } else {
       $element = $name;
    }

    switch ($len) {
      case 0:
        $lo .= "<$element/>";
        break;
      case 1:
        $arg = array_shift($args);
        if (is_array($arg)) { 
          $lo .= "<$element" . $this->build_attr($arg) . "/>";
        } elseif (is_numeric($arg) || is_string($arg)) {
          $lo .= $this->_container($element, array(), array( $arg ));
	    }
        break;
      case 2:
        $lo .= $this->_container($element, $args[1], array( $args[0] ));
        break;
      default:
        die(__METHOD__ . ": Invalid number of arguments [line:" . __LINE__ . "]");
    }

    // is element for direct output or for stringbuilder
    if ($do) {
      return "$lo";
    } else {
      $this->output .= $lo;
    }
  }

  function container($element, $attributes = array(), $contents = array()) {
    $this->output .= $this->_container($element, $attributes, $contents);  
  }

  function _container($element, $attributes = array(), $contents = array()) {
    $lo = "<$element";
    $lo .= $this->build_attr($attributes);
    $lo .= ">";
    foreach ($contents as $content) {
      $lo .= "$content";
    }
    $lo .= "</$element>";
    return $lo;
  }

  function _opentag($tag, $attributes = array()) {
    return "<$tag" . $this->build_attr($attributes) . ">";
  }

  function opentag($tag, $attributes = array()) {
     $this->output .= $this->_opentag($tag, $attributes);
  }

  function _closetag($tag) {
    return "</$tag>";
  }

  function closetag($tag) {
    $this->output .= $this->_closetag($tag);
  }

  function comment($message) {
    $this->output .= $this->_comment($message);
  }

  function _comment($message) {
    return "<!-- $message -->";
  }

  function cdata($cdata) {
    $this->output .= $this->_cdata($cdata);
  }

  function _cdata($cdata) {
    return "<![CDATA[ $cdata ]]>";
  }

  function doctype($doctype = "html") {
    $this->output .= $this->_doctype($doctype);
  }

  function _doctype($doctype = "html") {
    return "<!DOCTYPE $doctype>\n";
  }

  function __invoke($want_echo = true) {
    if ($want_echo) {
      echo $this->output;
    } else {
      return $this->output;
    }
  }

  private function build_attr($attributes) {
    $attrstr = '';
    foreach ($attributes as $attribute => $value) {
       $attrstr .= " $attribute=\"$value\"";
    }
    return $attrstr;
  }
}
