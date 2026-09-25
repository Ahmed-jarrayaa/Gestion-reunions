<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Planification $planification
 */
?>
<div class="card" style="max-width:820px;">
    <div class="card-header">
        <h4 style="margin:0;">Planification : <?= h($planification->titre) ?></h4>
    </div>
    <div class="card-body">
        <table>
            <tr>
                <th style="width:38%;">Titre</th>
                <td><?= h($planification->titre) ?></td>
            </tr>
            <tr>
                <th>Lieu</th>
                <td><?= h($planification->lieu) ?></td>
            </tr>
            <tr>
                <th>Date planifiée</th>
                <td><?= h($planification->date_planification) ?></td>
            </tr>
            <tr>
                <th>Créée par (id)</th>
                <td><?= $this->Number->format($planification->cree_par) ?></td>
            </tr>
            <tr>
                <th>Type (id)</th>
                <td><?= $this->Number->format($planification->id_type) ?></td>
            </tr>
            <tr>
                <th>Statut</th>
                <td>
                    <?php if ($planification->statut === 'accepte'): ?>
                        <span class="badge" style="background-color:#28a745; color:white;">Acceptée</span>
                    <?php elseif ($planification->statut === 'refuse'): ?>
                        <span class="badge" style="background-color:#dc3545; color:white;">Refusée</span>
                    <?php else: ?>
                        <span class="badge" style="background-color:#ffc107; color:black;">En attente</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:18px;">
            <?= $this->Html->link('&larr; Retour aux planifications', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-light btn-sm']) ?>
            <?php $user = $this->request->getAttribute('identity'); ?>
            <?php if ($user && $user->role === 'admin'): ?>
                <?= $this->Html->link('Modifier', ['action' => 'edit', $planification->id], ['class' => 'btn btn-primary btn-sm']) ?>
                <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $planification->id], ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer cette planification ?', 'class' => 'btn btn-danger btn-sm']) ?>
            <?php elseif ($user && $user->id === $planification->cree_par && $planification->statut === 'en_attente'): ?>
                <?= $this->Html->link('Accepter', ['action' => 'accepter', $planification->id], ['class' => 'btn btn-success btn-sm']) ?>
                <?= $this->Html->link('Refuser', ['action' => 'refuser', $planification->id], ['class' => 'btn btn-danger btn-sm']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
