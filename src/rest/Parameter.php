<?php
namespace RestApi;

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
?>
