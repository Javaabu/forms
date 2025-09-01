<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PostBelongsToMany extends Model
{
    protected $table = 'posts';

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'comment_post', 'post_id', 'comment_id');
    }
}

class PostMorphMany extends Model
{
    protected $table = 'posts';

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

class PostMorphToMany extends Model
{
    protected $table = 'posts';

    public function comments()
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }
}

class Comment extends Model
{
}

class SelectRelationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_handles_belongs_to_many_relationships()
    {


        $post = PostBelongsToMany::create(['content' => 'Content']);

        $commentA = Comment::create(['content' => 'Content A']);
        $commentB = Comment::create(['content' => 'Content B']);
        $commentC = Comment::create(['content' => 'Content C']);

        $post->comments()->sync([$commentA->getKey(), $commentC->getKey()]);

        $options = Comment::get()->pluck('content', 'id');

        Route::get('select-relation', function () use ($post, $options) {
            return view('select-relation')
                ->with('post', $post)
                ->with('options', $options);
        })->middleware('web');

        DB::enableQueryLog();

        $this->visit('/select-relation')
            ->seeElement('option[value="' . $commentA->getKey() . '"]:selected')
            ->seeElement('option[value="' . $commentB->getKey() . '"]:not(:selected)')
            ->seeElement('option[value="' . $commentC->getKey() . '"]:selected');

        // make sure we cache the result for each option element
        $this->assertCount(1, DB::getQueryLog());
    }

    #[Test]
    public function it_handles_morph_many_relationships()
    {


        $post = PostMorphMany::create(['content' => 'Content']);

        $commentA = $post->comments()->create(['content' => 'Content A']);
        $commentB = Comment::create(['content' => 'Content B']);
        $commentC = $post->comments()->create(['content' => 'Content C']);

        $options = Comment::get()->pluck('content', 'id');

        Route::get('select-relation', function () use ($post, $options) {
            return view('select-relation')
                ->with('post', $post)
                ->with('options', $options);
        })->middleware('web');

        DB::enableQueryLog();

        $this->visit('/select-relation')
            ->seeElement('option[value="' . $commentA->getKey() . '"]:selected')
            ->seeElement('option[value="' . $commentB->getKey() . '"]:not(:selected)')
            ->seeElement('option[value="' . $commentC->getKey() . '"]:selected');

        // make sure we cache the result for each option element
        $this->assertCount(1, DB::getQueryLog());
    }

    #[Test]
    public function it_handles_morph_to_many_relationships()
    {


        $post = PostMorphToMany::create(['content' => 'Content']);

        $commentA = $post->comments()->create(['content' => 'Content A']);
        $commentB = Comment::create(['content' => 'Content B']);
        $commentC = $post->comments()->create(['content' => 'Content C']);

        $options = Comment::get()->pluck('content', 'id');

        Route::get('select-relation', function () use ($post, $options) {
            return view('select-relation')
                ->with('post', $post)
                ->with('options', $options);
        })->middleware('web');

        DB::enableQueryLog();

        $this->visit('/select-relation')
            ->seeElement('option[value="' . $commentA->getKey() . '"]:selected')
            ->seeElement('option[value="' . $commentB->getKey() . '"]:not(:selected)')
            ->seeElement('option[value="' . $commentC->getKey() . '"]:selected');

        // make sure we cache the result for each option element
        $this->assertCount(1, DB::getQueryLog());
    }
}
