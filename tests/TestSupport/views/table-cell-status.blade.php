@php
    $article = new \Javaabu\Forms\Tests\TestSupport\Models\Article();
    $article->status = \Javaabu\Forms\Tests\TestSupport\Enums\ArticleStatuses::Published;
@endphp

@model($article)
<table>
    <x-forms::table.cell name="status" />
</table>
@endmodel