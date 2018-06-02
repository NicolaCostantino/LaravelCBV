<?php

namespace NicolaCostantino\LaravelCBV\generic\base;

use Illuminate\Http\Request;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class View extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public $http_method_names = ['get', 'post', 'put', 'patch', 'delete', 'head', 'options', 'trace'];

    /* Middleware: used for emulating the *args, **kwargs behavior */
    protected function autoload_kwargs_arguments() {
        $arguments = func_get_args();

        $flatten = function ($array) use ( &$flatten ) {
            $result = [];

            foreach($array as $key => $value) {
                if(is_array($value)) {
                    $result = array_merge($result, $flatten($value));
                } else if(is_int($key)) {
                    $result[] = $value;
                } else {
                    $result[$key] = $value;
                }
            }

            return $result;
        };

        $flattened_arguments = $flatten($arguments);

        foreach($flattened_arguments as $key => $value) {
            if(is_int($key)) {
                $this->args[] = $value;
            } else {
                $this->kwargs[$key] = $value;
            }
        }
    }

    protected function _allowed_methods()
    {
        $allowedMethodsMappedArray = array_map(function($value) {if(method_exists($this, $value)) return strtoupper($value);}, $this->http_method_names);
        // Re-index the elements of the array with array_values
        $allowedMethodsArray = array_values(array_filter($allowedMethodsMappedArray, function($value){return !is_null($value);}));
        return $allowedMethodsArray;
    }

    public function __construct()
    {
        $this->args = [];
        $this->kwargs = [];
        
        $arguments = func_get_args();
        $this->autoload_kwargs_arguments($arguments);
    }

    public function as_view(Request $request) {
        $this->autoload_kwargs_arguments($request->route()->parameters());
        // Store the request as property (so that will be accessible to ohter methods)
        $this->request = $request;

        // Call the dispatch method
        return $this->dispatch($request, $this->args, $this->kwargs);
    }

    public function dispatch(Request $request, Array $args, Array $kwargs) {
        $received_request_method = strtolower($request->method());

        if(in_array($received_request_method, $this->http_method_names)) {
            $handler = new \ReflectionMethod(get_class($this), $received_request_method);
        } else {
            $handler = new \ReflectionMethod(get_class($this), 'http_method_not_allowed');
        }

        return $handler->invoke($this, $request, $args, $kwargs);
    }

    public function http_method_not_allowed(Request $request, Array $args, Array $kwargs) {
        // TODO: Add logging for Method Not Allowed
        abort(405, implode(", ", $this->_allowed_methods()));
    } // @codeCoverageIgnore

    public function options(Request $request, Array $args, Array $kwargs)
    {
        // Handle responding to requests for the OPTIONS HTTP verb.
        return response('')
                ->withHeaders([
                    'Allow' => implode(", ", $this->_allowed_methods()),
                    'Content-Length' => '0',
                ]);
    }
}
