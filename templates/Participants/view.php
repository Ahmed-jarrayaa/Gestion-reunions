<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant $participant
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Participant'), ['action' => 'edit', $participant->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Participant'), ['action' => 'delete', $participant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participant->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Participants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Participant'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="participants view content">
            <h3><?= h($participant->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Presence') ?></th>
                    <td><?= h($participant->presence) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($participant->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Reunion') ?></th>
                    <td><?= $participant->id_reunion === null ? '' : $this->Number->format($participant->id_reunion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Utilisateur') ?></th>
                    <td><?= $participant->id_utilisateur === null ? '' : $this->Number->format($participant->id_utilisateur) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>