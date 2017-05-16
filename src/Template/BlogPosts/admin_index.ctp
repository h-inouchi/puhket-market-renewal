<h3 class="band-title">(管理用) ブログ一覧</h3>
<div class="row" id="event-list">
	<div class="link">
		<?php
		echo $this->Html->link('ブログ追加',
		[
			'controller' => 'blog_posts',
			'action' => 'add',
		]);
		?>
	</div>
</div>
<?php foreach ($blogPosts as $blogPost) : ?>
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<div class="event-box btn-effect">
			<div class="live_show_date list-top">
				<?php echo '日付：' . $blogPost['post_date'] ?>
			</div>
			<div class="title list-middle">
				<?php echo $blogPost['title'] ?>
			</div>
			<div class="link list-middle" style="float:left; margin-right:10px;">
				<?php
				    echo $this->Html->link('編集', array('action'=>'edit', $blogPost['id']));
				?>
			</div>
			<div class="link list-last">
				<?php
				    echo $this->Form->postLink('削除', array('action'=>'delete', $blogPost['id']), ['confirm'=>'sure?']);
				?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
