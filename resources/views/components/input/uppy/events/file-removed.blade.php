{{ $instanceName }}
    .on('file-removed', (file, reason) => {
        {{ $code }}
    });
