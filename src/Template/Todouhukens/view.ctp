<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Todouhuken'), ['action' => 'edit', $todouhuken->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Todouhuken'), ['action' => 'delete', $todouhuken->id], ['confirm' => __('Are you sure you want to delete # {0}?', $todouhuken->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Todouhukens'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Todouhuken'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="todouhukens view large-9 medium-8 columns content">
    <h3><?= h($todouhuken->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($todouhuken->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('From North Ranking') ?></th>
            <td><?= $this->Number->format($todouhuken->from_north_ranking) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('From East Ranking') ?></th>
            <td><?= $this->Number->format($todouhuken->from_east_ranking) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($todouhuken->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($todouhuken->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Name') ?></h4>
        <?= $this->Text->autoParagraph(h($todouhuken->name)); ?>
    </div>
    <div class="row">
        <h4><?= __('Filename') ?></h4>
        <?= $this->Text->autoParagraph(h($todouhuken->filename)); ?>
    </div>
</div>
