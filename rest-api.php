<?php
namespace RestApi;

const HTACCESS_RESOURCE_KEY = "rsrc";
const HTACCESS_PATH_KEY = "path";

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

class HttpStatus {
    private static $status = Array(
        200 => 'OK',
        404 => 'Not Found',   
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error'
    );

    public static function Ok() {
        return self::buildStatus(200);
    }

    public static function NotFound() {
        return self::buildStatus(404);
    }

    private static function buildStatus($code) {
        return (object) Array('code' => $code, 
            'message' => self::$status[$code]);
    }
}

class Parameter {
    public $pathParams = Array();
    public $queryParams = Array();

    public function __construct() {
        $path = $_REQUEST[HTACCESS_PATH_KEY];
        unset($_REQUEST[HTACCESS_PATH_KEY]);

        $this->pathParams = explode('/', $path);
        $this->queryParams = $_REQUEST;
    }
}

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

class Response {
    public static function respond($data, $status = null) {
        $status = $status ? $status : HttpStatus::Ok();

        header("HTTP/1.1 ".$status->code." ".$status->message);
        return json_encode($data);
    } 
} 

//Handler.class.php
class Handler {
	private $handler;
	private static $instance;
	
	public static function instance() {
		if(null === self::$instance)
			static::$instance = new self();
		
		return self::$instance;
	}
	
	private function __construct() { };
	private function __clone() { };
	private function __wakeup() { };
	
	public function registerHandler($handler) {
		$this->handler = $handler;
	}
	
	public function handle() {
		$request = new Request();
		
		$this->handler($request);
	}
}
?>
