<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ParticipantsPlanification> $participantsPlanifications
 */
?>
<div class="participantsPlanifications index content">
    <?= $this->Html->link(__('New Participants Planification'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Participants Planifications') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('id_planification') ?></th>
                    <th><?= $this->Paginator->sort('id_utilisateur') ?></th>
                    <th><?= $this->Paginator->sort('presence') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($participantsPlanifications as $participantsPlanification): ?>
                <tr>
                    <td><?= $this->Number->format($participantsPlanification->id) ?></td>
                    <td><?= $this->Number->format($participantsPlanification->id_planification) ?></td>
                    <td><?= $this->Number->format($participantsPlanification->id_utilisateur) ?></td>
                    <td><?= h($participantsPlanification->presence) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $participantsPlanification->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $participantsPlanification->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $participantsPlanification->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $participantsPlanification->id),
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