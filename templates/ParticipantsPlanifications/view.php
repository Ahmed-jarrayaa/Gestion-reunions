<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ParticipantsPlanification $participantsPlanification
 */
?>
<div class="card" style="max-width:820px;">
    <div class="card-header">
        <h4 style="margin:0;">Participation planifiée #<?= $this->Number->format($participantsPlanification->id) ?></h4>
    </div>
    <div class="card-body">
        <table>
            <tr>
                <th style="width:38%;">Planification</th>
                <td><?= $participantsPlanification->planification === null ? '' : h($participantsPlanification->planification->titre) ?></td>
            </tr>
            <tr>
                <th>Utilisateur</th>
                <td><?= $participantsPlanification->utilisateur === null ? '' : h($participantsPlanification->utilisateur->email) ?></td>
            </tr>
            <tr>
                <th>Présence</th>
                <td><?= $participantsPlanification->presence ? 'Oui' : 'Non'; ?></td>
            </tr>
        </table>

        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:18px;">
            <?= $this->Html->link('&larr; Retour', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-light btn-sm']) ?>
            <?= $this->Html->link('Modifier', ['action' => 'edit', $participantsPlanification->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $participantsPlanification->id], ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer cette participation ?', 'class' => 'btn btn-danger btn-sm']) ?>
        </div>
    </div>
</div>
