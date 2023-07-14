{{ $instanceName }}
    .on('file-added', (file) => {
        {{ $code }}
    });
