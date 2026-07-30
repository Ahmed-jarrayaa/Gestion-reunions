<?= $this->Form->create($planification) ?>
<fieldset>
    <legend><?= __('Informations de la planification') ?></legend>

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

        <h4>Participants à inviter</h4>
<?php foreach ($utilisateurs as $id => $email): ?>
    <label>
        <?= $this->Form->checkbox('participants_planifications[][id_utilisateur]', ['value' => $id]) ?>
        <?= h($email) ?>
    </label><br>
<?php endforeach; ?>
</fieldset>

<?= $this->Form->button(__('Enregistrer')) ?>
<?= $this->Form->end() ?>
