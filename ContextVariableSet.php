<?php

namespace ContextVariableSets;

abstract class ContextVariableSet
{
    protected static $library = [];

    public ?string $label = null;
    public array $default_data;
    public array $vars = [];
    private string $partial;
    public string $prefix;

    public function __construct(string $prefix, array $default_data = [], ?string $partial = null)
    {
        $this->prefix = $prefix;
        $this->default_data = $default_data;
        $this->partial = $partial ?? 'src/php/partial/' . str_replace('\\', '/', static::class) . '.php';
    }

    public function inputs()
    {
        foreach ($this->input_names() as $name) {
            ?><input class="cv" type="hidden" name="<?= $this->prefix ?>__<?= $name ?>" value="<?= htmlspecialchars($this->input_value($name) ?? $this->$name) ?>"><?php
        }
    }

    public function input_value(string $name): ?string
    {
        return null;
    }

    public function display()
    {
        ss_require($this->partial, [], $this);
    }

    protected function getRawData()
    {
        $data = $this->default_data;

        if ($hvalue = getallheaders()['X-Cvs'] ?? null) {
            foreach (explode(',', $hvalue) as $rawheader) {
                [$fname, $fvalue] = explode('=', $rawheader, 2);
                [$fmajor, $fminor] = explode('__', $fname, 2);

                if ($fmajor == $this->prefix) {
                    $data[$fminor] = str_replace('|', ',', $fvalue);
                }
            }
        } else {
            $prefix_du = $this->prefix . '__';

            foreach ($_GET as $qname => $qvalue) {
                if (strpos($qname, $prefix_du) === 0) {
                    $name = substr($qname, strlen($prefix_du));
                    $data[$name] = $qvalue;
                }
            }
        }

        return $data;
    }

    public static function get($name)
    {
        return @static::$library[$name];
    }

    public static function getAll()
    {
        return @static::$library;
    }

    public static function getValues()
    {
        $data = [];

        foreach (static::getAll() as $cvs) {
            foreach ($cvs->getRawData() as $name => $value) {
                $data[$cvs->prefix . '__' . $name] = $value;
            }
        }

        return $data;
    }

    public static function put($name, $object)
    {
        static::$library[$name] = $object;
    }

    public function constructQuery($changes)
    {
        $data = static::getValues();

        foreach ($changes as $name => $value) {
            $data[$this->prefix . '__' . $name] = $value;
        }

        $data = array_filter($data, fn ($v) => isset($v));

        return implode('&', array_map(fn ($v, $k) => "{$k}={$v}", array_values($data), array_keys($data)));
    }

    public static function form()
    {
        ?><div style="display: none;"><form id="cvs-form"><div><?php
            foreach (static::getAll() as $active) {
                $active->inputs();
            }
        ?><div id="new-vars-here"></div><?php
        ?></div></form></div><?php
    }

    public function input_names(): array
    {
        return [];
    }
}
