<?php

declare(strict_types=1);

it('can render the component', function() {
    $view = $this->blade(
        '<x-input.uppy.transloadit
            uiOptions="{ inline: true, target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.transloadit>'
    );

    $view->assertSee('uppyUpload.use(Dashboard');
    $view->assertSee('.use(Transloadit,');
});

it('can pass ui and ui options to component', function() {
    $view = $this->blade(
        '<x-input.uppy.transloadit
            ui="drag-drop"
            uiOptions="{ inline: true, target: \'#uppy-drag-drop\'}"
        >
            <div id="uppy-drag-drop">
            </div>
        </x-input.uppy.transloadit>'
    );

    $view->assertSee('uppyUpload.use(DragDrop, { inline: true, target:');
});

it('can pass the uppy instance name to component', function() {
    $view = $this->blade(
        '<x-input.uppy.transloadit
            instanceName="testinstance"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.transloadit>'
    );

    $view->assertSee('testinstance.use(Dashboard,');
});

it('can pass core options to component', function() {
    $view = $this->blade(
        '<x-input.uppy.transloadit
            coreOptions="{ debug: true }"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.transloadit>'
    );

    $view->assertSee('const uppyUpload = new Uppy({ debug: true });');
});

it('can pass uploader options to component', function() {
    $view = $this->blade(
        '<x-input.uppy.transloadit
            uploaderOptions="{ id: transloadittest, limit: 10, waitForEncoding: true}"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.transloadit>'
    );

    $view->assertSee('.use(Transloadit, { id: transloadittest, limit: 10, waitForEncoding: true');
});

it('can pass events to component', function() {
    $view = $this->blade(
        '@php
        $events = [
            "file-added" => "
                console.log(file);
            ",
        ];
        @endphp

        <x-input.uppy.transloadit
            :events="$events"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.transloadit>'
    );

    $view->assertSee('console.log(file);');
});

it('can pass plugins to component', function() {
    $view = $this->blade(
        '@php
        $plugins = [
            "Compressor" => "{ quality: 0.6 }",
        ];
        @endphp

        <x-input.uppy.transloadit
            :plugins="$plugins"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.transloadit>'
    );

    $view->assertSee('uppyUpload.use(Compressor, { quality: 0.6 });');
});

it('can pass extra javascript code to component', function() {
    $view = $this->blade(
        '<x-input.uppy.transloadit
            extraJs="console.log(\'Hello\')"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.transloadit>'
    );

    $view->assertSee("console.log");
});
