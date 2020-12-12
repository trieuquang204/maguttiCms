<?php


namespace App\maguttiCms\Admin\Helpers;


use Illuminate\Support\Str;

/**
 * Trait AdminFormContext
 * @package App\maguttiCms\Admin\Helpers
 */
trait AdminFormContext
{
    protected $context = null;

    public function context($context)
    {
        $this->context = $context;
        return $this;
    }

    function handleContext($key, $property)
    {
        if (Str::startsWith($key, 'seo') == $this->showSeo && data_get($property, 'context', null) == $this->context) {
            return true;
        }
    }
}