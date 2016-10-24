<?php

require_once('Controller/UserController.php');
require_once('config.php');

class REST {
  private $method;
  private $request;

  // Constructor
  public function __construct() {
    // get the HTTP method, path and body of the request
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
  }

  public function request() {
    if (isset($this->request[0]) && $this->request[0] == USERS_API_URI) {
      switch ( $this->method ) {
        case 'GET':
          $id = (int) isset($this->request[1])? $this->request[1]: null;
          UserController::get($id);
          break;
        case 'POST':
          UserController::post();
          break;
        case 'PUT':
          $id = (int) $this->request[1];
          if ($id) {
            UserController::put($id);
          }
          break;
        case 'DELETE':
          $id = (int) $this->request[1];
          if ($id) {
            UserController::delete($id);
          }
          break;
      }
    }
  }
}