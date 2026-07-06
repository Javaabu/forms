@php
    $article = new \Javaabu\Forms\Tests\TestSupport\Models\Article();
    $article->type = \Javaabu\Forms\Tests\TestSupport\Enums\ArticleTypes::Report;
@endphp

@model($article)
<x-forms::text-entry name="type"/>
@endmodel
