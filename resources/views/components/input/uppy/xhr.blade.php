@aware([
    'instanceName' => 'uppyUpload',
    'uploaderOptions' => "{
            endpoint: '/',
        }",
])

<x-input.uppy {{ $attributes }} >
    <x-slot:xhr>
        {{ $instanceName }}
          .use(XHR, {{ $uploaderOptions }});
    </x-slot>

    {{ $slot }}
</x-input.uppy>
