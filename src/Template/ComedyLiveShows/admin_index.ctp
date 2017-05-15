<h2 class="band-title"><?php echo $user['User']['unit_name'] ?></h2>
<h3 class="band-title">(管理用) 出演予定ライブ一覧</h3>
<div class="row" id="event-list">
	<div class="link">
		<?php
		echo $this->Html->link('出演予定追加',
		[
			'controller' => 'comedy_live_shows',
			'action' => 'add',
		]);
		?>
	</div>
</div>
<?php foreach ($comedy_live_shows as $comedy_live_show) : ?>
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<div class="event-box btn-effect">
			<div class="live_show_date list-top">
				<?php echo $comedy_live_show['live_show_date'] ?>
			</div>
			<div class="title list-middle">
				<?php echo $comedy_live_show['live_show_title']['title'] ?>
			</div>
			<div class="iri list-middle">
				<?php echo '入り：' . $comedy_live_show['live_show_title']['iri'] ?>
			</div>
			<div class="open list-middle">
				<?php echo '開場：' . $comedy_live_show['live_show_title']['open'] ?>
			</div>
			<div class="start list-middle">
				<?php echo '開演：' . $comedy_live_show['live_show_title']['start'] ?>
			</div>
			<div class="link list-middle" style="float:left; margin-right:10px;">
				<?php
				    echo $this->Html->link('編集', array('action'=>'edit', $comedy_live_show['id']));
				?>
			</div>
			<div class="link list-last">
				<?php
				    echo $this->Form->postLink('削除', array('action'=>'delete', $comedy_live_show['id']), ['confirm'=>'sure?']);
				?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
