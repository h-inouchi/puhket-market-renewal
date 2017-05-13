<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Inning High Scores'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="inningHighScores form large-9 medium-8 columns content">
    <?= $this->Form->create($inningHighScore) ?>
    <fieldset>
        <legend><?= __('Add Inning High Score') ?></legend>
        <?php
            echo $this->Form->control('high_score');
            echo $this->Form->control('player_name');
            echo $this->Form->control('game_name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
