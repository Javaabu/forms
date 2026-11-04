<?php

namespace Javaabu\Forms\Views\Components;

class Button extends Component
{
    protected string $view = 'button';

    /**
     * @param  string  $color  Bootstrap colour name: primary, danger, outline-secondary, link, ...
     * @param  string  $size  sm, md (default), lg or icon
     * @param  string  $startIcon  Icon before the label
     * @param  string  $endIcon  Icon after the label
     * @param  bool  $animate  Show a spinner once the form submits
     * @param  bool  $loading  Show a spinner and block clicks now
     */
    public function __construct(
        public string $type = '',
        public string $color = 'primary',
        public bool $animate = false,
        public string $size = '',
        public string $startIcon = '',
        public string $endIcon = '',
        public bool $loading = false,
        string $framework = '',
    ) {
        parent::__construct($framework);
    }

    /**
     * The size name the framework understands: sm, lg, icon, or null for the default.
     */
    public function frameworkSize(): ?string
    {
        return in_array($this->size, ['', 'md', 'default']) ? null : $this->size;
    }
}
