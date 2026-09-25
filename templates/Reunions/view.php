<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reunion $reunion
 */
$user = $this->request->getAttribute('identity');
$peutModifier = ($user && ($user->role === 'admin' || $user->id === $reunion->cree_par));
$nomType = isset($reunion->type_reunion) ? h($reunion->type_reunion->nom_type) : (isset($reunion->types_reunion) ? h($reunion->types_reunion->nom_type) : '');
?>
<div class="card" style="max-width:820px;">
    <div class="card-header">
        <h4 style="margin:0;"><?= h($reunion->titre) ?></h4>
        <span class="badge <?= $reunion->statut === 'valider' ? 'bg-success' : ($reunion->statut === 'en_attente' ? 'bg-warning' : 'bg-secondary') ?>">
            <?= h($reunion->statut ?? '') ?>
        </span>
    </div>

    <table class="table">
        <tr>
            <th style="width:38%;">Titre</th>
            <td><?= h($reunion->titre) ?></td>
        </tr>
        <tr>
            <th>Lieu</th>
            <td><?= h($reunion->lieu) ?></td>
        </tr>
        <tr>
            <th>Date et heure</th>
            <td><?= $reunion->date_heure ? h($reunion->date_heure->format('d/m/Y H:i')) : '' ?></td>
        </tr>
        <tr>
            <th>Type</th>
            <td><?= $nomType ?></td>
        </tr>
        <tr>
            <th>Statut</th>
            <td><?= h($reunion->statut ?? '') ?></td>
        </tr>
    </table>

    <div class="text" style="margin:16px 0;">
        <strong>Description</strong>
        <?= $this->Text->autoParagraph(h($reunion->description)); ?>
    </div>

    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:18px;">
        <a class="btn btn-light btn-sm" href="<?= $this->Url->build(['action' => 'index']) ?>">&larr; Retour aux réunions</a>
        <?php if ($peutModifier): ?>
            <a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['action' => 'edit', $reunion->id]) ?>">Modifier</a>
            <?= $this->Form->postLink(
                'Supprimer',
                ['action' => 'delete', $reunion->id],
                [
                    'confirm' => 'Voulez-vous vraiment supprimer cette réunion ?',
                    'class' => 'btn btn-danger btn-sm'
                ]
            ) ?>
        <?php endif; ?>
    </div>
</div>