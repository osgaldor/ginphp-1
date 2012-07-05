<?php
class Router {

    var $routes = array();

    function __construct($auth = false) {
        $this->auth = $auth;
    }

    function replace($req_uri, $routeArray) {
        return $routeArray[$req_uri];
    }

    function parse($uri) {

        if (ends_with($uri, '/')) $uri = substr($uri, 0, -1); // gets rid of trailing slash
        if ($uri == "") {
            return new Route("", "DefaultController", "index", array());
        }

        $segments = explode('/', $uri);
        $subdir = "";
        $class = "";
        $method = "";

        // check to see if a subdirectory in controllers
        if (!empty($segments[0])) {
            if (is_dir(WEB_ROOT . '/app/controllers/' . $segments[0])) {
                $subdir = $segments[0];
                if (count($segments) > 1) {
                    $segments = array_slice($segments, 1);
                }
            }
        }

        $controller = ucfirst($segments[0] . 'Controller');

        if ($subdir == "") {
            $classFile = WEB_ROOT . '/app/controllers/' . $controller . EXT;
        } else {
            $classFile = WEB_ROOT . '/app/controllers/' . $subdir . '/' . $controller . EXT;
        }

        // check to see if in default
        if ($segments[0] != "" && file_exists($classFile)) {
            $class = $segments[0];
            $segments = array_slice($segments, 1);
        } else {
            $class = "default";
        }

        // since greater than 1
        if (count($segments) > 0) {
            $method = $segments[0];
            // now remaining are arguments
            $segments = array_slice($segments, 1);
        } else {
            // will never be arguments
            $method = "index";
            $segments = array();
        }
        $controller = ucfirst($class . 'Controller');
        return new Route($subdir, $controller, $method, $segments);
    }

}

class Route {
    var $subdir;
    var $controller;
    var $method;
    var $arguments;

    function __construct($subdir, $controller, $method, $arguments) {
        $this->subdir = $subdir;
        $this->controller = $controller;
        $this->method = $method;
        $this->arguments = $arguments;
    }
}
