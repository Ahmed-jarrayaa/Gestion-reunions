<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ParticipantsPlanification $participantsPlanification
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Participants Planifications'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="participantsPlanifications form content">
            <?= $this->Form->create($participantsPlanification) ?>
            <fieldset>
                <legend><?= __('Add Participants Planification') ?></legend>
                <?php
                    echo $this->Form->control('id_planification');
                    echo $this->Form->control('id_utilisateur');
                    echo $this->Form->control('presence');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
