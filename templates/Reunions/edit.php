<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reunion $reunion
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Supprimer'),
                ['action' => 'delete', $reunion->id],
                ['confirm' => __('Êtes-vous sûr de vouloir supprimer la réunion #{0} ?', $reunion->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('Liste des Réunions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reunions form content">
            <?= $this->Form->create($reunion) ?>
            <fieldset>
                <legend><?= __('Modifier la Réunion') ?></legend>
                <?php
                    echo $this->Form->control('titre');
                    echo $this->Form->control('description');
                    echo $this->Form->control('date_heure');
                    echo $this->Form->control('lieu');
                    echo $this->Form->control('statut');
                    // Ne pas permettre de modifier le créateur :
                    // echo $this->Form->control('cree_par');
                    echo $this->Form->control('id_type', ['label' => 'Type de Réunion']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Enregistrer')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
