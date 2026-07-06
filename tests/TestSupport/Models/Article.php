<?php

namespace Javaabu\Forms\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Javaabu\Forms\Tests\TestSupport\Enums\ArticleStatuses;
use Javaabu\Forms\Tests\TestSupport\Enums\ArticleTypes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $fillable = [
        'status',
        'title',
        'content',
        'type',
    ];

    protected $casts = [
        'status' => ArticleStatuses::class,
        'type' => ArticleTypes::class,
    ];

    protected $attributes = [
        'status' => ArticleStatuses::Published,
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232);
    }

    public function getPhotoAttribute()
    {
        return $this->getFirstMediaUrl('featured_image');
    }

    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getFirstMediaUrl('featured_image', 'thumb')
        );
    }
}
