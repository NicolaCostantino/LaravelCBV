<?php

namespace NicolaCostantino\LaravelCBV\Test\generic\base\View;

use Mockery;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;

use NicolaCostantino\LaravelCBV\Test\TestCase;

use NicolaCostantino\LaravelCBV\Test\generic\base\ContextTraitWrapper;

class ContextTraitTest extends TestCase
{
    /**
     * Check that get_context_data() returns an array containing the 'view'
     * element with the View instance (default)
     */
    public function testGetContextDataWithNoExtraContextValues()
    {
        $sut = new ContextTraitWrapper();
        $result = $sut->get_context_data();
        $this->assertEquals($result['view'], $sut);
    }

    /**
     * Check that get_context_data() returns values in extra_content field
     */
    public function testGetContextDataWithExtraContextValues()
    {
        $extra_content = [
            'foo' => 'bar',
        ];
        $sut = new ContextTraitWrapper($extra_content);
        $result = $sut->get_context_data();
        $this->assertTrue(!array_diff(array_keys($extra_content), array_keys($result)));
    }
}