<div class="inline-rel">
    <div class="inline-modal repeater-modal">
        <div class="nav-dropdown--spacey" style="white-space: nowrap; width: 17em;">
            <div class="form-row">
                <div class="form-row__label">Repeater</div>
                <div class="form-row__value">
                    <select class="repeater-select cv-surrogate no-autosubmit" data-for="<?= $this->prefix ?>__period">
                        <option></option>
                        <?php
                            $selected = $period == $this->period ? 'selected="selected"' : '';

                            foreach (['day', 'month', 'year'] as $period):
                                ?><option <?= $selected ?> value="<?= $period ?>"><?php
                                    echo $period;
                                ?></option><?php
                            endforeach;
                        ?>
                    </select>
                </div>
                <div style="clear: both"></div>
            </div>

            <div class="form-row" data-repeaters="day">
                <div class="form-row__label">n</div>
                <div class="form-row__value">
                    <input class="cv-surrogate no-autosubmit" data-for="<?= $this->prefix ?>__n" type="number" step="1" min="1" value="<?= $this->n ?>" style="width: 4em">
                </div>
                <div style="clear: both"></div>
            </div>

            <div class="form-row" data-repeaters="day">
                <div class="form-row__label">Peg Date</div>
                <div class="form-row__value">
                    <input class="cv-surrogate no-autosubmit" data-for="<?= $this->prefix ?>__pegdate" type="text" value="<?= $this->pegdate ?>" style="width: 7em"><span class="button fromtoday">&bull;</span>
                </div>
                <div style="clear: both"></div>
            </div>

            <div class="form-row" data-repeaters="month year">
                <div class="form-row__label">Day</div>
                <div class="form-row__value">
                    <input class="cv-surrogate no-autosubmit" data-for="<?= $this->prefix ?>__day" type="text" value="<?= $this->day ?>" style="width: 7em">
                </div>
                <div style="clear: both"></div>
            </div>

            <div class="form-row" data-repeaters="year">
                <div class="form-row__label">Month</div>
                <div class="form-row__value">
                    <input class="cv-surrogate no-autosubmit" data-for="<?= $this->prefix ?>__month" type="text" value="<?= $this->month ?>" style="width: 7em">
                </div>
                <div style="clear: both"></div>
            </div>

            <div class="form-row" data-repeaters="day month year">
                <div class="form-row__label">F/F</div>
                <div class="form-row__value">
                     <select class="cv-surrogate no-autosubmit" data-for="<?= $this->prefix ?>__ff">
                        <option></option>
                        <?php
                            foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $i => $ff):
                                $selected = ($i + 1 == $this->ff) ? 'selected="selected"' : '';

                                ?><option <?= $selected ?> value="<?= $i + 1 ?>"><?= $ff ?></option><?php
                            endforeach;
                        ?>
                    </select>
                </div>
                <div style="clear: both"></div>
            </div>

            <div class="form-row" data-repeaters="month year">
                <div class="form-row__label">Offset</div>
                <div class="form-row__value">
                    <input class="cv-surrogate no-autosubmit" data-for="<?= $this->prefix ?>__offset" type="text" value="<?= $this->offset ?>" style="width: 7em">
                </div>
                <div style="clear: both"></div>
            </div>

            <div class="form-row" data-repeaters="month year">
                <div class="form-row__label">Round</div>
                <div class="form-row__value">
                     <select class="cv-surrogate no-autosubmit" data-for="<?= $this->prefix ?>__round">
                        <option></option>
                        <option <?= $this->round == 'Yes' ? 'selected': '' ?>>Yes</option>
                    </select>
                </div>
                <div style="clear: both"></div>
            </div>

            <div class="form-row">
                <div class="form-row__label">&nbsp;</div>
                <div class="form-row__value">
                    <a class="button cv-manip" data-manips="<?= $this->prefix ?>__period=">Clear</a>
                    <a class="button cv-manip" data-manips="">Apply</a>
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
    </div>
    <div class="inline-modal-trigger drnav <?= $this->period ? 'current' : '' ?>"><i class="icon icon--gray icon--repeat"></i></div>
</div>
