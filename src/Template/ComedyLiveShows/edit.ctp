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
                ['action' => 'delete', $comedyLiveShow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $comedyLiveShow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Comedy Live Shows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Live Show Titles'), ['controller' => 'LiveShowTitles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Live Show Title'), ['controller' => 'LiveShowTitles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Places'), ['controller' => 'Places', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Place'), ['controller' => 'Places', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ikuyo Comments'), ['controller' => 'IkuyoComments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ikuyo Comment'), ['controller' => 'IkuyoComments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="comedyLiveShows form large-9 medium-8 columns content">
    <?= $this->Form->create($comedyLiveShow) ?>
    <fieldset>
        <legend><?= __('Edit Comedy Live Show') ?></legend>
        <?php
            echo $this->Form->control('live_show_date');
            echo $this->Form->control('live_show_title_id', ['options' => $liveShowTitles]);
            echo $this->Form->control('place_id', ['options' => $places, 'empty' => true]);
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
