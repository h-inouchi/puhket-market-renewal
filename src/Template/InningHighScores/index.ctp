<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Inning High Score'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="inningHighScores index large-9 medium-8 columns content">
    <h3><?= __('Inning High Scores') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('high_score') ?></th>
                <th scope="col"><?= $this->Paginator->sort('player_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inningHighScores as $inningHighScore): ?>
            <tr>
                <td><?= $this->Number->format($inningHighScore->id) ?></td>
                <td><?= $this->Number->format($inningHighScore->high_score) ?></td>
                <td><?= h($inningHighScore->player_name) ?></td>
                <td><?= h($inningHighScore->created) ?></td>
                <td><?= h($inningHighScore->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $inningHighScore->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $inningHighScore->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $inningHighScore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inningHighScore->id)]) ?>
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
