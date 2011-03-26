<?php

class DemoController extends BaseController {

  public function form(&$params, &$model) {
    // header("Content-type: text/html;charset=utf-8");
  	$research["filter"]["pages > ?"] = 50;
  	$research["sort"][] = "pages ASC";
  
  	$library = Domain::query("Book")->find($research)();
  	$model["books"] = $library;
  
  	$book = Domain::withKind("Book");
  	$book->pages = 200;
  	$model["book"] = $book;
  }
  
  public function submit(&$params, &$model) {
    // header("Content-type: text/html;charset=utf-8");    
  	$book = Domain::withKind("Book");

  	$validators["name"] = array( V::required() );
  	$validators["pages"] = array( V::required(), V::numeric(), V::range(1,500) );
  	$validators["isbn"] = array( V::numeric(true) );

  	$result = Binder::bindData($book, $validators, $params);
  	$model["book"] = $book;
  	$model["result"] = $result;
  	if ($result->hasErrors()) return "form";  	
  	
  	var_dump($book->save());
  	
  	header("HTTP/1.1 301 Moved Permanently");
  	header("Location: http://localhost:8080/demo/form");
  	
  	return false;
  }
  
  public function delete(&$params, &$model) {
    $book = Domain::withKeyString($model["id"]);
 	$book->delete();

  	header("HTTP/1.1 301 Moved Permanently");
  	header("Location: http://localhost:8080/demo/form");
  	
  	return false;
  }

  public function show(&$params, &$model) {
    return false;
  }  
}
