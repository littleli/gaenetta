<?php

class DemoController extends BaseController {

  public function form(&$params, &$model) {
  	$book = Domain::withKind("Book");
  	$book->pages = 200;
  	$model["book"] = $book;
  }
  
  public function submit(&$params, &$model) {
  	$book = Domain::withKind("Book");
  	$validators["name"] = array( V::required() );
  	$validators["pages"] = array( V::required(), V::numeric(), V::range(1,500) );
  	$validators["isbn"] = array( V::numeric() );
  	$result = Binder::bindData($book, $validators, $params);
  	$model["book"] = $book;
  	$model["result"] = $result;
  	if ($result->hasErrors()) return "form"; 
  }

  public function show(&$params, &$model) {
  }  
}
