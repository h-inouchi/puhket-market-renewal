<div class="form-group">
	<h2 class="band-title">個人予定登録</h2>
	<?php
	echo $this->Form->create('PersonalSchedules');
	echo $this->Form->input('unit_member_id', [
		'label' => '個人名',
	    'options' => $unitMembers,
   		'class' => 'form-control',
	]);
	echo $this->Form->input('schedule_date', [
		'label' => '日付',
		'required' => false,
		'class' => 'form-control',
		'placeHolder' => '(例：2016/11/11)',
	]);
	echo $this->Form->input('schedule_title', [
		'label' => '予定名',
		'required' => false,
		'class' => 'form-control',
		'placeHolder' => '予定名を入れてください（必須）',
	]);
	echo $this->Form->input('start_time', [
		'label' => '何時から',
		'required' => false,
		'class' => 'form-control',
	]);
	echo $this->Form->input('end_time', [
		'label' => '何時まで',
		'required' => false,
		'class' => 'form-control',
	]);
	echo $this->Form->input('live_show_title_id', [
		'label' => 'ライブ名',
		'options' => $liveShowTitles,
		'empty' => '',
		'class' => 'form-control',
		'type' => 'hidden',
	]);
	echo $this->Form->input('place_id', [
		'label' => '場所',
	    'options' => $places,
		'empty' => '',
   		'class' => 'form-control',
		'type' => 'hidden',
	]);
	echo $this->Form->button(__('Submit'));
	echo $this->Form->end();
	?>
</div>
