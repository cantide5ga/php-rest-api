<?php
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
?>
