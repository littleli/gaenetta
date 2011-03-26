<?php

final class Tags {

  private $params;
  private $model;
  private $errorClass = "error";
  
  public function __construct(&$params, &$model) {
    $this->params = $params;
    $this->model = $model;
  }
  
  public function setErrorClass($cls) {
    $this->errorClass = $cls;
  }
  
  public function form($attributes = array()) {
    $controller = $this->model['controller'];
    $action = $this->model['action'];

	if (!$attributes['name']) {
      $javadate = new Java('java.util.Date');
      $name = 'form' . $javadate->time;
      $attributes['name'] = $name;
	}
	if (!$attributes['id']) {
	  $attributes['id'] = $attributes['name'];
	}
	if (!$attributes['method']) {
      $attributes['method'] = 'post';
	}		    

    // handle controller and action differently
	if ($attributes['controller']) {
      $controller = $attributes['controller'];
      unset($attributes['controller']);
	}	
	if ($attributes['action']) {
	  $action = $attributes['action'];
	}
	
	$attributes['action'] = '/dispatcher.php';
	    
    $html = new Html;
    $html->open_form($attributes);
    $html->input(array('type'=>'hidden','name'=>'controller','value'=>$controller));
    $html->input(array('type'=>'hidden','name'=>'action','value'=>$action));
    return $html(false);
  }
  
  public function endform() {
    return '</form>';
  }
  
  public function textField($attributes = array(), $binding) {
  	$attributes['type'] = 'text';
  	$this->markRejected($attributes, $binding);
    $html = new Html;
    $html->input($attributes);
    return $html(false);
  }
  
  public function textArea($content, $attributes = array(), $binding) {
	$html = new Html;
  	$this->markRejected($attributes, $binding);	
	$html->textarea($content, $attributes);
	return $html(false);
  }
  
  public function passwordField($attributes = array(), $binding) {
    $attributes['type'] = 'password';
   	$this->markRejected($attributes, $binding);
    $html = new Html;
    $html->input($attributes);
    return $html(false);
  }
  
  public function checkboxField($attributes, $binding) {
    $attributes['type'] = 'checkbox';
  	$this->markRejected($attributes, $binding);
  	$field = $attributes['name'];
  	$accepted = $binding->accepted;
  	$target = $binding->target;
  	if ($accepted && $target->$field) {
  	  $attributes['checked'] = 'checked';
  	}
  	$html = new Html;
    $html->input($attributes);
    return $html(false);
  }
  
  public function radioField($attributes, $binding) {
    $attributes['type'] = 'radio';
  	$this->markRejected($attributes, $binding);
    $html = new Html;
    $html->input($attributes);
    return $html(false);
  }
  
  public function hiddenField($attributes, $binding) {
    $attributes['type'] = 'hidden';
    $html = new Html;
    $html->input($attributes);
    return $html(false);
  }
  
  public function link($url, $absolute = false) {
    if ($absolute) {
      $url = $this->model['HOST'] . $url;
    }
    return $url;
  }
  
  public function linkTo($controller, $action, $params, $content, $attributes = array()) {
    $href = '/' . $controller . '/' . $action;
    if (!empty($params)) {
      $href .= '?' . urlencode($params);
    }
    $attributes['href'] = $href;
    $html = new Html;
    $html->a($content, $attributes);
    return $html(false);
  }
  
  public function linkToAction($action, $params, $content, $attributes = array()) {
    $href = '/' . $this->model['controller'] . '/' . $action;
    if (!empty($params)) {
      $href .= '?' . urlencode($params);
    }
    $attributes['href'] = $href;
    $html = new Html;
    $html->a($content, $attributes);
    return $html(false);
  }
  
  public function select($items, $itemLabel, $itemValue, $selectedItem, $attributes, $binding, $noselection = false) {
  	$this->markRejected($attributes, $binding);  
    $html = new Html;    
    $html->open_select($attributes);
    if (is_array($noselection)) {
      foreach ($noselection as $key => $value) {
		$html->option($key, array('value'=>$value));
      }
    }
    foreach ($items as $option) {
      if (is_object($option)) {
        $label = $option->$itemLabel;
        $attr['value'] = $option->$itemValue;
        if ($attr['value'] == $selectedValue) {
          $attr['selected'] = 'selected';
        }
        $html->option($label, $attr);
      } elseif (is_array($option)) {
        $label = $option[$itemLabel];
        unset($option[$itemLabel]);
        $value = $option[$itemValue];
		if ($value == $selectedValue) {
		  $option['selected'] = 'selected';
		}
        unset($option[$itemValue]);
        $html->option($label, $option);
      }
    }
    $html->close_select();
  }
  
  private function markRejected(&$attributes, &$binding) {
    if ($binding) {
  	  $fieldName = $attributes['name'];   
  	  $rejected = $binding->rejected;
  	  if ($rejected[$fieldName]) {
  	    // coloring
        $currentClass = $attributes['class'];
        if ($currentClass) {
          $currentClass .= " ${this->errorClass}";
        } else {
          $currentClass = "${this->errorClass}";
        }
        $attributes['class'] = $currentClass;
        // value
   	    $attributes['value'] = $rejected[$fieldName]['value'];
  	  }
  	}
  }
}
