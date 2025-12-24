<?php

namespace Javaabu\Forms\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function isTranslatable($attribute): bool
    {
        return $attribute == 'name';
    }
}
