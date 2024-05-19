<div {!! $attributes->merge(['class' => 'tab-container']) !!}>
    <ul class="nav nav-tabs" role="tablist">
        @foreach($tabs as $item)
            <x-forms::nav-item
                :framework="$framework"
                :title="empty($item['title']) ? $generateTitleByName($item['name']) : $item['title']"
                :url="empty($item['url']) ? '#'.$item['name'] : $item['url']"
                :is-tab="empty($item['url'])"
                :active="$item['name'] == $active"
                :disabled="! empty($item['disabled'])"
            />
        @endforeach
    </ul>
</div>
