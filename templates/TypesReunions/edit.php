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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $typesReunion->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $typesReunion->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Types Reunions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="typesReunions form content">
            <?= $this->Form->create($typesReunion) ?>
            <fieldset>
                <legend><?= __('Edit Types Reunion') ?></legend>
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
