<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require 'dao/TodoDao.class.php';
require '../vendor/autoload.php';

Flight::register('todoDao', 'TodoDao');

//CRUD operations for todos entity

/**
* List all todos
*/

Flight::route('GET /todos',function(){


  $todos=Flight::todoDao()->get_all();
  Flight::json($todos);

});


/**
*List individual todos
*/
Flight::route('GET /todos/@id',function($id){


  $todo=Flight::todoDao()->get_by_id($id);
  Flight::json($todo);

});

/**
* add todo
*/
Flight::route('POST /todos',function(){


  $request = Flight::request();
  $data=$request->data->getData();
  Flight::todoDao()->add($data['description'],$data['created']);

});



/**
*update todo

*/
/**
* delete todo

*/
Flight::route('DELETE /todos/@id',function($id){


  $dao->delete($id);
  Flight::json(["message"=>"deleted"]);

});




Flight::start();

 ?>
