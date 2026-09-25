<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Planification $planif
 * @var array $types
 * @var array $utilisateurs
 */

$entity = isset($planif) ? $planif : $planification;
?>
<div class="card" style="max-width:680px;">
    <div class="card-header"><h4 style="margin:0;">Nouvelle planification</h4></div>
    <div class="card-body">
        <?= $this->Form->create($entity, ['class' => 'form']) ?>

        <?= $this->Form->control('titre', ['label' => 'Titre']) ?>
        <?= $this->Form->control('date_planification', [
            'label' => 'Date et heure',
            'type' => 'datetime-local',
            'value' => $entity->date_planification ? date('Y-m-d\TH:i', strtotime($entity->date_planification)) : ''
        ]) ?>
        <?= $this->Form->control('lieu', ['label' => 'Lieu']) ?>
        <?= $this->Form->control('id_type', [
            'label' => 'Type de réunion',
            'type' => 'select',
            'options' => $types,
            'empty' => '-- Sélectionner --'
        ]) ?>

        <h4 style="margin:18px 0 8px;">Participants à inviter</h4>

        <?php if (!empty($participantEmails)): ?>
            <p><strong>Participants déjà ajoutés par le créateur :</strong></p>
            <ul>
                <?php foreach ($participantEmails as $email): ?>
                    <li><?= h($email) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php foreach ($utilisateurs as $id => $email): ?>
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                <input type="checkbox"
                       name="participants_ids[]"
                       value="<?= $id ?>"
                       id="participant-<?= $id ?>"
                       <?= in_array($id, $selectedParticipants ?? []) ? 'checked' : '' ?>>
                <label for="participant-<?= $id ?>" style="margin:0;"><?= h($email) ?></label>
            </div>
        <?php endforeach; ?>

        <div style="display:flex; gap:10px; margin-top:18px;">
            <?= $this->Form->button('Enregistrer', ['class' => 'btn btn-primary']) ?>
            <a class="btn btn-light" href="<?= $this->Url->build(['action' => 'index']) ?>">Annuler</a>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>