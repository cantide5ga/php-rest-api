<?php
namespace RestApi;

require_once "HttpStatus.php";
require_once "Response.php";

abstract class Api {
    protected $request;
    private $defaulStatus;

    function __construct($request) {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->request = $request;
    }

    public function process() {	
        $httpMethod = $this->request->httpMethod;
        $rsrc = $this->request->rsrc;

        $method = $httpMethod.$rsrc;

        if(method_exists($this, $method)) {
            return Response::respond(
            $this->{$method}($this->request->parameters)
            );
        } else {
            return \RestApi\Response::respond(null, \RestApi\HttpStatus::NotFound());
        }
    }       
}
?>
