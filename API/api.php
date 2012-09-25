<?php

require_once('router.php');

class API
{
    //Input datas
    private $_URI;          //URI - /password/cat/id
    private $_method;       //GET - POST - PUT - DELETE
    private $_rawInput;     //Raw input


    function __construct($inputs)
    {
        //HTTP inputs
        $this->_URI =       $this->_checkKey('URI', $inputs);
        $this->_rawInput =  $this->_checkKey('raw_input', $inputs);
        $this->_method =    $this->_checkKey('method', $inputs);
    }

    //Return NULL if the key does not exist
    private function _checkKey($key, $array){
        return array_key_exists($key, $array) ? $array[$key] : NULL;
    }

    public function run() {

        //Create the router
        $router = new Router();

        // Populate the router

        // GET homepage
        $router->addRoute('GET', '/', function() {
            echo "Home page";
        });

        // GET info page on a specific date
        $router->addRoute('GET', '/info/:day/:month/:year', function($day,$month,$year) {
            echo "Infos for $day/$month/$year";
        });

        // Execute functions
        function hello() { echo "Hello "; } 
        function world() { echo "world "; } 
        $router->addRoute('GET', '/helloworld' , hello(), world(), function() {
            echo "!";
        });

        //Run the router
        $router->run($this->_method, $this->_URI);
    }
}
