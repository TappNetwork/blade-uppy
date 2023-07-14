@aware([
    'instanceName' => 'uppyUpload',
    'uploaderOptions' => "{
            endpoint: '/',
        }",
])

<x-input.uppy {{ $attributes }} >
    <x-slot:tus>
        {{ $instanceName }}
          .use(Tus, {{ $uploaderOptions }});
    </x-slot>

    {{ $slot }}
</x-input.uppy>
