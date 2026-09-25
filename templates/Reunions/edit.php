<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reunion $reunion
 */
?>
<div class="card" style="max-width:680px;">
    <div class="card-header"><h4 style="margin:0;">Modifier la réunion</h4></div>
    <div class="card-body">
        <?= $this->Form->create($reunion, ['class' => 'form']) ?>
        <?= $this->Form->control('titre', ['label' => 'Titre']) ?>
        <?= $this->Form->control('description', ['label' => 'Description']) ?>
        <?= $this->Form->control('date_heure', ['label' => 'Date & heure']) ?>
        <?= $this->Form->control('lieu', ['label' => 'Lieu']) ?>
        <?= $this->Form->control('statut', ['label' => 'Statut']) ?>
        <?= $this->Form->control('id_type', ['label' => 'Type de réunion']) ?>

        <div style="display:flex; gap:10px; margin-top:18px;">
            <?= $this->Form->button('Enregistrer', ['class' => 'btn btn-primary']) ?>
            <a class="btn btn-light" href="<?= $this->Url->build(['action' => 'index']) ?>">Annuler</a>
            <?= $this->Form->postLink(
                'Supprimer',
                ['action' => 'delete', $reunion->id],
                ['confirm' => 'Êtes-vous sûr de vouloir supprimer cette réunion ?', 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>