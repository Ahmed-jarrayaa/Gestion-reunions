<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Planification> $planification
 */
?>
<div class="planification index content">
    <?= $this->Html->link(__('New Planification'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Planification') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('titre') ?></th>
                    <th><?= $this->Paginator->sort('date_planification') ?></th>
                    <th><?= $this->Paginator->sort('lieu') ?></th>
                    <th><?= $this->Paginator->sort('cree_par') ?></th>
                    <th><?= $this->Paginator->sort('id_type') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($planification as $planification): ?>
                <tr>
                    <td><?= $this->Number->format($planification->id) ?></td>
                    <td><?= h($planification->titre) ?></td>
                    <td><?= h($planification->date_planification) ?></td>
                    <td><?= h($planification->lieu) ?></td>
                    <td><?= $this->Number->format($planification->cree_par) ?></td>
                    <td><?= $this->Number->format($planification->id_type) ?></td>
                    <td class="actions">
<?php
$user = $this->request->getAttribute('identity'); // utilisateur connecté

// Si le planificateur est le créateur et le statut est en attente
if ($user->id === $planification->cree_par && $planification->statut === 'en_attente'): ?>
    <?= $this->Html->link('Accepter', ['action' => 'accepter', $planification->id], ['class' => 'btn btn-success btn-sm']) ?>
    <?= $this->Html->link('Refuser', ['action' => 'refuser', $planification->id], ['class' => 'btn btn-danger btn-sm']) ?>
<?php else: ?>
    <!-- Pour les autres utilisateurs, affichage du statut -->
    <?php if ($planification->statut === 'accepte'): ?>
        <span class="badge" style="background-color: #28a745; color: white;">Acceptée</span>
    <?php elseif ($planification->statut === 'refuse'): ?>
        <span class="badge" style="background-color: #dc3545; color: white;">Refusée</span>
    <?php else: ?>
        <span class="badge" style="background-color: #ffc107; color: black;">En attente</span>
    <?php endif; ?>
<?php endif; ?>


                        <?= $this->Html->link(__('View'), ['action' => 'view', $planification->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $planification->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $planification->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $planification->id),
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