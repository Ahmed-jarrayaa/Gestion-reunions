<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reunion $reunion
 * @var array $utilisateurs
 */
?>
<div class="card" style="max-width:680px;">
    <div class="card-header">
        <h4 style="margin:0;">Ajouter des participants à la réunion</h4>
    </div>
    <div class="card-body">
        <p style="margin-top:0;"><strong><?= h($reunion->titre) ?></strong> &nbsp;&middot;&nbsp;
            <?= $reunion->date_heure ? h($reunion->date_heure->format('d/m/Y H:i')) : '' ?>
            <?= $reunion->lieu ? ' &nbsp;&middot;&nbsp; ' . h($reunion->lieu) : '' ?>
        </p>

        <?= $this->Form->create(null, ['class' => 'form']) ?>

        <h4 style="margin:0 0 8px;">Choisissez les participants</h4>
        <?php foreach ($utilisateurs as $id => $email): ?>
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                <?= $this->Form->checkbox('utilisateurs[]', [
                    'label' => false,
                    'value' => $id,
                    'id' => 'utilisateur-' . $id,
                ]) ?>
                <label for="utilisateur-<?= $id ?>" style="margin:0;"><?= h($email) ?></label>
            </div>
        <?php endforeach; ?>

        <div style="display:flex; gap:10px; margin-top:18px;">
            <?= $this->Form->button('Ajouter', ['class' => 'btn btn-primary']) ?>
            <a class="btn btn-light" href="<?= $this->Url->build(['action' => 'select']) ?>">Annuler</a>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>