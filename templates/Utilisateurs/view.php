<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Utilisateur $utilisateur
 */
?>
<div class="card" style="max-width:820px;">
    <div class="card-header">
        <h4 style="margin:0;">Utilisateur : <?= h($utilisateur->nom) ?></h4>
    </div>
    <div class="card-body">
        <table>
            <tr>
                <th style="width:38%;">Nom</th>
                <td><?= h($utilisateur->nom) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= h($utilisateur->email) ?></td>
            </tr>
            <tr>
                <th>Rôle</th>
                <td>
                    <?php if ($utilisateur->role === 'admin'): ?>
                        <span class="badge" style="background-color:#dc3545; color:white;">Admin</span>
                    <?php else: ?>
                        <span class="badge" style="background-color:#17a2b8; color:white;">Membre</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Fonction</th>
                <td><?= isset($utilisateur->fonction) && $utilisateur->fonction !== null ? h($utilisateur->fonction->nom) : '' ?></td>
            </tr>
        </table>

        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:18px;">
            <?= $this->Html->link('&larr; Retour aux utilisateurs', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-light btn-sm']) ?>
            <?php $user = $this->request->getAttribute('identity'); ?>
            <?php if ($user && ($user->role === 'admin' || $user->id === $utilisateur->id)): ?>
                <?= $this->Html->link('Modifier', ['action' => 'edit', $utilisateur->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?php endif; ?>
            <?php if ($user && $user->role === 'admin'): ?>
                <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $utilisateur->id], ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer cet utilisateur ?', 'class' => 'btn btn-danger btn-sm']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
