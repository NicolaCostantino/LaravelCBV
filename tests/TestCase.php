<?php

namespace NicolaCostantino\LaravelCBV\Test;

use NicolaCostantino\LaravelCBV\CBVServiceProvider;
use Orchestra\Testbench\BrowserKit\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return NicolaCostantino\LaravelCBV\CBVServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [CBVServiceProvider::class];
    }
}