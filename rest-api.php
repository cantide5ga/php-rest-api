<?php
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
            return Response::respond(null, HttpStatus::NotFound());
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
		$path = explode('/', rtrim($_REQUEST['path'], '/'));
        $query = explode('/', rtrim($_REQUEST['query'], '&')); //need to deal with '?'
    
        $this->pathParams = array_shift($path);
        foreach($query as $kv) {
            $pair = explode('=', $kv);
            $key = $pair[0];
            $val = $pair[1];
            
            $this->queryParams[$key] = $val;
        }
	}
}

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

class Response {
    public static function respond($data, $status = null) {
		$status = $status ? $status : HttpStatus::Ok();
		
        header("HTTP/1.1 ".$status->code." ".$status->message);
        return json_encode($data);
    } 
} 
?>
