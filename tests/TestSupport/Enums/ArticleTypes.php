<?php

namespace Javaabu\Forms\Tests\TestSupport\Enums;

enum ArticleTypes: string
{
    case Report = 'report';
    case Image = 'image';

    public function getLabel(): string
    {
        return match ($this) {
            self::Report => 'Report Article',
            self::Image => 'Image Article'
        };
    }
}
