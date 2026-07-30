<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Reunion> $reunions
 */
$user = $this->request->getAttribute('identity');
$isAdmin = $user && $user->role === 'admin';
?>

<div class="reunions index content">
    <?= $this->Html->link(__('Nouvelle Réunion'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Réunions') ?></h3>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('titre') ?></th>
                    <th><?= $this->Paginator->sort('date_heure') ?></th>
                    <th><?= $this->Paginator->sort('lieu') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('cree_par') ?></th>
                    <th><?= $this->Paginator->sort('id_type') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reunions as $reunion): ?>
                <tr>
                    <td><?= $this->Number->format($reunion->id) ?></td>
                    <td><?= h($reunion->titre) ?></td>
                    <td><?= h($reunion->date_heure) ?></td>
                    <td><?= h($reunion->lieu) ?></td>
                    <td>
                        <?php
$user = $this->request->getAttribute('identity'); // utilisateur connecté

// Vérifier si l'utilisateur peut agir (admin ou créateur)
if ($user && ($user->role === 'admin' )):

    if ($reunion->statut === 'en_attente'): ?>
        <?= $this->Form->postLink('Accepter', ['action' => 'valider', $reunion->id, 'accepter'], ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Form->postLink('Refuser', ['action' => 'valider', $reunion->id, 'refuser'], ['class' => 'btn btn-danger btn-sm']) ?>
        <?= $this->Html->link(
    'Planifier',
    ['controller' => 'Planification', 'action' => 'add', $reunion->id],
    ['class' => 'btn btn-info btn-sm']
) ?>

    <?php elseif ($reunion->statut === 'accepte'): ?>
        <span class="badge" style="background-color: #28a745; color:white;">Acceptée</span>
    <?php elseif ($reunion->statut === 'refuse'): ?>
        <span class="badge" style="background-color: #dc3545; color:white;">Refusée</span>
    <?php elseif ($reunion->statut === 'valider'): ?>
        <span class="badge" style="background-color: #007bff; color:white;">Validée</span>
    <?php endif; ?>

<?php else: // pour les autres utilisateurs ?>

    <?php if ($reunion->statut === 'accepte'): ?>
        <span class="badge" style="background-color: #28a745; color:white;">Acceptée</span>
    <?php elseif ($reunion->statut === 'refuse'): ?>
        <span class="badge" style="background-color: #dc3545; color:white;">Refusée</span>
    <?php elseif ($reunion->statut === 'valider'): ?>
        <span class="badge" style="background-color: #007bff; color:white;">Validée</span>
    <?php else: ?>
        <span class="badge" style="background-color: #ffc107; color:black;">En attente</span>
    <?php endif; ?>

<?php endif; ?>



                    </td>
                    <td><?= $reunion->cree_par === null ? '' : $this->Number->format($reunion->cree_par) ?></td>
                    <td><?= $reunion->id_type === null ? '' : $this->Number->format($reunion->id_type) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Voir'), ['action' => 'view', $reunion->id]) ?>
                        <?php if ($isAdmin || $user->id === $reunion->cree_par): ?>
                            <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $reunion->id]) ?>
                            <?= $this->Form->postLink(
                                __('Supprimer'),
                                ['action' => 'delete', $reunion->id],
                                [
                                    'method' => 'delete',
                                    'confirm' => __('Êtes-vous sûr de vouloir supprimer la réunion #{0}?', $reunion->id),
                                ]
                            ) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('Première')) ?>
            <?= $this->Paginator->prev('< ' . __('Précédente')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Suivante') . ' >') ?>
            <?= $this->Paginator->last(__('Dernière') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} sur {{pages}}, affichant {{current}} enregistrements sur {{count}}')) ?></p>
    </div>
</div>
