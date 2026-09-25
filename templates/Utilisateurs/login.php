<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Connexion');
?>
<div class="login-page">
    <div class="card login-card">
        <div class="card-header">
            <h3 class="text-center">Connexion</h3>
        </div>
        <div class="card-body">
            <?= $this->Form->create() ?>
            <div class="mb-3">
                <?= $this->Form->control('email', [
                    'label' => 'Adresse email',
                    'type' => 'email',
                    'required' => true,
                    'autofocus' => true,
                ]) ?>
            </div>
            <div class="mb-3">
                <?= $this->Form->control('mot_de_passe', [
                    'label' => 'Mot de passe',
                    'type' => 'password',
                    'required' => true,
                ]) ?>
            </div>
            <div class="d-grid">
                <?= $this->Form->submit('Se connecter', ['class' => 'btn btn-primary']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
        <div class="card-footer text-center">
            <small class="text-muted">
                Pas encore de compte ?
                <?= $this->Html->link('Créer un compte', ['action' => 'add']) ?>
            </small>
        </div>
    </div>
</div>