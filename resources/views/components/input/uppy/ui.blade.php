@aware([
    'instanceName' => 'uppyUpload',
    'uiOptions' => '{}',
    'ui' => '',
])

{{ $instanceName }}.use({{ Str::of($ui)->camel()->ucfirst() }}, {{ $uiOptions }});
