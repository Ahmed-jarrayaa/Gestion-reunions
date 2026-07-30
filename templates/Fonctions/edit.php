<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fonction $fonction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $fonction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $fonction->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Fonctions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="fonctions form content">
            <?= $this->Form->create($fonction) ?>
            <fieldset>
                <legend><?= __('Edit Fonction') ?></legend>
                <?php
                    echo $this->Form->control('nom');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
