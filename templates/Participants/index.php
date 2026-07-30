<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Participant> $participants
 */
?>


<div class="participants index content">
    <?= $this->Html->link(__('New Participant'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Participants') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('id_reunion') ?></th>
                    <th><?= $this->Paginator->sort('id_utilisateur') ?></th>
                    <th><?= $this->Paginator->sort('presence') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($participants as $participant): ?>
                <tr>
                    <td><?= $this->Number->format($participant->id) ?></td>
                    <td><?= $participant->id_reunion === null ? '' : $this->Number->format($participant->id_reunion) ?></td>
                    <td><?= $participant->id_utilisateur === null ? '' : $this->Number->format($participant->id_utilisateur) ?></td>
                    <td><?= h($participant->presence) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $participant->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $participant->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $participant->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $participant->id),
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