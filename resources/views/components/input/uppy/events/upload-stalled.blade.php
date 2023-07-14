{{ $instanceName }}
    .on('upload-stalled', (error, files) => {
        {{ $code }}
    });
