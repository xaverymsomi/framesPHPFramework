<?php


declare(strict_types=1);

namespace Router;

interface RouterInterface {
   /**
    *simple add a route to the routing table
    *
    *@param string $route
    *@param array $params
    *@return void
    */
   public function add(string $route, array $params) : void;

   /**
    *Dispatch route and create controller object and execute the default method on controller
    *
    * @param string $url
    * @return void
    */

   public function dispatch(string $url) : void;
}