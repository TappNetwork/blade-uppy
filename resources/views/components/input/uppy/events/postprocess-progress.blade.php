{{ $instanceName }}
    .on('postprocess-progress', (progress) => {
        {{ $code }}
    });
