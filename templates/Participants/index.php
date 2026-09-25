<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Participant> $participants
 */
?>
<div class="card" style="max-width:1000px;">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h4 style="margin:0;">Participants</h4>
        <a class="btn btn-primary" href="<?= $this->Url->build(['action' => 'add']) ?>">+ Nouvelle participation</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('Reunions.titre') ?></th>
                    <th><?= $this->Paginator->sort('Utilisateurs.email') ?></th>
                    <th><?= $this->Paginator->sort('presence') ?></th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($participants as $participant): ?>
                <tr>
                    <td><?= $this->Number->format($participant->id) ?></td>
                    <td><?= $participant->reunion === null ? '' : h($participant->reunion->titre) ?></td>
                    <td><?= $participant->utilisateur === null ? '' : h($participant->utilisateur->email) ?></td>
                    <td><?= h($participant->presence) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('Voir', ['action' => 'view', $participant->id], ['class' => 'btn btn-light btn-sm']) ?>
                        <?= $this->Html->link('Modifier', ['action' => 'edit', $participant->id], ['class' => 'btn btn-info btn-sm']) ?>
                        <?= $this->Form->postLink(
                            'Supprimer',
                            ['action' => 'delete', $participant->id],
                            ['method' => 'delete', 'confirm' => 'Voulez-vous vraiment supprimer cette participation ?', 'class' => 'btn btn-danger btn-sm']
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
