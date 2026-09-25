<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Planification> $planification
 */
$user = $this->request->getAttribute('identity');
?>
<div class="card" style="max-width:1100px;">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h4 style="margin:0;">Planifications</h4>
        <?php if ($user && $user->role === 'admin'): ?>
            <a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['action' => 'add']) ?>">+ Nouvelle planification</a>
        <?php endif; ?>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('titre') ?></th>
                    <th><?= $this->Paginator->sort('date_planification', 'Date planifiée') ?></th>
                    <th><?= $this->Paginator->sort('lieu') ?></th>
                    <th><?= $this->Paginator->sort('statut') ?></th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($planification as $item): ?>
                <tr>
                    <td><?= h($item->titre) ?></td>
                    <td><?= $item->date_planification ? h($item->date_planification->format('d/m/Y H:i')) : '' ?></td>
                    <td><?= h($item->lieu) ?></td>
                    <td>
                        <?php if ($user && $user->id === $item->cree_par && $item->statut === 'en_attente'): ?>
                            <span class="badge bg-warning">En attente</span>
                        <?php elseif ($item->statut === 'accepte'): ?>
                            <span class="badge bg-success">Acceptée</span>
                        <?php elseif ($item->statut === 'refuse'): ?>
                            <span class="badge bg-danger">Refusée</span>
                        <?php else: ?>
                            <span class="badge bg-warning">En attente</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <?= $this->Html->link('Voir', ['action' => 'view', $item->id], ['class' => 'btn btn-light btn-sm']) ?>
                        <?php if ($user && $user->id === $item->cree_par && $item->statut === 'en_attente'): ?>
                            <?= $this->Html->link('Accepter', ['action' => 'accepter', $item->id], ['class' => 'btn btn-success btn-sm']) ?>
                            <?= $this->Html->link('Refuser', ['action' => 'refuser', $item->id], ['class' => 'btn btn-danger btn-sm']) ?>
                        <?php endif; ?>
                        <?php if ($user && $user->role === 'admin'): ?>
                            <?= $this->Html->link('Modifier', ['action' => 'edit', $item->id], ['class' => 'btn btn-info btn-sm']) ?>
                            <?= $this->Form->postLink(
                                'Supprimer',
                                ['action' => 'delete', $item->id],
                                ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer cette planification ?', 'class' => 'btn btn-danger btn-sm']
                            ) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< Premier') ?>
            <?= $this->Paginator->prev('< Précédent') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('Suivant >') ?>
            <?= $this->Paginator->last('Dernier >>') ?>
        </ul>
        <p><?= $this->Paginator->counter('Page {{page}} sur {{pages}}, {{current}} résultat(s) sur {{count}}') ?></p>
    </div>
</div>