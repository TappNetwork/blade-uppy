<?php

declare(strict_types=1);

it('can render the component', function() {
    $view = $this->blade(
        '<x-input.uppy.s3-multipart
            uiOptions="{ inline: true, target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.s3-multipart>'
    );

    $view->assertSee('uppyUpload.use(Dashboard');
    $view->assertSee('.use(AwsS3Multipart');
});

it('can pass ui and ui options to component', function() {
    $view = $this->blade(
        '<x-input.uppy.s3-multipart
            ui="drag-drop"
            uiOptions="{ inline: true, target: \'#uppy-drag-drop\'}"
        >
            <div id="uppy-drag-drop">
            </div>
        </x-input.uppy.s3-multipart>'
    );

    $view->assertSee('uppyUpload.use(DragDrop, { inline: true, target:');
});

it('can pass the uppy instance name to component', function() {
    $view = $this->blade(
        '<x-input.uppy.s3-multipart
            instanceName="testinstance"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.s3-multipart>'
    );

    $view->assertSee('testinstance.use(Dashboard,');
});

it('can pass core options to component', function() {
    $view = $this->blade(
        '<x-input.uppy.s3-multipart
            coreOptions="{ debug: true }"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.s3-multipart>'
    );

    $view->assertSee('const uppyUpload = new Uppy({ debug: true });');
});

it('can pass uploader options to component', function() {
    $view = $this->blade(
        '<x-input.uppy.s3-multipart
            uploaderOptions="{ id: s3multiparttest, limit: 10 }"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.s3-multipart>'
    );

    $view->assertSee('.use(AwsS3Multipart, { id: s3multiparttest, limit: 10 });');
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

        <x-input.uppy.s3-multipart
            :events="$events"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.s3-multipart>'
    );

    $view->assertSee('console.log(file);');
});

it('can pass plugins to component', function() {
    $view = $this->blade(
        '@php
        $plugins = [
            "ThumbnailGenerator" => "{ thumbnailWidth: 300, ThumbnailHeight: 300 }",
        ];
        @endphp

        <x-input.uppy.s3-multipart
            :plugins="$plugins"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.s3-multipart>'
    );

    $view->assertSee('uppyUpload.use(ThumbnailGenerator, { thumbnailWidth: 300, ThumbnailHeight: 300 });');
});

it('can pass extra javascript code to component', function() {
    $view = $this->blade(
        '<x-input.uppy.s3-multipart
            extraJs="console.log(\'Hello\')"
            uiOptions="{ target: \'#uppy-dashboard\'}"
        >
            <div id="uppy-dashboard">
            </div>
        </x-input.uppy.s3-multipart>'
    );

    $view->assertSee("console.log");
});
