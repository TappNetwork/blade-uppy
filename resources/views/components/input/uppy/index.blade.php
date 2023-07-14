@props([
    'ui' => 'dashboard',
    'uiOptions' => '{}',
    'uploaderOptions' => '{}',
    'instanceName' => 'uppyUpload',
    'extraJs' => '',
    'coreOptions' => '{
                debug: true,
                autoProceed: true,
                allowMultipleUploads: false,
            }',
    'events',
    'plugins' => [],
])

<div
    {{ $attributes }}
    x-data="{
        initUppy: function (element) {
            const {{ $instanceName }} = new Uppy({{ $coreOptions }});

            @isset($s3)
            {{ $s3 }}
            @endisset

            @isset($s3Multipart)
            {{ $s3Multipart }}
            @endisset

            @isset($xhr)
            {{ $xhr }}
            @endisset

            @isset($tus)
            {{ $tus }}
            @endisset

            @isset($transloadit)
            {{ $transloadit }}
            @endisset

            <x-dynamic-component
                component="input.uppy.ui"
            />

            @foreach($plugins as $pluginName => $pluginOptions)
                <x-dynamic-component
                    component="input.uppy.plugin"
                    :pluginName="$pluginName"
                    :pluginOptions="$pluginOptions"
                />
            @endforeach

            @isset($events)
                @foreach($events as $event => $code)
                    <x-dynamic-component
                        :component="'input.uppy.events.'.Str::of($event)->replace(':', '-')"
                        :code="$code"
                        :instanceName="$instanceName"
                    />
                @endforeach
            @endisset

            @if($extraJs !== '')
                {{ new Illuminate\Support\HtmlString($extraJs) }}
            @endif
        }
    }"
    x-init="initUppy($el)"
>

    {{ $slot }}

</div>
