<?php

namespace NicolaCostantino\LaravelCBV\Test\generic\base;

use Illuminate\Http\Request;

use NicolaCostantino\LaravelCBV\generic\base\View;
use NicolaCostantino\LaravelCBV\generic\base\ContextTrait;

class ViewWithGetMethod extends View
{
    public function get(Request $request, Array $args, Array $kwargs) {
        return;
    }
}

class ViewWithoutExtraAllowedHTTPMethods extends View
{
    // Only the option method defined in the base View
    public $http_method_names = ['options'];
}

class ContextTraitWrapper {
    use ContextTrait;

    public function __construct(Array $extra_context=Null) {
        if ($extra_context) {
            $this->extra_context = $extra_context;
        }
    }
}