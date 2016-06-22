<?php
class Response {
    public static function respond($data, $status = null) {
		$status = $status ? $status : HttpStatus::Ok();
		
        header("HTTP/1.1 ".$status->code." ".$status->message);
        return json_encode($data);
    } 
}    
?>
