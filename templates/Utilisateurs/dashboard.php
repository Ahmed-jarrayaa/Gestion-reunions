<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Tableau de bord');
use Cake\I18n\DateTime;
?>
<div class="heading">
    <h2>Tableau de bord - <?= h($userRole) ?></h2>
</div>

<h3><?= ($userRole === 'admin') ? 'Toutes les réunions' : 'Vos réunions' ?></h3>

<?php
$reunionsToShow = [];
foreach ($reunions as $reunion) {
    if ($userRole === 'admin' || $reunion->statut === 'valider') {
        $reunionsToShow[] = $reunion;
    }
}
?>

<div class="row">
    <?php if (!empty($reunionsToShow)): ?>
        <?php foreach ($reunionsToShow as $reunion): ?>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h3 style="margin-bottom:4px;">
                            <a href="<?= $this->Url->build(['controller' => 'Reunions', 'action' => 'view', $reunion->id]) ?>">
                                <?= h($reunion->titre) ?>
                            </a>
                        </h3>
                        <p class="small text-muted">
                            <?php if ($reunion->date_heure instanceof \DateTimeInterface): ?>
                                <?= h((new DateTime($reunion->date_heure))->i18nFormat('dd/MM/yyyy HH:mm')) ?>
                            <?php else: ?>
                                <?= h((string)$reunion->date_heure) ?>
                            <?php endif; ?>
                            &middot; Lieu : <?= h($reunion->lieu) ?>
                        </p>
                        <span class="badge bg-success"><?= h($reunion->statut) ?></span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-light btn-sm" href="<?= $this->Url->build(['controller' => 'Reunions', 'action' => 'view', $reunion->id]) ?>">Voir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-muted">Aucune réunion disponible.</p>
                    <?= $this->Html->link('Créer une réunion', ['controller' => 'Reunions', 'action' => 'add'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>