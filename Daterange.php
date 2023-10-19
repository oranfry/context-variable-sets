<?php

namespace ContextVariableSets;

use Periods\Period;

class Daterange extends ContextVariableSet
{
    public $chunk = null;
    public $date;
    public $period = null;
    public $period_id = null;
    public $periods;
    public $nullable;

    public function __construct(string $prefix, array $default_data = [], ?string $partial = null)
    {
        $this->nullable = (bool) ($default_data['nullable'] ?? false);

        unset($default_data['nullable']);

        $periods = $default_data['periods'] ?? [];

        foreach ($periods as $period) {
            if (!$period instanceof Period) {
                throw new Exception('Invalid period given to daterange, should be a Periods\\Period');
            }
        }

        $this->periods = $periods;

        unset($default_data['periods']);

        parent::__construct($prefix, $default_data, $partial);

        $data = $this->getRawData();

        $this->date = @$data['date'] ?: date('Y-m-d');

        $period_ids = array_keys($this->periods);
        $period_id = null;

        if (!$this->nullable || @$data['period_id'] !== '-') {
            $period_id = (@$data['period_id'] !== '-' ? @$data['period_id'] : null) ?: @reset($period_ids);
        }

        if ($period_id && $period = @$this->periods[$period_id]) {
            $this->period_id = $period_id;
            $this->period = $period;
            $this->chunk = $this->period->chunk($this->date);
        }
    }

    public function input_names(): array
    {
        return [
            'date',
            'period_id',
        ];
    }

    public function input_value(string $name): ?string
    {
        return match($name) {
            'period_id' => $this->period_id ?? '-',
            default => null,
        };
    }

    public function getTitle()
    {
        return $this->chunk ? $this->chunk->label() : null;
    }

    public function computeDates()
    {
        $highlight = null;
        $next = null;
        $prev = null;

        if ($this->period) {
            $curr = $this->period->chunk(date('Y-m-d'));
            $next = $this->chunk->next();
            $prev = $this->chunk->prev();

            $highlight = ['', '', ''];
            $highlight[($this->chunk->start() <=> $curr->start()) + 1] = 'current';
        }

        return compact('highlight', 'next', 'prev');
    }
}

