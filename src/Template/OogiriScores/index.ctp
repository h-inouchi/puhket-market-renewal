<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Oogiri Score'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="oogiriScores index large-9 medium-8 columns content">
    <h3><?= __('Oogiri Scores') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('score') ?></th>
                <th scope="col"><?= $this->Paginator->sort('uuid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($oogiriScores as $oogiriScore): ?>
            <tr>
                <td><?= $this->Number->format($oogiriScore->id) ?></td>
                <td><?= $this->Number->format($oogiriScore->score) ?></td>
                <td><?= h($oogiriScore->uuid) ?></td>
                <td><?= h($oogiriScore->created) ?></td>
                <td><?= h($oogiriScore->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $oogiriScore->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $oogiriScore->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $oogiriScore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $oogiriScore->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
