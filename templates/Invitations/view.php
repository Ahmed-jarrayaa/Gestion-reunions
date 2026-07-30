<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invitation $invitation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Invitation'), ['action' => 'edit', $invitation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Invitation'), ['action' => 'delete', $invitation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invitation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Invitations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Invitation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invitations view content">
            <h3><?= h($invitation->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($invitation->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Statut') ?></th>
                    <td><?= h($invitation->statut) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($invitation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Reunion') ?></th>
                    <td><?= $invitation->id_reunion === null ? '' : $this->Number->format($invitation->id_reunion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Envoi') ?></th>
                    <td><?= h($invitation->date_envoi) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>