<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Planification $planification
 */
?>
<div class="card" style="max-width:680px;">
    <div class="card-header">
        <h4 style="margin:0;">Modifier une planification</h4>
    </div>
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
                <?= $this->Form->checkbox('participants_planifications[][id_utilisateur]', ['value' => $id]) ?>
                <label style="margin:0;"><?= h($email) ?></label>
            </div>
        <?php endforeach; ?>

        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:16px;">
            <?= $this->Form->button('Enregistrer', ['class' => 'btn btn-primary']) ?>
            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $planification->id], ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer cette planification ?', 'class' => 'btn btn-danger']) ?>
            <?= $this->Html->link('Annuler', ['action' => 'index'], ['class' => 'btn btn-light']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>