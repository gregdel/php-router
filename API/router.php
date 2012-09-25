<?php

require_once('route.php');

class Router
{

	private $_routes;
	private $_matchingRoutes;
	private $_defaultRoute;
	
	function __construct()
	{
		// Contains all the routes
		$this->_routes = array();

		// Contains the matching routes
		$this->_matchingRoutes = array();

		// Init default route
		$this->_defaultRoute = NULL;
	}

	public function addRoute() {
		$args = func_get_args();
		array_push($this->_routes, new Route($args));
	}

	// If nothing match the default route apply
	public function setDefaultRoute($route) {
		$this->_defaultRoute = $route;
	}

	//Starting the router with the HTTP infos
	public function run($method, $URI) {

		//Find the matching methods
		$this->_findMatchingMethod($this->_routes, $method);

		//In previous matching routes find the ones matching the pattern
		$this->_findMatchingPattern($this->_matchingRoutes, $URI);

		if (count($this->_matchingRoutes) == 0) {
			//If no route match
			if ( !is_null($this->_matchingRoutes) )
				header('Location: '.$this->_defaultRoute);

		} else {
			//Run the matching routes
			foreach ($this->_matchingRoutes as $route) {
				$route->run();
			}
		}

	}

	private function _findMatchingMethod($routes, $method) {
		foreach ($routes as $route) {
			if ( $route->methodMatches($method) )
				array_push($this->_matchingRoutes, $route);
		}
	}

	private function _findMatchingPattern($routes, $URI) {
		//Reset the matching pattern array
		$this->_matchingRoutes = array();
		foreach ($routes as $route) {
			if ($route->patternMatches($URI))
				array_push($this->_matchingRoutes, $route);
		}
	}

}