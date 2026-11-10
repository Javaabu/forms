@php($c = $frameworkClasses())
<div {!! $attributes->merge(['class' => 'tab-container ' . $c->classes('tabs.tabs')]) !!} data-slot="tabs" data-orientation="horizontal">
    <div class="{{ $c->classes('tabs.tabs-list') }}" data-slot="tabs-list" data-variant="default" data-orientation="horizontal" role="tablist">
        @foreach($tabs as $item)
            <x-forms::tabs.nav-item
                :framework="$framework"
                :name="$item['name'] . '-tab'"
                :target="$stringToId($item['name'])"
                :title="empty($item['title']) ? $generateTitleByName($item['name']) : $item['title']"
                :url="empty($item['url']) ? '#'.$item['name'] : $item['url']"
                :is-tab="empty($item['url'])"
                :active="$item['name'] == $active"
                :disabled="! empty($item['disabled'])"
            />
        @endforeach
    </div>

    @foreach($tabs as $item)
        @isset(${$generateSlotByName($item['name'])})
        <x-forms::tabs.pane
            :framework="$framework"
            :name="$item['name']"
            :active="$item['name'] == $active"
        >
            {{ ${$generateSlotByName($item['name'])} }}
        </x-forms::tabs.pane>
        @endisset
    @endforeach
</div>
