<?php

$label = $this->value;

if ($this->options):
    $option_lookup = array_flip($this->options);

    if (isset($option_lookup[$this->value]) && is_string($option_lookup[$this->value])) :
        $label = $option_lookup[$this->value];
    endif;
endif;

$label = $label ?: $this->label ?: preg_replace('/.*_/', '', $this->prefix);

?><div class="navset">
    <div class="inline-rel">
        <div class="inline-modal">
            <div class="inline-dropdown">
                <a class="cv-manip <?= $this->value ? '' : 'current' ?>" data-manips="<?= $this->prefix ?>__value=">-</a>
                <?php
                    if ($this->options):
                        foreach ($this->options as $index => $option):
                            $current = $this->value == $option ? 'current' : '';
                            $manips = $this->prefix . '__value=' . $option;

                            ?><a class="cv-manip <?= $current ?>" data-manips="<?= $manips ?>"><?php
                                echo !is_numeric($index) ? $index : $option;
                            ?></a><?php
                        endforeach;
                     else:
                        ?><input class="cv-surrogate" data-for="<?= $this->prefix ?>__value" type="text" value="<?= $this->value ?>"><?php
                    endif;
                ?>
            </div>
        </div>
        <span class="inline-modal-trigger"><?= $label ?></span>
    </div>
</div>
