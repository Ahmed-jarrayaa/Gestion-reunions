<h3><?= __('Créer une Réunion') ?></h3>

<?= $this->Form->create($reunion) ?>

<!-- Champs réunion -->
<?= $this->Form->control('titre', ['label' => 'Titre de la réunion']) ?>
<?= $this->Form->control('description', ['type' => 'textarea', 'label' => 'Description']) ?>
<?= $this->Form->control('date_heure', ['label' => 'Date & Heure']) ?>
<?= $this->Form->control('lieu', ['label' => 'Lieu']) ?>

<!-- Type de réunion -->
<?= $this->Form->control('id_type', [
    'type' => 'select',
    'options' => $types,
    'empty' => 'Sélectionnez un type',
    'label' => 'Type de réunion'
]) ?>

<!-- Participants à cocher -->
<h4>Sélectionner des participants :</h4>
<?php foreach ($utilisateurs as $id => $email): ?>
    <label>
        <input type="checkbox" name="participants_ids[]" value="<?= $id ?>">
        <?= h($email) ?>
    </label><br>
<?php endforeach; ?>

<?= $this->Form->button(__('Proposer la réunion')) ?>
<?= $this->Form->end() ?>
