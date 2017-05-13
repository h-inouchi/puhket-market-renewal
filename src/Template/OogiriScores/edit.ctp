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
                ['action' => 'delete', $oogiriScore->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $oogiriScore->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Oogiri Scores'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="oogiriScores form large-9 medium-8 columns content">
    <?= $this->Form->create($oogiriScore) ?>
    <fieldset>
        <legend><?= __('Edit Oogiri Score') ?></legend>
        <?php
            echo $this->Form->control('score');
            echo $this->Form->control('uuid');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
