<?php

namespace ContextVariableSets;

class Repeater extends ContextVariableSet
{
    public $period;
    public $n;
    public $pegdate;
    public $day;
    public $month;
    public $round;
    public $offset;
    public $ff;

    public function __construct(string $prefix, array $default_data = [], ?string $partial = null)
    {
        parent::__construct($prefix, $default_data, $partial);

        $data = $this->getRawData();

        if (@$data['period']) {
            $this->period = @$data['period'];
            $this->n = @$data['n'] ?: 7;
            $this->pegdate = @$data['pegdate'] ?: date('Y-m-d');
            $this->day = @$data['day'];
            $this->month = @$data['month'];
            $this->round = @$data['round'];
            $this->offset = @$data['offset'];
            $this->ff = @$data['ff'];
        }
    }

    public function input_names(): array
    {
        return [
            'day',
            'ff',
            'month',
            'n',
            'offset',
            'pegdate',
            'period',
            'round',
        ];
    }

    public function render()
    {
        $r = "{$this->period}:";

        if ($this->period == 'day') {
            $r .= "{$this->pegdate}.{$this->n}";
        } else {
            $r .= "{$this->day}";

            if ($this->period == 'year') {
                $r .= "/{$this->month}";
            }
        }

        if ($this->round !== null) {
            $r .= 'r';
        }

        if ($this->ff) {
            $r .= 'f' . $this->ff;
        }

        if ($this->offset !== null) {
            $r .= str_replace(
                [' ', 'days', 'day', 'weeks', 'week', 'months', 'month', 'years', 'year'],
                ['',  'd',    'd',   'w',     'w',    'm',      'm',      'y',    'y'],
                $this->offset
            );
        }

        return $r;
    }
}
