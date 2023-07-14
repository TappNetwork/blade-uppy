{{ $instanceName }}
    .on('thumbnail:generated', (file, preview) => {
        {{ $code }}
    });
