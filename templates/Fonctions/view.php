<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fonction $fonction
 */
?>
<div class="card" style="max-width:820px;">
    <div class="card-header">
        <h4 style="margin:0;">Fonction : <?= h($fonction->nom) ?></h4>
    </div>
    <div class="card-body">
        <table>
            <tr>
                <th style="width:38%;">Nom</th>
                <td><?= h($fonction->nom) ?></td>
            </tr>
        </table>

        <?php if (!empty($fonction->utilisateurs)) : ?>
            <h4 style="margin-top:24px;">Membres ayant cette fonction</h4>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th class="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fonction->utilisateurs as $utilisateur) : ?>
                        <tr>
                            <td><?= h($utilisateur->nom) ?></td>
                            <td><?= h($utilisateur->email) ?></td>
                            <td><?= h($utilisateur->role) ?></td>
                            <td class="actions">
                                <?= $this->Html->link('Voir', ['controller' => 'Utilisateurs', 'action' => 'view', $utilisateur->id], ['class' => 'btn btn-light btn-sm']) ?>
                                <?= $this->Html->link('Modifier', ['controller' => 'Utilisateurs', 'action' => 'edit', $utilisateur->id], ['class' => 'btn btn-info btn-sm']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:18px;">
            <?= $this->Html->link('&larr; Retour aux fonctions', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-light btn-sm']) ?>
            <?= $this->Html->link('Modifier', ['action' => 'edit', $fonction->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= $this->Form->postLink(
                'Supprimer',
                ['action' => 'delete', $fonction->id],
                [
                    'method' => 'delete',
                    'confirm' => 'Voulez-vous vraiment supprimer cette fonction ?',
                    'class' => 'btn btn-danger btn-sm',
                ]
            ) ?>
        </div>
    </div>
</div>
