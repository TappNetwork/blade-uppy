@aware([
    'instanceName' => 'uppyUpload',
    'uiOptions' => '{}',
    'ui' => 'dashboard',
])

{{ $instanceName }}.use({{ Str::of($ui)->camel()->ucfirst() }}, {{ $uiOptions }});
