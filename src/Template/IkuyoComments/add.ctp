<div class="form-group">
	<h2 class="band-title"> ... 行くよ！</h2>

	<?php
	echo $this->Form->create('IkuyoComments');
	echo $this->Form->input('comedy_live_show_id', [
		'type' => 'hidden',
		'value' => $comedy_live_show_id,
		'class' => 'form-control', ]);
	echo $this->Form->input('live_show_title_id', [
		'type' => 'hidden',
		'value' => $live_show_title_id,
		'class' => 'form-control', ]);
	echo $this->Form->input('nick_name', [
		'label' => 'お名前（ニックネーム 可）',
		'required' => false,
		'class' => 'form-control',]);
	echo $this->Form->input('ticket_count', [
		'label' => '人数',
		'default' => 1,
		'required' => false,
		'class' => 'form-control',]);
	echo $this->Form->input('comment', [
		'label' => 'コメント（任意入力）',
		'rows' => 3,
		'class' => 'form-control',]);
	?>
</div>
<?php
echo $this->Form->button('入力完了！', ['type' => 'submit', 'class' => 'btn btn-primary']);
?>
<?= $this->Form->end() ?>