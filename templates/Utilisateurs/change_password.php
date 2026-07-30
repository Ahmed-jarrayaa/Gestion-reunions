<h2>Changer le mot de passe</h2>

<?= $this->Form->create(null) ?>
    <div>
        <?= $this->Form->control('current_password', ['type' => 'password', 'label' => 'Mot de passe actuel']) ?>
    </div>
    <div>
        <?= $this->Form->control('new_password', ['type' => 'password', 'label' => 'Nouveau mot de passe']) ?>
    </div>
    <div>
        <?= $this->Form->control('confirm_password', ['type' => 'password', 'label' => 'Confirmer le nouveau mot de passe']) ?>
    </div>
    <?= $this->Form->button('Changer le mot de passe') ?>
<?= $this->Form->end() ?>
