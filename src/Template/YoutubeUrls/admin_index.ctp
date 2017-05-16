<h2 class="band-title" style="margin-top:1px; margin-bottom:10px;">管理者用Youtube動画一覧</h2>
<div class="row" id="event-list">
	<div class="link">
		<?php
		echo $this->Html->link('動画(iframe)追加',
		[
			'controller' => 'youtube_urls',
			'action' => 'add',
		]);
		?>
	</div>
<?php foreach ($youtubeUrls as $youtubeUrl) : ?>
	<div class="col-xs-12">
		<div class="event-box btn-effect">
			<div class="title list-top">
				<?php echo $youtubeUrl['title'] ?>
			</div>
			<div class="content list-middle">
				<div class="video-wrapper">
					<div class="video-container">
						<?php echo $youtubeUrl['url'] ?>
					</div>
				</div>
			</div>
			<div class="content list-middle">
				カテゴリ：
				<?php if ($youtubeUrl['youtube_category'] == 1) {
					echo "道化太陽のサンチャンネル";
				} else if ($youtubeUrl['youtube_category'] == 2) {
					echo "プーケットマーケットの動画";
				} ?>
			</div>
			<div class="link list-middle" style="float:left; margin-right:10px;">
				<?php
				    echo $this->Html->link('編集', array('action'=>'edit', $youtubeUrl['id']));
				?>
			</div>
			<div class="link list-last">
				<?php
				    echo $this->Form->postLink('削除', array('action'=>'delete', $youtubeUrl['id']), ['confirm'=>'削除しますか?']);
				?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
<div class="paginator">
	<?php echo $this->Paginator->numbers([]); ?>
</div>
