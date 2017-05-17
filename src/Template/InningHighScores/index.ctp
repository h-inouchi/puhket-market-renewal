<script>
$(function(){
    // 自身のページを履歴に追加
    history.pushState(null, null, null);
    // ページ戻り時にも自身のページを履歴に追加
    $(window).on("popstate", function(){
        history.pushState(null, null, null);
    });
});
</script>
<h2 class="band-title">ハイスコア一覧</h2>
<div class="link">
	<?php
	if ($game_name == "baseball") {
		echo $this->Html->link('打席へ',
		[
			'controller' => 'batter_boxes',
			'action' => 'edit',
		]);
	} else if ($game_name == "todouhuken") {
		echo $this->Html->link('ゲームへ',
		[
			'controller' => 'todouhukens',
			'action' => 'index',
		]);
	}
	?>
</div>
<ul class="row" id="event-list" style="list-style-type: decimal">
<?php foreach ($inning_high_scores as $inning_high_score) : ?>
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<li class="event-box btn-effect">
			<div class="live_show_date list-top">
				<?php echo '名前：' . $inning_high_score['InningHighScore']['player_name']; ?>
			</div>
			<div class="ticket_count list-last" style="margin-left:10px;">
				<?php echo 'スコア：' . $inning_high_score['InningHighScore']['high_score']; ?>
			</div>
		</li>
	</div>
<?php endforeach; ?>
</ul>
