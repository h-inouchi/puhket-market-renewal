<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Personal Schedule'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Live Show Titles'), ['controller' => 'LiveShowTitles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Live Show Title'), ['controller' => 'LiveShowTitles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Places'), ['controller' => 'Places', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Place'), ['controller' => 'Places', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Unit Members'), ['controller' => 'UnitMembers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Unit Member'), ['controller' => 'UnitMembers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="personalSchedules index large-9 medium-8 columns content">
    <h3><?= __('Personal Schedules') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('schedule_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('schedule_title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('schedule_detail') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('live_show_title_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('place_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('unit_member_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($personalSchedules as $personalSchedule): ?>
            <tr>
                <td><?= $this->Number->format($personalSchedule->id) ?></td>
                <td><?= h($personalSchedule->schedule_date) ?></td>
                <td><?= h($personalSchedule->schedule_title) ?></td>
                <td><?= h($personalSchedule->schedule_detail) ?></td>
                <td><?= h($personalSchedule->start_time) ?></td>
                <td><?= h($personalSchedule->end_time) ?></td>
                <td><?= $personalSchedule->has('live_show_title') ? $this->Html->link($personalSchedule->live_show_title->title, ['controller' => 'LiveShowTitles', 'action' => 'view', $personalSchedule->live_show_title->id]) : '' ?></td>
                <td><?= $personalSchedule->has('place') ? $this->Html->link($personalSchedule->place->name, ['controller' => 'Places', 'action' => 'view', $personalSchedule->place->id]) : '' ?></td>
                <td><?= $personalSchedule->has('user') ? $this->Html->link($personalSchedule->user->id, ['controller' => 'Users', 'action' => 'view', $personalSchedule->user->id]) : '' ?></td>
                <td><?= $personalSchedule->has('unit_member') ? $this->Html->link($personalSchedule->unit_member->id, ['controller' => 'UnitMembers', 'action' => 'view', $personalSchedule->unit_member->id]) : '' ?></td>
                <td><?= h($personalSchedule->created) ?></td>
                <td><?= h($personalSchedule->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $personalSchedule->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $personalSchedule->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $personalSchedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $personalSchedule->id)]) ?>
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
