<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Planification $planification
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Planification'), ['action' => 'edit', $planification->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Planification'), ['action' => 'delete', $planification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $planification->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Planification'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Planification'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            
        </div>
    </aside>
    <div class="column column-80">
        <div class="planification view content">
            <h3><?= h($planification->titre) ?></h3>
            <table>
                <tr>
                    <th><?= __('Titre') ?></th>
                    <td><?= h($planification->titre) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lieu') ?></th>
                    <td><?= h($planification->lieu) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($planification->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cree Par') ?></th>
                    <td><?= $this->Number->format($planification->cree_par) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Type') ?></th>
                    <td><?= $this->Number->format($planification->id_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Planification') ?></th>
                    <td><?= h($planification->date_planification) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>