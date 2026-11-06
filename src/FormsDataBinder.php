<?php

namespace Javaabu\Forms;

use Illuminate\Support\Arr;

class FormsDataBinder
{
    /**
     * Tree of bound targets.
     */
    private array $bindings = [];

    /**
     * Bind a target to the current instance
     *
     * @param  mixed  $target
     */
    public function bind($target): void
    {
        $this->bindings[] = $target;
    }

    /**
     * Get the latest bound target.
     *
     * @return mixed
     */
    public function get()
    {
        return Arr::last($this->bindings);
    }

    /**
     * Remove the last binding.
     */
    public function pop(): void
    {
        array_pop($this->bindings);
    }
}
