<?php

extract($this->computeDates());

$label = $this->label ?: preg_replace('/.*_/', '', $this->prefix);

?><div class="navset cvs-daterange"><?php
    ?><div class="inline-rel"><?php
        ?><div class="inline-modal"><?php
            ?><div class="nav-dropdown nav-dropdown--always"><?php

                    if ($this->nullable):
                        if ($current = $this->period_id === null ? 'current' : ''):
                            $currentShortname = $label;
                        endif;

                        $href = strtok($_SERVER['REQUEST_URI'], '?') . '?' . $this->constructQuery(['period_id' => '-']);

                        ?><a class="<?= $current ?>" href="<?= $href ?>">-</a><?php
                    endif;

                    foreach ($this->periods as $shortname => $period):
                        if ($current = ($shortname == $this->period_id) ? 'current' : ''):
                            $currentShortname = $shortname;
                        endif;

                        $href = strtok($_SERVER['REQUEST_URI'], '?') . '?' . $this->constructQuery(['period_id' => $shortname, 'date' => $this->date]);

                        ?><a class="<?= $current ?>" href="<?= $href ?>"><?= $period->label() ?: $shortname ?></a><?php
                    endforeach;

                ?><input class="cv-surrogate" data-for="<?= $this->prefix ?>__date" type="text" value="<?= $this->chunk ? $this->chunk->start() : null ?>" style="margin: 0.5em; width: 7em"><?php
            ?></div><?php
        ?></div><?php

        ?><a class="cvs-daterange__selected_period inline-modal-trigger mb"><?php
            echo $currentShortname;
        ?></a><?php

        if ($this->chunk && ($this->chunk->start() !== null || $this->chunk->end() !== null)):
            if ($this->chunk->start() !== null):
                $href = strtok($_SERVER['REQUEST_URI'], '?') . '?' . $this->constructQuery(['date'=> $prev->start()]);

                ?><div class="drnav <?= $highlight[0] ?>"><?php
                    ?><a class="icon icon--gray icon--arrowleft" href="<?= $href ?>"></a><?php
                ?></div><?php
            endif;

            $href = strtok($_SERVER['REQUEST_URI'], '?') . '?' . $this->constructQuery(['date'=> date('Y-m-d')])

            ?><div class="drnav <?= $highlight[1] ?>"><a class="icon icon--gray icon--dot" href="<?= $href ?>"></a></div><?php

            if ($this->chunk->end() !== null):
                $href = strtok($_SERVER['REQUEST_URI'], '?') . '?' . $this->constructQuery(['date'=> $next->start()]);

                ?><div class="drnav <?= $highlight[2] ?>"><a class="icon icon--gray icon--arrowright" href="<?= $href ?>"></a></div><?php
            endif;
        endif;

    ?></div><?php
?></div><?php
