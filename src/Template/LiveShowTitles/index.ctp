<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Live Show Title'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comedy Live Shows'), ['controller' => 'ComedyLiveShows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comedy Live Show'), ['controller' => 'ComedyLiveShows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ikuyo Comments'), ['controller' => 'IkuyoComments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ikuyo Comment'), ['controller' => 'IkuyoComments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Personal Schedules'), ['controller' => 'PersonalSchedules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Personal Schedule'), ['controller' => 'PersonalSchedules', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="liveShowTitles index large-9 medium-8 columns content">
    <h3><?= __('Live Show Titles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('detail') ?></th>
                <th scope="col"><?= $this->Paginator->sort('open') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fee') ?></th>
                <th scope="col"><?= $this->Paginator->sort('iri') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($liveShowTitles as $liveShowTitle): ?>
            <tr>
                <td><?= $this->Number->format($liveShowTitle->id) ?></td>
                <td><?= h($liveShowTitle->title) ?></td>
                <td><?= h($liveShowTitle->detail) ?></td>
                <td><?= h($liveShowTitle->open) ?></td>
                <td><?= h($liveShowTitle->start) ?></td>
                <td><?= h($liveShowTitle->fee) ?></td>
                <td><?= h($liveShowTitle->iri) ?></td>
                <td><?= $liveShowTitle->has('user') ? $this->Html->link($liveShowTitle->user->id, ['controller' => 'Users', 'action' => 'view', $liveShowTitle->user->id]) : '' ?></td>
                <td><?= h($liveShowTitle->created) ?></td>
                <td><?= h($liveShowTitle->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $liveShowTitle->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $liveShowTitle->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $liveShowTitle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $liveShowTitle->id)]) ?>
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
