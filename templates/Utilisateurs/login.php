<body class="login-page dark-mode">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center">Connexion</h3>
                </div>
                <div class="card-body">
                    <?= $this->Flash->render() ?>
                    <?= $this->Form->create() ?>
                        <div class="mb-3">
                            <?= $this->Form->control('email', [
                                'label' => 'Adresse email',
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
                            <?= $this->Form->submit('Se connecter', [
                                'class' => 'btn btn-primary'
                            ]) ?>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
                <div class="card-footer text-center">
                    <small>
                        Pas encore de compte ? 
                        <?= $this->Html->link('Créer un compte', ['action' => 'add']) ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
