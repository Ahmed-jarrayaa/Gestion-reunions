<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Reunion> $reunions
 */
?>
<div class="card" style="max-width:1000px;">
    <div class="card-header">
        <h4 style="margin:0;">Ajouter des participants</h4>
    </div>
    <div class="card-body">
        <p class="small" style="margin-top:0;">Choisissez la réunion à laquelle vous voulez ajouter des participants.</p>

        <?php if (empty($reunions)): ?>
            <div class="alert alert-info">Aucune réunion disponible.</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Statut</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reunions as $reunion): ?>
                    <tr>
                        <td><?= h($reunion->titre) ?></td>
                        <td><?= $reunion->date_heure ? h($reunion->date_heure->format('d/m/Y H:i')) : '' ?></td>
                        <td><?= h($reunion->lieu) ?></td>
                        <td>
                            <?php if ($reunion->statut === 'valider'): ?>
                                <span class="badge bg-success">Validée</span>
                            <?php elseif ($reunion->statut === 'en_attente'): ?>
                                <span class="badge bg-warning">En attente</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?= h($reunion->statut ?? '') ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link('Ajouter des participants', ['action' => 'addMultiple', $reunion->id], ['class' => 'btn btn-primary btn-sm']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div style="margin-top:16px;">
            <a class="btn btn-light btn-sm" href="<?= $this->Url->build(['action' => 'index']) ?>">&larr; Retour aux réunions</a>
        </div>
    </div>
</div>