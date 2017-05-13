<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Todouhukens'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="todouhukens form large-9 medium-8 columns content">
    <?= $this->Form->create($todouhuken) ?>
    <fieldset>
        <legend><?= __('Add Todouhuken') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('filename');
            echo $this->Form->control('from_north_ranking');
            echo $this->Form->control('from_east_ranking');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
