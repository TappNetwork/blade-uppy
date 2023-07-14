{{ $instanceName }}
    .on('files-added', (files) => {
        {{ $code }}
    });
