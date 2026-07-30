<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypesReunion $typesReunion
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Types Reunions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="typesReunions form content">
            <?= $this->Form->create($typesReunion) ?>
            <fieldset>
                <legend><?= __('Add Types Reunion') ?></legend>
                <?php
                    echo $this->Form->control('nom_type');
                    echo $this->Form->control('description');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
