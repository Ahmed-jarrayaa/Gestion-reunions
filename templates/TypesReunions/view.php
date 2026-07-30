<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypesReunion $typesReunion
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Types Reunion'), ['action' => 'edit', $typesReunion->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Types Reunion'), ['action' => 'delete', $typesReunion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $typesReunion->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Types Reunions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Types Reunion'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="typesReunions view content">
            <h3><?= h($typesReunion->nom_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nom Type') ?></th>
                    <td><?= h($typesReunion->nom_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($typesReunion->id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($typesReunion->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>