<?php

namespace NicolaCostantino\LaravelCBV\Test\generic\base;

use NicolaCostantino\LaravelCBV\generic\base\View;

class ExposeProtectedMethods extends View
{
    public function public_allowed_methods()
    {
        return $this->_allowed_methods();
    }
}
