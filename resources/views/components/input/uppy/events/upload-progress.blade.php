{{ $instanceName }}
    .on('upload-progress', (file, progress) => {
        {{ $code }}
    });
