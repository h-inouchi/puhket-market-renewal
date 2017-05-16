<h1 class="band-title">ブログ記事一覧</h1>
<div class="row" id="event-list">
<?php foreach ($blogPosts as $blogPost) : ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="event-box btn-effect" style="padding:5px; 0">
			<div class="list-top">
				<?php echo $blogPost['post_date']; ?>
				<div style="float:right; margin-top:10px; margin-right:10px;">
					<?php echo 'by：' . $blogPost['name']; ?>
				</div>
			</div>
			<div class="list-last" style="margin-top:20px; margin-left:10px;">
				<?php
				echo $this->Html->link($blogPost['title'],
				[
					'controller' => 'blog_posts',
					'action' => 'view',
					$blogPost['id'],
				]);
				?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
<div class="paginator">
	<?php echo $this->Paginator->numbers([]); ?>
</div>
