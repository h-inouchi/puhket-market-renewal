<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Oogiri Scores'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="oogiriScores form large-9 medium-8 columns content">
    <?= $this->Form->create($oogiriScore) ?>
    <fieldset>
        <legend><?= __('Add Oogiri Score') ?></legend>
        <?php
            echo $this->Form->control('score');
            echo $this->Form->control('uuid');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
