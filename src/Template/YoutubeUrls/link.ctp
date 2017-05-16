<style>
h2 {
  background:#3d9ec7;
  color:white;
  padding: 10px 20px;
  font-size: 18px;
  font-family: 'Lucida Grande','Hiragino Kaku Gothic ProN', Meiryo, sans-serif;
}
</style>
<h1 class="band-title"><?php echo $user['unit_name'] . ' リンク'?></h1>
<h2>Twitter</h2>
<div class="row" id="twitter-link-list">
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<div class="event-box btn-effect">
			<?php
				echo '<a href="https://twitter.com/272Hi" target="_blank">' . $this->Html->image('thumb_inouchi.JPG', ['width' => '127', 'height' => 127]) . '</a><br>';
				echo '<a href="https://twitter.com/272Hi" target="_blank">いのうち(@272Hi）</a>';
			?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<div class="event-box btn-effect">
			<?php
				echo '<a href="https://twitter.com/mssmn6417" target="_blank">' . $this->Html->image('thumb_hidaka.JPG', ['width' => '127', 'height' => 127]) . '</a><br>';
				echo '<a href="https://twitter.com/mssmn6417" target="_blank">ひだか（@mssmn6417）</a>';
			?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<div class="event-box btn-effect">
			<?php
				echo '<a href="https://twitter.com/1114_ice" target="_blank">' . $this->Html->image('thumb_honda.JPG', ['width' => '127', 'height' => 127]) . '</a><br>';
				echo '<a href="https://twitter.com/1114_ice" target="_blank">ほんだ（@1114_ice）</a>';
			?>
		</div>
	</div>
</div>
<h2>道化太陽のサンチャンネル</h2>
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
