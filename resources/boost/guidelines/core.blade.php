{{--
    javaabu/forms guidelines for AI code assistants

    Maintained by: Javaabu (https://javaabu.com)

    Laravel Boost renders this file with Blade, and backticks don't stop directives or
    echoes from compiling, so the guideline is kept in a verbatim block. Without it the
    whole guideline is left out of apps' AGENTS.md (#21). BoostTest checks it renders.
--}}
@verbatim
## javaabu/forms

- This project builds Blade forms, buttons, cards, tables and other admin UI with `javaabu/forms` components (`<x-forms::text>`, `<x-forms::select2>`, `<x-forms::submit>`, …). Use them instead of writing form HTML by hand, and don't add another form-builder package.
- Bind models with `<x-forms::form :model="$model">` or `@model($model) … @endmodel`; never set `value="{{ old(...) }}"` yourself.
- Always activate the `javaabu-forms` skill when creating or changing a Blade form, a listing page (table, filters, pagination) or a details page, or when styling or translating these components.
@endverbatim
