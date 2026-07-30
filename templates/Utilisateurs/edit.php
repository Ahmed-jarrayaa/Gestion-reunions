<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Utilisateur $utilisateur
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $utilisateur->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $utilisateur->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Utilisateurs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="utilisateurs form content">
            <?= $this->Form->create($utilisateur) ?>
            <fieldset>
                <legend><?= __('Edit Utilisateur') ?></legend>
                <?php
                    echo $this->Form->control('nom');
                    echo $this->Form->control('email');
                    echo $this->Form->control('role');
                    echo $this->Form->control('mot_de_passe');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
