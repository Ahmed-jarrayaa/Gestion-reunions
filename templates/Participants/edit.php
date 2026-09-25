<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant $participant
 */
?>
<div class="card" style="max-width:620px;">
    <div class="card-header">
        <h4 style="margin:0;">Modifier une participation</h4>
    </div>
    <div class="card-body">
        <?= $this->Form->create($participant) ?>
        <fieldset>
            <?php
                echo $this->Form->control('id_reunion', ['label' => 'Réunion', 'options' => $reunions]);
                echo $this->Form->control('id_utilisateur', ['label' => 'Utilisateur', 'options' => $utilisateurs]);
                echo $this->Form->control('presence', ['label' => 'Présence']);
            ?>
        </fieldset>
        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:16px;">
            <?= $this->Form->button('Enregistrer', ['class' => 'btn btn-primary']) ?>
            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $participant->id], ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer cette participation ?', 'class' => 'btn btn-danger']) ?>
            <?= $this->Html->link('Annuler', ['action' => 'index'], ['class' => 'btn btn-light']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
