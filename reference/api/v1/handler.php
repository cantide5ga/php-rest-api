<?php
    require_once '../../../rest-api.php';
    require_once '../../entry/EntryResource.php';
    require_once '../../keyword/KeywordResource.php'; 
    
    $request = new Request();
    $rsrc = $request->rsrc;
    
    $api = null;
    switch($rsrc) {
	case 'entries':
		$api = new EntryResource($request);
		break;
	case 'keyword':
		$api = new KeywordResource($request);
		break;
	default:
		Response::respond(null, HttpStatus::NotFound());
		break;
	}
    
    if($api) echo $api->process();
?>
