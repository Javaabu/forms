<?php

namespace Javaabu\Forms\Views\Components;

class LinkButton extends Component
{
    protected string $view = 'link-button';

    /**
     * @param  string  $color  Bootstrap colour name: primary, danger, outline-secondary, link, ...
     * @param  string  $size  sm, md (default), lg or icon
     * @param  bool  $disabled  Render without an href and mark it aria-disabled
     */
    public function __construct(
        public string $url = '',
        public string $color = 'primary',
        public string $size = '',
        public string $startIcon = '',
        public string $endIcon = '',
        public bool $disabled = false,
        string $framework = '',
    ) {
        parent::__construct($framework);
    }

    public function frameworkSize(): ?string
    {
        return in_array($this->size, ['', 'md', 'default']) ? null : $this->size;
    }
}
