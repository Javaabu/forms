<?php

namespace Javaabu\Forms\Views\Components;

class Submit extends Button
{
    public function __construct(
        string $color = 'primary',
        string $size = '',
        string $startIcon = '',
        string $endIcon = '',
        bool $animate = true,
        bool $loading = false,
        string $framework = '',
    ) {
        parent::__construct('submit', $color, $animate, $size, $startIcon, $endIcon, $loading, $framework);
    }
}
