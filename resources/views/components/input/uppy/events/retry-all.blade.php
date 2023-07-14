{{ $instanceName }}
    .on('retry-all', (fileIDs) => {
        {{ $code }}
    });
