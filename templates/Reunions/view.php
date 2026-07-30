<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reunion $reunion
 */
$user = $this->request->getAttribute('identity');
$peutModifier = ($user && ($user->role === 'admin' || $user->id === $reunion->cree_par));
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>

            <?php if ($peutModifier): ?>
                <?= $this->Html->link(__('Edit Reunion'), ['action' => 'edit', $reunion->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Form->postLink(
                    __('Delete Reunion'),
                    ['action' => 'delete', $reunion->id],
                    [
                        'confirm' => __('Are you sure you want to delete # {0}?', $reunion->id),
                        'class' => 'side-nav-item'
                    ]
                ) ?>
            <?php endif; ?>
            

            <?= $this->Html->link(__('List Reunions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Reunion'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reunions view content">
            <h3><?= h($reunion->titre) ?></h3>
            <table>
                <tr>
                    <th><?= __('Titre') ?></th>
                    <td><?= h($reunion->titre) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lieu') ?></th>
                    <td><?= h($reunion->lieu) ?></td>
                </tr>
                <tr>
                    <th><?= __('Statut') ?></th>
                    <td><?= h($reunion->statut) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($reunion->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cree Par') ?></th>
                    <td><?= $reunion->cree_par === null ? '' : $this->Number->format($reunion->cree_par) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Type') ?></th>
                    <td><?= $reunion->id_type === null ? '' : $this->Number->format($reunion->id_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Heure') ?></th>
                    <td><?= h($reunion->date_heure) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($reunion->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
