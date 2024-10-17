<?php

namespace ContextVariableSets;

class Value extends ContextVariableSet
{
    public $options;
    public $value;
    public bool $nullable;

    public function __construct(string $prefix, array $default_data = [], ?string $partial = null)
    {
        $this->nullable = (bool) ($default_data['nullable'] ?? true);
        $this->options = $default_data['options'] ?? null;

        unset($default_data['nullable'], $default_data['options']);

        if (!$this->nullable && $this->options) {
            $default_data['value'] ??= reset($this->options);
        }

        parent::__construct($prefix, $default_data, $partial);

        $this->value = @$this->getRawData()['value'];

        if (!$this->nullable && !$this->value) {
            throw new Exception('Value [' . $prefix . '] is not nullable but no value could be established. Suggestion: provide a default value.');
        }
    }

    public function input_names(): array
    {
        return ['value'];
    }
}
