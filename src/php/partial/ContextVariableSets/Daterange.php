<?php

extract($this->computeDates());

?><div class="navset">
    <div class="inline-rel">
        <div class="inline-modal">
            <div class="nav-dropdown nav-dropdown--always">
                 <?php
                    foreach ($this->periods as $shortname => $period):
                        if ($current = ($shortname == $this->period_id) ? 'current' : ''):
                            $currentShortname = $shortname;
                        endif;

                        $href = strtok($_SERVER['REQUEST_URI'], '?') . '?' . $this->constructQuery(['period_id' => $shortname, 'date' => $this->date]);

                        ?><a class="<?= $current ?>" href="<?= $href ?>"><?= $period->label() ?></a><?php
                    endforeach;
                ?>
                <input class="cv-surrogate" data-for="<?= $this->prefix ?>__date" type="text" value="<?= $this->chunk->start() ?>" style="margin: 0.5em; width: 7em">
            </div>
        </div>
        <a class="inline-modal-trigger"><?= $currentShortname ?></a>

        <?php
            if ($this->chunk->start() !== null || $this->chunk->end() !== null):
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
        ?>
    </div>
</div>
