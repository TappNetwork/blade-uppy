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
    <x-slot:s3-multipart>
        {{ $instanceName }}
          .use(AwsS3Multipart, {{ $uploaderOptions }});
    </x-slot>

    {{ $slot }}
</x-input.uppy>
