<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Fonction> $fonctions
 */
?>
<div class="card" style="max-width:1000px;">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h4 style="margin:0;">Fonctions</h4>
        <a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['action' => 'add']) ?>">+ Nouvelle fonction</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nom') ?></th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fonctions as $fonction): ?>
                <tr>
                    <td><?= $this->Number->format($fonction->id) ?></td>
                    <td><?= h($fonction->nom) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('Voir', ['action' => 'view', $fonction->id], ['class' => 'btn btn-light btn-sm']) ?>
                        <?= $this->Html->link('Modifier', ['action' => 'edit', $fonction->id], ['class' => 'btn btn-info btn-sm']) ?>
                        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $fonction->id], ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer cette entrée ?', 'class' => 'btn btn-danger btn-sm']) ?>
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
