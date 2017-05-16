<h2 class="band-title" style="margin-top:1px; margin-bottom:10px;">ニュース一覧</h2>
<div class="row" id="event-list">
<?php foreach ($posts as $post) : ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="event-box btn-effect">
			<div class="post_text list-top">
				<?php echo $post['post_date']; ?>
			</div>
			<div class="post_text list-middle list-last">
				<?php echo $post['post_text']; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
<div class="paginator">
	<?php echo $this->Paginator->numbers([]); ?>
</div>
