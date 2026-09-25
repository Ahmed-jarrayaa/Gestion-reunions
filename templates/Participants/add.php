<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Planification $planification
 * @var array $utilisateurs Liste des utilisateurs ['id' => 'email']
 * @var array $selectedParticipants Ids des participants déjà présents
 * @var array $types Liste des types de réunion ['id' => 'nom_type']
 * @var int|null $idReunion
 */
?>
<div class="card" style="max-width:680px;">
    <div class="card-header"><h4 style="margin:0;">Créer une planification</h4></div>
    <div class="card-body">
        <?= $this->Form->create($planification, ['class' => 'form']) ?>

        <?= $this->Form->control('titre', ['label' => 'Titre']) ?>
        <?= $this->Form->control('date_planification', [
            'label' => 'Date et heure',
            'type' => 'datetime-local',
            'value' => $planification->date_planification ? $planification->date_planification->format('Y-m-d\TH:i') : ''
        ]) ?>
        <?= $this->Form->control('lieu', ['label' => 'Lieu']) ?>
        <?= $this->Form->control('id_type', [
            'label' => 'Type de réunion',
            'type' => 'select',
            'options' => $types,
            'empty' => '-- Sélectionner --'
        ]) ?>

        <h4 style="margin:18px 0 8px;">Participants à inviter</h4>
        <?php foreach ($utilisateurs as $id => $email): ?>
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                <?= $this->Form->checkbox('participants_planifications[][id_utilisateur]', [
                    'label' => false,
                    'value' => $id,
                    'checked' => in_array($id, $selectedParticipants),
                    'id' => 'participant-' . $id,
                ]) ?>
                <label for="participant-<?= $id ?>" style="margin:0;"><?= h($email) ?></label>
            </div>
        <?php endforeach; ?>

        <div style="display:flex; gap:10px; margin-top:18px;">
            <?= $this->Form->button('Enregistrer', ['class' => 'btn btn-primary']) ?>
            <a class="btn btn-light" href="<?= $this->Url->build(['controller' => 'Participants', 'action' => 'index']) ?>">Annuler</a>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>