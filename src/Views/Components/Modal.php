<?php

namespace Javaabu\Forms\Views\Components;

class Modal extends Component
{
    protected string $view = 'modal';

    public string $title;
    public ?string $modalSizeClass = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $id = '',
        string $title = '',
        string $modalSizeClass = null,
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->id = $id;
        $this->title = $title;
        $this->modalSizeClass = $modalSizeClass;
    }
}
