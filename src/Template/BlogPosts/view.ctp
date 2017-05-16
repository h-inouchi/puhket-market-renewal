<div class="info">
	<h1 class="blog_title"><?php echo h($blogPost['title']); ?></h1>
</div>
<div class="post_date">
	<?php echo '記事日付：' . $blogPost['post_date']; ?>
	<div style="float:right; margin-right:10px;">
		<?php echo 'by：' . $blogPost['name']; ?>
	</div>
</div>
<div class="post_text">
    <?php echo $blogPost['post_text']; ?>
</div>
