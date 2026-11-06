# Component attributes

Generated from the component constructors by `scripts/components-reference.php`. Every field also accepts `form-group-class`, `thaana`, `auto-resize` (textarea) and `decimals` (number), every component accepts `framework`, and any other attribute (`class`, `id`, `placeholder`, `min`, `step`, `data-*`, …) goes on the control.

| Component | Attributes (kebab-case) = default |
| --- | --- |
| `x-forms::accordion` | `id` (string, required), `items` = [] |
| `x-forms::accordion.collapse` | `parent` (string, required), `content` = '', `show` = false |
| `x-forms::accordion.header` | `target` (string, required), `title` = '', `show` = false |
| `x-forms::accordion.item` | `name` (string, required), `parent` (string, required), `title` = '', `content` = '', `show` = false, `disabled` = false |
| `x-forms::alert` | `type` = primary, `dismissible` = false, `icon` = '', `heading` = '' |
| `x-forms::boolean-entry` | `name` = '', `label` = '', `value` = null, `model` = null, `show-label` = true, `inline` = false, `inline-entry-label-class` = '', `inline-entry-class` = '' |
| `x-forms::bulk-actions` | `model` (string, required), `actions` (array, required) |
| `x-forms::button` | `type` = '', `color` = primary, `animate` = false, `size` = '', `start-icon` = '', `end-icon` = '', `loading` = false |
| `x-forms::button-group` | `inline` = true |
| `x-forms::card` | `title` = '' |
| `x-forms::card.footer` | — |
| `x-forms::card.header` | — |
| `x-forms::card.subtitle` | — |
| `x-forms::card.title` | — |
| `x-forms::checkbox` | `name` (string, required), `label` = '', `model` = null, `default` = false, `value` = 1, `show-errors` = true, `show-label` = true, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::conditional-link` | `url` (string, required), `name` = '', `show-link` = null, `can` = '', `arg` = [], `guard` = null, `value` = null, `model` = null, `multiline` = false |
| `x-forms::conditional-wrapper` | `enable-elem` (string, required), `enable-value` = null, `hide-fields` = false, `disable` = false, `enable-checkbox` = false, `json-encode` = null |
| `x-forms::date` | `name` (string, required), `label` = '', `type` = date, `model` = null, `default` = null, `date-format` = '', `icon` = '', `clear-icon` = '', `clear-btn-class` = '', `icon-wrapper-class` = '', `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::datetime` | `name` (string, required), `label` = '', `model` = null, `default` = null, `date-format` = '', `icon` = '', `clear-icon` = '', `clear-btn-class` = '', `icon-wrapper-class` = '', `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::email` | `name` (string, required), `label` = '', `model` = null, `default` = null, `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::error-summary` | `title` = '', `bag` = default, `labels` = [] |
| `x-forms::errors` | `name` = '', `bag` = default, `first-only` = true |
| `x-forms::file` | `name` (string, required), `label` = '', `type` = document, `mimetypes` = null, `extensions` = null, `max-size` = null, `collection` = '', `conversion` = '', `file-input-class` = '', `clear-icon` = '', `download-icon` = '', `upload-icon` = '', `model` = null, `default` = null, `show-hint` = true, `show-errors` = true, `show-label` = true, `required` = false, `disabled` = false, `ignore-accessor` = false, `upload` = false, `inline` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false, `multiple` = false |
| `x-forms::file-upload` | `name` (string, required), `label` = '', `type` = document, `mimetypes` = null, `extensions` = null, `max-size` = null, `collection` = '', `conversion` = '', `file-input-class` = '', `clear-icon` = '', `download-icon` = '', `upload-icon` = '', `model` = null, `default` = null, `show-hint` = true, `show-errors` = true, `show-label` = true, `required` = false, `disabled` = false, `ignore-accessor` = false, `inline` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::filter` | — |
| `x-forms::filter-submit` | `cancel-url` (string, required), `export` = false |
| `x-forms::form` | `method` = POST, `model` = null, `files` = false, `summary` = false, `summary-title` = '', `focus-on-error` = true, `error-bag` = default |
| `x-forms::form-close` | `method` = POST, `model` = null, `files` = false, `summary` = false, `summary-title` = '', `focus-on-error` = true, `error-bag` = default |
| `x-forms::form-group` | `name` = '', `label` = '', `required` = false, `inline` = false, `floating` = false, `wrap` = true, `show-label` = true, `inline-label-class` = '', `inline-input-class` = '', `blank-label` = false |
| `x-forms::form-open` | `method` = POST, `model` = null, `files` = false |
| `x-forms::formatted-value` | `name` = '', `value` = null, `model` = null, `multiline` = false |
| `x-forms::hidden` | `name` (string, required), `label` = '', `model` = null, `default` = null, `show-errors` = true, `show-label` = true, `required` = false, `inline` = false, `floating` = false, `show-js-errors` = false |
| `x-forms::icon` | `name` (string, required) |
| `x-forms::image` | `name` (string, required), `label` = '', `type` = image, `mimetypes` = null, `extensions` = null, `max-size` = null, `collection` = '', `conversion` = '', `file-input-class` = '', `icon` = '', `upload-icon` = '', `width` = 400, `height` = 400, `cover` = false, `fullwidth` = false, `maintain-aspect-ratio` = true, `circle` = false, `upload` = false, `aspect-ratio` = null, `model` = null, `default` = null, `show-hint` = true, `show-errors` = true, `show-label` = true, `required` = false, `disabled` = false, `ignore-accessor` = false, `inline` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::image-upload` | `name` (string, required), `label` = '', `type` = image, `mimetypes` = null, `extensions` = null, `max-size` = null, `collection` = '', `conversion` = '', `file-input-class` = '', `icon` = '', `upload-icon` = '', `width` = 400, `height` = 400, `cover` = false, `fullwidth` = false, `maintain-aspect-ratio` = true, `circle` = false, `aspect-ratio` = null, `model` = null, `default` = null, `show-hint` = true, `show-errors` = true, `show-label` = true, `required` = false, `disabled` = false, `ignore-accessor` = false, `inline` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::infolist` | `title` = '', `model` = null |
| `x-forms::input` | `name` (string, required), `label` = '', `type` = text, `model` = null, `default` = null, `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::input-help` | — |
| `x-forms::js-errors` | `name` = '' |
| `x-forms::label` | `label` = '', `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `blank-label` = false |
| `x-forms::label-required` | `text` = '' |
| `x-forms::latitude` | `name` (string, required), `label` = '', `model` = null, `default` = null, `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::link-button` | `url` = '', `color` = primary, `size` = '', `start-icon` = '', `end-icon` = '', `disabled` = false |
| `x-forms::longitude` | `name` (string, required), `label` = '', `model` = null, `default` = null, `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::map-input` | `name` (string, required), `lat-name` = lat, `lng-name` = lng, `radius-name` = radius, `polygon-name` = boundary, `disabled` = false, `enable-coordinates` = true, `enable-radius` = false, `enable-polygon` = false, `hide-inputs` = false, `radius-precision` = 0, `max-radius` = 6371000, `radius-unit` = m, `lat` = null, `lng` = null, `radius` = null, `polygon` = null, `default-lat` = null, `default-lng` = null, `default-radius` = null, `default-polygon` = null, `default-map-center-lat` = null, `default-map-center-lng` = null, `label` = '', `model` = null, `show-errors` = true, `show-label` = true, `required` = false, `inline` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::modal` | `id` = '', `title` = '', `modal-size-class` = null, `size` = lg, `description` = '' |
| `x-forms::nav-tabs` | `tabs` = [] |
| `x-forms::no-items` | `create-action` = #, `model` = null, `icon` = '', `model-type` = null, `show-create` = null, `title` = null, `message` = null |
| `x-forms::number` | `name` (string, required), `label` = '', `model` = null, `default` = null, `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::pagination` | `paginator` (Illuminate\Contracts\Pagination\Paginator, required) |
| `x-forms::password` | `name` (string, required), `label` = '', `model` = null, `default` = null, `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::per-page` | `amounts` = array, `label` = '', `show-label` = false, `per-page` = null |
| `x-forms::radio` | `name` (string, required), `label` = '', `model` = null, `default` = false, `value` = 1, `show-errors` = true, `show-label` = true, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::search-form` | `name` = search, `action` = '', `route` = '', `params` = [], `placeholder` = '', `icon` = '', `method` = GET, `model` = null, `files` = false |
| `x-forms::select` | `name` (string, required), `label` = '', `placeholder` = '', `options` = [], `model` = null, `default` = null, `multiple` = false, `relation` = false, `show-errors` = true, `show-label` = true, `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `is-select2` = false, `is-ajax` = false, `disabled` = false, `exclude-sync-field` = false, `sync-field-name` = '', `name-field` = '', `id-field` = '', `tags` = false, `inline-label-class` = '', `inline-input-class` = '', `form-group-class` = '', `show-js-errors` = false |
| `x-forms::select2` | `name` (string, required), `label` = '', `placeholder` = '', `options` = [], `model` = null, `default` = null, `multiple` = false, `relation` = false, `show-errors` = true, `show-label` = true, `show-placeholder` = false, `required` = false, `is-ajax` = false, `is-first` = false, `tags` = false, `hide-search` = false, `allow-clear` = true, `is-icon-select` = false, `child` = '', `ajax-child` = '', `ajax-url` = '', `selected-url` = '', `name-field` = '', `id-field` = '', `filter-field` = '', `fallback` = '', `parent-modal` = '', `icon-prefix` = '', `disabled` = false, `exclude-sync-field` = false, `sync-field-name` = '', `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `form-group-class` = '', `show-js-errors` = false, `clearable` = null, `min-chars` = null, `parent` = '' |
| `x-forms::status` | `label` = '', `color` = primary |
| `x-forms::submit` | `color` = primary, `size` = '', `start-icon` = '', `end-icon` = '', `animate` = true, `loading` = false |
| `x-forms::table` | `striped` = false, `no-bulk` = false, `model` = '', `table-class` = '', `filter-id` = null, `no-pagination` = false, `no-checkbox` = false |
| `x-forms::table.cell` | `name` = '', `label` = '', `show-label` = true, `value` = null, `model` = null, `multiline` = false |
| `x-forms::table.empty-row` | `columns` = 1, `no-checkbox` = false |
| `x-forms::table.heading` | `label` = '', `colspan` = 1, `sortable` = '', `name` = '' |
| `x-forms::table.row` | `name` = '', `row-id` = '', `model` = null, `model-id` = '', `no-checkbox` = false, `disable-checkbox` = false |
| `x-forms::tabs` | `tabs` = [], `active` = '' |
| `x-forms::tabs.nav-item` | `title` (string, required), `name` = '', `target` = '', `url` = #, `active` = false, `disabled` = false, `is-tab` = false |
| `x-forms::tabs.pane` | `name` (string, required), `labelled-by` = '', `active` = false |
| `x-forms::tel` | `name` (string, required), `label` = '', `model` = null, `default` = null, `show-errors` = true, `show-label` = true, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::text` | `name` (string, required), `label` = '', `model` = null, `default` = null, `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::text-entry` | `name` = '', `label` = '', `value` = null, `model` = null, `show-label` = true, `inline` = false, `multiline` = false, `wysiwyg` = false, `inline-entry-label-class` = '', `inline-entry-class` = '' |
| `x-forms::textarea` | `name` (string, required), `label` = '', `rows` = 3, `model` = null, `default` = null, `value` = null, `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `wysiwyg` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::time` | `name` (string, required), `label` = '', `model` = null, `default` = null, `date-format` = '', `icon` = '', `clear-icon` = '', `clear-btn-class` = '', `icon-wrapper-class` = '', `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::url` | `name` (string, required), `label` = '', `model` = null, `default` = null, `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
| `x-forms::wysiwyg` | `name` (string, required), `label` = '', `rows` = 3, `model` = null, `default` = null, `value` = null, `show-errors` = true, `show-label` = true, `placeholder` = '', `show-placeholder` = false, `required` = false, `inline` = false, `floating` = false, `inline-label-class` = '', `inline-input-class` = '', `show-js-errors` = false |
