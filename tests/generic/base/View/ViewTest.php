<?php

namespace NicolaCostantino\LaravelCBV\Test\generic\base;

use Mockery;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;

use NicolaCostantino\LaravelCBV\generic\base\View;
use NicolaCostantino\LaravelCBV\Test\TestCase;

class ViewFunctionTest extends TestCase
{
    /**
     * Check that the View class contains static $http_method_names array property
     * @return void
     */
    public function testHasHttpMethodsNamesArrayProperty()
    {
        $view = new View();
        $this->assertObjectHasAttribute("http_method_names", $view);
        $this->assertTrue(is_array($view->http_method_names));
    }

    /**
     * Check that the View class constructor sets as properties the value passed
     * @return void
     */
    public function testHasPassedProperty()
    {
        $view = new View();
        $this->assertObjectHasAttribute("args", $view);
        $this->assertTrue(is_array($view->args));
    }

    /**
     * Check that the View class constructor sets all
     * the value passed as key => value, unpacking associative arrays
     * @return void
     */
    public function testKwargsHasPassedPropertyAtFirstLevel()
    {
        $arguments = [
            'a' => 'key',
            'b' => 'door',
            'tree',
            'ignoredkey' => [
                'goodkey',
                'anothergoodkey'
            ]
        ];
        
        $view = new View($arguments);

        $this->assertTrue(in_array('a', array_keys($view->kwargs)));
        $this->assertEquals($view->kwargs['a'], 'key');
        $this->assertTrue(in_array('b', array_keys($view->kwargs)));
        $this->assertEquals($view->kwargs['b'], 'door');
        $this->assertTrue(in_array('tree', $view->args));
        $this->assertFalse(in_array('ignoredkey', $view->args));
        $this->assertFalse(in_array('ignoredkey', array_keys($view->kwargs)));
    }

    /**
     * Check that the View class constructor sets as kwargs properties the value passed via GET
     * @return void
     */
    public function testAsViewMethodArgumentsAutoloadingOnGET()
    {
        $request = Request::create(
            '/foo/baz',
            'GET'
        );

        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', '/foo/{bar}', ['as' => 'foo.bar']);
            $route->bind($request);
            return $route;
        });

        $mock = Mockery::mock('NicolaCostantino\LaravelCBV\generic\base\View', [])->makePartial();
        $mock->shouldReceive('dispatch')->once();

        $response = $mock->as_view($request);

        $this->assertTrue(in_array('bar', array_keys($mock->kwargs)));
        $this->assertEquals($mock->kwargs['bar'], 'baz');
    }

    /**
     * Check that the View class constructor sets as kwargs properties the value passed via POST
     * @return void
     */
    public function testAsViewMethodArgumentsAutoloadingOnPOST()
    {
        $request = Request::create(
            '/foo/baz',
            'GET'
        );

        $request->setRouteResolver(function () use ($request) {
            $route = new Route('POST', '/foo/{bar}', ['as' => 'foo.bar']);
            $route->bind($request);
            return $route;
        });

        $mock = Mockery::mock('NicolaCostantino\LaravelCBV\generic\base\View', [])->makePartial();
        $mock->shouldReceive('dispatch')->once();

        $response = $mock->as_view($request);

        $this->assertTrue(in_array('bar', array_keys($mock->kwargs)));
        $this->assertEquals($mock->kwargs['bar'], 'baz');
    }

    /**
     * Check that the as_view methods calls the dispatch method
     * @return void
     */
    public function testAsViewMethodCallsDispatch()
    {
        $request = new Request();
        $request->setMethod('GET');

        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', '/foo', ['as' => 'foo']);
            $route->bind($request);
            return $route;
        });

        $mock = Mockery::mock('NicolaCostantino\LaravelCBV\generic\base\View', [])->makePartial();
        $mock->shouldReceive('dispatch')->once();

        $response = $mock->as_view($request);
    }    

    /**
     * Check that a get request ends to a call of the get method
     * @return void
     */
    public function testAsViewMethodCallsGetOnGetRequest()
    {
        $request = Request::create(
            '/foo/baz',
            'GET'
        );

        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', '/foo/{bar}', ['as' => 'foo.bar']);
            $route->bind($request);
            return $route;
        });

        $expected_args = [];
        $expected_kwargs = ['bar' => 'baz'];

        $mock = Mockery::mock(ViewWithGetMethod::class, [])->makePartial();
        $mock->shouldReceive('get')->with($request, $expected_args, $expected_kwargs)->once();

        $response = $mock->as_view($request);
    }

    public function testProtectedAllowedMethodsMethodOnView()
    {
        $testClass = new ExposeProtectedMethods;
        $methods = $testClass->public_allowed_methods();
        $expected = ['OPTIONS'];
        $this->assertEquals($methods, $expected);
    }

    public function testMethodNotAllowed()
    {
        $request = new Request();
        $request->setMethod('GET');

        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', '/foo', ['as' => 'foo']);
            $route->bind($request);
            return $route;
        });

        $mock = Mockery::mock(ViewWithoutExtraAllowedHTTPMethods::class, [])->makePartial();

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $response = $mock->as_view($request);
    }

    public function testOptionHTTPVerbForSampleViewWithoutExtraAllowedHTTPMethods()
    {
        $request = new Request();
        $request->setMethod('OPTIONS');

        $request->setRouteResolver(function () use ($request) {
            $route = new Route('OPTIONS', '/foo', ['as' => 'foo']);
            $route->bind($request);
            return $route;
        });

        $mock = Mockery::mock(ViewWithoutExtraAllowedHTTPMethods::class, [])->makePartial();

        $response = $mock->as_view($request);

        $this->assertTrue($response->headers->has("allow"));
        $this->assertTrue($response->headers->contains("allow", 'OPTIONS'));
        $this->assertTrue($response->headers->has("content-length"));
        $this->assertTrue($response->headers->contains("content-length", '0'));
    }
}