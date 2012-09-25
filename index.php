<?php

require_once('API/api.php');

//Log
ini_set('log_errors' , '1');
ini_set('error_log' , 'errors.log');
ini_set('display_errors' , '0');

/*
 *
 * ---------------- URI & Params -----------------
 *
 */

//Empty arrays
$inputs = array();
$post = array();

//URI Data
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']) ); 
$inputs['URI'] = '/'.substr_replace($_SERVER['REQUEST_URI'], '', 0, strlen($scriptName));
$inputs['URI'] = str_replace('//', '/', $inputs['URI']);

//Method
// POST - PUT - GET - DELETE
$inputs['method'] = @$_SERVER['REQUEST_METHOD'];

//Raw input for requests
$inputs['raw_input'] = @file_get_contents('php://input');

//POST data
@parse_str($inputs['raw_input'] , $post);

//Merge all
$inputs = array_merge($inputs,$post);

/*
 *
 * ---------------- App -----------------
 *
 */
$app = new API($inputs);
$app->run();