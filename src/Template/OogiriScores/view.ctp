<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Oogiri Score'), ['action' => 'edit', $oogiriScore->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Oogiri Score'), ['action' => 'delete', $oogiriScore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $oogiriScore->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Oogiri Scores'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Oogiri Score'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="oogiriScores view large-9 medium-8 columns content">
    <h3><?= h($oogiriScore->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Uuid') ?></th>
            <td><?= h($oogiriScore->uuid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($oogiriScore->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Score') ?></th>
            <td><?= $this->Number->format($oogiriScore->score) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($oogiriScore->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($oogiriScore->modified) ?></td>
        </tr>
    </table>
</div>
