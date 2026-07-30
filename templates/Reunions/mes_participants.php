<h1>Participants de mes réunions</h1>

<?php foreach ($reunions as $reunion): ?>
    <h4 style="cursor:pointer; color:blue;" onclick="toggleParticipants('participants-<?= h($reunion->id) ?>')">
        <?= h($reunion->titre) ?> (<?= $reunion->date_heure->format('d/m/Y H:i') ?>)
    </h4>
    <ul id="participants-<?= h($reunion->id) ?>" style="display:none; margin-left: 20px;">
        <?php foreach ($reunion->participants as $participant): ?>
            <li><?= h($participant->utilisateur->nom) ?> <?= h($participant->utilisateur->prenom) ?> (<?= h($participant->utilisateur->id) ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>

<script>
function toggleParticipants(id) {
    const el = document.getElementById(id);
    if (el.style.display === 'none') {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
}
</script>
