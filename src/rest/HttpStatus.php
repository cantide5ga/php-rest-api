<?php

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

?>
