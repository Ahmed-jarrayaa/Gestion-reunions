<h1>Dashboard - <?= h($userRole) ?></h1>

<!-- Réunions -->
<h3><?= ($userRole === 'admin') ? 'Toutes les Réunions' : 'Vos Réunions' ?> :</h3>

<?php
// Filtrer uniquement les réunions validées pour les membres
$reunionsToShow = [];
foreach ($reunions as $reunion) {
    if ($userRole === 'admin' || $reunion->statut === 'valider') {
        $reunionsToShow[] = $reunion;
    }
}
?>

<?php if (!empty($reunionsToShow)): ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date & Heure</th>
                <th>Lieu</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reunionsToShow as $reunion): ?>
                <tr>
                    <td><?= h($reunion->titre) ?></td>
                    <td><?= h($reunion->date_heure) ?></td>
                    <td><?= h($reunion->lieu) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucune réunion disponible.</p>
<?php endif; ?>
