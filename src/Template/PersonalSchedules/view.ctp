<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Personal Schedule'), ['action' => 'edit', $personalSchedule->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Personal Schedule'), ['action' => 'delete', $personalSchedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $personalSchedule->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Personal Schedules'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Personal Schedule'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Live Show Titles'), ['controller' => 'LiveShowTitles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Live Show Title'), ['controller' => 'LiveShowTitles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Places'), ['controller' => 'Places', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Place'), ['controller' => 'Places', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Unit Members'), ['controller' => 'UnitMembers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit Member'), ['controller' => 'UnitMembers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="personalSchedules view large-9 medium-8 columns content">
    <h3><?= h($personalSchedule->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Schedule Date') ?></th>
            <td><?= h($personalSchedule->schedule_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Schedule Title') ?></th>
            <td><?= h($personalSchedule->schedule_title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Schedule Detail') ?></th>
            <td><?= h($personalSchedule->schedule_detail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Time') ?></th>
            <td><?= h($personalSchedule->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Time') ?></th>
            <td><?= h($personalSchedule->end_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Live Show Title') ?></th>
            <td><?= $personalSchedule->has('live_show_title') ? $this->Html->link($personalSchedule->live_show_title->title, ['controller' => 'LiveShowTitles', 'action' => 'view', $personalSchedule->live_show_title->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Place') ?></th>
            <td><?= $personalSchedule->has('place') ? $this->Html->link($personalSchedule->place->name, ['controller' => 'Places', 'action' => 'view', $personalSchedule->place->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $personalSchedule->has('user') ? $this->Html->link($personalSchedule->user->id, ['controller' => 'Users', 'action' => 'view', $personalSchedule->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Unit Member') ?></th>
            <td><?= $personalSchedule->has('unit_member') ? $this->Html->link($personalSchedule->unit_member->id, ['controller' => 'UnitMembers', 'action' => 'view', $personalSchedule->unit_member->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($personalSchedule->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($personalSchedule->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($personalSchedule->modified) ?></td>
        </tr>
    </table>
</div>
