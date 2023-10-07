<?php

namespace ContextVariableSets;

class Value extends ContextVariableSet
{
    public $value;
    public $options;

    public function __construct(string $prefix, array $default_data = [], ?string $partial = null)
    {
        $this->options = $default_data['options'] ?? null;

        unset($default_data['options']);

        parent::__construct($prefix, $default_data, $partial);

        $this->value = @$this->getRawData()['value'];
    }

    public function input_names(): array
    {
        return ['value'];
    }
}
