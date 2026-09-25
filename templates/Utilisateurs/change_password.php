<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Changer le mot de passe');
?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3>Changer le mot de passe</h3></div>
            <div class="card-body">
                <?= $this->Form->create(null) ?>
                <div class="mb-3">
                    <?= $this->Form->control('current_password', ['type' => 'password', 'label' => 'Mot de passe actuel', 'required' => true]) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('new_password', ['type' => 'password', 'label' => 'Nouveau mot de passe', 'required' => true]) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('confirm_password', ['type' => 'password', 'label' => 'Confirmer le nouveau mot de passe', 'required' => true]) ?>
                </div>
                <div class="d-grid">
                    <?= $this->Form->button('Changer le mot de passe', ['class' => 'btn btn-primary']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>