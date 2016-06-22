<?php
require_once 'Parameter.php';

class Request {
	const DELETE = 'DELETE';
    const POST = 'POST';
    const GET = 'GET';
    const PUT = 'PUT';
	
    public $httpMethod;
    public $rsrc;
    public $parameters;
            
    public function __construct() {
        $this->httpMethod = $_SERVER['REQUEST_METHOD']; //TODO validation?
        $this->rsrc = explode('/', rtrim($_REQUEST['path'], '/'))[0];
		$this->parameters = new Parameter();
    }
}    
?>
