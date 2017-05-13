<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Comedy Live Show'), ['action' => 'edit', $comedyLiveShow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Comedy Live Show'), ['action' => 'delete', $comedyLiveShow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comedyLiveShow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Comedy Live Shows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comedy Live Show'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Live Show Titles'), ['controller' => 'LiveShowTitles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Live Show Title'), ['controller' => 'LiveShowTitles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Places'), ['controller' => 'Places', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Place'), ['controller' => 'Places', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ikuyo Comments'), ['controller' => 'IkuyoComments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ikuyo Comment'), ['controller' => 'IkuyoComments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="comedyLiveShows view large-9 medium-8 columns content">
    <h3><?= h($comedyLiveShow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Live Show Date') ?></th>
            <td><?= h($comedyLiveShow->live_show_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Live Show Title') ?></th>
            <td><?= $comedyLiveShow->has('live_show_title') ? $this->Html->link($comedyLiveShow->live_show_title->title, ['controller' => 'LiveShowTitles', 'action' => 'view', $comedyLiveShow->live_show_title->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Place') ?></th>
            <td><?= $comedyLiveShow->has('place') ? $this->Html->link($comedyLiveShow->place->name, ['controller' => 'Places', 'action' => 'view', $comedyLiveShow->place->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $comedyLiveShow->has('user') ? $this->Html->link($comedyLiveShow->user->id, ['controller' => 'Users', 'action' => 'view', $comedyLiveShow->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($comedyLiveShow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($comedyLiveShow->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($comedyLiveShow->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Ikuyo Comments') ?></h4>
        <?php if (!empty($comedyLiveShow->ikuyo_comments)): ?>
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
            <?php foreach ($comedyLiveShow->ikuyo_comments as $ikuyoComments): ?>
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
</div>
