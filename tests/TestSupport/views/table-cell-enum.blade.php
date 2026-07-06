@php
    $article = new \Javaabu\Forms\Tests\TestSupport\Models\Article();
    $article->type = \Javaabu\Forms\Tests\TestSupport\Enums\ArticleTypes::Report;
@endphp

@model($article)
<table>
    <x-forms::table.cell name="type" />
</table>
@endmodel
