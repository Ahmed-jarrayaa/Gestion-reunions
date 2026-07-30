<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Invitation> $invitations
 */
?>
<a href="<?= $this->Url->build('/dashboard') ?>" class="btn btn-primary">
    Dashboard
</a>

<div class="invitations index content">
    <?= $this->Html->link(__('New Invitation'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Invitations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('id_reunion') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('statut') ?></th>
                    <th><?= $this->Paginator->sort('date_envoi') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invitations as $invitation): ?>
                <tr>
                    <td><?= $this->Number->format($invitation->id) ?></td>
                    <td><?= $invitation->id_reunion === null ? '' : $this->Number->format($invitation->id_reunion) ?></td>
                    <td><?= h($invitation->email) ?></td>
                    <td><?= h($invitation->statut) ?></td>
                    <td><?= h($invitation->date_envoi) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $invitation->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invitation->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $invitation->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $invitation->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>