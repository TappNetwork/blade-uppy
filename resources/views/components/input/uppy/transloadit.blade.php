@aware([
    'instanceName' => 'uppyUpload',
    'uploaderOptions' => "{}",
])

<x-input.uppy {{ $attributes }} >
    <x-slot:transloadit>
        {{ $instanceName }}
          .use(Transloadit, {{ $uploaderOptions }});
    </x-slot>

    {{ $slot }}
</x-input.uppy>
