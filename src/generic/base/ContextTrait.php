<?php

namespace NicolaCostantino\LaravelCBV\generic\base;

trait ContextTrait {
    /**
	 * A default context mixin that passes the keyword arguments
     * received by get_context_data() as the template context.
	 */

    public $extra_context = Null;

    public function get_context_data(Array $args=[], Array $kwargs=[]) {
        array_setdefault($kwargs, 'view', $this);
        if ($this->extra_context != Null) {
            $kwargs = array_update($kwargs, $this->extra_context);
        }
        return $kwargs;
    }
}