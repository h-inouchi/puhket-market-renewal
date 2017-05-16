<h2 class="band-title">プーケットマーケット</h2>
<h3 class="band-title">予約一覧</h3>
<div class="row" id="event-list">
<?php foreach ($ikuyo_comments as $ikuyo_comment) : ?>
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<div class="event-box btn-effect">
			<div class="live_show_date list-top">
				<?php echo $ikuyo_comment['comedy_live_show']['live_show_date']; ?>
			</div>
			<div class="title list-middle">
				ライブ名：<?php echo $ikuyo_comment['live_show_title']['title']; ?>
			</div>
			<div class="nick_name list-middle">
				お名前：<?php echo $ikuyo_comment['nick_name']; ?>
			</div>
			<div class="ticket_count list-middle">
				人数：<?php echo $ikuyo_comment['ticket_count']; ?> 人
			</div>
			<div class="ticket_count list-last" style="margin-left:10px;">
			<?php
		    if($ikuyo_comment['comment'])
		    {
				echo 'コメント：' . $ikuyo_comment['comment'];
		    }
			?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
