<h2>Choisir une réunion</h2>
<ul>
    <?php foreach ($reunions as $reunion): ?>
        <li>
            <?= h($reunion->titre) ?> -
            <?= $this->Html->link('Ajouter participants', ['action' => 'addMultiple', $reunion->id]) ?>
        </li>
    <?php endforeach; ?>
</ul>
