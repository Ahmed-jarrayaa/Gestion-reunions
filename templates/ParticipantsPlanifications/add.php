<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ParticipantsPlanification $participantsPlanification
 */
?>
<div class="card" style="max-width:620px;">
    <div class="card-header">
        <h4 style="margin:0;">Nouvelle participation planifiée</h4>
    </div>
    <div class="card-body">
        <?= $this->Form->create($participantsPlanification) ?>
        <fieldset>
            <?php
                echo $this->Form->control('id_planification', ['label' => 'Planification']);
                echo $this->Form->control('id_utilisateur', ['label' => 'Utilisateur']);
                echo $this->Form->control('presence', ['label' => 'Présence']);
            ?>
        </fieldset>
        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:16px;">
            <?= $this->Form->button('Enregistrer', ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link('Annuler', ['action' => 'index'], ['class' => 'btn btn-light']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
