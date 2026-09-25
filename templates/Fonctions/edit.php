<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fonction $fonction
 */
?>
<div class="card" style="max-width:620px;">
    <div class="card-header">
        <h4 style="margin:0;">Modifier une fonction</h4>
    </div>
    <div class="card-body">
        <?= $this->Form->create($fonction) ?>
        <fieldset>
            <?php
                echo $this->Form->control('nom', ['label' => 'Nom']);
            ?>
        </fieldset>
        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:16px;">
            <?= $this->Form->button('Enregistrer', ['class' => 'btn btn-primary']) ?>
            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $fonction->id], ['confirm' => 'Voulez-vous vraiment supprimer cette fonction ?', 'class' => 'btn btn-danger']) ?>
            <?= $this->Html->link('Annuler', ['action' => 'index'], ['class' => 'btn btn-light']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
