<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypesReunion $typesReunion
 */
?>
<div class="card" style="max-width:620px;">
    <div class="card-header">
        <h4 style="margin:0;">Nouveau type de réunion</h4>
    </div>
    <div class="card-body">
        <?= $this->Form->create($typesReunion) ?>
        <fieldset>
            <?php
                echo $this->Form->control('nom_type', ['label' => 'Nom du type']);
                echo $this->Form->control('description', ['label' => 'Description']);
            ?>
        </fieldset>
        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:16px;">
            <?= $this->Form->button('Enregistrer', ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link('Annuler', ['action' => 'index'], ['class' => 'btn btn-light']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
