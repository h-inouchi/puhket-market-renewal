<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Place'), ['action' => 'edit', $place->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Place'), ['action' => 'delete', $place->id], ['confirm' => __('Are you sure you want to delete # {0}?', $place->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Places'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Place'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comedy Live Shows'), ['controller' => 'ComedyLiveShows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comedy Live Show'), ['controller' => 'ComedyLiveShows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Personal Schedules'), ['controller' => 'PersonalSchedules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Personal Schedule'), ['controller' => 'PersonalSchedules', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="places view large-9 medium-8 columns content">
    <h3><?= h($place->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($place->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($place->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $place->has('user') ? $this->Html->link($place->user->id, ['controller' => 'Users', 'action' => 'view', $place->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($place->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($place->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($place->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Comedy Live Shows') ?></h4>
        <?php if (!empty($place->comedy_live_shows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Live Show Date') ?></th>
                <th scope="col"><?= __('Live Show Title Id') ?></th>
                <th scope="col"><?= __('Place Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($place->comedy_live_shows as $comedyLiveShows): ?>
            <tr>
                <td><?= h($comedyLiveShows->id) ?></td>
                <td><?= h($comedyLiveShows->live_show_date) ?></td>
                <td><?= h($comedyLiveShows->live_show_title_id) ?></td>
                <td><?= h($comedyLiveShows->place_id) ?></td>
                <td><?= h($comedyLiveShows->user_id) ?></td>
                <td><?= h($comedyLiveShows->created) ?></td>
                <td><?= h($comedyLiveShows->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ComedyLiveShows', 'action' => 'view', $comedyLiveShows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ComedyLiveShows', 'action' => 'edit', $comedyLiveShows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ComedyLiveShows', 'action' => 'delete', $comedyLiveShows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comedyLiveShows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Personal Schedules') ?></h4>
        <?php if (!empty($place->personal_schedules)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Schedule Date') ?></th>
                <th scope="col"><?= __('Schedule Title') ?></th>
                <th scope="col"><?= __('Schedule Detail') ?></th>
                <th scope="col"><?= __('Start Time') ?></th>
                <th scope="col"><?= __('End Time') ?></th>
                <th scope="col"><?= __('Live Show Title Id') ?></th>
                <th scope="col"><?= __('Place Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Unit Member Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($place->personal_schedules as $personalSchedules): ?>
            <tr>
                <td><?= h($personalSchedules->id) ?></td>
                <td><?= h($personalSchedules->schedule_date) ?></td>
                <td><?= h($personalSchedules->schedule_title) ?></td>
                <td><?= h($personalSchedules->schedule_detail) ?></td>
                <td><?= h($personalSchedules->start_time) ?></td>
                <td><?= h($personalSchedules->end_time) ?></td>
                <td><?= h($personalSchedules->live_show_title_id) ?></td>
                <td><?= h($personalSchedules->place_id) ?></td>
                <td><?= h($personalSchedules->user_id) ?></td>
                <td><?= h($personalSchedules->unit_member_id) ?></td>
                <td><?= h($personalSchedules->created) ?></td>
                <td><?= h($personalSchedules->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PersonalSchedules', 'action' => 'view', $personalSchedules->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PersonalSchedules', 'action' => 'edit', $personalSchedules->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PersonalSchedules', 'action' => 'delete', $personalSchedules->id], ['confirm' => __('Are you sure you want to delete # {0}?', $personalSchedules->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
