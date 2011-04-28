<?php

function checkbox(&$binding, &$attributes) {
  $attributes['type'] = 'checkbox';
  if ($binding) {
    $fieldName = $attributes['name'];
    $accepted = $binding->getAccepted();
    if ($accepted[$fieldName]) {
      $attributes['checked'] = NULL;
    }
  }
  $html = new Html;
  $html->input($attributes);
  return $html(false);
}

function checkboxGroup(&$checkboxModel, &$binding, &$each_attributes) {
}

function textField(&$binding, &$attributes) {
  $attributes['type'] = 'text';
  if ($binding) {
   $fieldName = $attributes['name'];
   $accepted = $binding->getAccepted();
   if ($accepted[$fieldName]) {
     if (is_array($binding->target)) {
       $value = $binding->target[$fieldName];
     } elseif (is_object($binding->target)) {
       $value = $binding->target->$fieldName;
     }
     $attributes['value'] = $value;
   }
   $attributes = $binding->markRejected($attributes);
  }
  $html = new Html;
  $html->input($attributes);
  return $html(false);
}

function radio(&$binding, &$attributes) {
  $attributes['type'] = 'radio';
  if ($binding) {
    $fieldName = $attributes['name'];
    $accepted = $binding->getAccepted();
    if ($accepted[$fieldName]) {
      $attributes['checked'] = NULL;
    }
  }
  $html = new Html;
  $html->input($attributes);
  return $html(false);
}

function radioGroup($radioGroupModel, $binding, $each_attributes) {
}

function hiddenField(&$binding, &$attributes) {
  $attributes['type'] = 'hidden';
  $html = new Html;
  $html->input($attributes);
  return $html(false);
}

function select(&$selectboxModel, &$binding, &$attributes) {
  $html = new Html;
  $html->open_select($attributes);
  foreach ($selectBoxModel as $option) {
    $label = $option['label'];
    $value = $option['value'];
    $html->option($label, array('value'=>$value));
  }
  $html->close_select();
  return $html(false);
}

function option($binding, $label, $value) {
  $html = new Html;
  $html->option($label, array('value'=>$value));
  return $html(false);
}

function form($controller, $action, &$attributes) {
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
  
  $attributes['action'] = '/dispatcher.php';
  
  $html = new Html;
  $html->open_form($attributes);
  $html->input(array('name'=>'controller','type'=>'hidden','value'=>$controller));
  $html->input(array('name'=>'action','type'=>'hidden','value'=>$action));
  return $html(false);
}

function end_form() {
  return '</form>';
}

function checked($item, &$checkedModel) {
  return in_array($item, $checkedModel) ? 'checked' : '';
}

function selected($item, &$selectModel) {
  return in_array($item, $selectModel) ? 'selected' : '';
}
