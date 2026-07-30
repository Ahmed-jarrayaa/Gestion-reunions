<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Planification $planif
 * @var array $types
 * @var array $utilisateurs
 */

$entity = isset($planif) ? $planif : $planification;
?>

<?= $this->Form->create($entity) ?>
<fieldset>
    <legend><?= __('Informations de la planification') ?></legend>

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

    <h4>Participants à inviter</h4>

<?php if (!empty($participantEmails)): ?>
    <p><strong>Participants déjà ajoutés par le créateur :</strong></p>
    <ul>
        <?php foreach ($participantEmails as $email): ?>
            <li><?= h($email) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php foreach ($utilisateurs as $id => $email): ?>
    <label>
        <input type="checkbox" 
               name="participants_ids[]" 
               value="<?= $id ?>" 
               <?= in_array($id, $selectedParticipants ?? []) ? 'checked' : '' ?>>
        <?= h($email) ?>
    </label><br>
<?php endforeach; ?>


</fieldset>

<?= $this->Form->button(__('Enregistrer')) ?>
<?= $this->Form->end() ?>
