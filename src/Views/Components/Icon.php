<?php

namespace Javaabu\Forms\Views\Components;

use Javaabu\Forms\Support\Icons\Svg;

class Icon extends Component
{
    protected string $view = 'icon';

    public string $icon;

    /**
     * Renders a bundled Lucide icon as inline SVG, or an icon-font <i> when given CSS classes.
     *
     * The name can be a bundled icon ("calendar"), a logical icon from forms.icons ("date"),
     * or CSS classes ("fa-regular fa-calendar").
     */
    public function __construct(
        public string $name,
        string $framework = '',
    ) {
        parent::__construct($framework);

        $this->icon = Svg::has($name) ? $name : $this->getFrameworkIcon($name);
    }

    public function isSvg(): bool
    {
        return Svg::has($this->icon);
    }

    public function svg(): string
    {
        return Svg::get($this->icon) ?? '';
    }
}
