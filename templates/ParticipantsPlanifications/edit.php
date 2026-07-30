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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $participantsPlanifications->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $participantsPlanifications->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Participants Planifications'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="participantsPlanifications form content">
            <?= $this->Form->create($participantsPlanifications) ?>
            <fieldset>
                <legend><?= __('Edit Participants Planification') ?></legend>
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
