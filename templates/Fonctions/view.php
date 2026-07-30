<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fonction $fonction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Fonction'), ['action' => 'edit', $fonction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Fonction'), ['action' => 'delete', $fonction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fonction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Fonctions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Fonction'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="fonctions view content">
            <h3><?= h($fonction->nom) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nom') ?></th>
                    <td><?= h($fonction->nom) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($fonction->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Utilisateurs') ?></h4>
                <?php if (!empty($fonction->utilisateurs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Nom') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Mot De Passe') ?></th>
                            <th><?= __('Fonction Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($fonction->utilisateurs as $utilisateur) : ?>
                        <tr>
                            <td><?= h($utilisateur->id) ?></td>
                            <td><?= h($utilisateur->nom) ?></td>
                            <td><?= h($utilisateur->email) ?></td>
                            <td><?= h($utilisateur->role) ?></td>
                            <td><?= h($utilisateur->mot_de_passe) ?></td>
                            <td><?= h($utilisateur->fonction_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Utilisateurs', 'action' => 'view', $utilisateur->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Utilisateurs', 'action' => 'edit', $utilisateur->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Utilisateurs', 'action' => 'delete', $utilisateur->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $utilisateur->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>