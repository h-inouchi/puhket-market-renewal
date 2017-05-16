<h2 class="band-title"> Youtube動画（iframe URL）登録</h2>

<?php
echo $this->Form->create($youtubeUrl);
echo $this->Form->control('title', ['label' => 'タイトル', 'required' => false]);
echo $this->Form->control('url', ['label' => 'URL', 'required' => false]);
echo $this->Form->control('youtube_category', [
    'options' => [1 => '道化太陽のサンチャンネル', 2 => 'プーケットマーケットの動画'],
    'default' => 1,
]);
echo $this->Form->button(__('Submit'));
echo $this->Form->end();
?>
