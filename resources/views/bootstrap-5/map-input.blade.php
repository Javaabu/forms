<x-forms::form-group :inline-input-class="$inlineInputClass" :inline-label-class="$inlineLabelClass" :wrap="$showLabel" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">

    <div
         {{ $attributes }}
         data-map-selector="true"
         data-lat="{{ $defaultMapCenterLat }}"
         data-lng="{{ $defaultMapCenterLng }}"
         data-enable-marker="{{ $enableCoordinates ? 'true' : 'false' }}"
         @if($disabled)
         data-disabled="true"
         @endif
         @if($enableRadius)
         data-enable-radius="true"
         @endif
         @if($enablePolygon)
         data-enable-polygon="true"
         @endif
    >
        @if($hideInputs)
            @if($enableCoordinates)
                <x-forms::hidden class="map-selector-lat" :value="$lat" :name="$latName" :required="$required" :disabled="$disabled" :framework="$framework" />
                <x-forms::hidden class="map-selector-lng" :value="$lng" :name="$lngName" :required="$required" :disabled="$disabled" :framework="$framework" />
            @endif

            @if($enableRadius)
                <x-forms::hidden class="map-selector-radius" :value="$radius" :name="$radiusName" :required="$required" :disabled="$disabled" :framework="$framework" />
            @endif

            @if($enablePolygon)
                <x-forms::hidden class="map-selector-polygon" :value="$polygon" :name="$polygonName" :required="$required" :disabled="$disabled" :framework="$framework" />
            @endif
        @else
            @if($enableCoordinates)
                <div class="row">
                    <div class="col-lg-6">
                        <x-forms::latitude class="map-selector-lat" :value="$lat" :name="$latName" :label="trans('forms::strings.latitude')" :required="$required" :disabled="$disabled" :framework="$framework" />
                    </div>
                    <div class="col-lg-6">
                        <x-forms::longitude class="map-selector-lng" :value="$lng" :name="$lngName" :label="trans('forms::strings.longitude')" :required="$required" :disabled="$disabled" :framework="$framework" />
                    </div>
                </div>
            @endif

            @if($enableRadius)
                <x-forms::number
                    :name="$radiusName"
                    class="map-selector-radius"
                    :label="trans('forms::strings.radius')"
                    :required="$required"
                    :disabled="$disabled"
                    :value="$radius"
                    :framework="$framework"
                    min="0"
                    :max="$maxRadius"
                    :step="$getRadiusStep()"
                >
                    <x-slot:append>{{ $radiusUnit == 'km' ? trans('forms::strings.km_abbr') : trans('forms::strings.meters_abbr') }}</x-slot:append>
                </x-forms::number>
            @endif

            @if($enablePolygon)
                <x-forms::textarea class="map-selector-polygon" :value="$polygon" :name="$polygonName" :label="trans('forms::strings.boundary')" :required="$required" :disabled="$disabled" :framework="$framework" />
            @endif
        @endif

        <div>
            <input class="map-selector-search" type="text" placeholder="{{ trans('forms::strings.map_search_string') }}" />
            <div class="map-selector-map"></div>
        </div>
    </div>

    @if(! empty($help))
        <x-forms::input-help :framework="$framework">
            {!! $help !!}
        </x-forms::input-help>
    @endif

    @if($hasErrorAndShow($name))
        <x-forms::errors :framework="$framework" :name="$name" />
    @endif

    @if($showJsErrors)
        <x-forms::js-errors :framework="$framework" :name="$name" />
    @endif
</x-forms::form-group>

@pushonce(config('forms.scripts_stack'))
    @include('forms::partials.maps-script')
@endpushonce
