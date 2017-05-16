<div class="form-group">
	<h2 class="band-title">画像登録</h2>
	<?php
	echo $this->Form->create(null,
		[
			'type' => 'file',
			'url' => ['action' => 'add'],
		]);
	echo $this->Flash->render();
	echo $this->Form->input('title', ['label' => '画像タイトル', 'required' => false]);
	echo $this->Form->input('display_order', ['label' => '表示順', 'value' => 9999, 'required' => false]);
	echo $this->Form->file('image');
	echo $this->Form->button(__('Submit'));
    echo $this->Form->end();
	?>
</div>
