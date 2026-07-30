<h3><?= __('Mes Réunions') ?></h3>

<table>
    <thead>
        <tr>
            <th><?= __('Titre') ?></th>
            <th><?= __('Date & Heure') ?></th>
            <th><?= __('Lieu') ?></th>
            <th><?= __('Statut') ?></th>
            <th><?= __('Type') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reunions as $reunion): ?>
        <tr>
            <td><?= h($reunion->titre) ?></td>
            <td><?= h($reunion->date_heure) ?></td>
            <td><?= h($reunion->lieu) ?></td>
            <td><?= h($reunion->statut) ?></td>
            <td><?= h($reunion->id_type) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('Voir'), ['action' => 'view', $reunion->id]) ?>
                <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $reunion->id]) ?>
                <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $reunion->id], ['confirm' => __('Voulez-vous vraiment supprimer # {0} ?', $reunion->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

