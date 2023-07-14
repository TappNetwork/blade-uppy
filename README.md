# Uppy blade

This package adds Blade components for [Uppy](https://uppy.io/docs) to use in your Laravel Blade views.

## Installation

### Install the package via Composer

```bash
composer require tapp/blade-uppy
```

### Add required JS libraries

Add in your `package.json` file the AlpineJS library and all the Uppy libraries you need (or install them directly according to the Uppy site doc):

```
...
"devDependencies": {
    "alpinejs": "^3.11.1",
    ...
    },
    "dependencies": {
    "@uppy/aws-s3-multipart": "^3.1.2",
    "@uppy/core": "^3.0.5",
    "@uppy/drag-drop": "^3.0.1",
    "@uppy/status-bar": "^3.0.1"
    ...
}
...
```

Add the Uppy libraries in your `resources/js/bootstrap.js` file:

```javascript
...

require('@uppy/core/dist/style.min.css')
require('@uppy/drag-drop/dist/style.min.css')
require('@uppy/status-bar/dist/style.min.css')

import Uppy from '@uppy/core'
import DragDrop from '@uppy/drag-drop'
import StatusBar from '@uppy/status-bar'
import AwsS3Multipart from '@uppy/aws-s3-multipart'

window.Uppy = Uppy
window.DragDrop = DragDrop
window.StatusBar = StatusBar
window.AwsS3Multipart = AwsS3Multipart
```

Add in your `resources/js/app.js`:

```javascript
...
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
```

Install the JS libraries:

using Mix:
```
npm install
npm run dev
```

using Vite:
```
npm install
npm run build
```

> You can use CDNs for [Uppy](https://uppy.io/docs/#With-a-script-tag) and [AlpineJS](https://github.com/alpinejs/alpine), if you prefer.

### Publish config file (optional)

Publish the config file with:
```bash
php artisan vendor:publish --tag=blade-uppy-config
```

The published config file contains the Uppy events that are loaded as components:

```php
return [
    'events' => [
        'cancel-all',
        'complete',
        'dashboard-file-edit-complete',
        'dashboard-file-edit-start',
        'dashboard-modal-closed',
        'dashboard-modal-open',
        'error',
        'file-added',
        'file-editor-cancel',
        'file-editor-complete',
        'file-editor-start',
        'file-removed',
        'files-added',
        'info-hidden',
        'info-visible',
        'postprocess-progress',
        'preprocces-progress',
        'progress',
        'reset-progress',
        'restriction-failed',
        'retry-all',
        'thumbnail-generated',
        'upload-error',
        'upload-progress',
        'upload-retry',
        'upload-stalled',
        'upload-success',
        'upload',
    ],
];
```

### Publish view files (optional)

```bash
php artisan vendor:publish --tag=blade-uppy-views
```

## Usage

Uppy uploaders are available as Blade components:

- AWS S3 `<x-input.uppy.s3>`
- AWS S3 Multipart `<x-input.uppy.s3-multipart>`
- XHR `<x-input.uppy.xhr>`
- Tus `<x-input.uppy.tus>`
- Transloadit `<x-input.uppy.transloadit>`

This is the component skeleton (using the `s3` blade component as an example, but it's the same for `s3-multipart`, `xhr`, `tus`, and `transloadit`):

```html
<x-input.uppy.s3
    attribute="attribute value"
    ...
>

    <!-- here in the component body, you can define the HTML to be used -->

</x-input.uppy.s3>
```

The UI that should be used (`dashboard` or `drag-drop`) can be defined with the `ui` attribute and UI options with `uiOptions` attribute:
```html
<x-input.uppy.s3
    ui="drag-drop"
    uiOptions="{ target: '.upload' }"
    ...
>
```

Any plugin can be added using the `plugins` array attribute, where the key is the plugin name and the value is the plugin options:
```html
@php
    $plugins = [
        'StatusBar' => "{ target: '.upload', hideAfterFinish: false }",
    ];
@endphp

<x-input.uppy.s3
    :plugins="$plugins"
    ...
>
```

Add any event using the `events` array attribute, where the key is the event name and the value is the event code:
```html
@php
    $plugins = [
        'StatusBar' => "{ target: '.upload', hideAfterFinish: false }",
    ];
@endphp

<x-input.uppy.s3
    :events="$events"
    ...
>
```

If you need to add extra JS code, use the `extraJs` attribute:

```html
<x-input.uppy.s3
    extraJs="your JS code here"
    ...
>
```

## Uploaders

### S3

Add the `input.uppy.s3` blade component to your blade view:

```html
<x-input.uppy.s3
    ui="dashboard"
    uiOptions="{ inline: true, target: '#uppy-dashboard'}"
>

    <div id="uppy-dashboard">
    </div>

</x-input.uppy.s3>
```

### S3 Multipart

Add the `input.uppy.s3-multipart` blade component to your blade view. 
E.g. using the Dashboard UI:

```html
<x-input.uppy.s3-multipart
    uiOptions="{ inline: true, target: '#uppy-dashboard'}"
    audio="{ target: Dashboard }"
    instanceName="file"
>

    <div id="uppy-dashboard">
    </div>

</x-input.uppy.s3-multipart>
```

### XHR

Add the `input.uppy.xhr` blade component to your blade view.
E.g. using the Drag and Drop UI:

```html
@php
$events = [
    'upload-success' => "
        const url = response.uploadURL;
        const fileName = file.name;
        const aleatorio = 1;

        const uploadedFileData = JSON.stringify(response.body);

        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = url;
        a.target = '_blank';
        a.appendChild(document.createTextNode(fileName));
        li.appendChild(a);

        document.querySelector('.upload .uploaded-files ol').appendChild(li);

        var inputElementUrlUploadFile = document.getElementById('file2');
        inputElementUrlUploadFile.value = url;
        inputElementUrlUploadFile.dispatchEvent(new Event('input'));
    ",
];

$plugins = [
    'StatusBar' => "{ target: '.upload .for-ProgressBar', hideAfterFinish: false }",
];
@endphp

<div class="flex items-center">
    <input type="hidden" name="file" id="file" />

    <x-input.uppy.xhr
        ui="drag-drop"
        uiOptions="{ target: '.upload .for-ProgressBar' }"
        :events="$events"
        :plugins="$plugins"
    >

        <section class="upload">
            <div class="for-DragDrop" x-ref="input"></div>

            <div class="for-ProgressBar"></div>

            <div id="progress-bar"></div>

            <div class="uploaded-files">
                <h5>{{ __('Uploaded file:') }}</h5>
                <ol></ol>
            </div>
        </section>

    </x-input.uppy.xhr>
</div>
```

### Tus

Add the `input.uppy.tus` blade component to your blade view:

```html
<x-input.uppy.tus
    uiOptions="{ inline: true, target: '#uppy-dashboard'}"
>

    <div id="uppy-dashboard">
    </div>

</x-input.uppy.tus>
```

### Transloadit

Add the `input.uppy.transloadit` blade component to your blade view:

```html
<x-input.uppy.transloadit
    uiOptions="{ inline: true, target: '#uppy-dashboard'}"
>

    <div id="uppy-dashboard">
    </div>

</x-input.uppy.transloadit>
```

## Available attributes for each component:

| Attribute | Description | Default value |
| --- | --- | --- |
| instanceName | Uppy instance name | uppyUpload |
| coreOptions | Core Uppy instance options | {} |
| uploaderOptions | Options used by uploader | {} |
| ui | UI for upload (dashboard or drag-drop) | dashboard |
| uiOptions | Options that should be passed to the UI | {} |
| :events | PHP array with the Uppy events (keys are event names, values are event code) | [] |
| :plugins | PHP array with the Uppy plugins (keys are plugin name, values are plugin options) | [] |
| extraJs | Extra JS code | '' |

### Uppy instance name

Use the `instanceName` attribute to define the Uppy instance name.

Default: `uppyUpload`

### Core Options

Core Uppy options are defined with the `coreOptions` attribute.

Default:
```javascript
{
    debug: true,
    autoProceed: true,
    allowMultipleUploads: false,
}
```

### Uploader Options

Can be defined using `uploaderOptions` attribute.

Default:
```javascript
{
    companionUrl: '/',
    companionHeaders:
    {
        'X-CSRF-TOKEN': window.csrfToken,
    },
}
```

### User Interface

#### ui attribute

Define the User Interface (UI) that should be used (Dashboard or Drag&Drop).
Possible values:

- dashboard
- drag-drop

E.g.:
```html
ui="dashboard"
```

Default: `dashboard`

#### uiOptions attribute

You may pass the Uppy UI JS options via `uiOptions` attribute.

- [Dashboard options](https://uppy.io/docs/dashboard/#options)
- [Drag & Drop options](https://uppy.io/docs/drag-drop/#options)

E.g.:

```html
uiOptions="{ target: '.upload .for-ProgressBar' }"
```

Default: `{}`

Docs:
- https://uppy.io/docs/dashboard
- https://uppy.io/docs/drag-drop

**Dashboard example:**

```html
@php
    $plugins = [
        'Audio' => "{ target: Dashboard }",
    ];
@endphp

<x-input.uppy.s3-multipart
    ui="dashboard"
    uiOptions="{ inline: true, target: '#uppy-dashboard'}"
    instanceName="file"
    :plugins="$plugins"
>

    <div id="uppy-dashboard">
    </div>

</x-input.uppy.s3-multipart>
```

**Drag & Drop example:**

```html
@php
    $plugins = [
        'StatusBar' => "{ target: '.upload .for-ProgressBar', hideAfterFinish: false }",
    ];
@endphp

<x-input.uppy.s3
    ui="drag-drop"
    coreOptions="{
        debug: true,
        autoProceed: true,
        allowMultipleUploads: false,
    }"
    uiOptions="{ target: '.upload .for-ProgressBar' }"
    :plugins="$plugins"
>

    <section class="upload">
        <div class="for-DragDrop" x-ref="input"></div>

        <div class="for-ProgressBar"></div>

        <div class="uploaded-files">
            <h5>{{ __('Uploaded file:') }}</h5>
            <ol></ol>
        </div>
    </section>

</x-input.uppy.s3>
```

### Plugins

#### User Interface Elements

UI elements can be added using the `plugins` attribute associative array, where the key should be the same name as the UI element (E.g. the key for `Status Bar` element is `StatusBar`) and the value is the JS options to be passed to the UI element.

UI elements Plugins:
- StatusBar
- ProgressBar
- DropTarget
- Informer
- ImageEditor
- ThumbnailGenerator

E.g.:

```php
@php
    $plugins = [
        'StatusBar' => "{ target: '.upload .for-ProgressBar', hideAfterFinish: false }",
    ];
@endphp

<x-input.uppy.s3-multipart
    ...
    :plugins="$plugins"
>
    ...
```

#### Sources

Define the sources to be used for upload using the `plugins` associative array attribute.

Source Plugins:
- Webcam
- Audio
- ScreenCapture

E.g.:
```php
@php
    $plugins = [
        'Audio' => "{  target: '#dashboard' }",
    ];
@endphp

<x-input.uppy.s3-multipart
    ...
    :plugins="$plugins"
>
    ...
```

#### Misc

Another misc plugins can be added using the component's `plugins` associative array attribute.

Misc Plugins:
- Golden Retriever
- Compressor
- Locales
- Form

For example to use the `GoldenRetriever` (`uppy.use(GoldenRetriever, { serviceWorker: false })`) and `Compressor` (`uppy.use(Compressor, { quality: 0.6 })`) plugins:

```php
@php
$plugins = [
    'GoldenRetriever' => "{ serviceWorker: false }",
    'Compressor' => "{ quality: 0.6 }",
];
@endphp

<x-input.uppy.s3-multipart
    ...
    :plugins="$plugins"
>
    ...
</x-input.uppy.s3-multipart>
```

### Events

Define the events as a PHP associative array (key is the event name and value is the JS content of the event) passed to `events` attribute:

```php
@php
$events = [
    'upload-success' => "
        const url = response.uploadURL;
        const fileName = file.name;
        const aleatorio = 1;

        const uploadedFileData = JSON.stringify(response.body);

        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = url;
        a.target = '_blank';
        a.appendChild(document.createTextNode(fileName));
        li.appendChild(a);

        document.querySelector('.upload .uploaded-files ol').appendChild(li);

        var inputElementUrlUploadFile = document.getElementById('file2');
        inputElementUrlUploadFile.value = url;
        inputElementUrlUploadFile.dispatchEvent(new Event('input'));
    ",
];
@endphp

<x-input.uppy.s3
    ...
    :events="$events"
>
    ...
</x-input.uppy.s3>
```

### Adding extra JS code

You can add some extra JS code using `extraJs` attribute.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover any security-related issues, please email security@tappnetwork.com.

## Credits

- [Tapp Network](https://github.com/TappNetwork)
- [All Contributors](../../contributors)

### Libraries used in this package:

- [Uppy](https://uppy.io)
- [AlpineJS](https://github.com/alpinejs/alpine)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
