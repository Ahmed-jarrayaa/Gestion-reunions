<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\TypesReunion> $typesReunions
 */
?>
<div class="card" style="max-width:1000px;">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h4 style="margin:0;">Types de réunions</h4>
        <a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['action' => 'add']) ?>">+ Nouveau type</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nom_type') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($typesReunions as $typesReunion): ?>
                <tr>
                    <td><?= $this->Number->format($typesReunion->id) ?></td>
                    <td><?= h($typesReunion->nom_type) ?></td>
                    <td><?= h($typesReunion->description) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('Voir', ['action' => 'view', $typesReunion->id], ['class' => 'btn btn-light btn-sm']) ?>
                        <?= $this->Html->link('Modifier', ['action' => 'edit', $typesReunion->id], ['class' => 'btn btn-info btn-sm']) ?>
                        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $typesReunion->id], ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer ce type ?', 'class' => 'btn btn-danger btn-sm']) ?>
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
