<?php

class Finder {

  private static final $ds = java_class('com.google.appengine.api.datastore.DatastoreServiceFactory')->getDatastoreService();
  private static final $fetchBuilder = java_class('com.google.appengine.api.datastore.FetchOptions$Builder');
  private static final $operators = array(
  	'=' => 'EQUAL',
  	'==' => 'EQUAL',
  	'>' => 'GREATER_THAN',
  	'>=' => 'GREATER_THAN_OR_EQUAL',
  	'=>' => 'GREATER_THAN_OR_EQUAL',  	
  	'in' => 'IN',
  	'IN' => 'IN',
  	'<' => 'LESS_THAN',
  	'<=' => 'LESS_THAN_OR_EQUAL',
  	'=<' => 'LESS_THAN_OR_EQUAL',
  	'!=' => 'NOT_EQUAL',
  	'<>' => 'NOT_EQUAL'
  );
  
  private static final $sortEnum = java_class('com.google.appengine.api.datastore.Query$SortDirection');
  private static final $directions = array(
    'ASC' => 'ASCENDING',
    'DESC' => 'DESCENDING'
  );

  private $q;

  public function __construct($kind) {
    $this->q = new Java('com.google.appengine.api.datastore.Query', $kind);
  }
  
  public function __invoke() {
	$entities = self::$ds->prepare($this->q)->asList(self::$fetchBuilder->withDefaults());
    foreach ($entities as $entity) {
      $result[] = new Domain($entity);
    }
    return $result;
  }
  
  public function filter($filters) {
    if (is_string($filters)) { // correct for single query portion
      $filters = array($filters);
 	}
 	
 	foreach ($filters as $filter => $filterVal) {
	  list($property, $operator, $mark) = preg_split('/\s+/', trim($filter)); 
	  $this->q->addFilter($property, self::$operators[$operator], $filterVal);	  
	}
	
    return $this;
  }
  
  public function sort($sorters) {
    if (is_string($sorters)) {
      $sorters = array($sorters);
    }
  
    foreach ($sorters as $sorter) {
      list($property, $direction) = preg_split('/\s+/', trim($sorter));
      $this->q->addSort($property, self::$directions[strtoupper($direction)]);
    }
    
    return $this;
  }
  
  public function find($queries) {
    $this->filter($queries['filter'])->sort($queries['sort']);
    return $this;
  }
}
