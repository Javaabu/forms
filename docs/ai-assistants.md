---
title: AI assistants
sidebar_position: 1.35
---

# AI assistants

The docs are plain Markdown written for people and AI coding assistants alike, and the package ships them, so they always match the installed version.

| File | What |
| --- | --- |
| `vendor/javaabu/forms/llms.txt` | The rules for using the package, and an index of every page |
| `vendor/javaabu/forms/docs/` | The pages |
| `vendor/javaabu/forms/resources/boost/` | The Laravel Boost guideline and skill |

## Laravel Boost

[Laravel Boost](https://github.com/laravel/boost) finds the guideline and the `javaabu-forms` skill in Composer packages by itself. After installing or updating the package, run:

```bash
php artisan boost:update
```

## Other assistants

Point your assistant at the rules from your project's instructions file (`AGENTS.md`, `CLAUDE.md`, `.cursor/rules`, `.github/copilot-instructions.md`):

```md
## Forms

Blade forms use javaabu/forms (`<x-forms::…>`). Before writing or changing a form, read vendor/javaabu/forms/llms.txt.
```

Or copy `vendor/javaabu/forms/resources/boost/skills/javaabu-forms` into your assistant's skills folder, such as `.claude/skills/`.
