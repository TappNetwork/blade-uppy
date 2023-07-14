<?php

namespace Tapp\BladeUppy;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class BladeUppyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-uppy.php', 'blade-uppy');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'blade-uppy');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/blade-uppy.php' => $this->app->configPath('blade-uppy.php'),
            ], 'blade-uppy-config');

            $this->publishes([
                __DIR__.'/../resources/views' => $this->app->resourcePath('views/vendor/blade-uppy'),
            ], 'blade-uppy-views');
        }

        $this->bootBladeComponents();
    }

    private function bootBladeComponents(): void
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $this->registerComponent('input.uppy.index', 'input.uppy');
            $this->registerComponent('input.uppy.ui');
            $this->registerComponent('input.uppy.plugin');
            $this->registerComponent('input.uppy.s3-multipart');
            $this->registerComponent('input.uppy.s3');
            $this->registerComponent('input.uppy.xhr');
            $this->registerComponent('input.uppy.tus');
            $this->registerComponent('input.uppy.transloadit');

            /** @var BladeComponent $component */
            foreach (config('blade-uppy.events', []) as $component) {
                $blade->component('blade-uppy::components.input.uppy.events.'.$component, 'input.uppy.events.'.$component);
            }
        });
    }

    protected function registerComponent(string $component, string $alias = null): void
    {
        if ($alias === null) {
            $alias = $component;
        }

        Blade::component('blade-uppy::components.'.$component, $alias);
    }
}
