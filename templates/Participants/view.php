<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant $participant
 */
?>
<div class="card" style="max-width:820px;">
    <div class="card-header">
        <h4 style="margin:0;">Participation #<?= $this->Number->format($participant->id) ?></h4>
    </div>
    <div class="card-body">
        <table>
            <tr>
                <th style="width:38%;">Réunion</th>
                <td><?= $participant->reunion === null ? '' : h($participant->reunion->titre) ?></td>
            </tr>
            <tr>
                <th>Utilisateur</th>
                <td><?= $participant->utilisateur === null ? '' : h($participant->utilisateur->email) ?></td>
            </tr>
            <tr>
                <th>Présence</th>
                <td><?= h($participant->presence) ?></td>
            </tr>
            <tr>
                <th>Id réunion</th>
                <td><?= $participant->id_reunion === null ? '' : $this->Number->format($participant->id_reunion) ?></td>
            </tr>
            <tr>
                <th>Id utilisateur</th>
                <td><?= $participant->id_utilisateur === null ? '' : $this->Number->format($participant->id_utilisateur) ?></td>
            </tr>
        </table>

        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:18px;">
            <?= $this->Html->link('&larr; Retour aux participants', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-light btn-sm']) ?>
            <?= $this->Html->link('Modifier', ['action' => 'edit', $participant->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $participant->id], ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer cette participation ?', 'class' => 'btn btn-danger btn-sm']) ?>
        </div>
    </div>
</div>
