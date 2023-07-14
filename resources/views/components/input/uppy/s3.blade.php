@aware([
    'instanceName' => 'uppyUpload',
    'uploaderOptions' => "{
            companionUrl: '/',
            companionHeaders:
            {
                'X-CSRF-TOKEN': window.csrfToken,
            },
        }",
])

<x-input.uppy {{ $attributes }} >
    <x-slot:s3>
        {{ $instanceName }}
          .use(AwsS3, {{ $uploaderOptions }});
    </x-slot>

    {{ $slot }}
</x-input.uppy>
