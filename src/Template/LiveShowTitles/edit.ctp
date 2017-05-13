<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $liveShowTitle->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $liveShowTitle->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Live Show Titles'), ['action' => 'index']) ?></li>
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
<div class="liveShowTitles form large-9 medium-8 columns content">
    <?= $this->Form->create($liveShowTitle) ?>
    <fieldset>
        <legend><?= __('Edit Live Show Title') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('detail');
            echo $this->Form->control('open');
            echo $this->Form->control('start');
            echo $this->Form->control('fee');
            echo $this->Form->control('iri');
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
