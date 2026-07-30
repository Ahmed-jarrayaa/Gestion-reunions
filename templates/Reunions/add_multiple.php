<h2>Ajouter des participants à la réunion : <?= h($reunion->titre) ?></h2>

<?= $this->Form->create(null) ?>

<?= $this->Form->control('utilisateurs', [
    'type' => 'select',
    'multiple' => 'checkbox',
    'options' => $utilisateurs,
    'label' => 'Choisissez les participants'
]) ?>

<?= $this->Form->button('Ajouter') ?>
<?= $this->Form->end() ?>
