<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ikuyo Comment'), ['action' => 'edit', $ikuyoComment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ikuyo Comment'), ['action' => 'delete', $ikuyoComment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ikuyoComment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ikuyo Comments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ikuyo Comment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comedy Live Shows'), ['controller' => 'ComedyLiveShows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comedy Live Show'), ['controller' => 'ComedyLiveShows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Live Show Titles'), ['controller' => 'LiveShowTitles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Live Show Title'), ['controller' => 'LiveShowTitles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ikuyoComments view large-9 medium-8 columns content">
    <h3><?= h($ikuyoComment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Comedy Live Show') ?></th>
            <td><?= $ikuyoComment->has('comedy_live_show') ? $this->Html->link($ikuyoComment->comedy_live_show->id, ['controller' => 'ComedyLiveShows', 'action' => 'view', $ikuyoComment->comedy_live_show->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Live Show Title') ?></th>
            <td><?= $ikuyoComment->has('live_show_title') ? $this->Html->link($ikuyoComment->live_show_title->title, ['controller' => 'LiveShowTitles', 'action' => 'view', $ikuyoComment->live_show_title->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nick Name') ?></th>
            <td><?= h($ikuyoComment->nick_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ikuyoComment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ticket Count') ?></th>
            <td><?= $this->Number->format($ikuyoComment->ticket_count) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($ikuyoComment->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($ikuyoComment->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Comment') ?></h4>
        <?= $this->Text->autoParagraph(h($ikuyoComment->comment)); ?>
    </div>
</div>
