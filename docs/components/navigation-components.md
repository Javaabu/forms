---
title: Navigation Components
description: Documentation for navigation components including tab navigation in the Javaabu Forms package
category: components
order: 10
---

# Navigation Components

This section covers navigation components including tab navigation systems.

---

## NavTabs

**File Path:** `src/Views/Components/NavTabs.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$tabs` (array|Collection): Array of tabs (default: [])
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `item`: Individual tab item

**Example:**
```blade
<x-nav-tabs :tabs="$tabs">
    <x-slot:item name="profile">
        <x-nav-item title="Profile" />
    </x-slot:item>

    <x-slot:item name="settings">
        <x-nav-item title="Settings" />
    </x-slot:item>
</x-nav-tabs>
```

---

## Navigation Components Usage Examples

### Basic Navigation Tabs
```blade
<x-nav-tabs :tabs="$tabs">
    <x-slot:item name="profile">
        <x-nav-item title="Profile" />
    </x-slot:item>

    <x-slot:item name="settings">
        <x-nav-item title="Settings" />
    </x-slot:item>

    <x-slot:item name="notifications">
        <x-nav-item title="Notifications" />
    </x-slot:item>
</x-nav-tabs>
```

### Active Tab Indicator
```blade
<x-nav-tabs :tabs="$tabs" active="settings">
    <x-slot:item name="profile">
        <x-nav-item title="Profile" />
    </x-slot:item>

    <x-slot:item name="settings">
        <x-nav-item title="Settings" :active="$tabs->isActive('settings')" />
    </x-slot:item>

    <x-slot:item name="notifications">
        <x-nav-item title="Notifications" />
    </x-slot:item>
</x-nav-tabs>
```

### Dynamic Tabs
```blade
<x-nav-tabs :tabs="$dynamicTabs">
    @foreach($dynamicTabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item
                :title="$tab->title"
                :active="$tabs->isActive($tab->name)"
            />
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Tabs with Dropdown
```blade
<x-nav-tabs :tabs="$tabs">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item
                :title="$tab->title"
                :active="$tabs->isActive($tab->name)"
            >
                @if($tab->hasDropdown)
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Option 1</a>
                        <a href="#" class="dropdown-item">Option 2</a>
                    </div>
                @endif
            </x-nav-item>
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Vertical Navigation Tabs
```blade
<div class="vertical-tabs">
    <x-nav-tabs :tabs="$tabs" :vertical="true">
        @foreach($tabs as $tab)
            <x-slot:item name="{{ $tab->name }}">
                <x-nav-item
                    :title="$tab->title"
                    :active="$tabs->isActive($tab->name)"
                />
            </x-slot:item>
        @endforeach
    </x-nav-tabs>
</div>
```

### Tabs with Icons
```blade
<x-nav-tabs :tabs="$tabs">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item
                :title="$tab->title"
                :active="$tabs->isActive($tab->name)"
            >
                <x-icon name="{{ $tab->icon }}" />
                {{ $tab->title }}
            </x-nav-item>
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Tabs with Badges
```blade
<x-nav-tabs :tabs="$tabs">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item
                :title="$tab->title"
                :active="$tabs->isActive($tab->name)"
            >
                {{ $tab->title }}
                @if($tab->hasBadge)
                    <span class="badge">{{ $tab->badge }}</span>
                @endif
            </x-nav-item>
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Tabs with Different Styles
```blade
<!-- Pills Style -->
<x-nav-tabs :tabs="$tabs" style="pills">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item :title="$tab->title" :active="$tabs->isActive($tab->name)" />
        </x-slot:item>
    @endforeach
</x-nav-tabs>

<!-- Line Style -->
<x-nav-tabs :tabs="$tabs" style="line">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item :title="$tab->title" :active="$tabs->isActive($tab->name)" />
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Conditional Tabs
```blade
@if($user->canEdit)
    <x-nav-tabs :tabs="$tabs">
        <x-slot:item name="edit">
            <x-nav-item title="Edit" :active="$tabs->isActive('edit')" />
        </x-slot:item>
    </x-nav-tabs>
@endif

@if($user->canDelete)
    <x-nav-tabs :tabs="$tabs">
        <x-slot:item name="delete">
            <x-nav-item title="Delete" :active="$tabs->isActive('delete')" />
        </x-slot:item>
    </x-nav-tabs>
@endif
```

### Tabs with URLs
```blade
<x-nav-tabs :tabs="$tabs">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item
                :title="$tab->title"
                :active="$tabs->isActive($tab->name)"
                :url="$tab->url"
            />
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Nested Tabs
```blade
<x-nav-tabs :tabs="$mainTabs">
    @foreach($mainTabs as $mainTab)
        <x-slot:item name="{{ $mainTab->name }}">
            <x-nav-item :title="$mainTab->title" :active="$tabs->isActive($mainTab->name)" />

            @if($mainTab->hasSubtabs)
                <x-nav-tabs :tabs="$mainTab->subtabs">
                    @foreach($mainTab->subtabs as $subtab)
                        <x-slot:item name="{{ $subtab->name }}">
                            <x-nav-item
                                :title="$subtab->title"
                                :active="$tabs->isActive($subtab->name)"
                            />
                        </x-slot:item>
                    @endforeach
                </x-nav-tabs>
            @endif
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Tabs with Descriptions
```blade
<x-nav-tabs :tabs="$tabs">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item
                :title="$tab->title"
                :active="$tabs->isActive($tab->name)"
            >
                {{ $tab->title }}
                <div class="nav-item-description">{{ $tab->description }}</div>
            </x-nav-item>
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Tabs with Custom Styling
```blade
<x-nav-tabs :tabs="$tabs" style="custom">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item
                :title="$tab->title"
                :active="$tabs->isActive($tab->name)"
                :class="custom-tab-class"
            />
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Tabs with Click Events
```blade
<x-nav-tabs :tabs="$tabs">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item
                :title="$tab->title"
                :active="$tabs->isActive($tab->name)"
                @click="navigateToTab('{{ $tab->name }}')"
            />
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Responsive Tabs
```blade
<x-nav-tabs :tabs="$tabs">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item
                :title="$tab->title"
                :active="$tabs->isActive($tab->name)"
            >
                @media (min-width: 768px)
                    {{ $tab->title }}
                @else
                    <x-icon name="{{ $tab->icon }}" />
                @endif
            </x-nav-item>
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Tabs with Tooltips
```blade
<x-nav-tabs :tabs="$tabs">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item
                :title="$tab->title"
                :active="$tabs->isActive($tab->name)"
            >
                <span class="nav-item-title">{{ $tab->title }}</span>
                <span class="nav-item-tooltip">{{ $tab->description }}</span>
            </x-nav-item>
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Tabs with Disabled States
```blade
<x-nav-tabs :tabs="$tabs">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item
                :title="$tab->title"
                :active="$tabs->isActive($tab->name)"
                :disabled="$tab->disabled"
            />
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```

### Tabs with Horizontal Line
```blade
<x-nav-tabs :tabs="$tabs" style="horizontal-line">
    @foreach($tabs as $tab)
        <x-slot:item name="{{ $tab->name }}">
            <x-nav-item :title="$tab->title" :active="$tabs->isActive($tab->name)" />
        </x-slot:item>
    @endforeach
</x-nav-tabs>
```
