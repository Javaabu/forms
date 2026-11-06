@if($isTab)
    <button
        type="button"
        role="tab"
        id="{{ $id() }}"
        data-tab-target="#{{ $target }}"
        aria-controls="{{ $target }}"
        aria-selected="{{ $active ? 'true' : 'false' }}"
        data-state="{{ $active ? 'active' : 'inactive' }}"
        data-slot="tabs-trigger"
        data-orientation="horizontal"
        tabindex="{{ $active ? '0' : '-1' }}"
        {!! $attributes->class([$frameworkClasses()->classes('tabs.tabs-trigger')]) !!}
        @if($disabled)
            disabled
        @endif
    >@if($slot->isNotEmpty()){{ $slot }}@else{{ $title }}@endif</button>
@else
    <a href="{{ $url }}"
        data-slot="tabs-trigger"
        data-state="{{ $active ? 'active' : 'inactive' }}"
        @if($active) aria-current="page" @endif
        @if($disabled) aria-disabled="true" @endif
        {!! $attributes->class([$frameworkClasses()->classes('tabs.tabs-trigger'), 'pointer-events-none opacity-50' => $disabled]) !!}>@if($slot->isNotEmpty()){{ $slot }}@else{{ $title }}@endif</a>
@endif
