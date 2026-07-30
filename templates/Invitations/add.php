<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invitation $invitation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Invitations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invitations form content">
            <?= $this->Form->create($invitation) ?>
            <fieldset>
                <legend><?= __('Add Invitation') ?></legend>
                <?php
                    echo $this->Form->control('id_reunion');
                    echo $this->Form->control('email');
                    echo $this->Form->control('statut');
                    echo $this->Form->control('date_envoi', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
