<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Personal Schedules'), ['action' => 'index']) ?></li>
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
<div class="personalSchedules form large-9 medium-8 columns content">
    <?= $this->Form->create($personalSchedule) ?>
    <fieldset>
        <legend><?= __('Add Personal Schedule') ?></legend>
        <?php
            echo $this->Form->control('schedule_date');
            echo $this->Form->control('schedule_title');
            echo $this->Form->control('schedule_detail');
            echo $this->Form->control('start_time');
            echo $this->Form->control('end_time');
            echo $this->Form->control('live_show_title_id', ['options' => $liveShowTitles, 'empty' => true]);
            echo $this->Form->control('place_id', ['options' => $places, 'empty' => true]);
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('unit_member_id', ['options' => $unitMembers, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
