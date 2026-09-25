<div class="card" style="max-width:680px;">
    <div class="card-header"><h4 style="margin:0;">Créer une réunion</h4></div>
    <div class="card-body">
        <?= $this->Form->create($reunion, ['class' => 'form']) ?>

        <?= $this->Form->control('titre', ['label' => 'Titre de la réunion']) ?>
        <?= $this->Form->control('description', ['type' => 'textarea', 'label' => 'Description']) ?>
        <?= $this->Form->control('date_heure', ['label' => 'Date & heure']) ?>
        <?= $this->Form->control('lieu', ['label' => 'Lieu']) ?>
        <?= $this->Form->control('id_type', [
            'type' => 'select',
            'options' => $types,
            'empty' => 'Sélectionnez un type',
            'label' => 'Type de réunion'
        ]) ?>

        <h4 style="margin:18px 0 8px;">Sélectionner des participants :</h4>
        <?php foreach ($utilisateurs as $id => $email): ?>
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                <input type="checkbox" name="participants_ids[]" value="<?= $id ?>" id="participant-<?= $id ?>">
                <label for="participant-<?= $id ?>" style="margin:0;"><?= h($email) ?></label>
            </div>
        <?php endforeach; ?>

        <div style="display:flex; gap:10px; margin-top:18px;">
            <?= $this->Form->button('Proposer la réunion', ['class' => 'btn btn-primary']) ?>
            <a class="btn btn-light" href="<?= $this->Url->build(['action' => 'index']) ?>">Annuler</a>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>