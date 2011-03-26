<?php

class DefaultViewResolver extends ViewResolver {

  private $params;
  private $model;
  
  public function __construct(&$params, &$model) {
    $this->params = $params;
    $this->model = $model;
  }
  
  public function resolve($control) {
    if ($control === false) {
      return;
    } elseif (is_string($control)) { // explicit view
	  $view = $control;
	  $controller = $this->model["controller"];
	} elseif (is_int($control)) {
	  $view = "$control";
	  $controller = "errors";
	} elseif ($control === NULL) { // DEFAULT
	  $view = $this->model["action"];
	  $controller = $this->model["controller"];
	}	
	$scriptToRender = "v/${controller}/${view}.php";
	$this->renderView($scriptToRender, $this->model);
  }
  
  protected function renderView($script, &$model) {
	 // include also some builders into the current scope
	 //
	 foreach ($model as $field => $value) {
	 	$$field = $value;
	 }

	 $params = $this->params;	 
	 $tags = new Tags($params, $model);

	 // and delegate to view template
	 include $script;
  }
}
