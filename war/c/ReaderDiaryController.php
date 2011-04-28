<?php

class ReaderDiaryController extends BaseController {

  function list(&$params, &$model) {    
    $query['sort'][] = 'rating DESC';
    $model['entries'] = Domain::query('Book')->find( $query )();
    
    // $welcome_url = http_build_url( array('scheme'=>'http', 'host'=>$_SERVER['HTTP_HOST'], 'path'=>'/readerDiary/list') );
    $model['login_url'] = Users::loginUrl( 'http://gaenetta.appspot.com/readerDiary/list' );
    
    // $goodbye_url = http_build_url( array('scheme'=>'http', 'host'=>$_SERVER['HTTP_HOST'], 'path'=>'/readerDiary/list') );
    $model['logout_url'] = Users::logoutUrl( 'http://gaenetta.appspot.com/readerDiary/list' );
  }
  
  function login() {
  }
  
  function logout() {
  }
  
  function add(&$params, &$model) {
    $book = Domain::withKind('Book');
    $model['book'] = $book; 
  }
  
  function submit(&$params, &$model) {    
    $book = Domain::withKind('Book');    
    $valid['title'] = array( V::required() );    
    $valid['author'] = array( V::required() );
    $valid['pages'] = array( V::required(), V::numeric() );
    $valid['isbn'] = array();
    $valid['link'] = array();
    $valid['format'] = array( V::required(), V::stringArray() );
    $valid['rating'] = array( V::numeric(true) );
    // $valid['characters'] = array( V::arrayString(true) );
        
    $result = Binder::bind($book, $valid, $params);
    $model['book'] = $book;
    $model['result'] = $result;
    
    if ($result->hasErrors()) return "add";    
    $book->save();    
    return redirect('readerDiary', 'list');
  }
}
