<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant $participant
 * @var array $reunions Liste des réunions ['id' => 'titre']
 * @var array $utilisateurs Liste des utilisateurs ['id' => 'email']
 */
?>

<h3>Ajouter un participant</h3>

<?= $this->Form->create($participant) ?>

<?= $this->Form->control('id_reunion', [
    'label' => 'Réunion',
    'options' => $reunions,
    'empty' => 'Sélectionnez une réunion',
]) ?>

<?= $this->Form->control('id_utilisateur', [
    'label' => 'Utilisateur',
    'options' => $utilisateurs,
    'empty' => 'Sélectionnez un utilisateur',
]) ?>

<?= $this->Form->control('presence', [
    'label' => 'Présence',
    'type' => 'checkbox'
]) ?>

<?= $this->Form->button('Enregistrer') ?>
<?= $this->Form->end() ?>
