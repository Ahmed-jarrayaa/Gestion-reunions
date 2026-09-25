<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypesReunion $typesReunion
 */
?>
<div class="card" style="max-width:820px;">
    <div class="card-header">
        <h4 style="margin:0;">Type de réunion : <?= h($typesReunion->nom_type) ?></h4>
    </div>
    <div class="card-body">
        <table>
            <tr>
                <th style="width:38%;">Nom du type</th>
                <td><?= h($typesReunion->nom_type) ?></td>
            </tr>
            <tr>
                <th>Description</th>
                <td><?= $this->Text->autoParagraph(h($typesReunion->description)); ?></td>
            </tr>
        </table>

        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:18px;">
            <?= $this->Html->link('&larr; Retour aux types', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-light btn-sm']) ?>
            <?= $this->Html->link('Modifier', ['action' => 'edit', $typesReunion->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $typesReunion->id], ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer ce type de réunion ?', 'class' => 'btn btn-danger btn-sm']) ?>
        </div>
    </div>
</div>
