<?php

declare(strict_types=1);

namespace Router;

use Exception;
use Router\RouterInterface;

class Router implements RouterInterface{

	/**
	 * return an array of route from our routing table
	 * @var array
	 */
	protected  array $routes = [];

	/**
	 * return an array of route parameters
	 * @var array
	 */
	protected  array $params = [];

	/**
	 * Adds a suffix onto the controller name
	 * @var string
	 */
	protected  string $controllerSuffix = '';

	/**
	 * @inheritDoc
	 */
	public function add(string $route, array $params) : void
	{
		// TODO: Implement add() method.
		$this->routes[$route] = $params;
	}

	/**
	 * @inheritDoc
	 * @throws Exception
	 */
	public function dispatch(string $url) : void
	{
		// TODO: Implement dispatch() method.
		if($this->match($url)) {
			$controller = $this->params['controller'];
			$controller = $this->transformUpperCamelCase($controller);
			$controller =  $this->getNamespace($controller);

			if(class_exists($controller)) {
				$controller = new $controller();
				$action = $this->params['action'];
				$action = $this->transformCamelCase($action);

				if(is_callable([$controller, $action])) {
					$controller->$action();
				} else {
					throw new Exception();
				}
			} else {
				throw new Exception();
			}
		} else {
			throw new Exception();
		}
	}

	public function transformUpperCamelCase(string $string) : string {
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
	}

	public function transformCamelCase(string $string) : string {
		return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $string))));
	}

	/**
	 * Match the route to the routes into routing table, setting the $this->params property
	 * if a route is found
	 *
	 * @param  string $url
	 * @return bool
	 */
	private function match(string $url) : bool
	{
		foreach ($this->routes as $route => $params) {
			if (preg_match($route, $url, $matches)) {
				foreach ($matches as $key => $param) {
					if(is_string($key)){
						$params[$key] = $param;
					}
				}
				$this->params = $params;
				return true;
			}
		}
		return false;
	}

   /**
    * Get the namespace for the controller class, the namespace defined within the route parameter
    * only if it was added
    *
    * @param  string $string
    *
    * @return string
    */
	private function getNamespace(string $string) : string
	{
		$namespace = 'App\\Controllers\\';
		if(array_key_exists('namespace', $this->params)) {
			$namespace .= $this->params['namespace'] . '\\';
		}
		return $namespace;
	}
}