<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Inning High Score'), ['action' => 'edit', $inningHighScore->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Inning High Score'), ['action' => 'delete', $inningHighScore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inningHighScore->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Inning High Scores'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Inning High Score'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="inningHighScores view large-9 medium-8 columns content">
    <h3><?= h($inningHighScore->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Player Name') ?></th>
            <td><?= h($inningHighScore->player_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($inningHighScore->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('High Score') ?></th>
            <td><?= $this->Number->format($inningHighScore->high_score) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($inningHighScore->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($inningHighScore->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Game Name') ?></h4>
        <?= $this->Text->autoParagraph(h($inningHighScore->game_name)); ?>
    </div>
</div>
