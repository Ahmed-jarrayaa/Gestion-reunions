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
            <?= $this->Html->link(__('Edit Participants Planification'), ['action' => 'edit', $participantsPlanification->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Participants Planification'), ['action' => 'delete', $participantsPlanification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participantsPlanification->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Participants Planifications'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Participants Planification'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="participantsPlanifications view content">
            <h3><?= h($participantsPlanification->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($participantsPlanification->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Planification') ?></th>
                    <td><?= $this->Number->format($participantsPlanification->id_planification) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Utilisateur') ?></th>
                    <td><?= $this->Number->format($participantsPlanification->id_utilisateur) ?></td>
                </tr>
                <tr>
                    <th><?= __('Presence') ?></th>
                    <td><?= $participantsPlanification->presence ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>