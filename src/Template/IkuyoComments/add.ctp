<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Ikuyo Comments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Comedy Live Shows'), ['controller' => 'ComedyLiveShows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comedy Live Show'), ['controller' => 'ComedyLiveShows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Live Show Titles'), ['controller' => 'LiveShowTitles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Live Show Title'), ['controller' => 'LiveShowTitles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ikuyoComments form large-9 medium-8 columns content">
    <?= $this->Form->create($ikuyoComment) ?>
    <fieldset>
        <legend><?= __('Add Ikuyo Comment') ?></legend>
        <?php
            echo $this->Form->control('comedy_live_show_id', ['options' => $comedyLiveShows]);
            echo $this->Form->control('live_show_title_id', ['options' => $liveShowTitles]);
            echo $this->Form->control('nick_name');
            echo $this->Form->control('ticket_count');
            echo $this->Form->control('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
