<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Créer un compte');
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h3 class="text-center">Créer un compte</h3></div>
            <div class="card-body">
                <?= $this->Form->create($utilisateur) ?>
                    <div class="mb-3">
                        <?= $this->Form->control('nom', [
                            'label' => 'Nom complet',
                            'required' => true,
                            'autofocus' => true,
                        ]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('email', [
                            'label' => 'Adresse email',
                            'type' => 'email',
                            'required' => true,
                        ]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('mot_de_passe', [
                            'label' => 'Mot de passe',
                            'type' => 'password',
                            'required' => true,
                        ]) ?>
                        <small class="text-muted">6 caractères minimum.</small>
                    </div>
                    <div class="d-grid">
                        <?= $this->Form->submit('S\'inscrire', ['class' => 'btn btn-primary']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
            <div class="card-footer text-center">
                <small class="text-muted">
                    Déjà un compte ?
                    <?= $this->Html->link('Se connecter', ['action' => 'login']) ?>
                </small>
            </div>
        </div>
    </div>
</div>