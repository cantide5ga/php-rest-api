<?php
namespace RestApi;

require_once 'Parameter.php';

class Request {
    public $httpMethod;
    public $rsrc;
    public $parameters;
        
    public function __construct() {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];

        $this->rsrc = $_REQUEST[HTACCESS_RESOURCE_KEY];
        unset($_REQUEST[HTACCESS_RESOURCE_KEY]);

        $this->parameters = new Parameter();
    }
}    
?>
