<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="text-center">Créer un compte</h3>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($utilisateur) ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control('prenom', [
                                    'label' => 'Prénom',
                                    'class' => 'form-control',
                                    'required' => true
                                ]) ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control('nom', [
                                    'label' => 'Nom',
                                    'class' => 'form-control',
                                    'required' => true
                                ]) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('email', [
                                'label' => 'Adresse email',
                                'type' => 'email',
                                'class' => 'form-control',
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('mot_de_passe', [
                                'label' => 'Mot de passe',
                                'type' => 'password',
                                'class' => 'form-control',
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="d-grid">
                            <?= $this->Form->submit('S\'inscrire', [
                                'class' => 'btn btn-success'
                            ]) ?>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
                <div class="card-footer text-center">
                    <small>
                        Déjà un compte ? 
                        <?= $this->Html->link('Se connecter', ['action' => 'login']) ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>