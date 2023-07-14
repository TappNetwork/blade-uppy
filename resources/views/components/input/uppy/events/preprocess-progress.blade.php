{{ $instanceName }}
    .on('preprocess-progress', (progress) => {
        {{ $code }}
    });
