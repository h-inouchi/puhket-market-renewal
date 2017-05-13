<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Live Show Title'), ['action' => 'edit', $liveShowTitle->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Live Show Title'), ['action' => 'delete', $liveShowTitle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $liveShowTitle->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Live Show Titles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Live Show Title'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comedy Live Shows'), ['controller' => 'ComedyLiveShows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comedy Live Show'), ['controller' => 'ComedyLiveShows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ikuyo Comments'), ['controller' => 'IkuyoComments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ikuyo Comment'), ['controller' => 'IkuyoComments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Personal Schedules'), ['controller' => 'PersonalSchedules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Personal Schedule'), ['controller' => 'PersonalSchedules', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="liveShowTitles view large-9 medium-8 columns content">
    <h3><?= h($liveShowTitle->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($liveShowTitle->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Detail') ?></th>
            <td><?= h($liveShowTitle->detail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Open') ?></th>
            <td><?= h($liveShowTitle->open) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start') ?></th>
            <td><?= h($liveShowTitle->start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fee') ?></th>
            <td><?= h($liveShowTitle->fee) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Iri') ?></th>
            <td><?= h($liveShowTitle->iri) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $liveShowTitle->has('user') ? $this->Html->link($liveShowTitle->user->id, ['controller' => 'Users', 'action' => 'view', $liveShowTitle->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($liveShowTitle->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($liveShowTitle->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($liveShowTitle->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Comedy Live Shows') ?></h4>
        <?php if (!empty($liveShowTitle->comedy_live_shows)): ?>
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
            <?php foreach ($liveShowTitle->comedy_live_shows as $comedyLiveShows): ?>
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
        <h4><?= __('Related Ikuyo Comments') ?></h4>
        <?php if (!empty($liveShowTitle->ikuyo_comments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Comedy Live Show Id') ?></th>
                <th scope="col"><?= __('Live Show Title Id') ?></th>
                <th scope="col"><?= __('Nick Name') ?></th>
                <th scope="col"><?= __('Ticket Count') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($liveShowTitle->ikuyo_comments as $ikuyoComments): ?>
            <tr>
                <td><?= h($ikuyoComments->id) ?></td>
                <td><?= h($ikuyoComments->comedy_live_show_id) ?></td>
                <td><?= h($ikuyoComments->live_show_title_id) ?></td>
                <td><?= h($ikuyoComments->nick_name) ?></td>
                <td><?= h($ikuyoComments->ticket_count) ?></td>
                <td><?= h($ikuyoComments->comment) ?></td>
                <td><?= h($ikuyoComments->created) ?></td>
                <td><?= h($ikuyoComments->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'IkuyoComments', 'action' => 'view', $ikuyoComments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'IkuyoComments', 'action' => 'edit', $ikuyoComments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'IkuyoComments', 'action' => 'delete', $ikuyoComments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ikuyoComments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Personal Schedules') ?></h4>
        <?php if (!empty($liveShowTitle->personal_schedules)): ?>
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
            <?php foreach ($liveShowTitle->personal_schedules as $personalSchedules): ?>
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
