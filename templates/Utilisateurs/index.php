<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Utilisateur> $utilisateurs
 */
?>
<div class="card" style="max-width:1000px;">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h4 style="margin:0;">Utilisateurs</h4>
        <a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['action' => 'add']) ?>">+ Nouvel utilisateur</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nom') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('role') ?></th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $utilisateur): ?>
                <tr>
                    <td><?= $this->Number->format($utilisateur->id) ?></td>
                    <td><?= h($utilisateur->nom) ?></td>
                    <td><?= h($utilisateur->email) ?></td>
                    <td>
                        <?php if ($utilisateur->role === 'admin'): ?>
                            <span class="badge" style="background-color:#dc3545; color:white;">Admin</span>
                        <?php else: ?>
                            <span class="badge" style="background-color:#17a2b8; color:white;">Membre</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <?= $this->Html->link('Voir', ['action' => 'view', $utilisateur->id], ['class' => 'btn btn-light btn-sm']) ?>
                        <?= $this->Html->link('Modifier', ['action' => 'edit', $utilisateur->id], ['class' => 'btn btn-info btn-sm']) ?>
                        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $utilisateur->id], ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer cet utilisateur ?', 'class' => 'btn btn-danger btn-sm']) ?>
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
