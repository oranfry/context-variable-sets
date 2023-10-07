<?php

namespace ContextVariableSets;

class Filter extends ContextVariableSet
{
    public $field;
    public $cmp;
    public $value;

    public function __construct(string $prefix, array $default_data = [], ?string $partial = null)
    {
        parent::__construct($prefix, $default_data, $partial);

        $data = $this->getRawData();

        $this->field = @$data['field'];
        $this->cmp = @$data['cmp'];
        $this->value = @$data['value'];
    }

    public function display()
    {
    }

    public function input_names()
    {
        return [
            'field',
            'cmp',
            'value',
        ];
    }
}
