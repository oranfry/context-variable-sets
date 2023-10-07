<?php

namespace ContextVariableSets;

class Hidden extends ContextVariableSet
{
    public $value;

    public function __construct(string $prefix, array $default_data = [], ?string $partial = null)
    {
        parent::__construct($prefix, $default_data, $partial);

        $this->value = @$this->getRawData()['value'];
    }

    public function display()
    {
    }

    public function input_names(): array
    {
        return ['value'];
    }
}
