<h1 class="band-title"><?php echo $user['unit_name'] ?></h1>
<h2 class="band-title" style="margin-top:1px; margin-bottom:10px;">Youtube動画一覧</h2>
<div class="row" id="event-list">
<?php foreach ($youtubeUrls as $youtubeUrl) : ?>
	<div class="col-xs-12">
		<div class="event-box btn-effect">
			<div class="title list-top">
				<?php echo $youtubeUrl['title'] ?>
			</div>
			<div class="content list-last">
				<div class="video-wrapper">
					<div class="video-container">
		    			<?php echo $youtubeUrl['url'] ?>
		    		</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
<div class="paginator">
	<?php echo $this->Paginator->numbers([]); ?>
</div>
