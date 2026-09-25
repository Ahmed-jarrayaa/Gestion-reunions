<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Utilisateur $utilisateur
 */
$this->assign('title', 'Modifier le profil');
$user = $this->request->getAttribute('identity');
$isAdmin = $user && $user->role === 'admin';
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Modifier le profil</h3>
            </div>
            <div class="card-body">
                <?= $this->Form->create($utilisateur) ?>
                    <div class="mb-3">
                        <?= $this->Form->control('nom', ['label' => 'Nom complet', 'required' => true]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('email', ['label' => 'Adresse email', 'type' => 'email', 'required' => true]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('mot_de_passe', [
                            'label' => 'Nouveau mot de passe',
                            'type' => 'password',
                            'placeholder' => 'Laisser vide pour ne pas changer',
                        ]) ?>
                    </div>
                    <?php if ($isAdmin): ?>
                        <div class="mb-3">
                            <?= $this->Form->control('role', [
                                'label' => 'Rôle',
                                'options' => ['admin' => 'Administrateur', 'membre' => 'Membre'],
                            ]) ?>
                        </div>
                    <?php endif; ?>
                    <div class="actions">
                        <?= $this->Form->button('Enregistrer', ['class' => 'btn btn-primary']) ?>
                        <?= $this->Html->link('Annuler', ['action' => 'view', $utilisateur->id], ['class' => 'btn btn-light']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>