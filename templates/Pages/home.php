<?php
/**
 * @var \App\View\AppView $this
 */
$user = $this->request->getAttribute('identity');
?>
<div class="container">
    <div class="landing-hero">
        <h1>Bienvenue sur MeetFlow</h1>
        <p>Planifiez, organisez et validez toutes vos réunions au même endroit.</p>
        <?php if ($user): ?>
            <a href="<?= $this->Url->build('/dashboard') ?>" class="btn">Accéder à mon tableau de bord</a>
        <?php else: ?>
            <a href="<?= $this->Url->build(['controller' => 'Utilisateurs', 'action' => 'login']) ?>" class="btn">Se connecter</a>
        <?php endif; ?>
    </div>

    <div class="feature-grid">
        <div class="card">
            <div class="card-body">
                <h3>&#128197; Création de réunions</h3>
                <p>Créez des réunions avec type, date, heure et lieu, puis invitez vos participants en quelques clics.</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3>&#9989; Validation par un administrateur</h3>
                <p>Chaque réunion est soumise à validation avant d'être planifiée et annoncée aux participants.</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3>&#128467; Calendrier intégré</h3>
                <p>Visualisez toutes les réunions dans un calendrier interactif, mises à jour en temps réel.</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3>&#128276; Notifications & rappels</h3>
                <p>Soyez averti des annulations, acceptations et réunions à venir grâce aux notifications et rappels automatiques.</p>
            </div>
        </div>
    </div>

    <?php if (!$user): ?>
        <div class="text-center" style="margin: 30px 0;">
            <p class="text-muted">Pas encore de compte ?</p>
            <a href="<?= $this->Url->build(['controller' => 'Utilisateurs', 'action' => 'add']) ?>" class="btn btn-primary">S'inscrire</a>
        </div>
    <?php endif; ?>
</div>