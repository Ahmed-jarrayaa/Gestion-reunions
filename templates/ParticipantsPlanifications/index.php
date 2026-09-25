<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ParticipantsPlanification> $participantsPlanifications
 */
?>
<div class="card" style="max-width:1000px;">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h4 style="margin:0;">Participants planifications</h4>
        <a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['action' => 'add']) ?>">+ Nouvelle entrée</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('id_planification', 'Planification') ?></th>
                    <th><?= $this->Paginator->sort('id_utilisateur', 'Utilisateur') ?></th>
                    <th><?= $this->Paginator->sort('presence') ?></th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($participantsPlanifications as $participantsPlanification): ?>
                <tr>
                    <td><?= $this->Number->format($participantsPlanification->id) ?></td>
                    <td><?= isset($participantsPlanification->planification->titre) ? h($participantsPlanification->planification->titre) : $this->Number->format($participantsPlanification->id_planification) ?></td>
                    <td><?= isset($participantsPlanification->utilisateur->nom) ? h($participantsPlanification->utilisateur->nom . ' (' . $participantsPlanification->utilisateur->email . ')') : $this->Number->format($participantsPlanification->id_utilisateur) ?></td>
                    <td><?= $participantsPlanification->presence ? 'Oui' : 'Non' ?></td>
                    <td class="actions">
                        <?= $this->Html->link('Voir', ['action' => 'view', $participantsPlanification->id], ['class' => 'btn btn-light btn-sm']) ?>
                        <?= $this->Html->link('Modifier', ['action' => 'edit', $participantsPlanification->id], ['class' => 'btn btn-info btn-sm']) ?>
                        <?= $this->Form->postLink(
                            'Supprimer',
                            ['action' => 'delete', $participantsPlanification->id],
                            ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer cette entrée ?', 'class' => 'btn btn-danger btn-sm']
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< Premier') ?>
            <?= $this->Paginator->prev('< Précédent') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('Suivant >') ?>
            <?= $this->Paginator->last('Dernier >>') ?>
        </ul>
        <p><?= $this->Paginator->counter('Page {{page}} sur {{pages}}, {{current}} résultat(s) sur {{count}}') ?></p>
    </div>
</div>