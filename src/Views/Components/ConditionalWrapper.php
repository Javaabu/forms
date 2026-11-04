<?php

namespace Javaabu\Forms\Views\Components;

class ConditionalWrapper extends Component
{
    protected string $view = 'conditional-wrapper';

    public bool $jsonEncode;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $enableElem,
        public $enableValue = null,
        public bool $hideFields = false,
        public bool $disable = false,
        public bool $enableCheckbox = false,
        ?bool $jsonEncode = null,
        string $framework = ''
    ) {
        parent::__construct($framework);

        $this->jsonEncode = is_null($jsonEncode) ? is_array($this->enableValue) : $jsonEncode;
    }
}
