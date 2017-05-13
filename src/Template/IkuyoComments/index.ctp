<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ikuyo Comment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comedy Live Shows'), ['controller' => 'ComedyLiveShows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comedy Live Show'), ['controller' => 'ComedyLiveShows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Live Show Titles'), ['controller' => 'LiveShowTitles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Live Show Title'), ['controller' => 'LiveShowTitles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ikuyoComments index large-9 medium-8 columns content">
    <h3><?= __('Ikuyo Comments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comedy_live_show_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('live_show_title_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nick_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ticket_count') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ikuyoComments as $ikuyoComment): ?>
            <tr>
                <td><?= $this->Number->format($ikuyoComment->id) ?></td>
                <td><?= $ikuyoComment->has('comedy_live_show') ? $this->Html->link($ikuyoComment->comedy_live_show->id, ['controller' => 'ComedyLiveShows', 'action' => 'view', $ikuyoComment->comedy_live_show->id]) : '' ?></td>
                <td><?= $ikuyoComment->has('live_show_title') ? $this->Html->link($ikuyoComment->live_show_title->title, ['controller' => 'LiveShowTitles', 'action' => 'view', $ikuyoComment->live_show_title->id]) : '' ?></td>
                <td><?= h($ikuyoComment->nick_name) ?></td>
                <td><?= $this->Number->format($ikuyoComment->ticket_count) ?></td>
                <td><?= h($ikuyoComment->created) ?></td>
                <td><?= h($ikuyoComment->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ikuyoComment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ikuyoComment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ikuyoComment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ikuyoComment->id)]) ?>
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
