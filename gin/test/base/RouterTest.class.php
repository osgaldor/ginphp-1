<?php
include_once ("../../../phpheader.inc.php");

class BaseRouterTest {

    public function test() {
        // using default since can't instanciate abstract
        $router = new Router();
        $route1 = $router->parse("");
        assertValue("1 - assert controller", "DefaultController", $route1->controller);
        assertValue("1 - assert subdir", "",$route1->subdir);
        assertValue("1 - assert method", "index", $route1->method);
        assertValue("1 - assert arguments", 0, count($route1->arguments));

        $route2 = $router->parse("");
        assertValue("2 - assert controller", "DefaultController", $route2->controller);
        assertValue("2 - assert subdir", "",$route2->subdir);
        assertValue("2 - assert method", "index", $route2->method);
        assertValue("2 - assert arguments", 0, count($route2->arguments));

        $route2b = $router->parse("foo");
        assertValue("2b - assert controller", "DefaultController", $route2b->controller);
        assertValue("2b - assert subdir", "",$route2->subdir);
        assertValue("2b - assert method", "foo", $route2b->method);
        assertValue("2b - assert arguments", 0, count($route2b->arguments));

        $route3 = $router->parse("hello");
        assertValue("3 - assert controller", "HelloController", $route3->controller);
        assertValue("3 - assert subdir", "",$route3->subdir);
        assertValue("3 - assert method", "index", $route3->method);
        assertValue("3 - assert arguments", 0, count($route3->arguments));

        $route4 = $router->parse("hello/add");
        assertValue("4 - assert controller", "HelloController", $route4->controller);
        assertValue("4 - assert subdir", "",$route4->subdir);
        assertValue("4 - assert method", "add", $route4->method);
        assertValue("4 - assert arguments", 0, count($route4->arguments));

        $route5 = $router->parse("hello/edit/1");
        assertValue("5 - assert controller", "HelloController", $route5->controller);
        assertValue("5 - assert subdir", "",$route5->subdir);
        assertValue("5 - assert method", "edit", $route5->method);
        assertValue("5 - assert arguments", 1, count($route5->arguments));

        $route6 = $router->parse("hello/something/1/2/3");
        assertValue("6 - assert controller", "HelloController", $route6->controller);
        assertValue("6 - assert subdir", "",$route6->subdir);
        assertValue("6 - assert method", "something", $route6->method);
        assertValue("6 - assert arguments", 3, count($route6->arguments));

        $route7 = $router->parse("admin/sample/1");
        assertValue("7 - assert controller", "DefaultController", $route7->controller);
        assertValue("7 - assert subdir", "admin",$route7->subdir);
        assertValue("7 - assert method", "sample", $route7->method);
        assertValue("7 - assert arguments", 1, count($route7->arguments));

        $routeArray = array();
        $routeArray['newurl/something'] = 'somecontroller/method';
        $routeArray['newurl/something2'] = 'hello/edit/1';
        assertValue("testing router replacement 1","somecontroller/method",$router->replace('newurl/something',$routeArray));
        assertValue("testing router replacement 2","",$router->replace('/not-real',$routeArray));

        $route8 = $router->parse($router->replace('newurl/something2',$routeArray));
        assertValue("8 - assert controller", "HelloController", $route8->controller);
        assertValue("8 - assert subdir", "",$route8->subdir);
        assertValue("8 - assert method", "edit", $route8->method);
        assertValue("8 - assert arguments", 1, count($route8->arguments));

    }
}

$routertest = new BaseRouterTest();
$routertest->test();